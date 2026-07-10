<?php
$is_sel_disable = 'disabled';
$cust_g_email =  (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";

$isgtm_auto = isset($ee_options['gtm_settings']['is_gtm_automatic_process']) && $ee_options['gtm_settings']['is_gtm_automatic_process'] == 'true' ? true : false;

// get store id
$tvs_admin = new TVC_Admin_Helper();
$tvs_admin_data = $tvs_admin->get_ee_options_data();
$store_id = $tvs_admin_data['setting']->store_id;

$gtm_account_id = isset($ee_options['gtm_settings']['gtm_account_id']) ? $ee_options['gtm_settings']['gtm_account_id'] : "";
$gtm_container_id = isset($ee_options['gtm_settings']['gtm_container_id']) ? $ee_options['gtm_settings']['gtm_container_id'] : "";

$is_gtm_automatic_process = isset($ee_options['gtm_settings']['is_gtm_automatic_process']) ? $ee_options['gtm_settings']['is_gtm_automatic_process'] : false;


?>



<?php
$connect_url = $TVC_Admin_Helper->get_custom_connect_url_subpage(admin_url() . 'admin.php?page=conversios-google-analytics', "gasettings");
?>

<div class="conv-card p-4 rounded conv-shadow-sm">

    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_ganalytics_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">Google Analytics 4 (GA4) Tracking</h4>
    </div>
    <hr class="conv-header-hr">

    <?php if (isset($pixel_settings_arr[$subpage]['topnoti']) && $pixel_settings_arr[$subpage]['topnoti'] != "") { ?>
        <div class="alert d-flex align-items-cente p-0" role="alert">
            <svg class="p-2 text-light conv-success-bg rounded-start" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 36px; height: 36px; display: inline-block; box-sizing: border-box;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <div class="p-2 w-100 rounded-end border border-start-0 shadow-sm conv-notification-alert lh-lg">
                <?php esc_html_e($pixel_settings_arr[$subpage]['topnoti'], "enhanced-e-commerce-for-woocommerce-store"); ?>
            </div>
        </div>
    <?php } ?>

    <form id="gasettings_form" class="convpixsetting-inner-box mt-4">

        <?php
        $tracking_option = (isset($ee_options['tracking_option']) && $ee_options['tracking_option'] != "") ? $ee_options['tracking_option'] : "";
        ?>
        <div>
            <!-- Google Analytics 4 -->
            <?php
            $ga4_analytic_account_id = (isset($googleDetail->ga4_analytic_account_id) && $googleDetail->ga4_analytic_account_id != "") ? $googleDetail->ga4_analytic_account_id : "";
            $measurement_id = (isset($googleDetail->measurement_id) && $googleDetail->measurement_id != "") ? $googleDetail->measurement_id : "";
            ?>
            <div id="analytics_box_GA4" class="py-1">
                <style>
                    #ga4-tab-nav {
                        display: flex;
                        list-style: none;
                        padding: 4px;
                        margin: 0 0 16px 0;
                        gap: 6px;
                        background: #f1f3f6;
                        border-radius: 10px;
                        width: 100%;
                    }
                    #ga4-tab-nav li { margin: 0; padding: 0; flex: 1; }
                    .ga4-tab-btn {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        gap: 8px;
                        width: 100%;
                        text-align: center;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 7px;
                        background: transparent;
                        color: #50575e;
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: 600;
                        text-decoration: none !important;
                        position: static;
                        bottom: auto;
                        z-index: auto;
                        transition: background 0.15s, color 0.15s, box-shadow 0.15s;
                        outline: none !important;
                        box-shadow: none !important;
                    }
                    .ga4-tab-btn:focus,
                    .ga4-tab-btn:active,
                    .ga4-tab-btn:focus-visible { outline: none !important; box-shadow: none !important; }
                    .ga4-tab-btn.is-active {
                        background: #ffffff !important;
                        color: #1967D2 !important;
                        box-shadow: 0 1px 6px rgba(0,0,0,0.13) !important;
                        font-weight: 700;
                    }
                    .ga4-tab-btn:hover:not(.is-active) { background: #e5e9ef; color: #2c3338; }
                    .ga4-tab-recommended {
                        display: inline-block;
                        font-size: 10px;
                        font-weight: 700;
                        background: #dcfce7;
                        color: #15803d;
                        border-radius: 4px;
                        padding: 1px 6px;
                        line-height: 1.6;
                        vertical-align: middle;
                    }
                    .ga4-tab-content-box {
                        border: 1px solid #c3c4c7;
                        border-radius: 0 0 4px 4px;
                        background: #fff;
                        padding: 24px;
                        position: relative;
                        z-index: 1;
                    }
                </style>
                <?php if (!empty($cust_g_email)) : ?>
                <!-- Auth done: no tabs, show content directly -->
                <div>
                <?php else : ?>
                <!-- No auth: show tabs -->
                <ul id="ga4-tab-nav">
                    <li><a class="ga4-tab-btn is-active" href="javascript:void(0);" data-method="auto">Automatic <span class="ga4-tab-recommended">Recommended</span></a></li>
                    <li><a class="ga4-tab-btn" href="javascript:void(0);" data-method="manual">Manual</a></li>
                </ul>

                <!-- Tab Content Wrapper -->
                <div class="ga4-tab-content-box">
                <?php endif; ?>

                    <!-- Auto-fetch Dropdowns -->
                    <div class="conv-hideme-gasettings" id="ga4_dropdowns_row">
                    <div class="mb-4 mt-2">
                        <?php require_once("googlesignin.php"); ?>
                    </div>
                    <div class="row">
                        <div class="col-5">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("GA4 Account ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                        <select id="ga4_analytic_account_id" name="ga4_analytic_account_id" acctype="GA4"
                            class="form-select form-select-lg mb-3 ga_analytic_account_id ga_analytic_account_id_ga4 selecttwo_search"
                            data-placeholder="Select GA4 Account ID"
                            style="width: 100%" <?php echo esc_html($is_sel_disable); ?>>
                            <?php if (!empty($ga4_analytic_account_id)) { ?>
                                <option selected><?php echo esc_html($ga4_analytic_account_id); ?></option>
                            <?php } ?>
                            <option value="">Select GA4 Account ID</option>
                        </select>
                    </div>
                    <div class="col-5">
                        <label class="conv-field-label d-flex align-items-center w-100">
                            <span><?php esc_html_e("GA4 Measurement ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </label>
                        <select id="ga4_property_id" name="measurement_id"
                            class="form-select form-select-lg mb-3 selecttwo_search"
                            data-placeholder="Select Measurement ID"
                            style="width: 100%"
                            <?php echo esc_html($is_sel_disable); ?>>
                            <option value="">Select Measurement ID</option>
                            <?php if (!empty($measurement_id)) { ?>
                                <option selected><?php echo esc_html($measurement_id); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-2 d-flex align-items-end">
                        <button type="button" class="btn btn-primary btn-sm d-flex conv-enable-selection align-items-center mb-3">
                            <span class="px-1"><?php esc_html_e("Edit", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                        </button>
                    </div>
                </div>
                
                <!-- Additional Tracking Moved Here -->
                <div id="additional_tracking" class="py-3 border-top mt-3">
                    <?php
                    // Fetch stored values
                    $conv_scroll_tracking = $ee_options['conv_track_page_scroll'] ?? "1";
                    $conv_file_download_tracking = $ee_options['conv_track_file_download'] ?? "1";
                    $conv_author_tracking = $ee_options['conv_track_author'] ?? "1";
                    $conv_signin_tracking = $ee_options['conv_track_signin'] ?? "1";
                    $conv_signup_tracking = $ee_options['conv_track_signup'] ?? "1";
                    ?>
                    <div class="row pt-1">
                        <div class="col-12">
                            <label class="conv-field-label d-flex align-items-center fw-bold" style="font-size: 14px; color: #202124;"><?php esc_html_e("Additional Tracking (Auto-Fetch Only):", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                        </div>
                        <div class="col-12 mx-3 my-2">
                            <div class="row">
                                <!-- Page Scroll Tracking -->
                                <div class="form-check mt-2 col-4">
                                    <input class="me-2" type="checkbox" id="conv_track_page_scroll"
                                        <?php echo $conv_scroll_tracking ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="enable_scroll_tracking">
                                        <?php esc_html_e("Page Scroll Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                    <svg class="conv-icon text-secondary conv-ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e("Measure how far users scroll on your site to analyze engagement and optimize content placement.", "enhanced-e-commerce-for-woocommerce-store"); ?>"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                                <!-- File Download Tracking -->
                                <div class="form-check mt-2 col-4">
                                    <input class="me-2" type="checkbox" id="conv_track_file_download"
                                        <?php echo $conv_file_download_tracking ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="enable_file_download_tracking">
                                        <?php esc_html_e("File Download Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                    <svg class="conv-icon text-secondary conv-ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e("Track when users download files to measure engagement and improve content performance.", "enhanced-e-commerce-for-woocommerce-store"); ?>"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                                <!-- Author Tracking -->
                                <div class="form-check mt-2 col-4">
                                    <input class="me-2" type="checkbox" id="conv_track_author"
                                        <?php echo $conv_author_tracking ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="enable_author_tracking">
                                        <?php esc_html_e("Author Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                    <svg class="conv-icon text-secondary conv-ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e("Measures user interactions with author content to improve audience targeting and content strategy.", "enhanced-e-commerce-for-woocommerce-store"); ?>"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                            </div>
                            <div class="row">
                                <!-- SignIn Event Tracking -->
                                <div class="form-check mt-2 col-4">
                                    <input class="me-2" type="checkbox" id="conv_track_signin"
                                        <?php echo $conv_signin_tracking ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="enable_signin_tracking">
                                        <?php esc_html_e("Login Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                    <svg class="conv-icon text-secondary conv-ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e("Track when users log in to understand engagement and improve user retention.", "enhanced-e-commerce-for-woocommerce-store"); ?>"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                                <!-- SignUp Event Tracking -->
                                <div class="form-check mt-2 col-4">
                                    <input class="me-2" type="checkbox" id="conv_track_signup"
                                        <?php echo $conv_signup_tracking ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="enable_signup_tracking">
                                        <?php esc_html_e("SignUp Event Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </label>
                                    <svg class="conv-icon text-secondary conv-ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php esc_attr_e("Track how many people sign up on your site to understand what attracts new users.", "enhanced-e-commerce-for-woocommerce-store"); ?>"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- Manual Entry Row -->
                <div class="row conv-hideme-gasettings d-none" id="ga4_manual_row">
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("GA4 Measurement ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                        <input type="text" id="ga4_property_id_manual" name="measurement_id" 
                            class="form-control form-control-lg mb-1" 
                            placeholder="e.g. G-XXXXXXX" 
                            value="<?php echo esc_attr($measurement_id); ?>">
                        <a href="https://www.conversios.io/docs/how-to-find-your-ga4-measurement-id/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find GA4 Measurement ID &rarr;</a>
                    </div>
                </div>
                </div> <!-- Closes Tab Content Wrapper -->
            </div>
            <!-- Google Analytics 4 End -->

        </div>
    </form>

</div>

<script>
    // get list of google analytics account
    function list_analytics_account(tvc_data, selelement, currele, page = 1) {
        var conversios_onboarding_nonce = "<?php echo wp_create_nonce('conversios_onboarding_nonce'); ?>";
        jQuery("#ga4_analytic_account_id").find('option').remove();
        jQuery("#ga4_property_id").find('option').remove();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "get_analytics_account_list",
                tvc_data: tvc_data,
                page: page,
                max_results: 100,
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
            success: function(response) {
                if (response && response.error == false) {
                    var error_msg = 'null';
                    if (response?.data?.items.length > 0) {
                        var AccOptions = "<option value=''>Select Account</option>";
                        var selected = '';
                        response?.data?.items.forEach(function(item) {
                            AccOptions = AccOptions + '<option value="' + item.id + '"> ' + item.name + '-' + item.id + '</option>';
                        });

                        jQuery('#ga4_analytic_account_id').append(AccOptions); //GA4 
                        selelement.prop("disabled", false);
                        jQuery(".conv-enable-selection").addClass('d-none');

                    } else {
                        console.log("error1", "There are no Google Analytics accounts associated with this email.");
                        getAlertMessageAll(
                            'info',
                            'Error',
                            message = 'No GA4 account was found for this email address. Please create one in Google Analytics, then refresh this page and try again.',
                            icon = 'error',
                            buttonText = 'Ok',
                            buttonColor = '#FCCB1E',
                            iconImageSrc = '<?php echo wp_kses(
                                                enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png', '', '', ''),
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

                } else if (response && response.error == true && response.error != undefined) {
                    const errors = response.errors;
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = errors,
                        icon = 'error',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc = '<?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png', '', '', ''),
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
                    var error_msg = errors;
                } else {
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = 'No GA4 account was found for this email address. Please create one in Google Analytics, then refresh this page and try again.',
                        icon = 'error',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc = '<?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png', '', '', ''),
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
                jQuery("#tvc-ga4-acc-edit-acc_box")?.removeClass('tvc-disable-edits');
                conv_change_loadingbar("hide");
                jQuery(".conv-enable-selection").removeClass('disabled');
            }
        });
    }


    // get list properties dropdown options
    function list_analytics_web_properties(type, tvc_data, account_id, thisselid) {
        jQuery("#ga4_property_id").prop("disabled", true);
        var conversios_onboarding_nonce = "<?php echo wp_create_nonce('conversios_onboarding_nonce'); ?>";
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
                                streamOptions = streamOptions + '<option value="' + item.measurementId + '">' + item.measurementId + ' - ' + item.displayName + '</option>';
                            });
                            jQuery('#ga4_property_id').append(streamOptions);
                            jQuery('#both_ga4_property_id').append(streamOptions);
                        } else {
                            var streamOptions = '<option value="">No GA4 Property Found</option>';
                            jQuery('#ga4_property_id').append(streamOptions);
                            jQuery('#both_ga4_property_id').append(streamOptions);
                            getAlertMessageAll(
                                'info',
                                'Error',
                                message = 'No GA4 account was found for this email address. Please create one in Google Analytics, then refresh this page and try again.',
                                icon = 'error',
                                buttonText = 'Ok',
                                buttonColor = '#FCCB1E',
                                iconImageSrc = '<?php echo wp_kses(
                                                    enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png', '', '', ''),
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
                        jQuery(".ga_analytic_account_id_ga4:not(#" + thisselid + ")").val(account_id).trigger("change");
                    }

                } else if (response && response.error == true && response.error != undefined) {
                    const errors = response.error[0];
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = errors,
                        icon = 'error',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc = '<?php echo wp_kses(
                                            enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png', '', '', ''),
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
                        'No GA4 account was found for this email address. Please create one in Google Analytics, then refresh this page and try again.',
                        'error',
                        'Ok',
                        '#FCCB1E',
                        '<?php echo wp_kses(
                            enhancad_get_plugin_image('/admin/images/logos/conv_error_logo.png', '', '', ''),
                            array(
                                'img' => array(
                                    'src'   => true,
                                    'alt'   => true,
                                    'class' => true,
                                    'style' => true,
                                ),
                            )
                        ); ?>'
                    );
                }
                conv_change_loadingbar("hide");
                jQuery("#ga4_property_id").prop("disabled", false);
            }
        });
    }

    function load_ga_accounts(tvc_data) {
        conv_change_loadingbar("show");
        jQuery(".conv-enable-selection").addClass('disabled');
        var selele = jQuery(".conv-enable-selection").closest(".conv-hideme-gasettings").find("select.ga_analytic_account_id");
        var currele = jQuery(this).closest(".conv-hideme-gasettings").find("select.ga_analytic_account_id");
        list_analytics_account(tvc_data, selele, currele);
    }

    //Onload functions
    jQuery(function() {
        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        var tvc_ajax_url = '<?php echo esc_url_raw(admin_url('admin-ajax.php')); ?>';
        let subscription_id = "<?php echo esc_attr($subscriptionId); ?>";
        let plan_id = "<?php echo esc_attr($plan_id); ?>";
        let app_id = "<?php echo esc_attr($app_id); ?>";
        let cust_g_email = "<?php echo esc_attr($cust_g_email); ?>";


        if (jQuery('#ga4_api_secret').val() == '') {
            jQuery('input[name="COV - GA4 - Refund"]').prop("disabled", true);
        } else {
            jQuery('input[name="COV - GA4 - Refund"]').prop("disabled", false);
        }
        jQuery(".selecttwo_search").select2({
            minimumResultsForSearch: 1,
            placeholder: function() {
                return jQuery(this).data('placeholder') || "Select Option";
            }
        });


        jQuery('input[type=radio][name=tracking_option]').change(function() {
            jQuery(".conv-hideme-gasettings").addClass('d-none');
            jQuery(this).parent().find(".conv-hideme-gasettings").removeClass('d-none');
            var tracking_option = jQuery(this).val();
            if (tracking_option == "BOTH" || tracking_option == "GA4") {
                jQuery("#ga4apisecret_box").removeClass("d-none");
            }
            if (tracking_option == "UA") {
                jQuery("#ga4apisecret_box").addClass("d-none");
            }
        });

        <?php
        $sub = isset($_GET['subpage']) ? sanitize_text_field($_GET['subpage']) : '';
        $sub_id = isset($_GET['subscription_id']) ? sanitize_text_field($_GET['subscription_id']) : '';
        $g_mail = isset($_GET['g_mail']) ? sanitize_text_field($_GET['g_mail']) : '';
        if ($sub === 'gasettings' && $sub_id !== '' && $g_mail !== '') : ?>
            load_ga_accounts(tvc_data);
        <?php endif; ?>


        jQuery(".conv-enable-selection").click(function() {
            // Only handle GA4 buttons — ignore buttons from other panels (e.g. bingsettings)
            if (!jQuery(this).closest('#analytics_box_GA4').length) return;
            conv_change_loadingbar("show");
            jQuery(".conv-enable-selection").addClass('disabled');
            var selele = jQuery(".conv-enable-selection").closest(".conv-hideme-gasettings").find("select.ga_analytic_account_id");
            var currele = jQuery(this).closest(".conv-hideme-gasettings").find("select.ga_analytic_account_id");
            list_analytics_account(tvc_data, selele, currele);
        });
        
        jQuery('.ga4-tab-btn').on('click', function(e) {
            e.preventDefault();
            jQuery('.ga4-tab-btn').removeClass('is-active');
            jQuery(this).addClass('is-active');
            
            var method = jQuery(this).attr('data-method');
            if (method === 'manual') {
                jQuery('#ga4_dropdowns_row').addClass('d-none');
                jQuery('#ga4_manual_row').removeClass('d-none');
            } else {
                jQuery('#ga4_manual_row').addClass('d-none');
                jQuery('#ga4_dropdowns_row').removeClass('d-none');
            }
        });

        jQuery(document).on('select2:select', '.ga_analytic_account_id', function(e) {
            if (jQuery(this).val() != "" && jQuery(this).val() != undefined) {
                conv_change_loadingbar("show");
                var account_id = jQuery(e.target).val();
                var acctype = jQuery(e.target).attr('acctype');
                var thisselid = e.target.getAttribute('id');
                console.log(acctype);
                list_analytics_web_properties(acctype, tvc_data, account_id, thisselid);
                jQuery(".ga_analytic_account_id").closest(".conv-hideme-gasettings").find("select").prop("disabled", false);
            } else {
                jQuery(".ga_analytic_account_id").closest(".conv-hideme-gasettings").find("select").prop("disabled", false);
            }

        });

        jQuery(document).on("change", "form#gasettings_form", function() {
            <?php if ($cust_g_email != "") { ?>
                jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled");
                jQuery(".conv-btn-connect").addClass("conv-btn-connect-enabled-google");
                jQuery(".conv-btn-connect").text('Save');

            <?php } else { ?>
                jQuery(".tvc_google_signinbtn_ga").trigger("click");
            <?php } ?>

            if (jQuery('#ga4_api_secret').val() == '') {

                jQuery('input[name="COV - GA4 - Refund"]').prop("disabled", true);
                jQuery('input[name="COV - GA4 - Refund"]').prop("checked", false);
            } else {
                jQuery('input[name="COV - GA4 - Refund"]').prop("disabled", false);

            }
        });


        // Global GA4 save function — called by convSaveActivePanel() in general-fields.php
        window.convSaveGA4 = function() {
            var tracking_option = 'GA4';
            var box_id = "#analytics_box_" + tracking_option;
            var selected_vals = {};
            selected_vals["ua_analytic_account_id"] = "";
            selected_vals["property_id"] = "";
            selected_vals["ga4_analytic_account_id"] = "";
            selected_vals["measurement_id"] = "";
            selected_vals["subscription_id"] = "<?php echo $tvc_data['subscription_id'] ?>";
            // Always write measurement_id from whichever tab is currently active
            if (jQuery('#ga4_manual_row').is(':visible')) {
                // Manual tab: read directly from the text input
                var manual_val = jQuery('#ga4_property_id_manual').val();
                selected_vals["measurement_id"] = manual_val ? manual_val.trim() : "";
                selected_vals["ga4_analytic_account_id"] = ""; // not applicable in manual mode
            } else {
                // Automatic tab: read from the select dropdowns
                jQuery(box_id).find("select").each(function() {
                    var val = jQuery(this).val();
                    if (val && val !== "" && val !== "undefined") {
                        selected_vals[jQuery(this).attr('name')] = val;
                    }
                });
            }
            
            selected_vals["tracking_option"] = tracking_option;
            selected_vals["ga4_api_secret"] = jQuery("#ga4_api_secret").val();
            selected_vals["conv_track_author"] = document.getElementById('conv_track_author').checked ? "1" : "0";
            selected_vals["conv_track_signin"] = document.getElementById('conv_track_signin').checked ? "1" : "0";
            selected_vals["conv_track_signup"] = document.getElementById('conv_track_signup').checked ? "1" : "0";
            selected_vals["conv_track_page_scroll"] = document.getElementById('conv_track_page_scroll').checked ? "1" : "0";
            selected_vals["conv_track_file_download"] = document.getElementById('conv_track_file_download').checked ? "1" : "0";
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "conv_save_pixel_data",
                    pix_sav_nonce: "<?php echo wp_create_nonce('pix_sav_nonce_val'); ?>",
                    conv_options_data: selected_vals,
                    conv_options_type: ["eeoptions", "eeapidata", "middleware"],
                    conv_tvc_data: tvc_data,
                },
                beforeSend: function() {
                    conv_change_loadingbar("show");
                    change_top_button_state("disable");
                },
                success: function(response) {
                    if (response == "0" || response == "1") {
                        convMarkClean('gasettings');
                        // Update sidebar dot based on whether measurement_id is set
                        if (selected_vals["measurement_id"] && selected_vals["measurement_id"] !== "") {
                            convSetTabConnected('gasettings');
                        } else {
                            convSetTabDisconnected('gasettings');
                        }
                        jQuery("#conv_save_success_txt").html("Congratulations, you have successfully saved your GA4 configurations!");
                        jQuery("#conv_save_success_modal").addClass("conv-modal--show");
                        conv_change_loadingbar("hide");
                        change_top_button_state("disable");
                    } else {
                        conv_change_loadingbar("hide");
                        change_top_button_state("enable");
                    }
                },
                error: function() {
                    conv_change_loadingbar("hide");
                    change_top_button_state("enable");
                }
            });
        };

        // Save data (legacy click handler — delegates to convSaveGA4)
        jQuery(document).on("click", ".conv-btn-connect-enabled-google", function() {
            convSaveGA4();
        });
    });
</script>