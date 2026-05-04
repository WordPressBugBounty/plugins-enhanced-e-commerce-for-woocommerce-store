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
                    var error_msg = 'null';




                    jQuery('#conv_save_success_modal').on('hidden.bs.modal', function() {
                        jQuery('#conv_save_success_modal .leave-a-review').hide();
                    });

                    jQuery(document).ajaxSuccess(function(event, xhr, settings) {
                        try {
                            let params = new URLSearchParams(settings.data);
                            let action = params.get('action');
                            const response = JSON.parse(xhr.responseText);
                            // console.log("AJAX Success detected for action:", action, xhr);
                            if (response.conv_param_error) {
                                console.log("got error:", response.conv_param_error);
                                showConversiosError(response.conv_param_error, "error");
                            }
                        } catch (e) {
                            console.warn("Failed to parse AJAX data", e);
                        }
                        return false;
                    });

                    function showConversiosError(message, type = "error") {
                        jQuery(".conv-global-toast").remove();

                        let bgColor = "#dc3545",
                            icon = "❌";
                        if (type === "success") {
                            bgColor = "#28a745";
                            icon = "✅";
                        } else if (type === "warning") {
                            bgColor = "#ffc107";
                            icon = "⚠️";
                        } else if (type === "info") {
                            bgColor = "#17a2b8";
                            icon = "ℹ️";
                        }

                        const toastHTML = `
        <div class="conv-global-toast" 
             style="position:fixed; top:20px; right:20px; z-index:99999;
                    background:${bgColor}; color:#fff; padding:14px 18px; 
                    border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.2);
                    display:flex; align-items:center; justify-content:space-between;
                    gap:10px; font-size:15px; min-width:300px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span>${message}</span>
            </div>
            <span class="conv-toast-close" 
                  style="cursor:pointer; font-weight:bold; font-size:18px; margin-left:10px;">&times;</span>
        </div>
    `;

                        jQuery("body").append(toastHTML);

                        // 🔹 Close on click
                        jQuery(".conv-toast-close").on("click", function() {
                            jQuery(this).closest(".conv-global-toast").fadeOut(300, function() {
                                jQuery(this).remove();
                            });
                        });

                        // 🔹 Auto-hide after 10 seconds
                        setTimeout(() => {
                            jQuery(".conv-global-toast").fadeOut(400, function() {
                                jQuery(this).remove();
                            });
                        }, 10000);
                    }

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
