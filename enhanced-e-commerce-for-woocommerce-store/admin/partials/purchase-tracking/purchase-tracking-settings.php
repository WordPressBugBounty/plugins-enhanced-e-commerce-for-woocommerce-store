<?php
/**
 * Purchase Tracking Settings Page - 2026 Edition.
 *
 * @package Enhanced_Ecommerce_Google_Analytics
 * @since   7.6.3
 */

if (!defined('WPINC')) {
    die;
}

if (!class_exists('Conv_Purchase_Tracking_Settings')) {

    class Conv_Purchase_Tracking_Settings
    {
        protected $ee_options;
        protected $plan_id;
        protected $tvc_api_data;

        public function __construct()
        {
            $this->ee_options = maybe_unserialize(get_option('ee_options', []));
            if (is_string($this->ee_options)) $this->ee_options = maybe_unserialize($this->ee_options);
            if (!is_array($this->ee_options)) $this->ee_options = [];
            $TVC_Admin_Helper = new TVC_Admin_Helper();
            $this->tvc_api_data = $TVC_Admin_Helper->get_ee_options_data();
            $this->plan_id    = 1;
            //echo '<pre>'; print_r($this->ee_options); echo '</pre>';
            if (isset($this->tvc_api_data['setting']) && isset($this->tvc_api_data['setting']->plan_id)) {
                $this->plan_id = (int) $this->tvc_api_data['setting']->plan_id;
            }
            $this->render();
        }

        protected function render()
        {
            $ee_options = $this->ee_options;
            $plan_id    = $this->plan_id;
            $is_pro     = ($plan_id !== 1);
            $TVC_Admin_Helper = new TVC_Admin_Helper();

            // In the free version, ORE is always in read-only preview mode to show potential tracked orders
            $is_ore_plan_allowed = false;
            
            $get_ee_options_data = $this->tvc_api_data;
            $subscriptionId = $ee_options['subscription_id'] ?? '';
            $tvc_data = [
                'subscription_id' => $subscriptionId,
                'user_domain'     => get_site_url(),
                'currency_code'   => (function_exists('get_woocommerce_currency')) ? get_woocommerce_currency() : 'USD',
                'timezone_string' => wp_timezone_string(),
                'user_country'    => (class_exists('WooCommerce')) ? WC()->countries->get_base_country() : '',
                'app_id'          => 1,
                'time'            => date("d-M-Y h:i:s A")
            ];
            $googleDetail = $get_ee_options_data['setting'] ?? new stdClass();
            $is_refresh_token_expire = method_exists($TVC_Admin_Helper, 'is_refresh_token_expire') ? $TVC_Admin_Helper->is_refresh_token_expire() : false;

            // Complement tvc_data - prioritize $_GET['g_mail'] from Google auth redirect, fallback to stored value
            $tvc_data['g_mail'] = !empty($_GET['g_mail']) ? sanitize_email(wp_unslash($_GET['g_mail'])) : sanitize_email(get_option('ee_customer_gmail', ''));
            $tvc_data['microsoft_mail'] = sanitize_email(get_option('ee_customer_msmail', ''));
            if ($subscriptionId != "" && isset($googleDetail) && is_object($googleDetail)) {
                $tvc_data['subscription_id'] = $googleDetail->id ?? $subscriptionId;
            }

            // Fetch Dependency Info
            $customer_gmail = !empty($_GET['g_mail']) ? sanitize_email(wp_unslash($_GET['g_mail'])) : get_option('ee_customer_gmail');
            $is_signed_in   = !empty($customer_gmail);

            // GA4 Values
            $ga4_account_id     = !empty($googleDetail->ga4_analytic_account_id) ? $googleDetail->ga4_analytic_account_id : ($ee_options['ga4_analytic_account_id'] ?? ($ee_options['ga_id'] ?? ''));
            $ga4_measurement_id = !empty($googleDetail->measurement_id) ? $googleDetail->measurement_id : ($ee_options['gm_id'] ?? ($ee_options['measurement_id'] ?? ''));
            $ga4_api_secret     = !empty($googleDetail->ga4_api_secret) ? $googleDetail->ga4_api_secret : ($ee_options['ga4_api_secret'] ?? '');
            $ga4_property_id    = !empty($googleDetail->ga4_property_id) ? $googleDetail->ga4_property_id : ($ee_options['ga_id'] ?? '');

            // GAds Values
            $gads_account_id    = $googleDetail->google_ads_id ?? ($ee_options['google_ads_id'] ?? '');
            $gads_send_to       = !empty($ee_options['ore_gads_conversion_id']) ? $ee_options['ore_gads_conversion_id'] : '';

            // FB Values
            $fb_pixel_id        = $ee_options['fb_pixel_id'] ?? '';
            $fb_capi_token      = $ee_options['fb_conversion_api_token'] ?? '';

            // Current toggle values
            $ga4_enabled  = !empty($ee_options['conv_ore_ga4_enabled'])  ? (int) $ee_options['conv_ore_ga4_enabled']  : 0;
            $fb_enabled   = !empty($ee_options['conv_ore_fb_enabled'])   ? (int) $ee_options['conv_ore_fb_enabled']   : 0;
            $gads_enabled = !empty($ee_options['conv_ore_gads_enabled']) ? (int) $ee_options['conv_ore_gads_enabled'] : 0;
            $master_enabled = 1; // Master toggle removed based on USR request

            $nonce = wp_create_nonce('conversios_nonce');
            $connect_url = $TVC_Admin_Helper->get_custom_connect_url_subpage(admin_url() . 'admin.php?page=conversios-purchase-tracking', "ptsettings");
            ?>
            <style>
            :root {
                --conv-ore-bg: #f8fafc;
                --conv-ore-surface: #ffffff;
                --conv-ore-border: #e2e8f0;
                --conv-ore-accent: #2563eb;
                --conv-ore-accent-meta: #0668E1;
                --conv-ore-text-main: #0f172a;
                --conv-ore-text-dim: #64748b;
                --conv-ore-glass: blur(12px);
                --conv-ore-card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            }

            .conv_ore_set_container {
                background: var(--conv-ore-bg);
                color: var(--conv-ore-text-main);
                min-height: 100vh;
                padding-bottom: 120px;
                position: relative;
                margin-top: 20px;
                border: 1px solid var(--conv-ore-border);
            }

            .conv_ore_set_container * { box-sizing: border-box; }

            /* Hero Styles */
            .conv_ore_set_hero {
                position: relative;
                padding: 24px 40px;
                background: #ffffff;
                border-bottom: 1px solid var(--conv-ore-border);
                overflow: hidden;
            }

            .conv_ore_set_hero_content {
                display: flex;
                align-items: center;
                gap: 40px;
                max-width: 1400px;
                margin: 0 auto;
            }

            .conv_ore_set_hero_left { flex: 1.2; }
            .conv_ore_set_hero_right { flex: 0.8; display: flex; justify-content: center; }

            .conv_ore_set_badge {
                display: inline-block;
                background: #eff6ff;
                border: 1px solid #dbeafe;
                color: #2563eb;
                padding: 8px 18px;
                border-radius: 100px;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 1.5px;
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(37, 99, 235, 0.05);
            }

            .conv_ore_set_title {
                font-size: 42px;
                font-weight: 800;
                line-height: 1.1;
                margin: 0 0 20px;
                color: var(--conv-ore-text-main);
                letter-spacing: -1px;
            }

            .conv_ore_set_gradient_text {
                background: linear-gradient(135deg, #2563eb 0%, #0668E1 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .conv_ore_set_subtitle {
                font-size: 18px;
                color: var(--conv-ore-text-dim);
                max-width: 580px;
                line-height: 1.6;
                margin-bottom: 0;
            }

            /* Grid & Cards */
            .conv_ore_set_grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 24px;
                padding: 40px 60px;
                max-width: 1400px;
                margin: 0 auto;
            }

            .conv_ore_set_card {
                background: var(--conv-ore-surface);
                border: 1px solid var(--conv-ore-border);
                border-radius: 16px;
                box-shadow: var(--conv-ore-card-shadow);
                overflow: hidden;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .conv_ore_set_glass {
                background: rgba(255, 255, 255, 0.95);
            }

            .conv_ore_set_card_header {
                padding: 24px 32px;
                border-bottom: 1px solid var(--conv-ore-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: rgba(255,255,255,0.5);
            }

            .conv_ore_set_card_header h3 {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 12px;
                color: var(--conv-ore-text-main);
            }

            .conv_ore_set_card_body {
                padding: 32px;
            }

            /* Ecosystem Sub-cards */
            .conv_ore_ecosystem_row {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }
            .conv_ore_ecosystem_row.cols-3 {
                grid-template-columns: repeat(3, 1fr);
            }

            .conv_ore_inner_card {
                background: #fff;
                padding: 24px;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                transition: all 0.2s ease;
            }
            .conv_ore_inner_card:hover { border-color: var(--conv-ore-accent); }

            .conv_ore_group_title {
                font-size: 14px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: var(--conv-ore-text-dim);
                margin-bottom: 24px;
                display: flex;
                align-items: center;
                gap: 10px;
                border-bottom: 1px solid #f1f5f9;
                padding-bottom: 12px;
            }

            /* Form Elements */
            .conv_ore_field {
                margin-bottom: 20px;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .conv_ore_field label {
                font-size: 12px;
                font-weight: 700;
                color: var(--conv-ore-text-main);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .conv_ore_input {
                background: #ffffff;
                border: 1px solid #cbd5e1;
                border-radius: 10px;
                padding: 10px 16px;
                color: var(--conv-ore-text-main);
                font-size: 14px;
                font-weight: 500;
                transition: all 0.2s;
                width: 100%;
            }
            .conv_ore_input:focus {
                outline: none;
                border-color: var(--conv-ore-accent);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }
            .conv_ore_input:disabled { opacity: 0.6; cursor: not-allowed; background: #f1f5f9; }

            /* Switches */
            .conv_ore_set_switch {
                position: relative;
                display: inline-block;
                width: 50px;
                height: 26px;
            }
            .conv_ore_set_switch input { opacity: 0; width: 0; height: 0; }
            .conv_ore_set_slider {
                position: absolute;
                cursor: pointer;
                top: 0; left: 0; right: 0; bottom: 0;
                background-color: #cbd5e1;
                transition: .4s;
                border-radius: 34px;
            }
            .conv_ore_set_slider:before {
                position: absolute;
                content: "";
                height: 20px;
                width: 20px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            input:checked + .conv_ore_set_slider { background-color: #22c55e; }
            input:checked + .conv_ore_set_slider:before { transform: translateX(24px); }

            /* Auth Hub */
            .conv_ore_auth_hub {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 24px;
                margin-bottom: 32px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }

            /* Footer */
            .conv_ore_set_footer {
                position: fixed;
                bottom: 0; left: 160px; right: 0;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                padding: 24px 60px;
                border-top: 1px solid var(--conv-ore-border);
                z-index: 1000;
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 32px;
                box-shadow: 0 -10px 15px -3px rgba(0, 0, 0, 0.05);
            }

            .conv_ore_btn_glow {
                background: var(--conv-ore-accent);
                color: #fff;
                padding: 14px 32px;
                border-radius: 10px;
                font-weight: 700;
                font-size: 14px;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.39);
            }
            .conv_ore_btn_glow:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45); }
            .conv_ore_btn_glow:disabled { opacity: 0.5; cursor: not-allowed; background: #94a3b8; box-shadow: none; }

            .conv_ore_toast { background: #0f172a; color: #fff; padding: 16px 32px; border-radius: 12px; font-weight: 600; position: fixed; bottom: 100px; left: 50%; transform: translateX(-50%); z-index: 10000; display: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
            .conv_ore_unsaved { color: #f59e0b; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px; }

            /* Stats */
            .conv_ore_stats_grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
            }
            .conv_ore_stat_tile {
                padding: 24px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                text-align: left;
                display: flex;
                flex-direction: column;
            }
            .conv_ore_stat_label { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--conv-ore-text-dim); min-height: 44px; line-height: 1.4; display: flex; align-items: flex-end; margin-bottom: 8px; padding-bottom: 6px; border-bottom: 1px solid rgba(0,0,0,0.08); }
            .conv_ore_stat_value { font-size: 28px; font-weight: 800; color: var(--conv-ore-text-main); }

            /* Select2 Overrides */
            .select2-container--default .select2-selection--single {
                height: 44px;
                border: 1px solid #cbd5e1;
                border-radius: 10px;
                padding: 8px 12px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px; }
            /* Ensure Select2 dropdown renders above modal backdrop */
            .select2-container--open { z-index: 10005 !important; }
            .select2-container--open .select2-dropdown { z-index: 10005 !important; }
            /* Reset DataTables length selector to native compact look */
            .dataTables_length select, #conv_ore_ordertabel_limit { width: 50px !important; height: 28px !important; line-height: 1 !important; padding: 2px 8px !important; border-radius: 4px !important; border: 1px solid #cbd5e1 !important; font-size: 13px !important; }

            @media (max-width: 1200px) {
                .conv_ore_set_hero { padding: 40px; }
                .conv_ore_set_grid { padding: 40px; }
                .conv_ore_ecosystem_row { grid-template-columns: 1fr; }
            }
            @media (max-width: 782px) {
                .conv_ore_set_footer { left: 0; padding: 20px; }
                .conv_ore_set_hero_content { flex-direction: column; text-align: center; }
                .conv_ore_stat_tile { padding: 15px; }
            }

            .d-none { display: none !important; }
            @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
            .spin { animation: spin 1s linear infinite; display: inline-block; vertical-align: middle; }

            /* Order Details Table */
            .conv_ore_details_section { margin-top: 28px; border-top: 1px solid #e2e8f0; padding-top: 24px; }
            .conv_ore_details_header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
            .conv_ore_details_header h4 { margin: 0; font-size: 15px; font-weight: 700; color: var(--conv-ore-text-main); display: flex; align-items: center; gap: 8px; }
            .conv_ore_details_wrap { overflow-x: hidden; border: 1px solid #e2e8f0; border-radius: 10px; }
            .conv_ore_meta_val { max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block; vertical-align: middle; cursor: default; font-family: 'SFMono-Regular', Consolas, monospace; font-size: 11px; }
            .conv_ore_badge_pixel { background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
            .conv_ore_badge_api { background: #dbeafe; color: #1e40af; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
            .conv_ore_badge_skipped { background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
            .conv_ore_badge_none { background: #f1f5f9; color: #94a3b8; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }

            /* dt-control expand/collapse arrow */
            td.dt-control { cursor: pointer; position: relative; }
            td.dt-control::before { content:'\25B6'; display:inline-block; font-size:11px; color:#94a3b8; transition:transform .2s ease; }
            tr.shown td.dt-control::before { transform:rotate(90deg); color:var(--conv-ore-accent,#6366f1); }
            .conv_ore_order_link { color: var(--conv-ore-accent); text-decoration: none; font-weight: 700; }
            .conv_ore_order_link:hover { text-decoration: underline; }
            /* DataTables overrides for ORE table */
            #conv_ore_dt_wrapper .dataTables_wrapper { font-size: 12px; }
            #conv_ore_dt_wrapper table.dataTable { border-collapse: collapse !important; width: 100% !important; }
            #conv_ore_dt_wrapper table.dataTable thead th { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 10px 10px; white-space: nowrap; }
            #conv_ore_dt_wrapper table.dataTable tbody td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 12px; vertical-align: middle; }
            #conv_ore_dt_wrapper table.dataTable tbody tr:hover { background: #f8fafc; }
            #conv_ore_dt_wrapper .dataTables_length, #conv_ore_dt_wrapper .dataTables_filter { padding: 12px 14px; }
            #conv_ore_dt_wrapper .dataTables_length select { border: 1px solid #cbd5e1; border-radius: 6px; padding: 4px 8px; }
            #conv_ore_dt_wrapper .dataTables_filter input { border: 1px solid #cbd5e1; border-radius: 6px; padding: 5px 10px; margin-left: 6px; }
            #conv_ore_dt_wrapper .dataTables_info { padding: 12px 14px; font-size: 12px; color: #64748b; }
            #conv_ore_dt_wrapper .dataTables_paginate { padding: 12px 14px; }
            #conv_ore_dt_wrapper .dataTables_paginate .paginate_button { padding: 4px 12px; border: 1px solid #cbd5e1; border-radius: 6px; margin: 0 2px; font-size: 12px; cursor: pointer; }
            #conv_ore_dt_wrapper .dataTables_paginate .paginate_button.current { background: var(--conv-ore-accent) !important; color: #fff !important; border-color: var(--conv-ore-accent); }
            #conv_ore_dt_wrapper .dataTables_paginate .paginate_button:hover:not(.current) { background: #f1f5f9; }
            #conv_ore_dt_wrapper .dataTables_empty { text-align: center; padding: 40px 12px !important; color: #94a3b8; font-size: 13px; font-weight: 600; }

            /* Modal Styles */
            .conv_ore_modal_backdrop { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 10001; display: none; align-items: center; justify-content: center; }
            .conv_ore_modal { position: relative; background: #fff; width: 100%; max-width: 500px; border-radius: 24px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); animation: modalFadeIn 0.3s ease; }
            @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
            .conv_ore_modal_header { padding: 14px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; position: relative; display: flex; align-items: center; gap: 10px; border-radius: 24px 24px 0 0; }
            .conv_ore_modal_header h3 { margin: 0; font-size: 17px; font-weight: 800; color: #0f172a; }
            .conv_ore_modal_close { position: absolute; top: 20px; right: 20px; cursor: pointer; color: #64748b; font-size: 20px; transition: color 0.2s; }
            .conv_ore_modal_close:hover { color: #0f172a; }
            .conv_ore_modal_body { padding: 20px; overflow-y: auto; overflow-x: hidden; }
            .conv_ore_modal_footer { padding: 0 20px 20px; }
            .conv_ore_modal_alert { padding: 10px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 14px; display: none; line-height: 1.4; }
            .conv_ore_modal_alert.info { background: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; }
            .conv_ore_modal_alert.error { background: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }
            .conv_ore_modal_field { margin-bottom: 14px; }
            .conv_ore_modal_field label { display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 8px; }
            .conv_ore_modal_btn { width: 100%; background: #2563eb; color: #fff; padding: 10px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; }
            .conv_ore_modal_btn:hover:not(:disabled) { background: #1d4ed8; }
            .conv_ore_modal_btn:disabled { opacity: 0.5; cursor: not-allowed; }
            .conv_ore_modal_confirm { display: flex; gap: 10px; font-size: 12px; color: #1e293b; margin-top: 14px; cursor: pointer; align-items: flex-start; padding: 10px; background: #f1f5f9; border-radius: 12px; transition: all 0.2s; border: 1px solid transparent; }
            .conv_ore_modal_confirm:hover { background: #e2e8f0; border-color: #cbd5e1; }
            .conv_ore_modal_confirm input[type="checkbox"] { 
                width: 22px !important; 
                height: 22px !important; 
                min-width: 22px !important; 
                margin: 0 !important; 
                cursor: pointer !important; 
                border: 2px solid #64748b !important;
                border-radius: 6px !important;
                background: #fff !important;
                -webkit-appearance: none !important;
                appearance: none !important;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
            }
            .conv_ore_modal_confirm input[type="checkbox"]:checked {
                background-color: #2563eb !important;
                border-color: #2563eb !important;
            }
            .conv_ore_modal_confirm input[type="checkbox"]:checked::after {
                content: '✓';
                color: #fff;
                font-size: 16px;
                font-weight: 900;
                position: absolute;
            }
            .conv_ore_modal_confirm span { line-height: 1.5; user-select: none; font-weight: 500; }
            .conv_ore_display_box { padding: 9px 16px; border: 1px solid #cbd5e1; border-radius: 10px; background: #f8fafc; font-size: 13px; font-weight: 500; height: 38px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; line-height: 18px; }
            .conv-fullscreen-loader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 99999; display: flex; justify-content: center; align-items: center; }
            .disabledsection {
                opacity: 0.5;
                pointer-events: none;
                cursor: not-allowed;
                filter: grayscale(0.5);
            }
            .daterangepicker { box-sizing: border-box; z-index: 99999; font-family: inherit; }
            .daterangepicker * { box-sizing: border-box; }
            .daterangepicker table { margin: 0; }
            .daterangepicker th, .daterangepicker td { padding: 4px; border-radius: 4px; min-width: 32px; height: 32px; line-height: 24px; }
        </style>

            <div class="conv_ore_set_container" id="conv_ore_root">
                
                <div id="conv_ore_toast" class="conv_ore_toast">Ecosystem Synchronized.</div>



                <header class="conv_ore_set_hero">
                    <div class="conv_ore_set_hero_content">
                        <div class="conv_ore_set_hero_left" style="flex: 1; text-align: left;">
                            <div class="conv_ore_set_badge" style="margin-bottom: 12px;">
                                <span class="dashicons dashicons-visibility" style="font-size: 14px; width: 14px; height: 14px; line-height: 14px; margin-right: 6px;"></span>
                                RECOVERY ENGINE <?php echo $is_ore_plan_allowed ? 'ACTIVE' : 'PREVIEW'; ?>
                            </div>
                            <h1 class="conv_ore_set_title" style="font-size: 24px; margin-bottom: 8px;">Order Recovery <span class="conv_ore_set_gradient_text">Engine</span></h1>
                            <p class="conv_ore_set_subtitle" style="font-size: 14px; max-width: 800px; margin-bottom: 0;">Align browser and server-side tracking across Google and Meta. Ensure accurate attribution for every conversion.</p>
                        </div>
                    </div>
                </header>

                <main class="conv_ore_set_grid">
                    <!-- Stats Card -->
                    <div class="conv_ore_set_card conv_ore_set_glass">
                        <div class="conv_ore_set_card_header">
                            <h3><span class="dashicons dashicons-chart-area" style="color:var(--conv-ore-accent)"></span> Performance Summary</h3>
                            <div style="margin-left: auto; display: flex; align-items: center; gap: 10px;">
                                <button id="btn_ore_manual_sync" class="button button-small d-none" style="border-radius: 8px; font-weight: 700; color: #64748b; background: #fff;">
                                    <span class="dashicons dashicons-update" style="font-size: 14px; width: 14px; height: 14px; line-height: 14px; margin-top: 4px;"></span> Sync Now
                                </button>
                                <div id="conv_ore_report_daterange" class="button button-small" style="border-radius: 8px; border-color: #cbd5e1;">
                                    <span class="dashicons dashicons-calendar-alt"></span> <span class="daterange-text">Syncing Stats...</span>
                                </div>
                            </div>
                        </div>
                        <div class="conv_ore_set_card_body">
                            <div class="conv_ore_stats_grid">
                                <div class="conv_ore_stat_tile"><div class="conv_ore_stat_label">Total<br>Orders</div><div class="conv_ore_stat_value" id="stat_total">0</div></div>
                                <div class="conv_ore_stat_tile"><div class="conv_ore_stat_label" style="color:#22c55e">Already<br>Tracked</div><div class="conv_ore_stat_value" id="stat_client">0</div></div>
                                <div class="conv_ore_stat_tile">
                                    <div class="conv_ore_stat_label" style="color:#ef4444; display:flex; align-items:center; gap:5px;">
                                        <span>Missed<br>Conversions</span>
                                        <div class="conv_ore_stat_tooltip" style="position:relative; display:inline-block; cursor:pointer;" title="Why might some metrics not match 'Total Orders'?

Due to strict browser privacy features (Apple iOS 14.5+ ATT), aggressive adblockers (Brave, uBlock), or users opting out of cookies, some orders entirely block the generation of necessary click trackers (like _fbp, user_agent, and gclid).

When major tracking parameters are destroyed natively by the user's browser, the server-side recovery engine skips sending them to ensure compliance with privacy laws and Meta/Google policies. This is normal behavior.">
                                            <span class="dashicons dashicons-editor-help" style="font-size: 14px; width: 14px; height: 14px; color: #94a3b8;"></span>
                                        </div>
                                    </div>
                                    <div class="conv_ore_stat_value" id="stat_server">0</div>
                                    <div id="stat_server_breakdown" style="font-size: 11px; margin-top: 8px; color: #64748b; font-weight: 600; line-height: 1.4; display:none;"></div>
                                </div>
                                <div class="conv_ore_stat_tile"><div class="conv_ore_stat_label" style="color:#ef4444">Missed<br>Revenue</div><div class="conv_ore_stat_value" id="stat_recovered_revenue"><?php echo html_entity_decode(get_woocommerce_currency_symbol()); ?>0</div></div>
                            </div>

                            <?php
                                $ore_last_cron = get_option('conv_ore_last_cron', '');
                                $ore_next_cron_ts = wp_next_scheduled('conv_dbnewfeature_schedule_hook');
                                $ore_next_cron = $ore_next_cron_ts ? get_date_from_gmt(gmdate('Y-m-d H:i:s', $ore_next_cron_ts), 'M j, Y g:i A') : '';
                                $ore_last_display = $ore_last_cron ? date('M j, Y g:i A', strtotime($ore_last_cron)) : 'NA';
                                $ore_next_title = '';
                                if ($ore_next_cron_ts) {
                                    $time_diff = $ore_next_cron_ts - time();
                                    $abs_diff = abs($time_diff);
                                    $hours = floor($abs_diff / 3600);
                                    $minutes = floor(($abs_diff % 3600) / 60);
                                    $time_str = [];
                                    if ($hours > 0) $time_str[] = $hours . 'h';
                                    if ($minutes > 0 || empty($time_str)) $time_str[] = $minutes . 'm';
                                    
                                    if ($time_diff > 0) {
                                        $ore_next_title = 'In ' . implode(' ', $time_str);
                                    } else {
                                        $ore_next_title = 'Overdue by ' . implode(' ', $time_str);
                                    }
                                }
                            ?>
                            <div id="ore_cron_info" style="margin: 10px 0 0; font-size: 11px; color: #94a3b8; line-height: 1.8; display: flex; gap: 20px; flex-wrap: wrap;">
                                <span><span class="dashicons dashicons-backup" style="font-size: 13px; width: 13px; height: 13px; line-height: 1; vertical-align: middle; margin-right: 3px; color: #64748b;"></span> Last Cron: <strong id="ore_last_cron_time" style="color: <?php echo $ore_last_cron ? '#0f172a' : '#000'; ?>"><?php echo esc_html($ore_last_display); ?></strong></span>
                                <?php if ($ore_next_cron) : ?>
                                <span title="<?php echo esc_attr($ore_next_title); ?>" style="cursor:help; border-bottom: 1px dotted #94a3b8;"><span class="dashicons dashicons-clock" style="font-size: 13px; width: 13px; height: 13px; line-height: 1; vertical-align: middle; margin-right: 3px; color: #64748b;"></span> Next Cron: <strong style="color: #0f172a;"><?php echo esc_html($ore_next_cron); ?></strong></span>
                                <?php else : ?>
                                <span><span class="dashicons dashicons-clock" style="font-size: 13px; width: 13px; height: 13px; line-height: 1; vertical-align: middle; margin-right: 3px; color: #64748b;"></span> Next Cron: <strong style="color: #000;">NA</strong></span>
                                <?php endif; ?>
                            </div>
                            <?php if (defined('DISABLE_WP_CRON') && DISABLE_WP_CRON) : ?>
                            <div style="margin-top: 10px; padding: 10px; background-color: #fffbeb; border-left: 3px solid #f59e0b; font-size: 11px; color: #92400e; border-radius: 4px;">
                                <strong style="color: #b45309;"><span class="dashicons dashicons-warning" style="font-size: 14px; width: 14px; height: 14px; line-height: 1; vertical-align: middle;"></span> WP-Cron is Disabled:</strong> The <code>DISABLE_WP_CRON</code> constant is set to true on this website. 
                                <?php if (isset($time_diff) && $time_diff < -3600) : ?>
                                <br><span style="color: #ef4444; font-weight: 600;">⚠️ Critical Issue:</span> The background synchronization is severely overdue. Your server-level cron job is not configured correctly or is failing. Please set up a server cron (e.g., via cPanel) to trigger <code>wp-cron.php</code> regularly, or remove the constant from <code>wp-config.php</code>.
                                <?php else : ?>
                                Ensure that a server-level cron job is configured to trigger <code>wp-cron.php</code> regularly, otherwise background synchronization will not run.
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <div style="margin-top: 24px; margin-bottom: 24px; padding: 16px 20px; background: #fff5f5; border: 1px solid #fecaca; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                                <div style="display: flex; align-items: center; gap: 16px;">
                                    <div style="background: #ef4444; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 0 4px rgba(239,68,68,0.2);">
                                        <span class="dashicons dashicons-warning" style="font-size: 20px; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"></span>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0 0 4px 0; color: #991b1b; font-size: 16px; font-weight: 700;">You are actively losing tracked revenue!</h4>
                                        <p style="margin: 0; color: #b91c1c; font-size: 13px;">Ad-blockers and privacy updates are blinding your campaigns. <br> Order Recovery Engine seamlessly restores your lost sales data.</p>
                                    </div>
                                </div>
                                <a href="<?php echo esc_url('https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=rednudge&utm_campaign=upgrade&plugin_name=aio'); ?>" target="_blank" class="button" style="background: #ef4444; border-color: #dc2626; color: #fff; font-weight: 700; text-shadow: none; font-size: 14px; padding: 4px 16px; height: 38px; line-height: 28px; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3); transition: all 0.2s;">Unlock Order Recovery Engine Now &rarr;</a>
                            </div>

                            <!-- Order Details Table (DataTables SSP) -->
                            <div class="conv_ore_details_section">
                                <div class="conv_ore_details_header">
                                    <h4><span class="dashicons dashicons-editor-table" style="color:var(--conv-ore-accent); font-size: 18px; width: 18px; height: 18px;"></span> Order Details</h4>
                                </div>
                                <div id="conv_ore_dt_wrapper" class="conv_ore_details_wrap">
                                    <table id="conv_ore_datatable" class="table conv_bordershadow rounded row-border table-borderless w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-start text-truncate">Order #</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Tracking</th>
                                                <th class="text-truncate">Synced Channels</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </main>


            </div>

            <!-- GA4 Assistant Modal -->
            <div id="ga4_assistant_modal" class="conv_ore_modal_backdrop">
                <div class="conv_ore_modal">
                    <div class="conv_ore_modal_header">
                        <div class="conv_ore_modal_close"><span class="dashicons dashicons-no-alt"></span></div>
                        <img src="<?php echo ENHANCAD_PLUGIN_URL; ?>/admin/images/logos/conv_ganalytics_logo.png" style="width: 28px;" alt="">
                        <h3>Google Analytics Settings</h3>
                    </div>
                    <div class="conv_ore_modal_body">
                        <div id="modal_alert_info" class="conv_ore_modal_alert info" style="display: block;">
                            <strong>Logged in as:</strong> <?php echo !empty($customer_gmail) ? esc_html($customer_gmail) : 'Not Connected'; ?>
                        </div>
                        <div id="modal_alert_error" class="alert alert-danger" style="display:none; font-size: 13px; line-height: 1.5; padding: 12px; margin-bottom: 15px; border-radius: 6px;"></div>
                        
                        <div class="conv_ore_modal_field">
                            <label>Analytics Account</label>
                            <select id="modal_ga4_account" class="conv_ore_input selecttwo">
                                <option value="">Loading accounts...</option>
                            </select>
                        </div>
                        
                        <div class="conv_ore_modal_field">
                            <label>Measurement ID</label>
                            <div id="modal_ga4_property_wrapper" class="disabledsection">
                                <select id="modal_ga4_property" class="conv_ore_input selecttwo" disabled>
                                    <option value="">Select an account first</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="conv_ore_modal_field">
                            <label style="display: flex; justify-content: space-between; align-items: center;">
                                API Secret (Token)
                                <button type="button" id="btn_modal_create_secret" class="button button-small" style="display: none; height: 24px; line-height: 22px; font-size: 11px;">+ Create New</button>
                            </label>
                            <div id="modal_ga4_secret_wrapper" class="disabledsection">
                                <select id="modal_ga4_secret" class="conv_ore_input selecttwo" disabled>
                                    <option value="">Select a property first</option>
                                </select>
                            </div>
                        </div>

                        <label class="conv_ore_modal_confirm disabledsection" id="modal_ga4_confirm_wrapper">
                            <input type="checkbox" id="modal_ga4_confirm" disabled>
                            <span>I confirm that events will be tracked using the selected Measurement ID, and the data will be synced for Order Recovery.</span>
                        </label>
                    </div>
                    <div class="conv_ore_modal_footer">
                        <button id="btn_modal_save_ga4" class="conv_ore_modal_btn" disabled>Save Configuration</button>
                    </div>
                </div>
            </div>

            <!-- GAds Assistant Modal -->
            <div id="gads_assistant_modal" class="conv_ore_modal_backdrop">
                <div class="conv_ore_modal">
                    <div class="conv_ore_modal_header">
                        <div class="conv_ore_modal_close"><span class="dashicons dashicons-no-alt"></span></div>
                        <img src="<?php echo ENHANCAD_PLUGIN_URL; ?>/admin/images/logos/conv_gads_logo.png" style="width: 48px; margin-bottom: 12px;" alt="">
                        <h3>Google Ads Settings</h3>
                    </div>
                    <div class="conv_ore_modal_body">
                        <div class="conv_ore_modal_alert info" style="display: block;">
                            <strong>Logged in as:</strong> <?php echo !empty($customer_gmail) ? esc_html($customer_gmail) : 'Not Connected'; ?>
                        </div>
                        <div id="gads_modal_error" class="alert alert-danger" style="display:none; font-size: 13px; line-height: 1.5; padding: 12px; margin-bottom: 15px; border-radius: 6px;"></div>
                        
                        <div class="conv_ore_modal_field">
                            <label>Google Ads Account</label>
                            <select id="modal_gads_account" class="conv_ore_input selecttwo">
                                <option value="">Loading accounts...</option>
                            </select>
                        </div>
                        
                        <div class="conv_ore_modal_field">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <label style="margin-bottom: 0;">Conversion Action (API)</label>
                                <button type="button" id="btn_modal_create_gads_conversion" class="button button-small" style="display: none; height: 24px; line-height: 22px; font-size: 11px;">
                                    <span class="dashicons dashicons-plus" style="font-size: 14px; width: 14px; height: 14px; line-height: 22px;"></span> Create New
                                </button>
                            </div>
                            <div style="font-size: 11px; color: #64748b; margin-bottom: 8px; line-height: 1.4;">Conversions measured and securely sent server-side via the Google Ads API.</div>
                            <div id="modal_gads_label_wrapper" class="disabledsection">
                                <select id="modal_gads_label" class="conv_ore_input selecttwo" disabled>
                                    <option value="">Select an account first</option>
                                </select>
                            </div>
                        </div>

                        <label class="conv_ore_modal_confirm disabledsection" id="modal_gads_confirm_wrapper">
                            <input type="checkbox" id="modal_gads_confirm" disabled>
                            <span>I confirm that conversions will be tracked using the selected Google Ads Account and Conversion Action.</span>
                        </label>
                    </div>
                    <div class="conv_ore_modal_footer">
                        <button id="btn_modal_save_gads" class="conv_ore_modal_btn" disabled>Save Configuration</button>
                    </div>
                </div>
            </div>

            <!-- Meta Assistant Modal -->
            <div id="meta_assistant_modal" class="conv_ore_modal_backdrop">
                <div class="conv_ore_modal">
                    <div class="conv_ore_modal_header">
                        <div class="conv_ore_modal_close"><span class="dashicons dashicons-no-alt"></span></div>
                        <img src="<?php echo ENHANCAD_PLUGIN_URL; ?>/admin/images/logos/conv_meta_logo.png" style="width: 48px; margin-bottom: 12px;" alt="">
                        <h3>Meta Settings</h3>
                    </div>
                    <div class="conv_ore_modal_body">
                        <div class="conv_ore_modal_alert info" style="display: block;">
                            Manually configure your Meta Pixel and Conversions API (CAPI) access token.<br>
                            <a href="https://www.conversios.io/docs/sst-pro-setup-meta-facebook-pixel-capi/?utm_source=woo_aiopro_plugin&utm_medium=ore_meta_modal&utm_campaign=capi_help" target="_blank" style="font-weight: 700; color: #1e40af; text-decoration: underline; display: inline-block; margin-top: 6px;">How to find Pixel ID and CAPI Token &rarr;</a>
                        </div>
                        <div id="meta_modal_error" class="conv_ore_modal_alert error"></div>
                        
                        <div class="conv_ore_modal_field">
                            <label>Meta Pixel ID</label>
                            <input type="text" id="modal_fb_pixel_id" class="conv_ore_input" placeholder="e.g. 1029384756473">
                        </div>
                        
                        <div class="conv_ore_modal_field">
                            <label>Meta CAPI Token</label>
                            <textarea id="modal_fb_capi_token" class="conv_ore_input" style="height: 100px; resize: none;" placeholder="EAAB..."></textarea>
                        </div>
                    </div>
                    <div class="conv_ore_modal_footer">
                        <button id="btn_modal_save_meta" class="conv_ore_modal_btn">Save Configuration</button>
                    </div>
                </div>
            </div>

            <script>
            jQuery(document).ready(function() {
                const nonce = '<?php echo esc_js($nonce); ?>';
                const ajaxUrl = '<?php echo esc_url_raw(admin_url("admin-ajax.php")); ?>';
                const onboardingNonce = '<?php echo wp_create_nonce("conversios_onboarding_nonce"); ?>';
                const pixSavNonce = '<?php echo wp_create_nonce("pix_sav_nonce_val"); ?>';
                const tvc_data = <?php echo wp_json_encode($tvc_data); ?>;
                const subId = '<?php echo esc_js($subscriptionId); ?>';
                const ga4SecretsCache = {}; // Cache for MP secrets to avoid 429s

                function showToast(msg) { jQuery('#conv_ore_toast').text(msg).fadeIn(300).delay(2500).fadeOut(400); }
                jQuery('.selecttwo').not('.conv_ore_modal_backdrop .selecttwo').select2({ width: '100%' });

                <?php if (!$is_ore_plan_allowed): ?>
                // Disable all inputs in preview mode to make it fully read-only without blurring
                jQuery('.conv_ore_set_container input, .conv_ore_set_container select, .conv_ore_set_container textarea, .conv_ore_set_container button').prop('disabled', true);
                // Keep the upgrade button and daterangepicker enabled
                jQuery('.conv_ore_set_container a').css('pointer-events', 'auto');
                jQuery('#conv_ore_report_daterange').prop('disabled', false).css('pointer-events', 'auto');
                <?php endif; ?>

                function checkAndToggleGadsRequirements() {
                    const accId = jQuery('#google_ads_id').val();
                    if (!accId || accId === 'Not Selected') {
                        jQuery('#gads_requirements_notice').hide();
                        return;
                    }
                    jQuery.post(ajaxUrl, {
                        action: 'conv_check_gads_tracking_setting',
                        TVCNonce: '<?php echo wp_create_nonce("con_get_conversion_list-nonce"); ?>',
                        gads_id: accId
                    }, function(response) {
                        try {
                            const res = typeof response === 'string' ? JSON.parse(response) : response;
                            if (res && !res.error && res.data) {
                                const dataObj = Array.isArray(res.data) ? res.data[0] : res.data;
                                // If the property exists AND is true, hide it. Otherwise show it.
                                if (dataObj && dataObj.accepted_customer_data_terms === true) {
                                    jQuery('#gads_requirements_notice').hide();
                                } else {
                                    jQuery('#gads_requirements_notice').css('display', 'flex');
                                }
                            } else {
                                jQuery('#gads_requirements_notice').css('display', 'flex');
                            }
                        } catch (e) {
                            jQuery('#gads_requirements_notice').css('display', 'flex');
                        }
                    });
                }
                
                // Trigger check on load
                checkAndToggleGadsRequirements();

                jQuery(document).on('change input', 'input:not([aria-controls="conv_ore_datatable"]), select:not([name="conv_ore_datatable_length"])', function() {
                    jQuery('#btn_save_settings').prop('disabled', false);
                    jQuery('#unsaved_notice').removeClass('d-none');
                });

                // --- Channel Toggle Validation ---
                // Prevent enabling a channel if required settings are not configured.
                // GA4 requires: GA4 Account ID, Measurement ID, API Secret
                // Google Ads requires: Conversion ID, Conversion Label
                // Meta requires: Meta Pixel ID, Access Token

                jQuery('#conv_ore_ga4_enabled').on('change', function() {
                    if (jQuery(this).is(':checked')) {
                        const hasAccount = jQuery('#ga4_analytic_account_id').val();
                        const hasMeasurement = jQuery('#ga4_property_id').val();
                        const hasSecret = jQuery('#ga4_api_secret').val();
                        if (!hasAccount || !hasMeasurement || !hasSecret) {
                            jQuery(this).prop('checked', false);
                            jQuery('#btn_ga4_assistant').trigger('click');
                            return;
                        }
                        jQuery('.ga4-dep').removeClass('disabledsection');
                    } else {
                        jQuery('.ga4-dep').addClass('disabledsection');
                    }
                });

                jQuery('#conv_ore_gads_enabled').on('change', function() {
                    if (jQuery(this).is(':checked')) {
                        const sendTo = jQuery('#ee_conversio_send_to').val();
                        if (!sendTo) {
                            jQuery(this).prop('checked', false);
                            jQuery('#btn_gads_assistant').trigger('click');
                            return;
                        }
                        jQuery('.gads-dep').removeClass('disabledsection');
                    } else {
                        jQuery('.gads-dep').addClass('disabledsection');
                    }
                });

                jQuery('#conv_ore_fb_enabled').on('change', function() {
                    if (jQuery(this).is(':checked')) {
                        const hasPixel = jQuery('#fb_pixel_id').val();
                        const hasToken = jQuery('#fb_conversion_api_token').val();
                        if (!hasPixel || !hasToken) {
                            jQuery(this).prop('checked', false);
                            jQuery('#btn_meta_assistant').trigger('click');
                            return;
                        }
                        jQuery('.meta-dep').removeClass('disabledsection');
                    } else {
                        jQuery('.meta-dep').addClass('disabledsection');
                    }
                });

                // --- GA4 Assistant Modal Logic ---
                jQuery('#btn_ga4_assistant').on('click', function(e) {
                    e.preventDefault();
                    if (!<?php echo $is_signed_in ? 'true' : 'false'; ?>) {
                        alert('Please sign in with Google first.');
                        return;
                    }
                    const modal = jQuery('#ga4_assistant_modal');
                    modal.css('display', 'flex');
                    // Reset modal state
                    jQuery('#modal_ga4_confirm').prop('checked', false).prop('disabled', true);
                    jQuery('#modal_ga4_confirm_wrapper').addClass('disabledsection');
                    jQuery('#btn_modal_save_ga4').prop('disabled', true);
                    
                    // Wait for modal animation to complete before initializing Select2
                    setTimeout(function() {
                        jQuery('#modal_ga4_account, #modal_ga4_property, #modal_ga4_secret').each(function() {
                            if (jQuery(this).hasClass('select2-hidden-accessible')) {
                                jQuery(this).select2('destroy');
                            }
                        });
                        jQuery('#modal_ga4_account, #modal_ga4_property, #modal_ga4_secret').select2({
                            width: '100%',
                            dropdownParent: modal.find('.conv_ore_modal')
                        });
                        loadModalAccounts();
                    }, 400);
                });

                // Google Selection Assistant (GAds)
                jQuery('#btn_gads_assistant').on('click', function(e) {
                    e.preventDefault();
                    if (!<?php echo $is_signed_in ? 'true' : 'false'; ?>) {
                        alert('Please connect your Google Account first.');
                        return;
                    }
                    const modal = jQuery('#gads_assistant_modal');
                    modal.css('display', 'flex');
                    jQuery('#modal_gads_confirm').prop('checked', false).prop('disabled', true);
                    jQuery('#modal_gads_confirm_wrapper').addClass('disabledsection');
                    jQuery('#btn_modal_save_gads').prop('disabled', true);

                    // Wait for modal animation to complete before initializing Select2
                    setTimeout(function() {
                        jQuery('#modal_gads_account, #modal_gads_label').each(function() {
                            if (jQuery(this).hasClass('select2-hidden-accessible')) {
                                jQuery(this).select2('destroy');
                            }
                        });
                        jQuery('#modal_gads_account, #modal_gads_label').select2({
                            width: '100%',
                            dropdownParent: modal.find('.conv_ore_modal')
                        });
                        loadModalGAdsAccounts();
                    }, 400);
                });

                jQuery('.conv_ore_modal_close').on('click', function() {
                    jQuery(this).closest('.conv_ore_modal_backdrop').hide();
                });

                // Auto-Open Popups on load
                setTimeout(function() {
                    if (!<?php echo $is_signed_in ? 'true' : 'false'; ?>) return;

                    if (jQuery('#conv_ore_ga4_enabled').is(':checked')) {
                        if (!jQuery('#ga4_analytic_account_id').val() || !jQuery('#ga4_property_id').val() || !jQuery('#ga4_api_secret').val()) {
                            jQuery('#btn_ga4_assistant').trigger('click');
                            return; 
                        }
                    }
                    if (jQuery('#conv_ore_gads_enabled').is(':checked')) {
                        if (!jQuery('#google_ads_id').val()) {
                            jQuery('#btn_gads_assistant').trigger('click');
                        }
                    }
                }, 1000);

                function loadModalAccounts() {
                    jQuery('#modal_ga4_account').html('<option value="">Loading...</option>');
                    jQuery.post(ajaxUrl, { action: "get_analytics_account_list", tvc_data: JSON.stringify(tvc_data), conversios_onboarding_nonce: onboardingNonce }, function(res) {
                        if (typeof res === "string") { try { res = JSON.parse(res); } catch(e) { console.error("Acc list parse error", e); } }
                        const data = res?.data || res;
                        const items = data?.items;
                        if (res && (res.error === false || res.success) && items) {
                            let html = '<option value="">-- Select Account --</option>';
                            items.forEach(i => {
                                html += `<option value="${i.id}">${i.name} (${i.id})</option>`;
                            });
                            jQuery('#modal_ga4_account').html(html);
                            
                            const savedAccId = jQuery('#ga4_analytic_account_id').val();
                            if (savedAccId && jQuery('#modal_ga4_account option[value="' + savedAccId + '"]').length > 0) {
                                jQuery('#modal_ga4_account').val(savedAccId);
                            }
                            
                            jQuery('#modal_ga4_account').trigger('change');
                        } else {
                            const errorMsg = res?.data?.message || res?.message || 'Could not load accounts.';
                            jQuery('#modal_alert_error').text(errorMsg).show();
                            jQuery('#modal_ga4_account').trigger('change');
                        }
                    });
                }

                jQuery('#modal_ga4_account').on('change', function() {
                    const accId = jQuery(this).val();
                    if (!accId) {
                        jQuery('#modal_ga4_property').html('<option value="">Select an account first</option>').prop('disabled', true);
                        return;
                    }
                    jQuery('#modal_ga4_property').html('<option value="">Loading properties...</option>').prop('disabled', true);
                    jQuery('#modal_ga4_property_wrapper').addClass('disabledsection');
                    jQuery.post(ajaxUrl, { action: "get_analytics_web_properties", tvc_data: JSON.stringify(tvc_data), account_id: accId, type: 'GA4', conversios_onboarding_nonce: onboardingNonce }, function(res) {
                        if (typeof res === "string") { try { res = JSON.parse(res); } catch(e) { console.error("Property parse error", e); } }
                        const data = res?.data || res;
                        const items = data?.items || data?.wep_measurement;
                        if (res && (res.error === false || res.success) && items) {
                            let html = '<option value="">-- Select Property --</option>';
                            items.forEach(i => {
                                const mId = i.measurementId || i.id;
                                // GA4 numeric ID is often in i.id, i.propertyId, or part of i.name (e.g. 'properties/12345')
                                let pId = i.id || i.propertyId || i.property_id;
                                if (i.name && i.name.indexOf('properties/') !== -1) {
                                    pId = i.name.split('/')[1];
                                }
                                html += `<option value="${mId}" data-propid="${pId}">${mId} - ${i.name || i.displayName}</option>`;
                            });
                            jQuery('#modal_ga4_property').html(html);
                            
                            const savedPropId = jQuery('#ga4_property_id').val();
                            if (savedPropId && jQuery('#modal_ga4_property option[value="' + savedPropId + '"]').length > 0) {
                                jQuery('#modal_ga4_property').val(savedPropId);
                            }
                            
                            jQuery('#modal_ga4_property').prop('disabled', false).trigger('change');
                            jQuery('#modal_ga4_property_wrapper').removeClass('disabledsection');
                        } else {
                            jQuery('#modal_alert_error').text('Could not load properties.').show();
                        }
                    });
                });

                jQuery('#modal_ga4_property').on('change', function() {
                    const accId = jQuery('#modal_ga4_account').val();
                    const propId = jQuery(this).val();
                    if (!accId || !propId) {
                        jQuery('#modal_ga4_secret').html('<option value="">Select a property first</option>').prop('disabled', true);
                        jQuery('#modal_ga4_secret_wrapper').addClass('disabledsection');
                        jQuery('#btn_modal_create_secret').hide();
                        return;
                    }
                    const numericPropId = jQuery(this).find('option:selected').data('propid');
                    const cacheKey = `${accId}_${propId}_${numericPropId}`;

                    if (ga4SecretsCache[cacheKey]) {
                        renderSecrets(ga4SecretsCache[cacheKey]);
                        jQuery('#btn_modal_create_secret').hide();
                        return;
                    }

                    jQuery('#modal_ga4_secret').html('<option value="">Loading secrets...</option>').prop('disabled', true);
                    jQuery('#modal_ga4_secret_wrapper').addClass('disabledsection');
                    jQuery('#btn_modal_create_secret').hide();
                    
                    jQuery.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        global: false,
                        data: {
                            action: 'conv_fetch_ga4_mp_secrets',
                            nonce: '<?php echo wp_create_nonce("ga4_mp_secrets_nonce"); ?>',
                            measurement_id: propId,
                            ga4_property_id: numericPropId,
                            account_id: accId
                        },
                        success: function(res) {
                            if (typeof res === "string") { try { res = JSON.parse(res); } catch(e) {} }
                            
                            let secrets = [];
                            if (res.data && Array.isArray(res.data)) {
                                secrets = res.data;
                            } else {
                                const data = res?.data || res;
                                const secret = data?.secret || res?.secret || data?.secretValue;
                                const name = data?.displayName || secret;
                                secrets = data?.items || (secret ? [{id: secret, name: name}] : []);
                            }
                            
                            const isSuccess = (res.success || res.error === false || res.status === 200 || res.status === "200");
                            if (isSuccess && secrets && secrets.length > 0) {
                                jQuery('#modal_alert_error').hide();
                                ga4SecretsCache[cacheKey] = secrets;
                                renderSecrets(secrets);
                                jQuery('#btn_modal_create_secret').hide();
                            } else {
                                if (res.error === true || (res.status && res.status !== 200 && res.status !== "200")) {
                                    let errorRaw = res?.errors?.[0] || res?.message || res?.data?.message || res?.error?.message || 'Failed to fetch secrets.';
                                    if (Array.isArray(errorRaw) && errorRaw.length > 0) errorRaw = errorRaw[0];
                                    let displayError = typeof errorRaw === 'string' ? errorRaw : JSON.stringify(errorRaw);
                                    if (displayError.indexOf('User Data Collection Acknowledgement') !== -1) {
                                        displayError = `<strong>Action Required:</strong> The User Data Collection Acknowledgement must be attested on this property before measurement protocol secrets may be created.<br><br><strong>How to fix:</strong> Open your <a href="https://analytics.google.com/" target="_blank">Google Analytics</a> account &rarr; Go to <strong>Admin</strong> (gear icon) &rarr; Under <em>Data collection and modification</em> click <strong>Data collection</strong> &rarr; Click <strong>I Acknowledge</strong> in the User Data Collection Acknowledgement section.<br><br>Please check <a href="https://www.conversios.io/docs/ga4-user-data-collection-acknowledgement-steps/?utm_source=woo_aiopro_plugin&utm_medium=ore_ga4_modal&utm_campaign=ga4_secret_help" target="_blank" style="color: #2563eb; font-weight: 600; text-decoration: underline;">this document for more details</a>.`;
                                    }
                                    jQuery('#modal_alert_error').html(displayError).show();
                                    jQuery('#modal_ga4_secret').html(`<option value="">-- No Secret Available --</option>`).prop('disabled', true).trigger('change');
                                    jQuery('#modal_ga4_secret_wrapper').addClass('disabledsection');
                                    jQuery('#btn_modal_create_secret').show();
                                } else {
                                    // Empty secrets, auto-create
                                    jQuery('#modal_alert_error').hide();
                                    jQuery('#modal_ga4_secret').html('<option value="">Auto-creating secret...</option>').prop('disabled', true);
                                    jQuery('#modal_ga4_secret_wrapper').addClass('disabledsection');
                                    jQuery('#btn_modal_create_secret').trigger('click');
                                }
                            }
                        }
                    });
                });

                jQuery('#modal_ga4_secret').on('change', function() {
                    const hasSecret = jQuery(this).val();
                    if (hasSecret) {
                        jQuery('#modal_ga4_confirm').prop('disabled', false).trigger('change');
                        jQuery('#modal_ga4_confirm_wrapper').removeClass('disabledsection');
                    } else {
                        jQuery('#modal_ga4_confirm').prop('disabled', true).prop('checked', false).trigger('change');
                        jQuery('#modal_ga4_confirm_wrapper').addClass('disabledsection');
                    }
                });

                function renderSecrets(secrets) {
                    let html = '<option value="">-- Select Secret --</option>';
                    secrets.forEach(s => {
                        const val = s.secretValue || s.id || s.secret || (typeof s === 'string' ? s : '');
                        const dispName = s.displayName || s.name || val;
                        const text = (dispName && val && dispName !== val) ? `${dispName} (${val})` : (dispName || val);
                        html += `<option value="${val}">${text}</option>`;
                    });
                    jQuery('#modal_ga4_secret').html(html);
                    
                    const savedSecret = jQuery('#ga4_api_secret').val();
                    if (savedSecret && jQuery('#modal_ga4_secret option[value="' + savedSecret + '"]').length > 0) {
                        jQuery('#modal_ga4_secret').val(savedSecret);
                    } else if (secrets.length === 1) {
                        const s = secrets[0];
                        const val = s.id || s.secret || s.secretValue || (typeof s === 'string' ? s : '');
                        jQuery('#modal_ga4_secret').val(val);
                    }
                    
                    jQuery('#modal_ga4_secret').prop('disabled', false).trigger('change');
                    jQuery('#modal_ga4_secret_wrapper').removeClass('disabledsection');
                    jQuery('#btn_modal_create_secret').hide(); 
                }

                jQuery('#btn_modal_create_secret').on('click', function(e) {
                    e.preventDefault();
                    const accId = jQuery('#modal_ga4_account').val();
                    const propId = jQuery('#modal_ga4_property').val();
                    const numericPropId = jQuery('#modal_ga4_property option:selected').data('propid');
                    if(!accId || !propId) return;

                    const btn = jQuery(this);
                    const originalText = btn.text();
                    btn.prop('disabled', true).text('Creating...');
                    
                    jQuery.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        global: false,
                        data: {
                            action: 'conv_create_ga4_mp_secret',
                            nonce: '<?php echo wp_create_nonce("ga4_mp_secrets_nonce"); ?>',
                            measurement_id: propId,
                            ga4_property_id: numericPropId,
                            account_id: accId
                        },
                        success: function(res) {
                            if (typeof res === "string") { try { res = JSON.parse(res); } catch(e) {} }
                            if (res.success || res.error === false) {
                                jQuery('#modal_alert_error').hide();
                                showToast('Secret created successfully.');
                                const item = res.data;
                                if (item && item.secretValue) {
                                    const val = item.secretValue;
                                    const name = item.displayName || val;
                                    const text = (name && val && name !== val) ? `${name} (${val})` : (name || val);
                                    // Check if it already exists to avoid duplicates
                                    if (jQuery(`#modal_ga4_secret option[value="${val}"]`).length === 0) {
                                        jQuery('#modal_ga4_secret').append(`<option value="${val}">${text}</option>`);
                                    }
                                    jQuery('#modal_ga4_secret').val(val).prop('disabled', false).trigger('change');
                                    jQuery('#modal_ga4_secret_wrapper').removeClass('disabledsection');
                                } else {
                                    jQuery('#modal_ga4_property').trigger('change'); // Refresh the list if data is missing
                                }
                            } else {
                                let errorRaw = res.errors || res.data?.message || res.error?.message || res.message || 'Failed to create secret.';
                                if (Array.isArray(errorRaw) && errorRaw.length > 0) errorRaw = errorRaw[0];
                                let displayError = typeof errorRaw === 'string' ? errorRaw : JSON.stringify(errorRaw);
                                if (displayError.indexOf('User Data Collection Acknowledgement') !== -1) {
                                    displayError = `<strong>Action Required:</strong> The User Data Collection Acknowledgement must be attested on this property before measurement protocol secrets may be created.<br><br><strong>How to fix:</strong> Open your <a href="https://analytics.google.com/" target="_blank">Google Analytics</a> account &rarr; Go to <strong>Admin</strong> (gear icon) &rarr; Under <em>Data collection and modification</em> click <strong>Data collection</strong> &rarr; Click <strong>I Acknowledge</strong> in the User Data Collection Acknowledgement section.<br><br>Please check <a href="https://www.conversios.io/docs/ga4-user-data-collection-acknowledgement-steps/?utm_source=woo_aiopro_plugin&utm_medium=ore_ga4_modal&utm_campaign=ga4_secret_help" target="_blank" style="color: #2563eb; font-weight: 600; text-decoration: underline;">this document for more details</a>.`;
                                }
                                jQuery('#modal_alert_error').html(displayError).show();
                                jQuery('#modal_ga4_secret').html('<option value="">-- No Secret Available --</option>').prop('disabled', true).trigger('change');
                                jQuery('#btn_modal_create_secret').show();
                            }
                            btn.prop('disabled', false).text(originalText);
                        }
                    });
                });

                jQuery('#modal_ga4_account, #modal_ga4_property, #modal_ga4_secret, #modal_ga4_confirm').on('change', function() {
                    const isValid = jQuery('#modal_ga4_account').val() && 
                                    jQuery('#modal_ga4_property').val() && 
                                    jQuery('#modal_ga4_secret').val() && 
                                    jQuery('#modal_ga4_confirm').is(':checked');
                    jQuery('#btn_modal_save_ga4').prop('disabled', !isValid);
                });

                jQuery('#btn_modal_save_ga4').on('click', function() {
                    const accId = jQuery('#modal_ga4_account').val();
                    const propId = jQuery('#modal_ga4_property').val();
                    const numericPropId = jQuery('#modal_ga4_property option:selected').data('propid');
                    const secret = jQuery('#modal_ga4_secret').val();
                    const btn = jQuery(this).text('Saving...').prop('disabled', true);
                    
                    const selected_vals = {
                        ga4_analytic_account_id: accId,
                        measurement_id: propId,
                        ga_id: numericPropId, // Numeric property ID used in middleware/plugin
                        ga4_api_secret: secret,
                        subscription_id: subId
                    };

                    jQuery.post(ajaxUrl, {
                        action: "conv_save_pixel_data",
                        pix_sav_nonce: pixSavNonce,
                        conv_options_data: selected_vals,
                        conv_options_type: ["eeoptions", "eeapidata", "middleware"]
                    }, function(response) {
                        if (response == "0" || response == "1") {
                            jQuery('#ga4_assistant_modal').hide();

                            // Update main page fields
                            jQuery('#ga4_analytic_account_id').val(accId);
                            jQuery('#display_ga4_account').text(accId);
                            jQuery('#ga4_property_id').val(propId);
                            jQuery('#display_ga4_measurement').text(propId);
                            jQuery('#ga4_numeric_property_id').val(numericPropId);
                            jQuery('#ga4_api_secret').val(secret);
                            jQuery('#display_ga4_secret').text(secret || 'Not Selected');
                            
                            // Trigger Custom Dimension creation
                            jQuery.post(ajaxUrl, { action: "conv_create_ga4_custom_dimension", pix_sav_nonce: pixSavNonce, ga_cid: "1", non_woo_tracking: "1" });
                            
                            showToast('GA4 Configuration Updated.');
                            btn.text('Save Configuration').prop('disabled', false);
                            jQuery('#conv_ore_ga4_enabled').prop('checked', true).trigger('change');
                            jQuery('#btn_save_settings').prop('disabled', false);
                            jQuery('#unsaved_notice').removeClass('d-none'); // Show unsaved notice as we just updated fields but didn't perform final save
                        } else {
                            jQuery('#modal_alert_error').text('Failed to save settings.').show();
                            btn.text('Save Configuration').prop('disabled', false);
                        }
                    });
                });
                // --- GAds Assistant Logic ---
                function loadModalGAdsAccounts() {
                    jQuery('#modal_gads_account').html('<option value="">Loading...</option>');
                    jQuery.post(ajaxUrl, { action: "list_googl_ads_account", tvc_data: JSON.stringify(tvc_data), conversios_onboarding_nonce: onboardingNonce }, function(res) {
                        if (typeof res === "string") { try { res = JSON.parse(res); } catch(e) {} }
                        const items = res?.data || res;
                        if (res && (res.error === false || res.success) && Array.isArray(items)) {
                            let html = '<option value="">-- Select Account --</option>';
                            items.forEach(i => { html += `<option value="${i}">${i}</option>`; });
                            jQuery('#modal_gads_account').html(html);
                            
                            const savedGAdsId = jQuery('#google_ads_id').val();
                            if (savedGAdsId && jQuery('#modal_gads_account option[value="' + savedGAdsId + '"]').length > 0) {
                                jQuery('#modal_gads_account').val(savedGAdsId);
                            }
                            
                            jQuery('#modal_gads_account').trigger('change');
                        } else {
                            jQuery('#gads_modal_error').text('Could not load Google Ads accounts.').show();
                        }
                    });
                }

                jQuery('#modal_gads_account').on('change', function() {
                    jQuery('#gads_modal_error').hide();
                    const accId = jQuery(this).val();
                    if (!accId) {
                        jQuery('#modal_gads_label').html('<option value="">Select an account first</option>').prop('disabled', true);
                        jQuery('#modal_gads_label_wrapper').addClass('disabledsection');
                        jQuery('#btn_modal_create_gads_conversion').hide();
                        return;
                    }
                    jQuery('#modal_gads_label').html('<option value="">Loading conversions...</option>').prop('disabled', true);
                    jQuery('#modal_gads_label_wrapper').addClass('disabledsection');
                    jQuery('#btn_modal_create_gads_conversion').hide();

                    jQuery.post(ajaxUrl, { 
                        action: "conv_get_conversion_list_gads_bycat", 
                        gads_id: accId, 
                        conversionCategory: 'PURCHASE',
                        type: 'UPLOAD_CLICKS',
                        TVCNonce: '<?php echo wp_create_nonce("con_get_conversion_list-nonce"); ?>'
                    }, function(res) {
                        if (typeof res === "string") { try { res = JSON.parse(res); } catch(e) {} }
                        if (res && res !== 0 && Object.keys(res).length > 0) {
                            let html = '<option value="">-- Select Conversion --</option>';
                            Object.keys(res).forEach(id => {
                                html += `<option value="${id}">${res[id]} (${id})</option>`;
                            });
                            jQuery('#modal_gads_label').html(html);
                            
                            const savedSendTo = jQuery('#ee_conversio_send_to').val();
                            if (savedSendTo && jQuery('#modal_gads_label option[value="' + savedSendTo + '"]').length > 0) {
                                jQuery('#modal_gads_label').val(savedSendTo);
                            }
                            
                            jQuery('#modal_gads_label').prop('disabled', false).trigger('change');
                            jQuery('#modal_gads_label_wrapper').removeClass('disabledsection');
                            jQuery('#btn_modal_create_gads_conversion').hide();
                        } else {
                            jQuery('#gads_modal_error').hide();
                            jQuery('#modal_gads_label').html('<option value="">Auto-creating conversion...</option>').prop('disabled', true);
                            jQuery('#modal_gads_label_wrapper').addClass('disabledsection');
                            jQuery('#btn_modal_create_gads_conversion').hide().trigger('click');
                        }
                    });
                });

                jQuery('#modal_gads_label').on('change', function() {
                    if (jQuery(this).val()) {
                        jQuery('#modal_gads_confirm').prop('disabled', false);
                        jQuery('#modal_gads_confirm_wrapper').removeClass('disabledsection');
                    } else {
                        jQuery('#modal_gads_confirm').prop('disabled', true).prop('checked', false);
                        jQuery('#modal_gads_confirm_wrapper').addClass('disabledsection');
                    }
                    jQuery('#modal_gads_confirm').trigger('change');
                });

                jQuery('#modal_gads_account, #modal_gads_label, #modal_gads_confirm').on('change', function() {
                    const isValid = jQuery('#modal_gads_account').val() && jQuery('#modal_gads_label').val() && jQuery('#modal_gads_confirm').is(':checked');
                    jQuery('#btn_modal_save_gads').prop('disabled', !isValid);
                });

                jQuery('#btn_modal_create_gads_conversion').on('click', function() {
                    const accId = jQuery('#modal_gads_account').val();
                    const btn = jQuery(this).html('<span class="dashicons dashicons-update spin"></span> Creating...').prop('disabled', true);
                    
                    jQuery.post(ajaxUrl, {
                        action: "conv_create_gads_conversion",
                        gads_id: accId,
                        conversionCategory: 'PURCHASE',
                        type: 'UPLOAD_CLICKS',
                        conversionName: 'ORE Purchase API',
                        TVCNonce: '<?php echo wp_create_nonce("con_get_conversion_list-nonce"); ?>'
                    }, function(response) {
                        try { if (typeof response === 'string') response = JSON.parse(response); } catch(e) {}
                        if (response.status == "200" && response.data) {
                            jQuery('#gads_modal_error').hide();
                            showToast('Conversion Action Created.');
                            let dataParts = response.data.split('/');
                            let convId = dataParts[dataParts.length - 1];
                            let optionHtml = `<option value="${convId}">ORE Purchase API (${convId})</option>`;
                            
                            // Re-enable and populate the dropdown dynamically to bypass API lag
                            if(jQuery('#modal_gads_label option').length === 1 && jQuery('#modal_gads_label option').val() === "") {
                                jQuery('#modal_gads_label').html('<option value="">-- Select Conversion --</option>');
                            }
                            jQuery('#modal_gads_label').append(optionHtml);
                            jQuery('#modal_gads_label').val(convId).prop('disabled', false).trigger('change');
                            jQuery('#modal_gads_label_wrapper').removeClass('disabledsection');
                            jQuery('#btn_modal_create_gads_conversion').hide();
                        } else {
                            jQuery('#gads_modal_error').html(response.message || 'Failed to create conversion action.').show();
                            jQuery('#modal_gads_label').html('<option value="">-- No Conversion Available --</option>').prop('disabled', true).trigger('change');
                            jQuery('#btn_modal_create_gads_conversion').show();
                        }
                        btn.html('<span class="dashicons dashicons-plus"></span> Create New').prop('disabled', false);
                    });
                });

                jQuery('#btn_modal_save_gads').on('click', function() {
                    const accId = jQuery('#modal_gads_account').val();
                    const label = jQuery('#modal_gads_label').val();
                    const btn = jQuery(this).text('Saving...').prop('disabled', true);

                    const gads_data = {
                        action:                'conv_save_pixel_data',
                        pix_sav_nonce:         pixSavNonce,
                        conv_options_type:     ["eeoptions", "eeapidata", "middleware"],
                        conv_options_data: {
                            google_ads_id:         accId,
                            ore_gads_conversion_id: label,
                            conv_ore_gads_enabled: 1, // Auto-enable GAds channel when credentials are saved
                            subscription_id:       subId
                        }
                    };

                    jQuery.post(ajaxUrl, gads_data, function(response) {
                        if (response === "0" || response === "1") {
                            jQuery('#gads_assistant_modal').hide();

                            jQuery('#google_ads_id').val(accId);
                            jQuery('#display_gads_account').text(accId);
                            jQuery('#ee_conversio_send_to').val(label);

                            // Update Conversion ID display field
                            jQuery('#display_gads_id').text(label);

                            showToast('Google Ads Configuration Updated.');
                            btn.text('Save Configuration').prop('disabled', false);
                            jQuery('#conv_ore_gads_enabled').prop('checked', true).trigger('change');
                            jQuery('#btn_save_settings').prop('disabled', false);
                            jQuery('#unsaved_notice').removeClass('d-none');
                            checkAndToggleGadsRequirements();
                        } else {
                            jQuery('#gads_modal_error').text('Failed to save settings.').show();
                            btn.text('Save Configuration').prop('disabled', false);
                        }
                    });
                });

                // --- Meta Assistant Logic ---
                jQuery('#btn_meta_assistant').on('click', function() {
                    jQuery('#modal_fb_pixel_id').val(jQuery('#fb_pixel_id').val());
                    jQuery('#modal_fb_capi_token').val(jQuery('#fb_conversion_api_token').val());
                    jQuery('#meta_assistant_modal').css('display', 'flex');
                });

                jQuery('#btn_modal_save_meta').on('click', function() {
                    const pixelId = jQuery('#modal_fb_pixel_id').val().trim();
                    const capiToken = jQuery('#modal_fb_capi_token').val().trim();
                    const btn = jQuery(this).text('Saving...').prop('disabled', true);

                    if (!pixelId) {
                        jQuery('#meta_modal_error').text('Please enter Pixel ID.').show();
                        btn.text('Save Configuration').prop('disabled', false);
                        return;
                    }

                    // For Meta, we save locally to the main fields first, then save to DB
                    const selected_vals = {
                        fb_pixel_id: pixelId,
                        fb_conversion_api_token: capiToken,
                        conv_ore_fb_enabled: 1,
                        subscription_id: subId
                    };

                    jQuery.post(ajaxUrl, {
                        action: "conv_save_pixel_data",
                        pix_sav_nonce: pixSavNonce,
                        conv_options_data: selected_vals,
                        conv_options_type: ["eeoptions", "eeapidata", "middleware"]
                    }, function(response) {
                        if (response == "0" || response == "1") {
                            jQuery('#meta_assistant_modal').hide();

                            // Update main page fields
                            jQuery('#fb_pixel_id').val(pixelId);
                            jQuery('#display_fb_pixel_id').text(pixelId);
                            jQuery('#fb_conversion_api_token').val(capiToken);
                            jQuery('#display_fb_capi_token').text(capiToken || 'Not Selected');
                            
                            showToast('Meta Configuration Updated.');
                            btn.text('Save Configuration').prop('disabled', false);
                            jQuery('#conv_ore_fb_enabled').prop('checked', true).trigger('change');
                            jQuery('#btn_save_settings').prop('disabled', false);
                            jQuery('#unsaved_notice').removeClass('d-none');
                        } else {
                            jQuery('#meta_modal_error').text('Failed to save settings.').show();
                            btn.text('Save Configuration').prop('disabled', false);
                        }
                    });
                });
                // --- End GAds Assistant Logic ---
                // --- End GA4 Assistant Modal Logic ---




                // Updates the report dashboard stats from a response object.
                // Called from DataTable's xhr callback on draw=1.
                function updateReportStats(d) {
                    jQuery('#stat_total').text(d.total || 0);
                    jQuery('#stat_client').text(d.client || 0);
                    jQuery('#stat_server').text(d.server || 0);
                    jQuery('#stat_recovered_revenue').html('<?php echo html_entity_decode(get_woocommerce_currency_symbol()); ?>' + (d.recovered_revenue || '0.00'));
                    if (jQuery('#stat_synced').length) jQuery('#stat_synced').text(d.synced || 0);

                    if (d.breakdown) {
                        jQuery('#stat_server_breakdown').html(
                            'GA4: <span style="color:#0f172a">' + (d.breakdown.ga4 || 0) + '</span> | ' +
                            'Meta: <span style="color:#0f172a">' + (d.breakdown.fb || 0) + '</span> | ' +
                            'Ads: <span style="color:#0f172a">' + (d.breakdown.ads || 0) + '</span>'
                        ).show();
                    } else {
                        jQuery('#stat_server_breakdown').hide();
                    }

                    // Last cron timestamp (updates PHP-rendered value after manual sync)
                    if (d.last_cron) {
                        jQuery('#ore_last_cron_time').text(d.last_cron).css('color', '#0f172a');
                    }
                }

                jQuery('#btn_ore_manual_sync').on('click', function(e) {
                    e.preventDefault();
                    const drp = jQuery('#conv_ore_report_daterange').data('daterangepicker');
                    if (!drp) return;

                    const btn = jQuery(this).html('<span class="dashicons dashicons-update spin"></span> Syncing...').prop('disabled', true);
                    
                    jQuery.post(ajaxUrl, { 
                        action: 'conv_ore_manual_sync', 
                        start_date: drp.startDate.format('YYYY-MM-DD'), 
                        end_date: drp.endDate.format('YYYY-MM-DD'), 
                        conversios_nonce: nonce 
                    }, function(res) {
                        if (res.success) {
                            let msg = `Successfully synced ${res.data.synced} orders.`;
                            if (res.data.failed > 0) {
                                msg += ` ${res.data.failed} failed (check conv-ore-tracking.log).`;
                            }
                            showToast(msg);
                            // Reload table — draw resets to 1 so report stats refresh too
                            initOreDataTable();
                        } else {
                            alert(res.data?.message || 'Sync failed.');
                        }
                        btn.html('<span class="dashicons dashicons-update"></span> Sync Now').prop('disabled', false);
                    });
                });

                // --- Order Details DataTable (Server-Side Processing) ---
                const currSymbol = '<?php echo html_entity_decode(get_woocommerce_currency_symbol()); ?>';
                let oreDataTable = null;

                function metaCell(val) {
                    if (!val) return '<span style="color:#cbd5e1">—</span>';
                    const e = jQuery('<span/>').text(val).html();
                    return '<span class="conv_ore_meta_val" title="' + e + '">' + e + '</span>';
                }



                function initOreDataTable() {
                    if (oreDataTable) {
                        oreDataTable.destroy();
                        jQuery('#conv_ore_datatable').empty();
                    }
                    const drp = jQuery('#conv_ore_report_daterange').data('daterangepicker');
                    if (!drp) return;

                    oreDataTable = jQuery('#conv_ore_datatable').DataTable({
                        serverSide: true,
                        processing: true,
                        pageLength: 25,
                        order: [[2, 'desc']],
                        ajax: {
                            url: ajaxUrl,
                            type: 'POST',
                            data: function(d) {
                                d.action = 'conv_get_ore_data';
                                d.conversios_nonce = nonce;
                                d.start_date = drp.startDate.format('YYYY-MM-DD');
                                d.end_date = drp.endDate.format('YYYY-MM-DD');
                            },
                            // Extract report stats from first draw response
                            dataSrc: function(json) {
                                if (json.report) {
                                    updateReportStats(json.report);
                                }
                                return json.data;
                            }
                        },
                        columns: [
                            { data: 'number', title: 'Order #', className: 'text-start text-truncate', render: function(d, t, r) { return '<a href="'+r.edit_url+'" class="conv_ore_order_link" target="_blank">#'+d+'</a>'; } },
                            { data: 'date', title: 'Date', render: function(d) { return '<span style="white-space:nowrap">'+d+'</span>'; } },
                            { data: 'total', title: 'Total', render: function(d) { return currSymbol + parseFloat(d).toFixed(2); } },
                            { data: 'conv_order_tracked', title: 'Tracking', orderable: false, render: function(d, t, r) {
                                if (d === 'pixel' || r._tracked) return '<span class="conv_ore_badge_pixel">Pixel</span>';
                                if (d === 'api') return '<span class="conv_ore_badge_api">Server</span>';
                                if (d === 'skipped') return '<span class="conv_ore_badge_skipped" title="Missing required tracking data (cookies blocked)">Skipped</span>';
                                return '<span class="conv_ore_badge_none">Pending</span>';
                            }},
                            { data: '_ore_synced_channels', title: 'Synced Channels', orderable: false, render: function(d) { return metaCell(d); } }
                        ],
                        dom: '<"d-flex justify-content-between align-items-center bg-white"lf>rtip',
                        lengthMenu: [
                            [10, 25, 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000],
                            [10, 25, 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000]
                        ],
                        searching: true,
                        paging: true,
                        language: {
                            emptyTable: 'No orders found in the selected range.',
                            processing: '<span class="dashicons dashicons-update spin"></span> Loading orders...',
                            info: 'Showing _START_ to _END_ of _TOTAL_ orders',
                            lengthMenu: 'Show _MENU_ orders'
                        },
                        initComplete: function() {
                            jQuery('.dataTables_length select[name="conv_ore_datatable_length"]').attr('id', 'conv_ore_ordertabel_limit');
                            jQuery('.dataTables_filter input[aria-controls="conv_ore_datatable"]').attr('placeholder', '#Order Id');
                        }
                    });


                }

                if(jQuery.fn.daterangepicker) {
                    var defaultStart = moment().subtract(29, 'days');
                    var defaultEnd = moment();
                    jQuery('#conv_ore_report_daterange').daterangepicker({ startDate: defaultStart, endDate: defaultEnd, maxDate: defaultEnd, opens: 'left' }, function(start, end) {
                        jQuery('#conv_ore_report_daterange .daterange-text').text(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
                        initOreDataTable();
                    });
                    
                    // Initial load
                    setTimeout(function() {
                        jQuery('#conv_ore_report_daterange .daterange-text').text(defaultStart.format('MMM D') + ' - ' + defaultEnd.format('MMM D, YYYY'));
                        initOreDataTable();
                    }, 500);
                }

                jQuery('#btn_save_settings').on('click', function(e) {
                    e.preventDefault();

                    // Pre-save validation: disable toggles for channels with missing required fields
                    if (jQuery('#conv_ore_ga4_enabled').is(':checked')) {
                        if (!jQuery('#ga4_analytic_account_id').val() || !jQuery('#ga4_property_id').val() || !jQuery('#ga4_api_secret').val()) {
                            jQuery('#conv_ore_ga4_enabled').prop('checked', false);
                            jQuery('.ga4-dep').addClass('disabledsection');
                            jQuery('#btn_ga4_assistant').trigger('click');
                            return;
                        }
                    }
                    if (jQuery('#conv_ore_gads_enabled').is(':checked')) {
                        const sendTo = jQuery('#ee_conversio_send_to').val();
                        if (!sendTo || sendTo.trim() === '') {
                            jQuery('#conv_ore_gads_enabled').prop('checked', false);
                            jQuery('.gads-dep').addClass('disabledsection');
                            jQuery('#btn_gads_assistant').trigger('click');
                            return;
                        }
                    }
                    if (jQuery('#conv_ore_fb_enabled').is(':checked')) {
                        if (!jQuery('#fb_pixel_id').val() || !jQuery('#fb_conversion_api_token').val()) {
                            jQuery('#conv_ore_fb_enabled').prop('checked', false);
                            jQuery('.meta-dep').addClass('disabledsection');
                            jQuery('#btn_meta_assistant').trigger('click');
                            return;
                        }
                    }

                    const btn = jQuery(this).text('Saving Configuration...').prop('disabled', true);

                    // Channel credentials are already saved by each modal on confirm.
                    // btn_save_settings only needs to persist the channel toggle states.
                    jQuery.post(ajaxUrl, {
                        action: 'conv_ore_save_settings',
                        conversios_nonce: nonce,
                        conv_ore_master_enabled: 1,
                        conv_ore_ga4_enabled:  jQuery('#conv_ore_ga4_enabled').is(':checked')  ? 1 : 0,
                        conv_ore_fb_enabled:   jQuery('#conv_ore_fb_enabled').is(':checked')   ? 1 : 0,
                        conv_ore_gads_enabled: jQuery('#conv_ore_gads_enabled').is(':checked') ? 1 : 0
                    }, function() {
                        showToast('Configuration Saved Successfully.');
                        jQuery('#unsaved_notice').addClass('d-none');
                        btn.text('Save Configuration').prop('disabled', true);
                    });
                });
            });
            </script>
            <style>
                @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
                .spin { animation: spin 1s linear infinite; display: inline-block; vertical-align: middle; }
            </style>
            <?php
        }
    }
}
