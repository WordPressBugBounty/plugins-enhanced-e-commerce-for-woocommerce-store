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

            if (version_compare(PLUGIN_TVC_VERSION, "7.1.2", ">") && ($gm_id != "" || $google_ads_id != "" || $google_merchant_id != "")) {
                if (empty($conv_onboarding_done_step) || $conv_onboarding_done_step == "6") {
                    if (!empty($conv_onboarding_done) || ($gm_id != "" || $google_ads_id != "" || $google_merchant_id != "")) {
                        $conv_oldredi = admin_url('admin.php?page=conversios-analytics-reports');
                        echo "<script> location.href='" . esc_js($conv_oldredi) . "'; </script>";
                        exit();
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
                do_action('conversios_start_html_' . sanitize_text_field(wp_unslash($_GET['page'])));
            $this->current_html();
            $this->current_js_licence_active();
            if (isset($_GET['page']) && $_GET['page'] != "")
                do_action('conversios_end_html_' . sanitize_text_field(wp_unslash($_GET['page'])));
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

                        <div class="row bg-white rounded py-2">
                            <div class="col-12 dshboardwelcome">
                                <!-- licence key html call-->
                                <?php //$this->dashboard_licencebox_html(); 
                                ?>
                                <h2 class="text-center mb-0">
                                    <?php esc_html_e("Conversios All In One Plugin", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h2>
                                <h4 class="text-center">
                                    Start instantly with no coding - our <b>ready-to-use GTM</b> setup handles everything for you.
                                </h4>
                            </div>

                            <div class="convhori-step-text convhori-step-list py-3 my-2 mt-3">
                                <h5 class="ps-4">Key Features</h5>
                                <ul class="conv-green-checklist list-unstyled ms-5">
                                    <li class="d-flex align-items-cente">
                                        GA4 <b class="px-2">E-commerce</b> tracking for <b class="ps-2">Woocommerce</b>
                                        <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="page_view, purchase, view_item_list, view_item, select_item, add_to_cart, remove_from_cart, view_cart, begin_checkout, add_payment_info, and add_shipping_info.">
                                            info
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-cente">
                                        GA4 <b class="px-2">Lead Generation</b> and Other tracking for <b class="ps-2">Wordpress</b>
                                        <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Lead Form Submit, Lead Email Click, Lead Phone Click, Page Scroll, File Download, Author, Login, Signup">
                                            info
                                        </span>
                                    </li>
                                    <li>Google Ads <b>purchase</b> and <b>lead</b> conversion tracking</li>
                                    <li>Facebook and other ad platform pixel integration</li>
                                    <li><b>Real-time</b> product feed sync with Google Merchant Center <br> Facebook, and TikTok</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-center pt-2">
                                <div class="convhori-step-container">
                                    <!-- Step 1 -->
                                    <div class="convhori-step-box">
                                        <?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_ganalytics_logo.png', '', 'align-self-center'),
                                            array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true,
                                                    'class' => true,
                                                    'style' => true,
                                                ),
                                            )
                                        ); ?>
                                    </div>
                                    <div class="convhori-step-line"></div>
                                    <!-- Step 2 -->
                                    <div class="convhori-step-box">
                                        <?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_gads_logo.png', '', 'align-self-center'),
                                            array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true,
                                                    'class' => true,
                                                    'style' => true,
                                                ),
                                            )
                                        ); ?>
                                    </div>
                                    <div class="convhori-step-line"></div>

                                    <!-- Step 3 -->
                                    <div class="convhori-step-box">
                                        <?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_gmc_logo.png', '', 'align-self-center'),
                                            array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true,
                                                    'class' => true,
                                                    'style' => true,
                                                ),
                                            )
                                        ); ?>
                                    </div>
                                    <div class="convhori-step-line"></div>

                                    <!-- Step 4 -->
                                    <div class="convhori-step-box">
                                        <?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_meta_logo.png', '', 'align-self-center'),
                                            array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true,
                                                    'class' => true,
                                                    'style' => true,
                                                ),
                                            )
                                        ); ?>
                                    </div>
                                    <div class="convhori-step-line"></div>

                                    <!-- Step 5 -->
                                    <div class="convhori-step-box">
                                        <?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/mix_logos.png', '', 'align-self-center', 'width: 42px;'),
                                            array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true,
                                                    'class' => true,
                                                    'style' => true,
                                                ),
                                            )
                                        ); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center convhori-step-text">
                                <div>
                                    1. Setup Google <br> Analytics 4
                                </div>

                                <div>
                                    2. Setup Google <br> Ads Conversion
                                </div>

                                <div>
                                    3. Setup Google <br> Merchant Center
                                </div>

                                <div>
                                    4. Setup Meta <br> (Facebook) Pixel
                                </div>

                                <div>
                                    5. Setup <br> Other Pixels
                                </div>
                            </div>

                            <div class="d-flex justify-content-center convhori-step-text pt-3">
                                <a href="admin.php?page=conversios&amp;wizard=pixelandanalytics" class="btn btn-primary p-2 px-3 mt-auto d-flex align-items-center">
                                    Start Your Setup Now
                                    <span class="dashicons dashicons-arrow-right-alt ms-2"></span>
                                </a>
                            </div>
                        </div>

                        <!-- <div class="row bg-white rounded py-4 mt-4">
                           
                        </div> -->

                    </div>



                </div>
                </div>
            </section>


<?php
        }
    }
}
new Conversios_Dashboard();
