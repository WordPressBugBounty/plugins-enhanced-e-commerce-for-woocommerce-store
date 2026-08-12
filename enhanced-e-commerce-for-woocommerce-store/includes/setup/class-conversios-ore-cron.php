<?php
/**
 * Daily cron — sends last-24-hr tracked/untracked order stats
 * to the Conversios middleware (/api/v2/ore-data).
 *
 * @since 7.2.18
 */

if (!defined('ABSPATH')) {
    exit;
}

class Conversios_Ore_Cron
{
    const CONV_ORE_HOOK = 'conversios_daily_ore_sync';

    public function __construct()
    {
        add_action('plugins_loaded', function () {
            if (!wp_next_scheduled(self::CONV_ORE_HOOK)) {
                wp_schedule_event(time(), 'daily', self::CONV_ORE_HOOK);
            }
        });
        add_action(self::CONV_ORE_HOOK, [$this, 'conv_ore_run']);
    }

    /** Removes the scheduled event — called on plugin deactivation. */
    public static function conv_ore_clear_cron()
    {
        wp_clear_scheduled_hook(self::CONV_ORE_HOOK);
    }

    /**
     * Cron callback. Collects last-24-hr order stats and POSTs to middleware.
     */
    public function conv_ore_run()
    {
        if (!defined('CONV_IS_WC') || CONV_IS_WC !== 1) {
            return;
        }

        $conv_ore_ee_options      = unserialize(get_option('ee_options'));
        $conv_ore_subscription_id = isset($conv_ore_ee_options['subscription_id'])
            ? sanitize_text_field($conv_ore_ee_options['subscription_id'])
            : '';

        if (empty($conv_ore_subscription_id)) {
            return;
        }

        global $wpdb;

        $conv_ore_since    = gmdate('Y-m-d H:i:s', strtotime('-24 hours'));
        $conv_ore_currency = function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : '';

        $conv_ore_hpos_table = esc_sql( $wpdb->prefix . 'wc_orders' );
        $conv_ore_use_hpos   = $wpdb->get_var(
            $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like( $wpdb->prefix . 'wc_orders' ))
        ) === $wpdb->prefix . 'wc_orders';

        if ($conv_ore_use_hpos) {
            $conv_ore_meta_table = esc_sql( $wpdb->prefix . 'wc_orders_meta' );

            // phpcs:ignore PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQL.NotPrepared -- HPOS table names from $wpdb->prefix only.
            $conv_ore_tracked_row = $wpdb->get_row($wpdb->prepare(
                "SELECT COUNT(o.id) AS cnt, COALESCE(SUM(o.total_amount), 0) AS rev
                   FROM {$conv_ore_hpos_table} o
                  INNER JOIN {$conv_ore_meta_table} m ON m.order_id = o.id AND m.meta_key = '_tracked'
                  WHERE o.type = 'shop_order'
                    AND o.status IN ('wc-processing','wc-completed')
                    AND o.date_created_gmt >= %s",
                $conv_ore_since
            ));

            // phpcs:ignore PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQL.NotPrepared -- HPOS table names from $wpdb->prefix only.
            $conv_ore_untracked_row = $wpdb->get_row($wpdb->prepare(
                "SELECT COUNT(o.id) AS cnt, COALESCE(SUM(o.total_amount), 0) AS rev
                   FROM {$conv_ore_hpos_table} o
                  WHERE o.type = 'shop_order'
                    AND o.status IN ('wc-processing','wc-completed')
                    AND o.date_created_gmt >= %s
                    AND NOT EXISTS (
                        SELECT 1 FROM {$conv_ore_meta_table} m
                         WHERE m.order_id = o.id AND m.meta_key = '_tracked'
                    )",
                $conv_ore_since
            ));
        } else {
            $conv_ore_tracked_row = $wpdb->get_row($wpdb->prepare(
                "SELECT COUNT(p.ID) AS cnt,
                        COALESCE(SUM(CAST(pm_total.meta_value AS DECIMAL(15,4))), 0) AS rev
                   FROM {$wpdb->posts} p
                  INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_tracked'
                  INNER JOIN {$wpdb->postmeta} pm_total ON pm_total.post_id = p.ID
                                                        AND pm_total.meta_key = '_order_total'
                  WHERE p.post_type   = 'shop_order'
                    AND p.post_status IN ('wc-processing','wc-completed')
                    AND p.post_date_gmt >= %s",
                $conv_ore_since
            ));

            $conv_ore_untracked_row = $wpdb->get_row($wpdb->prepare(
                "SELECT COUNT(p.ID) AS cnt,
                        COALESCE(SUM(CAST(pm_total.meta_value AS DECIMAL(15,4))), 0) AS rev
                   FROM {$wpdb->posts} p
                  INNER JOIN {$wpdb->postmeta} pm_total ON pm_total.post_id = p.ID
                                                        AND pm_total.meta_key = '_order_total'
                  WHERE p.post_type   = 'shop_order'
                    AND p.post_status IN ('wc-processing','wc-completed')
                    AND p.post_date_gmt >= %s
                    AND NOT EXISTS (
                        SELECT 1 FROM {$wpdb->postmeta} pm2
                         WHERE pm2.post_id = p.ID AND pm2.meta_key = '_tracked'
                    )",
                $conv_ore_since
            ));
        }

        $conv_ore_tracked_count     = (int)   ($conv_ore_tracked_row->cnt   ?? 0);
        $conv_ore_tracked_revenue   = round((float) ($conv_ore_tracked_row->rev   ?? 0), 2);
        $conv_ore_untracked_count   = (int)   ($conv_ore_untracked_row->cnt ?? 0);
        $conv_ore_untracked_revenue = round((float) ($conv_ore_untracked_row->rev ?? 0), 2);

        wp_remote_post(esc_url_raw(TVC_API_CALL_URL . '/ore-data'), [
            'timeout'  => 10,
            'blocking' => false,
            'headers'  => [
                'Authorization' => 'Bearer MTIzNA==',
                'Content-Type'  => 'application/json',
            ],
            'body' => wp_json_encode([
                'subscription_id'       => $conv_ore_subscription_id,
                'event_datetime'        => current_time('Y-m-d H:i:s'),
                'untracked_order_count' => $conv_ore_untracked_count,
                'untracked_revenue'     => $conv_ore_untracked_revenue,
                'tracked_order_count'   => $conv_ore_tracked_count,
                'tracked_revenue'       => $conv_ore_tracked_revenue,
                'currency'              => $conv_ore_currency,
                'additional_data'       => [
                    'source'       => 'WordPress',
                    'store_url'    => get_site_url(),
                    'total_orders' => $conv_ore_tracked_count + $conv_ore_untracked_count,
                ],
            ]),
        ]);
    }
}
