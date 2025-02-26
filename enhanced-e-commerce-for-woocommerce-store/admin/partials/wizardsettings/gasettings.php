<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
$is_sel_disable_ga = 'disabled';
$cust_g_email =  (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";

$gtm_account_id = isset($ee_options['gtm_settings']['gtm_account_id']) ? $ee_options['gtm_settings']['gtm_account_id'] : "";
$gtm_container_id = isset($ee_options['gtm_settings']['gtm_container_id']) ? $ee_options['gtm_settings']['gtm_container_id'] : "";
$is_gtm_automatic_process = isset($ee_options['gtm_settings']['is_gtm_automatic_process']) ? $ee_options['gtm_settings']['is_gtm_automatic_process'] : false;

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

<div class="mt-3">
    <div class="alert alert-primary mb-5 d-flex" role="alert">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_gtm_logo.png', '', 'me-2 align-self-center'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <div class="text-dark">
            <h4 class="m-0"><?php esc_html_e("🎉 Great News! ", "enhanced-e-commerce-for-woocommerce-store"); ?></h4>
            <ul class="list-styled ps-3">
                <li class="m-0">
                    <?php esc_html_e("Our Ready-to-Use GTM Configuration includes tags, triggers, and variables for GA4, Google Ads, Facebook, and other ad platforms. ", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </li>
                <li class="m-0">
                    <?php esc_html_e("Just connect each platform, and we'll handle the rest—no more GTM worries! 🚀", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="convwiz_pixtitle mt-0 mb-3 d-flex justify-content-between align-items-center py-0">
        <div class="col-7">
            <div class="convwizlogotitle">
                <div class="d-flex flex-row align-items-center">
                    <?php echo wp_kses(
                        enhancad_get_plugin_image('/admin/images/logos/conv_ganalytics_logo.png', '', 'conv_channel_logo me-2 align-self-center'),
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
                            <?php esc_html_e("Google Analytics 4", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                    </div>
                </div>
            </div>

            <ul class="conv-green-checklis list-unstyled mt-3">
                <li class="d-flex">
                    <span class="material-symbols-outlined text-success md-18">
                        check_circle
                    </span>
                    All the e-commerce event tracking including Purchase for <b class="px-2">Woocommerce</b>
                    <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="page_view, purchase, view_item_list, view_item, select_item, add_to_cart, remove_from_cart, view_cart, begin_checkout, add_payment_info, and add_shipping_info.">
                        info
                    </span>
                </li>
                <li class="d-flex">
                    <span class="material-symbols-outlined text-success md-18">
                        check_circle
                    </span>
                    All the lead generation event tracking including Form Submit for <b class="px-2">WordPress</b>
                    <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Lead Form Submit, Lead Email Click, Lead Phone Click, Page Scroll, File Download, Author, Login, Signup">
                        info
                    </span>
                </li>
            </ul>

        </div>

        <div class="col convgauthcol">

            <!-- Google SignIn -->
            <div class="convpixsetting-inner-box ">
                <?php
                $g_email = (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";
                ?>
                <?php if ($g_email != "") { ?>
                    <div class="convgauthsigned ps-3">
                        <h5 class="fw-normal mb-1">
                            <?php esc_html_e("Successfully signed in with account:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                        <span>
                            <?php echo (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : ""; ?>
                            <span class="conv-link-blue ps-2 tvc_google_signinbtn_ga">
                                <?php esc_html_e("Change", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </span>
                        </span>
                    </div>

                <?php } else { ?>

                    <div class="tvc_google_signinbtn_box " style="width: 185px;">
                        <div class="tvc_google_signinbtn_ga google-btn">
                            <?php echo wp_kses(
                                enhancad_get_plugin_image('/admin/images/logos/btn_google_signin_dark_normal_web.png'),
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
                    <div class="ps-1 pt-2">We only require Google authorization to access your Google Analytics 4 Account and Measurement ID for data tracking. Your personal information and account details remain completely secure and private.</div>
                <?php } ?>
            </div>
            <!-- Google SignIn End -->
        </div>



    </div>





    <form id="gasettings_form" class="convgawiz_form convpixsetting-inner-box mt-0 pb-3 pt-0" datachannel="GA">
        <div class="product-feed">
            <div class="progress-wholebox">
                <div class="card-body p-0">
                    <ul class="progress-steps-list p-0">

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
                                <div class="row conv-border-box">
                                    <div class="col-6">
                                        <h5 class="d-flex fw-normal mb-1 text-dark">
                                            <b><?php esc_html_e("GA4 Account", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                        </h5>
                                        <select id="ga4_analytic_account_id" name="ga4_analytic_account_id" acctype="GA4" class="form-select form-select-lg mb-3 ga_analytic_account_id ga_analytic_account_id_ga4 selecttwo_search" style="width: 100%" <?php echo esc_attr($is_sel_disable_ga); ?>>
                                            <?php if (!empty($ga4_analytic_account_id)) { ?>
                                                <option selected><?php echo esc_attr($ga4_analytic_account_id); ?></option>
                                            <?php } ?>
                                            <option value="">Select GA4 Account ID</option>
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <h5 class="d-flex fw-normal mb-1 text-dark">
                                            <b><?php esc_html_e("GA4 Measurement ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                        </h5>
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
                            <div id="enable_cid" class="pt-4 ps-2">
                                <div class="row ">
                                    <div class="col-12 m-auto text-end d-flex">
                                        <div class="form-check p-0 me-2">
                                            <input class="form-check-input ms-auto float-end" type="checkbox" id="non_woo_tracking" name="non_woo_tracking" checked>
                                        </div>
                                        <label class="form-check-label fw-normal text-dark" for="non_woo_tracking">
                                            Enable Recommended Events in GA4
                                        </label>
                                        <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Page scroll tracking, File download, Author tracking, SignUp, Login.">
                                            info
                                        </span>
                                    </div>
                                    <div class="col-12 m-auto text-end d-flex">
                                        <div class="form-check p-0 me-2">
                                            <input class="form-check-input ms-auto float-end" type="checkbox" id="ga_cid" name="ga_cid" checked>
                                        </div>
                                        <label class="form-check-label fw-normal text-dark" for="ga_cid">
                                            Enable client id and Enhance conversion in GA4 for better reporting
                                        </label>
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
    <div class="tab_bottom_buttons d-flex align-items-center pt-0">
        <div class="ms-auto d-flex align-items-center">
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

<div class="modal fade" id="nogaaccfound" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="nogaaccfoundLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-12 flex-row pt-3">
                    <div class="d-flex justify-content-between align-items-center conv_create_gads_new_card rounded px-3 py-3">
                        <?php echo wp_kses(
                            enhancad_get_plugin_image('/admin/images/logos/conv_ganalytics_logo.png', '', 'conv_channel_logo me-4 align-self-start'),
                            array(
                                'img' => array(
                                    'src' => true,
                                    'alt' => true,
                                    'class' => true,
                                    'style' => true,
                                ),
                            )
                        ); ?>
                        <div class="div">
                            <h6 class="text-dark mb-3">
                                <?php esc_html_e("No Google Analytics account was found linked to this email.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h6>
                            <div class="text-dark mb-3">
                                Please log in with the email that has admin access to your Google Analytics account
                            </div>
                            <div class="text-dark">
                                <?php esc_html_e("To get the most out of this plugin, you need to connect Google Analytics. It helps you track your users' actions and understand their journey on your site.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="https://analytics.google.com/" target="_blank" class="d-flex btn btn-primary align-items-center">
                    Create new Google Analytics Account
                    <span class="material-symbols-outlined">
                        arrow_forward
                    </span>
                </a>
            </div>
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
                jQuery('#ga4_analytic_account_id, #ga4_property_id').html('<option value="">Select Google Analytics accounts</option>');
                jQuery("#save_gahotclcr").addClass("disabledsection");
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
                        jQuery("#nogaaccfound").modal('show');
                    }

                } else if (response && response.error == true && response.error != undefined) {
                    const errors = response.errors[0];
                    jQuery("#nogaaccfound").modal('show');
                } else {
                    jQuery("#nogaaccfound").modal('show');
                }
                jQuery("#tvc-ga4-acc-edit-acc_box")?.removeClass('tvc-disable-edits');
                conv_change_loadingbar("hide");
                jQuery(".conv-enable-selection_ga").removeClass('disabled');
                setTimeout(function() {
                    jQuery("#ga4_analytic_account_id").select2('open');
                }, 1000);

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
                            jQuery('.event-setting-row_ga').addClass("convdisabledbox");
                            jQuery("#save_gahotclcr").removeClass("disabledsection"); // added new line
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
                                iconImageSrc = '<?php echo wp_kses(
                                                    enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png'),
                                                    array(
                                                        'img' => array(
                                                            'src' => true,
                                                            'alt' => true,
                                                            'class' => true,
                                                            'style' => true,
                                                        ),
                                                    )
                                                ); ?>'
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
                        iconImageSrc = '<?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png'),
                                            array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true,
                                                    'class' => true,
                                                    'style' => true,
                                                ),
                                            )
                                        ); ?>'
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
                        iconImageSrc = '<?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png'),
                                            array(
                                                'img' => array(
                                                    'src' => true,
                                                    'alt' => true,
                                                    'class' => true,
                                                    'style' => true,
                                                ),
                                            )
                                        ); ?>'
                    );
                }
                conv_change_loadingbar("hide");
                jQuery("#ga4_property_id").prop("disabled", false);
                jQuery('.event-setting-row_ga').addClass("convdisabledbox");
                setTimeout(function() {
                    jQuery("#ga4_property_id").select2('open');
                }, 1000);
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
            selected_vals["ga_cid"] = document.getElementById('ga_cid').checked ? "1" : "0";
            selected_vals["non_woo_tracking"] = document.getElementById('non_woo_tracking').checked ? "1" : "0";
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


    });
</script>