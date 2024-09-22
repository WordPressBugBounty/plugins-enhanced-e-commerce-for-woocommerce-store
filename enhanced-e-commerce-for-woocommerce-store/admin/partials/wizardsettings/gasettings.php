<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
$is_sel_disable_ga = 'disabled';
$cust_g_email =  (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";

$gtm_account_id = isset($ee_options['gtm_settings']['gtm_account_id']) ? $ee_options['gtm_settings']['gtm_account_id'] : "";
$gtm_container_id = isset($ee_options['gtm_settings']['gtm_container_id']) ? $ee_options['gtm_settings']['gtm_container_id'] : "";
$is_gtm_automatic_process = isset($ee_options['gtm_settings']['is_gtm_automatic_process']) ? $ee_options['gtm_settings']['is_gtm_automatic_process'] : false;
?>

<div class="mt-3">
    <div class="convwizard_pixtitle mt-0 mb-3">
        <div class="d-flex flex-row align-items-center">
            <h5 class="m-0 text-bold h5">
                <?php esc_html_e("Google Analytics 4", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </h5>
        </div>
        <div class="mt-1">
            <?php esc_html_e("Easily set up tracking in 2 simple steps given below", "enhanced-e-commerce-for-woocommerce-store"); ?>
        </div>
    </div>


    <form id="gasettings_form" class="convgawiz_form convpixsetting-inner-box mt-0 pb-3 pt-0" datachannel="GA">
        <div class="product-feed">
            <div class="progress-wholebox">
                <div class="card-body p-0">
                    <ul class="progress-steps-list p-0">
                        <li class="gmc_mail_step">
                            <!-- Google SignIn -->
                            <div class="convpixsetting-inner-box">
                                <?php
                                $g_email = (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";
                                ?>
                                <?php if ($g_email != "") { ?>
                                    <h5 class="fw-normal mb-1">
                                        <?php esc_html_e("Successfully signed in with account:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </h5>
                                    <span>
                                        <?php echo (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : ""; ?>
                                        <span class="conv-link-blue ps-2 tvc_google_signinbtn_ga">
                                            <?php esc_html_e("Change", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </span>
                                    </span>
                                <?php } else { ?>

                                    <div class="tvc_google_signinbtn_box" style="width: 185px;">
                                        <div class="tvc_google_signinbtn_ga google-btn">
                                            <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/btn_google_signin_dark_normal_web.png'); ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- Google SignIn End -->
                        </li>
                        <li class="gmc_account_id_step pt-3">
                            <!-- GA4 account ID Selection -->
                            <?php
                            $tracking_option = (isset($ee_options['tracking_option']) && $ee_options['tracking_option'] != "") ? $ee_options['tracking_option'] : "";
                            $ua_analytic_account_id = (isset($googleDetail->ua_analytic_account_id) && $googleDetail->ua_analytic_account_id != "") ? $googleDetail->ua_analytic_account_id : "";
                            $property_id = (isset($googleDetail->property_id) && $googleDetail->property_id != "") ? $googleDetail->property_id : "";
                            $ga4_analytic_account_id = (isset($googleDetail->ga4_analytic_account_id) && $googleDetail->ga4_analytic_account_id != "") ? $googleDetail->ga4_analytic_account_id : "";
                            $measurement_id = (isset($googleDetail->measurement_id) && $googleDetail->measurement_id != "") ? $googleDetail->measurement_id : "";
                            ?>
                            <div id="analytics_box_GA4" class="py-1">
                                <div class="row pt-1">
                                    <div class="col d-flex">
                                        <img class="conv_channel_logo me-4 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_ganalytics_logo.png'); ?>" />
                                        <select id="ga4_analytic_account_id" name="ga4_analytic_account_id" acctype="GA4" class="form-select form-select-lg mb-3 ga_analytic_account_id ga_analytic_account_id_ga4 selecttwo_search" style="width: 100%" <?php echo esc_attr($is_sel_disable_ga); ?>>
                                            <?php if (!empty($ga4_analytic_account_id)) { ?>
                                                <option selected><?php echo esc_attr($ga4_analytic_account_id); ?></option>
                                            <?php } ?>
                                            <option value="">Select GA4 Account ID</option>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <select id="ga4_property_id" name="measurement_id" class="form-select form-select-lg mb-3 selecttwo_search pixvalinput_gahot" style="width: 100%" <?php echo esc_attr($is_sel_disable_ga); ?>>
                                            <option value="">Select Measurement ID</option>
                                            <?php if (!empty($measurement_id)) { ?>
                                                <option selected><?php echo esc_attr($measurement_id); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <!-- GA4 account ID Selection End -->

                            <div id="ga4apisecret_box" class="py-3 ps-4">
                                <div class="row pt-2 ps-4">
                                    <div class="col-12">
                                        <h5 class="d-flex fw-normal mb-1 text-dark">
                                            <?php esc_html_e("GA4 API Secret (To track refund order)", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                            <span class="align-middle conv-link-blue fw-bold-500 upgradetopro_badge" popupopener="ga4apisecret_box">&nbsp;
                                                <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                                                <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                            </span>
                                        </h5>
                                        <input readonly="" type="text" name="ga4_api_secret" id="ga4_api_secret" class="form-control disabled" value="" placeholder="e.g. CnTrpcbsStWFU5-TmSuhuS">
                                    </div>

                                </div>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>


    </form>

    <!-- Tab bottom buttons -->
    <div class="tab_bottom_buttons d-flex align-items-center pt-4">
        <div class="ms-auto d-flex align-items-center">
            <button class="btn btn-outline-primary" style="width:184px" onclick="changeTabBox('gtmbox-tab')">
                <?php esc_html_e('Go Back', "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
            <?php
            $isgsdisabled = "";
            if (empty($measurement_id)) {
                $isgsdisabled = "disabledsection";
            }
            ?>
            <button id="save_gahotclcr" type="button" class="btn btn-primary px-5 ms-3 <?php esc_attr($isgsdisabled); ?>">
                <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <?php esc_html_e('Save & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
        </div>
    </div>

</div>

<script>
    // get list of google analytics account
    function list_analytics_account(tvc_data, selelement, currele, page = 1) {
        conv_change_loadingbar_popup("show");
        var conversios_onboarding_nonce = "<?php echo esc_html(wp_create_nonce('conversios_onboarding_nonce')); ?>";
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "get_analytics_account_list",
                tvc_data: tvc_data,
                page: page,
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
            success: function(response) {
                if (response && response.error == false) {
                    var error_msg = 'null';
                    if (response?.data?.items.length > 0) {
                        var AccOptions = '';
                        var selected = '';
                        response?.data?.items.forEach(function(item) {
                            AccOptions = AccOptions + '<option value="' + item.id + '"> ' + item.name +
                                '-' + item.id + '</option>';
                        });

                        jQuery('#ga4_analytic_account_id').append(AccOptions); //GA4 
                        jQuery('#ga4_analytic_account_id').prop("disabled", false);
                    } else {
                        // console.log("error1", "There are no Google Analytics accounts associated with this email.");
                        getAlertMessageAll(
                            'info',
                            'Error',
                            message = 'There are no Google Analytics accounts associated with this email.',
                            icon = 'info',
                            buttonText = 'Ok',
                            buttonColor = '#FCCB1E',
                            iconImageSrc =
                            '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                        );
                    }

                } else if (response && response.error == true && response.error != undefined) {
                    const errors = response.errors[0];
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = response.errors,
                        icon = 'info',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc =
                        '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                    );
                    var error_msg = errors;
                } else {
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = 'There are no Google Analytics accounts associated with this email.',
                        icon = 'info',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc =
                        '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                    );
                }
                jQuery("#tvc-ga4-acc-edit-acc_box")?.removeClass('tvc-disable-edits');
                conv_change_loadingbar("hide");
                jQuery(".conv-enable-selection_ga").removeClass('disabled');
                //jQuery('#ga4_analytic_account_id').select2('open');
            }
        });
    }


    // get list properties dropdown options
    function list_analytics_web_properties(type, tvc_data, account_id, thisselid) {
        jQuery("#ga4_property_id").prop("disabled", true);
        jQuery("#save_gahotclcr").addClass("disabledsection");
        var conversios_onboarding_nonce = "<?php echo esc_html(wp_create_nonce('conversios_onboarding_nonce')); ?>";
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "get_analytics_web_properties",
                account_id: account_id,
                type: type,
                tvc_data: tvc_data,
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
            success: function(response) {
                if (response && response.error == false) {
                    var error_msg = 'null';


                    if (type == "GA4") {
                        jQuery('#ga4_property_id').empty().trigger("change");
                        jQuery('#both_ga4_property_id').empty().trigger("change");
                        if (response?.data?.wep_measurement.length > 0) {
                            var streamOptions = '<option value="">Select Measurement Id</option>';
                            var selected = '';
                            response?.data?.wep_measurement.forEach(function(item) {
                                let dataName = item.name.split("/");
                                streamOptions = streamOptions + '<option value="' + item.measurementId +
                                    '">' + item.measurementId + ' - ' + item.displayName + '</option>';
                            });
                            jQuery('#ga4_property_id').append(streamOptions);
                            jQuery('#both_ga4_property_id').append(streamOptions);
                            jQuery('.event-setting-row_ga').addClass("convdisabledbox")
                        } else {
                            var streamOptions = '<option value="">No GA4 Property Found</option>';
                            jQuery('#ga3_property_id').append(streamOptions);
                            jQuery('#both_ga3_property_id').append(streamOptions);
                            getAlertMessageAll(
                                'info',
                                'Error',
                                message =
                                'There are no Google Analytics 4 Properties associated with this analytics account.',
                                icon = 'info',
                                buttonText = 'Ok',
                                buttonColor = '#FCCB1E',
                                iconImageSrc =
                                '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                            );
                        }
                        jQuery(".ga_analytic_account_id_ga4:not(#" + thisselid + ")").val(account_id).trigger(
                            "change");
                    }

                } else if (response && response.error == true && response.error != undefined) {
                    const errors = response.error[0];
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = errors,
                        icon = 'info',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc =
                        '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                    );
                    //add_message("error", errors);
                    var error_msg = errors;
                } else {
                    //add_message("error", "There are no Google Analytics Properties associated with this email.");
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = 'There are no Google Analytics Properties associated with this email.',
                        icon = 'info',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc =
                        '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                    );
                }
                conv_change_loadingbar("hide");
                jQuery("#ga4_property_id").prop("disabled", false);
                jQuery('.event-setting-row_ga').addClass("convdisabledbox")
            }
        });
    }

    function load_ga_accounts(tvc_data) {
        conv_change_loadingbar("show");
        jQuery(".conv-enable-selection_ga").addClass('disabled');
        var selele = jQuery(".conv-enable-selection_ga").closest(".conv-hideme-gasettings").find(
            "select.ga_analytic_account_id");
        var currele = jQuery(this).closest(".conv-hideme-gasettings").find("select.ga_analytic_account_id");
        list_analytics_account(tvc_data, selele, currele);
    }

    //Onload functions
    jQuery(function() {

        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        var tvc_ajax_url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        let subscription_id = "<?php echo esc_attr($subscriptionId); ?>";
        let plan_id = "<?php echo esc_attr($plan_id); ?>";
        let app_id = "<?php echo esc_attr($app_id); ?>";
        let bagdeVal = "yes";
        let convBadgeVal = "<?php echo esc_attr($convBadgeVal); ?>";
        let cust_g_email = "<?php echo esc_attr($cust_g_email); ?>";

        jQuery('#ga4_property_id, #ga4_analytic_account_id').on('select2:select', function(e) {
            if (jQuery('#ga4_property_id').val() == "" || jQuery('#ga4_analytic_account_id').val() == "") {
                jQuery("#save_gahotclcr").addClass("disabledsection");
            } else {
                jQuery("#save_gahotclcr").removeClass("disabledsection");
            }
        });


        jQuery(".selecttwo_search").select2({
            minimumResultsForSearch: 1,
            placeholder: function() {
                jQuery(this).data('placeholder');
            }
        });


        <?php if ((isset($cust_g_email) && $cust_g_email != "")) { ?>
            jQuery('.pawizard_tab_but').on('shown.bs.tab', function(e) {
                if (jQuery(e.target).attr('aria-controls') == "webpixbox") {
                    load_ga_accounts(tvc_data);
                }
            });
        <?php } ?>


        jQuery(document).on('select2:select', '.ga_analytic_account_id', function(e) {
            if (jQuery(this).val() != "" && jQuery(this).val() != undefined) {
                conv_change_loadingbar("show");
                var account_id = jQuery(e.target).val();
                var acctype = jQuery(e.target).attr('acctype');
                var thisselid = e.target.getAttribute('id');
                list_analytics_web_properties(acctype, tvc_data, account_id, thisselid);
                jQuery(".ga_analytic_account_id").closest(".conv-hideme-gasettings").find("select").prop(
                    "disabled", false);
            } else {
                jQuery(".ga_analytic_account_id").closest(".conv-hideme-gasettings").find("select").prop(
                    "disabled", false);
                jQuery('#ga4_property_id').val("").trigger("change");
            }

        });


        // Save data
        jQuery(document).on("click", "#save_gahotclcr", function() {
            jQuery(this).find(".spinner-border").removeClass("d-none");
            jQuery(this).addClass('disabledsection');
            changeTabBox("webadsbox-tab");
            var tracking_option = 'GA4'; //jQuery('input[type=radio][name=tracking_option]:checked').val();
            var box_id = "#analytics_box_" + tracking_option;
            var has_error = 0;
            var selected_vals = {};
            selected_vals["ua_analytic_account_id"] = "<?php echo esc_attr($ua_analytic_account_id); ?>";
            selected_vals["property_id"] = "<?php echo esc_attr($property_id); ?>";
            selected_vals["ga4_analytic_account_id"] = "";
            selected_vals["measurement_id"] = "";
            selected_vals["subscription_id"] = "<?php echo esc_html($tvc_data['subscription_id']) ?>";
            selected_vals["conv_onboarding_done_step"] = "<?php echo esc_js("2"); ?>";
            jQuery(box_id).find("select, input").each(function() {
                if (!jQuery(this).val() || jQuery(this).val() == "" || jQuery(this).val() ==
                    "undefined") {
                    has_error = 1;
                    return;
                } else {
                    selected_vals[jQuery(this).attr('name')] = jQuery(this).val();
                }
            });
            selected_vals["tracking_option"] = tracking_option;

            var data_gahotclcr = {
                action: "conv_save_pixel_data",
                pix_sav_nonce: "<?php echo esc_html(wp_create_nonce('pix_sav_nonce_val')); ?>",
                conv_options_data: selected_vals,
                conv_options_type: ["eeoptions", "eeapidata", "middleware"],
                //conv_options_type: ["eeoptions"],
                conv_tvc_data: tvc_data,
            };

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: data_gahotclcr,
                success: function(response) {
                    jQuery("#save_gahotclcr").find(".spinner-border").addClass("d-none");
                    jQuery("#save_gahotclcr").removeClass('disabledsection');
                }
            });
        });

    });
</script>