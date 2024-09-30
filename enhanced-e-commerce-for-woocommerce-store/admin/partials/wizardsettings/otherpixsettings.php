<div class="convwiz_pixtitle mt-3 mb-3 d-flex justify-content-between align-items-center py-0">
    <div class="col-7">
        <div class="convwizlogotitle">
            <div class="d-flex flex-row align-items-center">
                <img style="width: 42px;" class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/mix_logos.png'); ?>" />
                <div>
                    <h5 class="m-0 text-bold h5">
                        <?php esc_html_e("Other Pixels Available", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="alert alert-success mb-0" role="alert">
        <?php esc_html_e('This screen allows you to track additional pixels. If you prefer to skip this step, simply click "Save & Finish" to finish your setup.', 'enhanced-e-commerce-for-woocommerce-store'); ?>
    </div>
</div>
<!-- Other Pixel Form -->
<form id="otherpixelsetings_form" class="convgawiz_form_webotherpix convpixsetting-inner-box pb-0 convwiz_border" datachannel="otherpix">
    <div class="pb-1">
        <!-- Facebook ID  -->
        <?php
        $tiKtok_ads_pixel_id = (isset($ee_options["tiKtok_ads_pixel_id"]) && $ee_options["tiKtok_ads_pixel_id"] != "") ? $ee_options["tiKtok_ads_pixel_id"] : "";
        $snapchat_ads_pixel_id = (isset($ee_options["snapchat_ads_pixel_id"]) && $ee_options["snapchat_ads_pixel_id"] != "") ? $ee_options["snapchat_ads_pixel_id"] : "";
        $pinterest_ads_pixel_id = (isset($ee_options["pinterest_ads_pixel_id"]) && $ee_options["pinterest_ads_pixel_id"] != "") ? $ee_options["pinterest_ads_pixel_id"] : "";
        $microsoft_ads_pixel_id = (isset($ee_options["microsoft_ads_pixel_id"]) && $ee_options["microsoft_ads_pixel_id"] != "") ? $ee_options["microsoft_ads_pixel_id"] : "";
        $msclarity_pixel_id = (isset($ee_options["msclarity_pixel_id"]) && $ee_options["msclarity_pixel_id"] != "") ? $ee_options["msclarity_pixel_id"] : "";
        $hotjar_pixel_id = (isset($ee_options["hotjar_pixel_id"]) && $ee_options["hotjar_pixel_id"] != "") ? $ee_options["hotjar_pixel_id"] : "";
        $crazyegg_pixel_id = (isset($ee_options["crazyegg_pixel_id"]) && $ee_options["crazyegg_pixel_id"] != "") ? $ee_options["crazyegg_pixel_id"] : "";
        ?>
        <div id="otherpixel_box" class="py-1">
            <div class="row pt-2">
                <div class="col-6 pt-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_tiktok_logo.png'); ?>" />
                        <b><?php esc_html_e("Tiktok Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="tiKtok_ads_pixel_id" id="tiKtok_ads_pixel_id" class="form-control" value="<?php echo esc_attr($tiKtok_ads_pixel_id); ?>">
                </div>

                <div class="col-6 pt-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_snap_logo.png'); ?>" />
                        <b><?php esc_html_e("Snapchat Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="snapchat_ads_pixel_id" id="snapchat_ads_pixel_id" class="form-control" value="<?php echo esc_attr($snapchat_ads_pixel_id); ?>">
                </div>


                <div class="col-6 pt-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_pint_logo.png'); ?>" />
                        <b><?php esc_html_e("Pinterest Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="pinterest_ads_pixel_id" id="pinterest_ads_pixel_id" class="form-control" value="<?php echo esc_attr($pinterest_ads_pixel_id); ?>">
                </div>

                <div class="col-6 pt-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <img style="height: 24px;" class="me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_bing_logo.png'); ?>" />
                        <b><?php esc_html_e("Microsoft Ads (Bing) Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="microsoft_ads_pixel_id" id="microsoft_ads_pixel_id" class="form-control" value="<?php echo esc_attr($microsoft_ads_pixel_id); ?>">
                </div>

                <div class="col-6 pt-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_clarity_logo.png'); ?>" />
                        <b><?php esc_html_e("MS Clarity Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="msclarity_pixel_id" id="msclarity_pixel_id" class="form-control" value="<?php echo esc_attr($msclarity_pixel_id); ?>">
                </div>

                <div class="col-6 pt-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_hotjar_logo.png'); ?>" />
                        <b><?php esc_html_e("Hotjar Pixel", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="hotjar_pixel_id" id="hotjar_pixel_id" class="form-control" value="<?php echo esc_attr($hotjar_pixel_id); ?>">
                </div>

                <div class="col-6 pt-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_crazyegg_logo.png'); ?>" />
                        <b><?php esc_html_e("Crazy Egg Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="crazyegg_pixel_id" id="crazyegg_pixel_id" class="form-control" value="<?php echo esc_attr($crazyegg_pixel_id); ?>">
                </div>
            </div>
        </div>

    </div>
</form>
<!-- Tab bottom buttons -->
<div class="tab_bottom_buttons d-flex justify-content-end pt-2">
    <div class="ms-auto d-flex align-items-center">
        <button class="btn btn-outline-primary" onclick="changeTabBox('webfbbox-tab')">
            <?php esc_html_e('Go Back', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
        <button id="conv_save_opix_finish" type="button" class="btn btn-primary px-5 ms-3">
            <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <?php esc_html_e('Save & Finish', "enhanced-e-commerce-for-woocommerce-store"); ?>
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
        if (jQuery("#google_merchant_center_id").val() != "" &&
            jQuery("#google_merchant_center_id").val() != undefined &&
            jQuery("#google_merchant_center_id").val() != null
        ) {
            jQuery(".aftersetupurl").attr("href", "<?php echo esc_url('admin.php?page=conversios-google-shopping-feed&tab=feed_list'); ?>");
            jQuery("#aftersetupurlblue").html("Sync Products with Google Now <span class='material-symbols-outlined fs-5'>arrow_forward</span>");
        }

        jQuery("#conv_wizfinish").modal("show");
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

        jQuery(document).on("click", "#conv_save_opix_finish", function() {
            conv_change_loadingbar("show");
            jQuery(this).addClass('disabled');
            var selected_vals = {};
            selected_vals["subscription_id"] = "<?php echo esc_html($tvc_data['subscription_id']) ?>";

            selected_vals["tiKtok_ads_pixel_id"] = jQuery("#tiKtok_ads_pixel_id").val();
            selected_vals["snapchat_ads_pixel_id"] = jQuery("#snapchat_ads_pixel_id").val();
            selected_vals["pinterest_ads_pixel_id"] = jQuery("#pinterest_ads_pixel_id").val();
            selected_vals["microsoft_ads_pixel_id"] = jQuery("#microsoft_ads_pixel_id").val();
            selected_vals["msclarity_pixel_id"] = jQuery("#msclarity_pixel_id").val();
            selected_vals["hotjar_pixel_id"] = jQuery("#hotjar_pixel_id").val();
            selected_vals["crazyegg_pixel_id"] = jQuery("#crazyegg_pixel_id").val();

            selected_vals["conv_onboarding_done_step"] = "<?php echo esc_js("6"); ?>";
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