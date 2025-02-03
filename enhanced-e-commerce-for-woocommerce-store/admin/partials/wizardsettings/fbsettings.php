<div class="convwiz_pixtitle mt-3 mb-0 d-flex justify-content-between align-items-center py-0">
    <div class="col-7">
        <div class="convwizlogotitle">
            <div class="d-flex flex-row align-items-center">
                <?php echo wp_kses(
                    enhancad_get_plugin_image('/admin/images/logos/conv_meta_logo.png', '', 'conv_channel_logo me-2 align-self-center'),
                    array(
                        'img' => array(
                            'src' => true,
                            'alt' => true,
                            'class' => true,
                            'style' => true,
                        ),
                    )
                ); ?>
                <div>
                    <h5 class="m-0 text-bold h5">
                        <?php esc_html_e("Meta (Facebook) Pixel", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h5>
                </div>
            </div>
        </div>

        <ul class="conv-green-checklis list-unstyled mt-3">
            <li class="d-flex">
                <span class="material-symbols-outlined text-success md-18">
                    check_circle
                </span>
                <?php esc_html_e("All the e-commerce pixel tracking including Purchase", "enhanced-e-commerce-for-woocommerce-store"); ?>
                <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="PageView, ViewContent, AddToCart, InitiateCheckout, AddPaymentInfo, Purchase">
                    info
                </span>
            </li>
            <li class="d-flex">
                <span class="material-symbols-outlined text-success md-18">
                    check_circle
                </span>
                <?php esc_html_e("All the lead generation pixel tracking including Form Submit", "enhanced-e-commerce-for-woocommerce-store"); ?>
                <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Lead, email_click, phone_click, address_click">
                    info
                </span>
            </li>
        </ul>

    </div>

</div>

<!-- Facebook Form -->
<form id="facebooksetings_form" class="convgawiz_form_webads convpixsetting-inner-box pb-0 convwiz_border" datachannel="FB">
    <div class="pb-1">
        <!-- Facebook ID  -->
        <?php
        $fb_pixel_id = (isset($ee_options["fb_pixel_id"]) && $ee_options["fb_pixel_id"] != "") ? $ee_options["fb_pixel_id"] : "";
        ?>
        <div id="fbpixel_box" class="py-1">
            <div class="row pt-2">
                <div class="col-7 conv-border-box ms-3">
                    <h5 class="fw-normal mb-1 text-dark">
                        <b><?php esc_html_e("Enter Meta Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                    </h5>
                    <input type="text" name="fb_pixel_id" id="fb_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($fb_pixel_id); ?>" placeholder="e.g. 518896233175751">
                    <?php esc_html_e("Set up conversions and create audiences for Meta Business Center.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    <a target="_blank" href="<?php echo esc_url('https://www.conversios.io/docs/how-to-setup-fb-pixel-and-fbcapi-using-conversios-plugin/?utm_source=woo_aiofree_plugin&utm_medium=pixelandanalytics_wizard&utm_campaign=knowmore'); ?>" class="conv-link-blue">
                        <u><?php esc_html_e("Learn More", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                    </a>
                </div>
            </div>

            <div class="pt-3">
                <div class="row">
                    <div class="col-12">
                        <div class="row row-x-0 d-flex justify-content-between align-items-center conv_create_gads_new_card rounded px-3 py-3" style="background: #caf3e3;">
                            <div class="mt-0 mb-2 col-3 d-flex justify-content-center">
                                <?php echo wp_kses(
                                    enhancad_get_plugin_image('/admin/images/fbcapiimpact.png','','rounded shadow'),
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
                            <div class="mt-0 mb-2 col-9">
                                <div class="fs-6 fw-bold text-primary">Facebook Conversion API (FCAPI) Benefits in Professional Plan</div>
                                <ul class="conv-green-checklis fb-kapi list-unstyled mt-1">
                                    <li class="d-flex fs-14 fw-bold">
                                        <span class="material-symbols-outlined text-success md-18">
                                            check_circle
                                        </span>
                                        <?php esc_html_e("Improves Event Match Quality scores by sending extra user data (e.g., email, phone number).", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </li>
                                    <li class="d-flex fs-14 fw-bold">
                                        <span class="material-symbols-outlined text-success md-18">
                                            check_circle
                                        </span>
                                        <?php esc_html_e("Highest Event Match Quality Score via Our plugin 9.3", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </li>
                                    <li class="d-flex fs-14 fw-bold">
                                        <span class="material-symbols-outlined text-success md-18">
                                            check_circle
                                        </span>
                                        <?php esc_html_e("Complete picture of user journeys, resulting in better conversion attribution, especially with iOS 14+ restrictions.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </li>
                                    <li class="d-flex fs-14 fw-bold">
                                        <span class="material-symbols-outlined text-success md-18">
                                            check_circle
                                        </span>
                                        <?php esc_html_e("Bypasses ad blockers and browser restrictions, ensuring more precise tracking of conversions.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </li>
                                </ul>
                                <a target="_blank" href="<?php echo esc_url('https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=capi'); ?>" class="align-middle btn btn-sm btn-primary fw-bold-500">
                                    <?php esc_html_e("Buy Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>

    </div>
</form>
<!-- Tab bottom buttons -->
<div class="tab_bottom_buttons d-flex justify-content-end pt-4">
    <div class="ms-auto d-flex align-items-center">
        <button class="btn btn-outline-primary" onclick="changeTabBox('webgmcbox-tab')">
            <?php esc_html_e('Go Back', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
        <button id="conv_save_fb_finish" type="button" class="conv_save_fb_finish btn btn-primary px-5 ms-3 disabledsection">
            <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <?php esc_html_e('Save & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
        <button class="btn btn-outline-primary ms-3 conv_save_fb_finish">
            <?php esc_html_e('Skip & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
    </div>
</div>

<script>
    function conv_onboarding_done(tvc_data) {
        var conversios_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>";
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


    jQuery(function() {
        jQuery(document).on("input", "#fb_pixel_id", function() {
            if (jQuery(this).val() == "") {
                jQuery("#conv_save_fb_finish").addClass("disabledsection");
            } else {
                jQuery("#conv_save_fb_finish").removeClass("disabledsection");
            }
        });

        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";

        jQuery(document).on("click", ".conv_save_fb_finish", function() {
            //conv_change_loadingbar("show");
            jQuery("#conv_save_fb_finish").addClass('disabledsection');
            changeTabBox("webotherbox-tab");

            var selected_vals = {};
            selected_vals["subscription_id"] = "<?php echo esc_html($tvc_data['subscription_id']) ?>";
            selected_vals["fb_pixel_id"] = jQuery("#fb_pixel_id").val();
            selected_vals["conv_onboarding_done_step"] = "<?php echo esc_js("5"); ?>";
            //selected_vals["conv_onboarding_done"] = "<?php echo esc_js(gmdate('Y-m-d H:i:s')) ?>";

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "conv_save_pixel_data",
                    pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                    conv_options_data: selected_vals,
                    conv_options_type: ["eeoptions", "eeapidata", "middleware"],
                },
                success: function(response) {
                    if (jQuery("#fb_pixel_id").val() == "") {
                        jQuery("#conv_save_fb_finish").addClass("disabledsection");
                    } else {
                        jQuery("#conv_save_fb_finish").removeClass("disabledsection");
                    }
                    //conv_change_loadingbar("hide");
                    //conv_wizfinish_popupopen();
                    //conv_onboarding_done(tvc_data);
                }
            });
        });
    });
</script>