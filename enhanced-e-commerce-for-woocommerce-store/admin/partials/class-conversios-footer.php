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
            <?php
            $licenceInfoArr = array(
                esc_html__( "Plan Type:", "enhanced-e-commerce-for-woocommerce-store" ) => esc_html__( "Free", "enhanced-e-commerce-for-woocommerce-store" ),
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
                                                    '%s',
                                                    esc_html($key)
                                                );
                                                ?>
                                            </span>
                                            <span class="ps-2">
                                                <?php
                                                printf(
                                                    '%s',
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





        <?php
        }

        public function before_end_footer_add_script()
        {
            $TVC_Admin_Helper = new TVC_Admin_Helper();
            $subscriptionId =  sanitize_text_field($TVC_Admin_Helper->get_subscriptionId());
        ?>
            <script>
                jQuery(function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    });
                });
            </script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    var screen_name = '<?php echo isset($_GET['page']) ? esc_js(sanitize_text_field(wp_unslash($_GET['page']))) : ''; ?>';

                    // ── Notification Banner (AJAX) ──

                    jQuery.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'convaio_get_notification_banner',
                            convaio_nonce: '<?php echo esc_js("general_nonce"); ?>'
                        },
                        success: function(response) {
                            if (response && response.error === false && response.data && response.data.banner_isactive) {
                                var d = response.data;
                                var html = '<span class="notif-text" style="color:' + (d.banner_text_color || '#2d3a2e') + '">' + (d.banner_text || '') + '</span>';
                                if (d.banner_button_text && d.banner_button_link) {
                                    html += '<a href="' + d.banner_button_link + '" target="_blank" class="notif-cta-btn" style="margin-left:15px; border-radius:15px; padding:6px 15px; text-decoration:none; display:inline-block; font-weight:bold; background:' + (d.banner_button_bg || '#2e7d32') + ';color:' + (d.banner_button_text_color || '#fff') + '">' + d.banner_button_text + '</a>';
                                }
                                var bannerBar = jQuery('#convaio-notification-bar');
                                bannerBar.html(html);
                                bannerBar.css({
                                    'background': d.banner_bg || 'linear-gradient(90deg, #a8e6cf 0%, #f5c98a 100%)',
                                    'color': d.banner_text_color || '#2d3a2e'
                                });
                                bannerBar.slideDown();
                            }
                        }
                    });

                });
            </script>

<?php

        }
    }
}
new Conversios_Footer();
