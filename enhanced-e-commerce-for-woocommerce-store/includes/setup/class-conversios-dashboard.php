<?php

/**
 * @since      4.1.4
 * Description: Conversios Onboarding page, It's call while active the plugin
 */
if (class_exists('Conversios_Dashboard') === FALSE) {
    class Conversios_Dashboard
    {

        protected $screen;
        protected $TVC_Admin_Helper;
        protected $TVC_Admin_DB_Helper;
        protected $CustomApi;
        protected $PMax_Helper;
        protected $subscription_id;
        protected $ga_traking_type;
        protected $currency_code;
        protected $currency_symbol;
        protected $ga_currency;
        protected $ga_currency_symbols;
        protected $ga4_measurement_id;
        protected $ga4_analytic_account_id;
        protected $ga4_property_id;
        protected $subscription_data;
        protected $plan_id = 1;
        protected $is_need_to_update_api_data_wp_db = false;
        protected $report_data;
        protected $notice;
        protected $google_ads_id;
        protected $connect_url;
        protected $g_mail;
        protected $is_refresh_token_expire;

        protected $resource_center_data = array();
        protected $ee_options;
        protected $ee_customer_gmail;
        protected $is_channel_connected;
        protected $chkEvenOdd;

        public function __construct()
        {
            // if (empty($this->subscription_id)) {
            //     wp_redirect("admin.php?page=conversios-google-analytics");
            //     exit;
            // }

            $this->TVC_Admin_Helper = new TVC_Admin_Helper();
            $this->TVC_Admin_DB_Helper = new TVC_Admin_DB_Helper();
            $this->CustomApi = new CustomApi();
            //$this->PMax_Helper = new Conversios_PMax_Helper();
            $this->connect_url = $this->TVC_Admin_Helper->get_custom_connect_url(admin_url() . 'admin.php?page=conversios');
            $this->subscription_id = $this->TVC_Admin_Helper->get_subscriptionId();

            $this->ee_options = $this->TVC_Admin_Helper->get_ee_options_settings();
            //$this->ee_customer_gmail = get_option("ee_customer_gmail");

            $this->subscription_data = $this->TVC_Admin_Helper->get_user_subscription_data();
            if (isset($this->subscription_data->plan_id) && !in_array($this->subscription_data->plan_id, array("1"))) {
                $this->plan_id = $this->subscription_data->plan_id;
            }
            if (isset($this->subscription_data->google_ads_id) && $this->subscription_data->google_ads_id != "") {
                $this->google_ads_id = $this->subscription_data->google_ads_id;
            }
            if (empty($this->subscription_id)) {
                wp_redirect("admin.php?page=conversios-google-analytics");
                exit;
            }

            $gm_id = isset($this->ee_options['gm_id']) ? $this->ee_options['gm_id'] : "";
            $google_ads_id = isset($this->ee_options['google_ads_id']) ? $this->ee_options['google_ads_id'] : "";
            $tracking_method = isset($this->ee_options['tracking_method']) ? $this->ee_options['tracking_method'] : "";
            $google_merchant_id = isset($this->ee_options['google_merchant_id']) ? $this->ee_options['google_merchant_id'] : "";
            $conv_onboarding_done_step = isset($this->ee_options['conv_onboarding_done_step']) ? $this->ee_options['conv_onboarding_done_step'] : "";
            $conv_onboarding_done = isset($this->ee_options['conv_onboarding_done']) ? $this->ee_options['conv_onboarding_done'] : "";

            //echo '<pre>'; print_r($this->ee_options); echo '</pre>';

            // Redirect to report
            if (version_compare(PLUGIN_TVC_VERSION, "7.1.2", ">") && ($gm_id != "" || $google_ads_id != "" || $google_merchant_id != "")) {
                if (empty($conv_onboarding_done_step) || $conv_onboarding_done_step == "5") {
                    if (!empty($conv_onboarding_done) || ($gm_id != "" || $google_ads_id != "" || $google_merchant_id != "")) {
                        $conv_oldredi = admin_url('admin.php?page=conversios-analytics-reports');
                        echo "<script> location.href='" . $conv_oldredi . "'; </script>";
                        exit();
                        //add_action('wp_loaded', array($this, 'conv_redirect_olduser'));
                    }
                }
            }

            $this->includes();
            $this->screen = get_current_screen();
            $this->load_html();
        }

        public function conv_redirect_olduser()
        {
            wp_safe_redirect(admin_url('admin.php?page=conversios-analytics-reports'));
            exit;
        }

        public function includes()
        {
            if (!class_exists('CustomApi.php')) {
                require_once(ENHANCAD_PLUGIN_DIR . 'includes/setup/CustomApi.php');
            }
        }


        public function load_html()
        {
            if (isset($_GET['page']) && $_GET['page'] != "")
                do_action('conversios_start_html_' . sanitize_text_field($_GET['page']));
            $this->current_html();
            $this->current_js_licence_active();
            if (isset($_GET['page']) && $_GET['page'] != "")
                do_action('conversios_end_html_' . sanitize_text_field($_GET['page']));
        }



        public function current_js_licence_active()
        { ?>
            <script>
                jQuery(function() {
                    jQuery("#acvivelicbtn").click(function() {
                        var post_data_lic = {
                            action: "tvc_call_active_licence",
                            licence_key: jQuery("#licencekeyinput").val(),
                            conv_licence_nonce: '<?php echo esc_js(wp_create_nonce("conv_lic_nonce")); ?>',
                        }
                        jQuery.ajax({
                            type: "POST",
                            dataType: "json",
                            url: tvc_ajax_url,
                            data: post_data_lic,
                            beforeSend: function() {
                                jQuery("#acvivelicbtn").find(".spinner-border").removeClass("d-none");
                            },
                            success: function(response) {
                                jQuery("#licencemsg").removeClass();
                                if (response.error === false) {
                                    jQuery("#licencemsg").addClass('text-success').text(response.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    jQuery("#licencemsg").addClass('text-danger').text(response.message);
                                }
                                jQuery('#acvivelicbtn').find(".spinner-border").addClass("d-none");
                            }
                        });
                    });
                });
            </script>
        <?php }
        public function dashboard_licencebox_html()
        { ?>
            <div class="dash-area">
                <div class="dashwhole-box">
                    <div class="card">
                        <div class="card-body">
                            <div class="purchase-box">
                                <h4>
                                    <?php esc_html_e("Already purchased license Key?", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h4>
                                <div class="form-box">
                                    <input type="email" class="form-control icontrol" readonly id="exampleFormControlInput1" placeholder="Enter your key">
                                </div>
                                <div class="upgrade-btn">
                                    <a target="_blank" href="<?php echo esc_url($this->TVC_Admin_Helper->get_conv_pro_link_adv("licenceinput", "dashboard", "", "linkonly", "")); ?>" class="btn btn-dark common-btn">
                                        <?php esc_html_e("Upgrade to Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }


        // Main function for HTM structure
        public function current_html()
        {
        ?>
            <section style="max-width: 1200px; margin:auto;">
                <div class="dash-conv">
                    <div class="container">

                        <div class="row bg-white rounded py-4">
                            <div class="col-12 dshboardwelcome">
                                <!-- licence key html call-->
                                <?php //$this->dashboard_licencebox_html(); 
                                ?>
                                <h2 class="text-center">
                                    <?php esc_html_e("Welcome To Conversios Plugin", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h2>
                                <h4 class="text-center conv-link-blue">
                                    <?php esc_html_e("Choose your platform to unlock powerful analytics and engagement tools tailored for you.", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                            </div>
                            <div class="d-flex justify-content-center py-4">
                                <div class="col-4 dshboardwelcome_box m-3 p-3 d-flex flex-column">
                                    <h5 class="d-inline">
                                        <span class="conv-link-blue">
                                            <?php esc_html_e("For WooCommerce Users:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </span>
                                    </h5>
                                    </span>
                                    </h5>
                                    <ul class="px-4 pb-4">
                                        <li><b>Understand Customer Behavior:</b> Get insights into how customers shop on your site.</li>
                                        <li><b>Track Ads Across Platforms</b>: See how your ads perform on different platforms.</li>
                                        <li><b>Improve Google Ads:</b> Make your Google ads more effective.</li>
                                        <li><b>Manage Product feeds Easily</b>: Simplify the process of adding products to ad platforms.</li>
                                        <li><b>Get Detailed Reports:</b> Make better decisions with detailed reports on your store's performance.</li>
                                    </ul>
                                    <a href="<?php echo esc_url('admin.php?page=conversios&wizard=pixelandanalytics'); ?>" class="btn btn-primary w-100 p-2 mt-auto">
                                        Start Optimizing Now
                                    </a>
                                </div>
                                <div class="col-4 dshboardwelcome_box m-3 p-3 d-flex flex-column">
                                    <h5 class="d-inline">
                                        <span class="conv-link-blue">
                                            <?php esc_html_e("For WordPress Users:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </span>
                                    </h5>
                                    <ul class="px-4 pb-4">
                                        <li><b>Understand Customer Behavior:</b> Get insights into how customers shop on your site.</li>
                                        <li><b>Track Form Submissions:</b> Understand how visitors interact with your forms.</li>
                                        <li><b>Track Email Clicks:</b> Discover which email CTAs are most effective.</li>
                                        <li><b>Track Phone Clicks:</b> Monitor how often users click on phone numbers on your site.</li>
                                        <li><b>General Reports:</b>Make data-driven decisions with comprehensive insights.</li>
                                    </ul>
                                    <a href="<?php echo esc_url('admin.php?page=conversios&wizard=pixelandanalytics'); ?>" class="btn btn-primary w-100 p-2 mt-auto">
                                        Begin Setup
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                </div>
            </section>


<?php
        }
    }
}
new Conversios_Dashboard();
