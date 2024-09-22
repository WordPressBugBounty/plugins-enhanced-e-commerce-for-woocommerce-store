<!-- Facebook Form -->
<form id="facebooksetings_form" class="convgawiz_form_webads convpixsetting-inner-box pb-0 convwiz_border" datachannel="FB">
    <div class="pb-1">
        <!-- Facebook ID  -->
        <?php
        $fb_pixel_id = (isset($ee_options["fb_pixel_id"]) && $ee_options["fb_pixel_id"] != "") ? $ee_options["fb_pixel_id"] : "";
        ?>
        <div id="fbpixel_box" class="py-1">
            <div class="row pt-2">
                <div class="convwizard_pixtitle mt-0">
                    <div class="align-items-center mb-3">
                        <h5 class="m-0 h5">
                            <?php esc_html_e("Meta (Facebook) Pixel", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                        <?php esc_html_e(" Easily set up conversions and create audiences effortlessly using the simple steps given below.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <a target="_blank" href="<?php echo esc_url('https://www.conversios.io/docs/how-to-setup-fb-pixel-and-fbcapi-using-conversios-plugin/?utm_source=woo_aiofree_plugin&utm_medium=pixelandanalytics_wizard&utm_campaign=knowmore'); ?>" class="conv-link-blue">
                            <u><?php esc_html_e("Know how", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                        </a>
                    </div>
                </div>
                <div class="col-6 d-flex">
                    <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_meta_logo.png'); ?>" />
                    <input type="text" name="fb_pixel_id" id="fb_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($fb_pixel_id); ?>" placeholder="e.g. 518896233175751">
                </div>
            </div>

            <div class="py-3 ps-4">
                <div class="row pt-2 ps-2">
                    <div class="col-6 pe-4">
                        <h5 class="d-flex fw-normal mb-1 text-dark">
                            <?php esc_html_e("Meta (Facebook) Conversion API Token", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            <span class="conv-link-blue ms-2 fw-bold-500 upgradetopro_badge ms-auto" popupopener="fbcapi">
                                <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                                <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </span>
                        </h5>
                        <input readonly="" type="text" class="form-control disabled" value="" placeholder="e.g. CnTrpcbsStWFU5-TmSuhuSCnTrpcbsSTWFU%-TmSuhuS">
                    </div>

                </div>
            </div>

        </div>

    </div>
</form>
<!-- Tab bottom buttons -->
<div class="tab_bottom_buttons d-flex justify-content-end pt-4">
    <div class="ms-auto d-flex align-items-center">
        <button class="btn btn-outline-primary" style="width:184px" onclick="changeTabBox('webgmcbox-tab')">
            <?php esc_html_e('Go Back', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
        <button id="conv_save_fb_finish" type="button" class="btn btn-primary px-5 ms-3">
            <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <?php esc_html_e('Finish & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
    </div>
</div>

<script>
    function conv_onboarding_done(tvc_data) {
        var conversios_onboarding_nonce = "<?php echo esc_html(wp_create_nonce('conversios_onboarding_nonce')); ?>";
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "update_setup_time_to_subscription",
                tvc_data: tvc_data,
                subscription_id: "<?php echo esc_html($tvc_data['subscription_id']) ?>",
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
            success: function(response) {
                console.log("conv_onboarding_done");
            }
        });
    }

    function conv_wizfinish_popupopen() {
        jQuery("#conv_wizfinish").modal("show");
        jQuery('.modal-backdrop').appendTo('#wpbody-content');
        jQuery('body').removeClass("modal-open")
        jQuery('body').css("padding-right", "");
        jQuery("#conv_wizfinish").css("position", "absolute");
    }
    jQuery(function() {
        // jQuery(document).on("input", "#fb_pixel_id", function() {
        //     if (jQuery(this).val() == "") {
        //         jQuery("#conv_save_fb_finish").addClass("disabledsection");
        //     } else {
        //         jQuery("#conv_save_fb_finish").removeClass("disabledsection");
        //     }
        // });

        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";

        jQuery(document).on("click", "#conv_save_fb_finish", function() {
            conv_change_loadingbar("show");
            jQuery(this).addClass('disabled');
            var selected_vals = {};
            selected_vals["subscription_id"] = "<?php echo esc_html($tvc_data['subscription_id']) ?>";
            selected_vals["fb_pixel_id"] = jQuery("#fb_pixel_id").val();
            selected_vals["conv_onboarding_done_step"] = "<?php echo esc_js("5"); ?>";
            selected_vals["conv_onboarding_done"] = "<?php echo esc_js(gmdate('Y-m-d H:i:s')) ?>";

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "conv_save_pixel_data",
                    pix_sav_nonce: "<?php echo esc_html(wp_create_nonce('pix_sav_nonce_val')); ?>",
                    conv_options_data: selected_vals,
                    conv_options_type: ["eeoptions", "eeapidata", "middleware"],
                },
                success: function(response) {
                    conv_change_loadingbar("hide");
                    conv_wizfinish_popupopen();
                    conv_onboarding_done(tvc_data);
                }
            });
        });
    });
</script>