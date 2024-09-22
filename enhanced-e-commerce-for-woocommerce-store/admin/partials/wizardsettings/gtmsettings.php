<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 
?>
<div class="">
    <form id="gtmsettings_form">

        <div class="convpixsetting-inner-box mt-4">
            <div class="d-flex align-items-center mb-2">
                <img class="me-2" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/gtm_logo.png'); ?>" width="32px" height="32px">
                <h3 class="mb-0 h5" style="font-weight:500">
                    <?php esc_html_e("Select Google Tag Manager Container ID:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </h3>
            </div>
            <?php
            $disabledsection = "disabledsection";
            $tracking_method = (isset($ee_options['tracking_method']) && $ee_options['tracking_method'] != "") ? $ee_options['tracking_method'] : "";
            $want_to_use_your_gtm = "";
            if ($tracking_method == "gtm") {
                $want_to_use_your_gtm = (isset($ee_options['want_to_use_your_gtm']) && $ee_options['want_to_use_your_gtm'] != "") ? $ee_options['want_to_use_your_gtm'] : "0";
            }
            if ((isset($_GET['wizard_channel']) && sanitize_text_field($_GET['wizard_channel']) == "gtmsettings")) {
                $want_to_use_your_gtm = "1";
            }
            $use_your_gtm_id = isset($ee_options['use_your_gtm_id']) ? $ee_options['use_your_gtm_id'] : "";
            ?>
            <div class="px-2">
                <div class="py-1">
                    <input class="align-top" type="radio" checked="checked" name="want_to_use_your_gtm" id="want_to_use_your_gtm_default" value="0">
                    <label class="form-check-label h6 mb-0 ps-2" for="want_to_use_your_gtm_default">
                        <?php esc_html_e("Default Container", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </label>
                    <small><?php esc_html_e("This pre-configured Conversios GTM container (GTM - K7X94DG) has been set up for tracking purposes, and access to this is not available.", "enhanced-e-commerce-for-woocommerce-store"); ?></small>
                </div>

                <div class="py-1 pt-2">
                    <input class="align-top" type="radio" value="1" disabled readonly>
                    <label class="form-check-label h6 mb-0 ps-2">
                        <?php esc_html_e("Connect Custom GTM Container", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <span class="conv-link-blue ms-2 fw-bold-500 upgradetopro_badge" popupopener="gtmpro">
                            <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                            <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </span>
                    </label>
                    <small><strong style="color:#0AB17B"><?php esc_html_e("Recommended:", "enhanced-e-commerce-for-woocommerce-store"); ?></strong>&nbsp;
                        <?php esc_html_e("Automatically configure your GTM container with essential tags, triggers, and variables precise tracking.", "enhanced-e-commerce-for-woocommerce-store"); ?></small>
                </div>

            </div>

            <input type="hidden" name="tracking_method" id="tracking_method" value="gtm">
        </div>
    </form>




    <!-- Tab bottom buttons -->
    <div class="tab_bottom_buttons d-flex justify-content-end pt-4">
        <button type="button" class="btn btn-primary px-5 ms-3" id="save_gtm_settings">
            <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <?php esc_html_e('Continue Setup', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
    </div>
</div>

<?php
// When user visiting this one screen by landing from new feature popup
if (isset($_GET['onboarding'])) {
    update_option('conv_popup_newfeature', 'yes');
}
?>

<script>
    var store_id = '<?php echo esc_html($store_id); ?>';
    // set static width to container dropdown to avoid lenght issue when there is no account.
    // jQuery('#gtm_account_container_list').siblings('.select2:first').attr('style', 'width: 312px');
    jQuery('#gtm_account_container_list').select2();
    jQuery(".selecttwo_configs").select2();
    let automation_status = "<?php echo esc_html($automation_status); ?>";
    let plan_id = "<?php echo esc_html($plan_id); ?>";
    let gtm_account_id = "<?php echo esc_html($gtm_account_id); ?>";
    let gtm_container_id = "<?php echo esc_js($gtm_container_id); ?>";
    let gtm_container_public_id = "<?php echo esc_js($gtm_container_publicId); ?>";
    let gtm_account_container_name = "<?php echo esc_js($gtm_account_container_name); ?>";
    let subscription_id = "<?php echo esc_html($tvc_data['subscription_id']); ?>"; //subscription_id  
    let selectedOption = gtm_account_id + '_' + gtm_container_id + '_' + gtm_container_public_id;

    let is_gtm_automatic_process = false;
    let is_gtm_automatic_process_check = "<?php echo esc_html($is_gtm_automatic_process); ?>"
    let gtm_gmail = "<?php echo esc_url($g_gtm_email); ?>";
    jQuery(document).on("click", "#save_gtm_settings", function() {
        jQuery(this).find(".spinner-border").removeClass("d-none");
        jQuery(this).addClass('disabledsection');
        //save_gtm_settings();
        changeTabBox("webpixbox-tab");
        jQuery(this).find(".spinner-border").addClass("d-none");
        jQuery(this).removeClass('disabledsection');
    });

    // Set GTM on page load. 
    let tracking_method = "<?php echo esc_js($tracking_method) ?>";
    if (tracking_method != 'gtm' && tracking_method == '') {
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "conv_save_pixel_data",
                pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                conv_options_data: {
                    want_to_use_your_gtm: 0,
                    tracking_method: 'gtm',
                    conv_onboarding_done_step: <?php echo esc_js("1"); ?>
                },
                conv_options_type: ["eeoptions", "eeapidata"],
            },
            success: function(response) {
                jQuery('.gtm-badge').removeClass('conv-badge-yellow').addClass('conv-badge-green');
                jQuery('.gtm-badge').text('Connected')
                jQuery('.conv-pixel-list-item').removeClass('conv-gtm-not-connected').addClass(
                    'conv-gtm-connected')
                jQuery('.gtm-lable').html('Container ID: <b> GTM-K7X94DG (Conversios Default Container)</b>')
            },
            error: function(error) {
                // console.log('error', error)
                jQuery('.gtm-badge').removeClass('conv-badge-green').addClass('conv-badge-yellow');
                jQuery('.gtm-badge').text('Mandatory')
                jQuery('.conv-pixel-list-item').removeClass('conv-gtm-connected').addClass(
                    'conv-gtm-not-connected')
            }
        });
    }
</script>