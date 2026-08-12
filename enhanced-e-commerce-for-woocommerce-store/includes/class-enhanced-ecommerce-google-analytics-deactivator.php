<?php

/**
 * Fired during plugin deactivation
 *
 * @link       test.com
 * @since      1.0.0
 *
 * @package    Enhanced_Ecommerce_Google_Analytics
 * @subpackage Enhanced_Ecommerce_Google_Analytics/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Enhanced_Ecommerce_Google_Analytics
 * @subpackage Enhanced_Ecommerce_Google_Analytics/includes
 * @author     Tatvic
 */
class Enhanced_Ecommerce_Google_Analytics_Deactivator {


	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( 'tvc_add_cron_interval_for_product_sync' );
		wp_clear_scheduled_hook( 'conversios_daily_ore_sync' );

		if ( function_exists( 'as_unschedule_all_actions' ) ) {
			as_unschedule_all_actions( 'ee_auto_product_sync_check' );
			as_unschedule_all_actions( 'auto_feed_wise_product_sync_process_scheduler_ee' );
			as_unschedule_all_actions( 'init_feed_wise_product_sync_process_scheduler_ee' );
		}

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$TVC_Admin_Helper = new TVC_Admin_Helper();
		$caller           = 'deactivate_function';
		$TVC_Admin_Helper->update_app_status( $caller, '0' );
		$TVC_Admin_Helper->app_activity_detail( $caller, 'deactivate' );

		if ( class_exists( 'Conversios_Ore_Cron' ) ) {
			Conversios_Ore_Cron::conv_ore_clear_cron();
		}
	}
}
