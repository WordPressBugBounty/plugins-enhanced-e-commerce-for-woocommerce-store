<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since      4.0.2
 * Description: Conversios Onboarding page, It's call while active the plugin
 */
if (!class_exists('Conversios_Footer')) {
    class Conversios_Footer
    {
        protected $TVC_Admin_Helper = "";
        public function __construct()
        {
            add_action('add_conversios_footer', array($this, 'before_end_footer'));
            add_action('add_conversios_footer', array($this, 'before_end_footer_add_script'));
            $this->TVC_Admin_Helper = new TVC_Admin_Helper();
        }
        public function before_end_footer()
        {
?>
            <div class="tvc_footer_links">
            </div>
            <?php
            $licenceInfoArr = array(
                "Plan Type:" => "Free",
            );
            ?>


            <div class="modal fade" id="convLicenceInfoMod" tabindex="-1" aria-labelledby="convLicenceInfoModLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 700px;">
                    <div class="modal-content">
                        <div class="modal-header badge-dark-blue-bg text-white">
                            <h5 class="modal-title text-white" id="convLicenceInfoModLabel">
                                <?php esc_html_e("My Subscription", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h5>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <?php foreach ($licenceInfoArr as $key => $value) { ?>
                                        <div class="<?php echo $key == "Connected with:" ? "col-md-12" : "col-md-6"; ?> py-2 px-0">
                                            <span class="fw-bold">
                                                <?php
                                                printf(
                                                    esc_html__('%s', 'enhanced-e-commerce-for-woocommerce-store'),
                                                    esc_html($key)
                                                );
                                                ?>
                                            </span>
                                            <span class="ps-2">
                                                <?php
                                                printf(
                                                    esc_html__('%s', 'enhanced-e-commerce-for-woocommerce-store'),
                                                    esc_html($value)
                                                );
                                                ?>
                                            </span>
                                        </div>
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <div class="fs-6">
                                <span><?php esc_html_e("You are currently using our free plugin, no license needed! Happy Analyzing.", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                                <span><?php esc_html_e("To unlock more features of Google Products ", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                                <?php echo wp_kses_post($this->TVC_Admin_Helper->get_conv_pro_link_adv("planpopup", "globalheader", "conv-link-blue", "anchor", "Upgrade to Pro Version")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- new feature notes modal start -->
            <?php $user_id = get_current_user_id(); ?>
            <div class="modal fade" id="convnewfeaturemodal" data-userdata="<?php echo esc_attr(get_option('conv_popup_newfeature')); ?>" tabindex="-1" aria-labelledby="convnewfeaturemodalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
                    <div class="modal-content">
                        <div class="modal-header align-items-baseline">
                            <div>
                                <h3 class="modal-title" id="convnewfeaturemodalLabel">
                                    <?php esc_html_e("Exciting New Features!", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </h3>
                                <p class="m-0">In your updated plugin
                                    version:<code><?php echo esc_html(PLUGIN_TVC_VERSION) ?></code></p>
                            </div>
                            <button type="button" id="conv_close_popup" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style=" background: ghostwhite;">
                            <h5 class="" style="font-weight: 500; color: #09BD83; ">We're excited to announce new features to help
                                you better track user interactions on your website.</h5>
                            <h4 style="color: #6c757d;">GA4 E-Commerce Tracking:</h4>
                            <ul class="flex-wrap mb-3 d-flex" style="list-style: circle;">
                                <li class="flex-fill w-50">page_view</li>
                                <li class="flex-fill w-50">view_item_list</li>
                                <li class="flex-fill w-50">select_item</li>
                                <li class="flex-fill w-50">view_item</li>
                                <li class="flex-fill w-50">add_to_cart</li>
                                <li class="flex-fill w-50">view_cart</li>
                                <li class="flex-fill w-50">remove_from_cart</li>
                                <li class="flex-fill w-50">begin_checkout</li>
                                <li class="flex-fill w-50">add_shipping_info</li>
                                <li class="flex-fill w-50">add_payment_info</li>
                                <li class="flex-fill w-50">purchase</li>
                            </ul>
                            <h4 style="color: #6c757d;">Lead Generation Tracking:</h4>
                            <ul class="flex-wrap d-flex" style="list-style: circle;">
                                <li class="flex-fill w-50">form_lead_submit</li>
                                <li class="flex-fill w-50">phone_click</li>
                                <li class="flex-fill w-50">email_click</li>
                                <li class="flex-fill w-50">address_click</li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <p>Take advantage of these powerful features to optimize your tracking and enhance your insights!</p>
                            <button type="button" id="conv_dont_show_popup" class="btn btn-secondary btn-sm">
                                <?php esc_html_e("Don't remind again", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </button>
                            <a href="<?php echo esc_url_raw('admin.php?page=conversios&wizard=pixelandanalytics&onboarding=1'); ?>" class="btn btn-success btn-sm">
                                <?php esc_html_e("Setup Now ", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- new feature notes modal end -->

            <!-- Upgrade to PRO modal -->
            <div class="modal fade" id="upgradetopromodal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-dialog">
                        <div class="modal-content p-4">
                            <div class="modal-header border-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img class="m-auto d-block" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/uptopro_2024.png'); ?>">
                                <h4 id="conuptppro_text" class="pt-4"></h4>
                            </div>
                            <div class="modal-footer border-0 justify-content-center pt-0">
                                <div class="col-6 m-0 p-2">
                                    <a target="_blank" id="conuptppro_elink" href="<?php echo esc_url_raw('https://www.conversios.io/pricing/'); ?>" class="btn btn-outline-dark w-100">
                                        <?php esc_html_e("Explore More Features", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </a>
                                </div>
                                <div class="col-6 m-0 p-2">
                                    <a target="_blank" id="conuptppro_ulink" href="<?php echo esc_url_raw('https://www.conversios.io/pricing/'); ?>" class="btn btn-success w-100">
                                        <?php esc_html_e("Upgrade Now & Get 50% Off", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Upgrade to PRO modal End -->


        <?php
        }

        public function before_end_footer_add_script()
        {
            $TVC_Admin_Helper = new TVC_Admin_Helper();
            $subscriptionId =  sanitize_text_field($TVC_Admin_Helper->get_subscriptionId());
        ?>
            <script>
                jQuery(function() {
                    //New feature modal popup initiate
                    // if (!document.cookie.includes('conv_popup_newfeature') && jQuery('#convnewfeaturemodal').data('userdata') != 'yes') {
                    // 	// First visit, display popup
                    // 	jQuery("#convnewfeaturemodal").modal('show');
                    // }
                    jQuery('#conv_close_popup').click(function() {
                        // Set cookie to expire in 24 hours
                        document.cookie = "conv_popup_newfeature=true; expires=" + new Date(Date.now() + 24 * 60 * 60 *
                            1000).toUTCString() + "; path=/";
                        jQuery("#convnewfeaturemodal").modal('hide');
                    });
                    jQuery('#conv_dont_show_popup').click(function() {
                        jQuery("#convnewfeaturemodal").modal('hide');
                        jQuery.ajax({
                            type: "POST",
                            dataType: "json",
                            url: tvc_ajax_url,
                            data: {
                                action: "conv_convnewfeaturemodal_ajax",
                                wp_nonce: "<?php echo esc_js(wp_create_nonce('convnewfeaturemodal_nonce')); ?>",
                            }
                        });
                    });


                });
            </script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    var screen_name = '<?php echo isset($_GET['page']) ? esc_js(sanitize_text_field($_GET['page'])) : ''; ?>';
                    var error_msg = 'null';
                    jQuery('.navinfotopnav ul li a').click(function() {
                        cons
                        var slug = $(this).find('span').text();
                        var menu = $(this).attr('href');
                        str_menu = slug.replace(/\s+/g, '_').toLowerCase();
                        user_tracking_data('click', error_msg, screen_name, 'topmenu_' + str_menu);
                    });

                    // Open UpgradetoPro Popup
                    jQuery(".upgradetopro_badge").click(function() {
                        var popupopener = jQuery(this).attr("popupopener");
                        var propopup_text_arr = {
                            ga4apisecret_box: "Automatically track refund orders and gain insights into frequently returned products and total refund value.",
                            ga4apisecret_box_inner: "Automatically track refund orders and gain insights into frequently returned products and total refund value.",
                            fbcapi: "You can boost event matching, data accuracy, privacy compliance, and ad performance with Facebook Conversion API.",
                            fbcapi_inner: "You can boost event matching, data accuracy, privacy compliance, and ad performance with Facebook Conversion API.",
                            snapcapi: "You can boost event matching, data accuracy, privacy compliance, and ad performance with Snapchat Conversion API.",
                            snapcapi_inner: "You can boost event matching, data accuracy, privacy compliance, and ad performance with Snapchat Conversion API.",
                            tiktokcapi: "You can boost event matching, data accuracy, privacy compliance, and ad performance with Tiktok Events API.",
                            tiktokcapi_inner: "You can boost event matching, data accuracy, privacy compliance, and ad performance with Tiktok Events API.",
                            gtmpro: "Create all GTM tags and triggers for e-commerce events in your GTM container with just a single click. No manual setup needed.",
                            gtmpro_inner: "Create all GTM tags and triggers for e-commerce events in your GTM container with just a single click. No manual setup needed.",
                            gadseec: "Build Audience & improve the accuracy of your conversion with Google Ads Conversion & Enhance Conversion Tracking",
                            gadseec_inner: "Build Audience & improve the accuracy of your conversion with Google Ads Conversion & Enhance Conversion Tracking",
                            generalreport: "Access enhanced ecommerce reports from Google Analytics and Google Ads, including historical data."
                        };

                        var propopup_elink_arr = {
                            ga4apisecret_box: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=ga4apikey",
                            fbcapi: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=capi",
                            snapcapi: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=snapcapi",
                            tiktokcapi: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=tiktokcapi",
                            gtmpro: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=owngtm",
                            gadseec: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=gadseec",
                            ga4apisecret_box_inner: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=innersetting_ga4&utm_campaign=ga4apikey",
                            gadseec_inner: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=innersetting_gads&utm_campaign=gadseec",
                            fbcapi_inner: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=innersetting_fb&utm_campaign=capi",
                            snapcapi_inner: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=innersetting_snap&utm_campaign=capi",
                            tiktokcapi_inner: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=innersetting_tiktok&utm_campaign=capi",
                            gtmpro_inner: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=innersetting_gtm&utm_campaign=owngtm",
                            generalreport: "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=generalreport&utm_campaign=daterange"
                        };

                        var propopup_ulink_arr = {
                            ga4apisecret_box: "https://www.conversios.io/checkout?pid=wpAIO_SY1&?utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=ga4apikey",
                            fbcapi: "https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=capi",
                            snapcapi: "https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=snapcapi",
                            tiktokcapi: "https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=tiktokcapi",
                            gtmpro: "https://www.conversios.io/checkout/?pid=wpAIO_SY1&utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=owngtm",
                            gadseec: "https://www.conversios.io/checkout/?pid=wpAIO_SY1&utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=gadseec",
                            ga4apisecret_box_inner: "https://www.conversios.io/checkout?pid=wpAIO_SY1&?utm_source=woo_aiofree_plugin&utm_medium=innersetting_ga4&utm_campaign=ga4apikey",
                            fbcapi_inner: "https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=innersetting_fb&utm_campaign=capi",
                            snapcapi_inner: "https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=innersetting_snap&utm_campaign=capi",
                            tiktokcapi_inner: "https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=innersetting_tiktok&utm_campaign=capi",
                            gtmpro_inner: "https://www.conversios.io/checkout/?pid=wpAIO_SY1&utm_source=woo_aiofree_plugin&utm_medium=innersetting_gtm&utm_campaign=owngtm",
                            gadseec_inner: "https://www.conversios.io/checkout/?pid=wpAIO_SY1&utm_source=woo_aiofree_plugin&utm_medium=innersetting_gads&utm_campaign=gadseec",
                            generalreport: "https://www.conversios.io/checkout/?pid=wpAIO_SY1&utm_source=woo_aiofree_plugin&utm_medium=generalreport&utm_campaign=daterange"
                        };

                        jQuery("#conuptppro_text").html(propopup_text_arr[popupopener]);
                        jQuery("#conuptppro_elink").attr('href', propopup_elink_arr[popupopener]);
                        jQuery("#conuptppro_ulink").attr('href', propopup_ulink_arr[popupopener]);
                        jQuery("#upgradetopromodal").modal('show');
                    });
                });

                function user_tracking_data(event_name, error_msg, screen_name, event_label) {
                    jQuery.ajax({
                        type: "POST",
                        dataType: "json",
                        url: tvc_ajax_url,
                        data: {
                            action: "update_user_tracking_data",
                            event_name: event_name,
                            error_msg: error_msg,
                            screen_name: screen_name,
                            event_label: event_label,
                            TVCNonce: "<?php echo esc_js(wp_create_nonce('update_user_tracking_data-nonce')); ?>"
                        },
                        success: function(response) {
                            // console.log('user tracking');
                        }
                    });
                }
            </script>
            <script>
                window.fwSettings = {
                    'widget_id': 81000001743
                };
                ! function() {
                    if ("function" != typeof window.FreshworksWidget) {
                        var n = function() {
                            n.q.push(arguments)
                        };
                        n.q = [], window.FreshworksWidget = n
                    }
                }()
            </script>
            <script type='text/javascript' src='https://ind-widget.freshworks.com/widgets/81000001743.js' async defer></script>
<?php
        }
    }
}
new Conversios_Footer();
