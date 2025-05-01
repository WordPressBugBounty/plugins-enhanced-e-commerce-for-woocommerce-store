<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Google Ads specific variables
$is_sel_disable_ga = 'disabled';
$is_sel_disable_gads = 'disabled';
$property_id = (isset($ee_api_data->property_id) && $ee_api_data->property_id != "") ? $ee_api_data->property_id : "";
$ga4_analytic_account_id = (isset($ee_api_data->ga4_analytic_account_id) && $ee_api_data->ga4_analytic_account_id != "") ? $ee_api_data->ga4_analytic_account_id : "";
$measurement_id = (isset($ee_api_data->measurement_id) && $ee_api_data->measurement_id != "") ? $ee_api_data->measurement_id : "";
$google_ads_id = (isset($ee_api_data->google_ads_id) && $ee_api_data->google_ads_id != "") ? $ee_api_data->google_ads_id : "";

// GMC specific variables
$get_site_domain = unserialize(get_option('ee_api_data'));
$is_domain_claim = (isset($get_site_domain['setting']->is_domain_claim)) ? esc_attr($get_site_domain['setting']->is_domain_claim) : 0;
$is_site_verified = (isset($get_site_domain['setting']->is_site_verified)) ? esc_attr($get_site_domain['setting']->is_site_verified) : 0;
$plan_id = isset($get_site_domain['setting']->plan_id) ? $get_site_domain['setting']->plan_id : 1;
$connect_gmc_url = $tvc_admin_helper->get_custom_connect_url(admin_url() . 'admin.php?page=conversios&wizard=productFeedEven_gmcsetting');
$google_merchant_center_id = '';
$merchan_id = '';
$is_channel_connected = false;
if (isset($ee_options['google_merchant_center_id']) && $ee_options['google_merchant_center_id'] !== '') {
    $google_merchant_center_id = $ee_options['google_merchant_center_id'];
    $merchan_id = isset($ee_options['merchant_id']) ? $ee_options['merchant_id'] : '';
}
$conwizenablesuperfeed = (isset($ee_options['conwizenablesuperfeed'])) ? esc_attr($ee_options['conwizenablesuperfeed']) : "";
$conwizverifysite = (isset($ee_options['conwizverifysite'])) ? esc_attr($ee_options['conwizverifysite']) : "";
$conwizverifydomain = (isset($ee_options['conwizverifydomain'])) ? esc_attr($ee_options['conwizverifydomain']) : "";
?>

<div class="col convgauthcol">

    <!-- Google SignIn -->
    <div class="convpixsetting-inner-box d-flex justify-content-end">
        <?php
        $g_email = (isset($tvc_data['g_mail']) && esc_attr($subscription_id)) ? esc_attr($tvc_data['g_mail']) : "";
        ?>
        <?php if ($g_email != "") { ?>
            <div class="convgauthsigned ps-3">
                <h5 class="fw-normal mb-1">
                    <?php esc_html_e("Successfully signed in with account:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </h5>
                <span>
                    <?php echo (isset($tvc_data['g_mail']) && esc_attr($subscription_id)) ? esc_attr($tvc_data['g_mail']) : ""; ?>
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
            <div class="ps-1 pt-2">
                Google auth lets us show your GA4 traffic, session, and campaign reports—secure and private.
            </div>
        <?php } ?>
    </div>
    <!-- Google SignIn End -->
</div>

<div class="conwizaccord_accordion">

    <!-- Google Analytics Section -->
    <div class="conwizaccord_item" id="accordion1">
        <div class="conwizaccord_header">
            <div class="conwizaccord_logo-title">
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
                <h5 class="m-0 text-bold h5">Google Analytics 4</h5>
            </div>
            <span class="material-symbols-outlined conwizaccord_icon toggle-icon">expand_more</span>
        </div>
        <div class="conwizaccord_body">

            <form id="gasettings_form" class="convgawiz_form convpixsetting-inner-box mt-0 pb-3 pt-0" datachannel="GA">
                <div class="product-feed">
                    <div class="progress-wholebo mt-0 pt-0">
                        <div class="card-body p-0">

                            <!-- GA4 account ID Selection -->
                            <div id="analytics_box_GA4" class="py-1">
                                <div class="row conv-border-box">
                                    <div class="col-5">
                                        <h5 class="d-flex fw-normal mb-1 text-dark">
                                            <b><?php esc_html_e("GA4 Account", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                        </h5>
                                        <select id="ga4_analytic_account_id" name="ga4_analytic_account_id" acctype="GA4" class="form-select form-select-lg mb-3 ga_analytic_account_id ga_analytic_account_id_ga4 selecttwo_search" style="width: 100%" <?php echo esc_html($is_sel_disable_ga); ?>>
                                            <?php if (!empty($ga4_analytic_account_id)) { ?>
                                                <option selected><?php echo esc_attr($ga4_analytic_account_id); ?></option>
                                            <?php } ?>
                                            <option value="">Select GA4 Account ID</option>
                                        </select>
                                    </div>

                                    <div class="col-5">
                                        <h5 class="d-flex fw-normal mb-1 text-dark">
                                            <b><?php esc_html_e("GA4 Measurement ID", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                        </h5>
                                        <select id="ga4_property_id" name="measurement_id" class="form-select form-select-lg mb-3 selecttwo_search pixvalinput_gahot" style="width: 100%" <?php echo esc_html($is_sel_disable_ga); ?>>
                                            <option value="">Select Measurement ID</option>
                                            <?php if (!empty($measurement_id)) { ?>
                                                <option selected><?php echo esc_attr($measurement_id); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-sm d-flex conv-enable-selection_ga conv-link-blue align-items-center">
                                            <span class="material-symbols-outlined md-18">edit</span>
                                            <?php esc_html_e("Change", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <div id="enable_cid" class="pt-4 ps-2">
                                            <div class="row">
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
                                    </div>


                                    <div class="col-12">
                                        <div class="tab_bottom_buttons d-flex align-items-center pt-0">
                                            <div class="ms-auto d-flex align-items-center">
                                                <?php
                                                $isgsdisabled = "";
                                                if (empty($measurement_id)) {
                                                    $isgsdisabled = "disabledsection";
                                                }
                                                ?>
                                                <button id="save_gahotclcr" type="button" class="d-none btn btn-sm btn-outline-primary ms-3 <?php esc_attr($isgsdisabled); ?>">
                                                    <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    <?php esc_html_e('Save Google Analytics', "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="conwizaccord_item" id="accordion2">
        <div class="conwizaccord_header">
            <div class="conwizaccord_logo-title">
                <?php echo wp_kses(
                    enhancad_get_plugin_image('/admin/images/logos/conv_gads_logo.png', '', 'conv_channel_logo me-2 align-self-center'),
                    array(
                        'img' => array(
                            'src' => true,
                            'alt' => true,
                            'class' => true,
                            'style' => true,
                        ),
                    )
                ); ?>
                <h5 class="m-0 text-bold h5">Google Ads</h5>
            </div>
            <span class="material-symbols-outlined conwizaccord_icon toggle-icon">expand_more</span>
        </div>
        <div class="conwizaccord_body">
            <form id="gadssettings_form" class="convgawiz_form_webads convpixsetting-inner-box mt-0 pb-1 convwiz_border formchanged_webads" datachannel="GoogleAds">
                <div class="product-feed">
                    <div class="progress-wholebox">
                        <div class="card-body p-0">
                            <ul class="progress-steps-list p-0">
                                <li class="gmc_account_id_step">
                                    <div id="analytics_box_ads" class="conv-border-box row">
                                        <?php
                                        $countries = json_decode($wp_filesystem->get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json"));
                                        $credit = json_decode($wp_filesystem->get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/country_reward.json"));
                                        $off_country = "";
                                        $off_credit_amt = "";
                                        if (is_array($countries) || is_object($countries)) {
                                            foreach ($countries as $key => $value) {
                                                if ($value->code == $tvc_data['user_country']) {
                                                    $off_country = $value->name;
                                                    break;
                                                }
                                            }
                                        }

                                        if (is_array($credit) || is_object($credit)) {
                                            foreach ($credit as $key => $value) {
                                                if ($value->name == $off_country) {
                                                    $off_credit_amt = $value->price;
                                                    break;
                                                }
                                            }
                                        }
                                        ?>

                                        <div class="col-12 flex-row">
                                            <div class="d-flex justify-content-between align-items-center conv_create_gads_new_card rounded px-3 py-3">
                                                <?php
                                                if ($off_credit_amt == "") {
                                                    $off_credit_amt = 'USD 500.00';
                                                }
                                                ?>
                                                <div class="amtbtn">
                                                    <?php echo esc_html($off_credit_amt); ?>
                                                </div>
                                                <div class="div">
                                                    <h5 class="text-dark mb-0">
                                                        <?php
                                                        $credit_message = "Your " . $off_credit_amt . " in Ads Credit is ready to be claimed";
                                                        echo esc_html($credit_message);
                                                        ?>
                                                    </h5>
                                                    <span class="text-dark fs-12">
                                                        <div class="text-dark fs-12 pt-1">
                                                            <?php esc_html_e("Spend", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                            <?php echo esc_html($off_credit_amt); ?>
                                                            <?php esc_html_e("with Google Ads in the first 60 days to unlock the credit", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        </div>
                                                        <?php esc_html_e("Sign up for Google Ads and complete your payment information to apply the offer to", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        <br>
                                                        <?php esc_html_e("your account.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        <a href="https://www.google.com/intl/en_in/ads/coupons/terms/cyoi/" class="" target="_blank">
                                                            <u><?php esc_html_e("Terms and conditions apply.", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                                                        </a>
                                                    </span>
                                                </div>
                                                <div class="align-self-center">
                                                    <button id="conv_create_gads_new_btn" type="button" class="btn btn-primary px-5" data-bs-toggle="modal" data-bs-target="#conv_create_gads_new">
                                                        <?php esc_html_e("Create Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-8 mt-4">
                                            <h5 class="fw-normal mb-1 text-dark">
                                                <b><?php esc_html_e("Select your existing Google Ads Account", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                                <div id="spinner_mcc_check" class="spinner-border text-primary d-none float-end spinner-border-sm" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </h5>
                                            <select id="google_ads_id" name="google_ads_id" class="valtoshow_inpopup_this form-select form-select-lg mb-3 selecttwo_search google_ads_id" style="width: 100%" <?php echo esc_html($is_sel_disable_gads); ?>>
                                                <?php if (!empty($google_ads_id)) { ?>
                                                    <option value="<?php echo esc_attr($google_ads_id); ?>" selected><?php echo esc_html($google_ads_id); ?></option>
                                                <?php } ?>
                                                <option value="">Select Account</option>
                                            </select>
                                        </div>

                                        <div class="col-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm d-flex conv-enable-selection_gads conv-link-blue align-items-center">
                                                <span class="material-symbols-outlined md-18">edit</span>
                                                <span class="px-1">
                                                    <?php esc_html_e("Change", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                </span>
                                            </button>
                                        </div>

                                        <div id="conv_mcc_alert" class="my-3 mx-2 alert alert-danger fs-8 d-none col-11" role="alert">
                                            <?php esc_html_e("You have selected a MCC account OR account is in unsupported state(Cancelled, In Progress, Suspended). Please select other google ads account to proceed further.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </div>

                                        <div id="gadsconversion_settings" class="col-12 mt-4">
                                            <ul class="ps-0">
                                                <?php if (CONV_IS_WC) { ?>

                                                    <li class="<?php echo !CONV_IS_WC ? 'hidden' : 'd-flex align-items-center my-2' ?>">
                                                        <div class="inlist_text_pre" conversion_name="PURCHASE">
                                                            <h5 class="mb-0"><?php esc_html_e("Purchase Conversion Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                                            <div class="inlist_text_notconnected">
                                                                <?php esc_html_e("Set to measure & optimize the Google Campaign ROAS", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                            </div>
                                                            <div class="inlist_text_connected d-flex d-none">
                                                                <div class="text-success pe-2"><?php esc_html_e("Connected :", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                                                <div class="inlist_text_connected_convid"></div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-sm ms-auto conv_con_modal_opener px-4" conversion_name="PURCHASE">
                                                            <?php esc_html_e("Enable Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        </button>
                                                    </li>

                                                    <li class="<?php echo !CONV_IS_WC ? 'hidden' : 'd-flex align-items-center my-2' ?>">
                                                        <div class="inlist_text_pre" conversion_name="ADD_TO_CART">
                                                            <h5 class="mb-0"><?php esc_html_e("Add to Cart Conversion Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                                            <div class="inlist_text_notconnected">
                                                                <?php esc_html_e("Set to measure & optimize the Google Campaign ROAS", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                            </div>
                                                            <div class="inlist_text_connected d-flex d-none">
                                                                <div class="text-success pe-2"><?php esc_html_e("Connected :", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                                                <div class="inlist_text_connected_convid"></div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-sm ms-auto conv_con_modal_opener px-4" conversion_name="ADD_TO_CART">
                                                            <?php esc_html_e("Enable Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        </button>
                                                    </li>

                                                    <li class="<?php echo !CONV_IS_WC ? 'hidden' : 'd-flex align-items-center my-2' ?>">
                                                        <div class="inlist_text_pre" conversion_name="BEGIN_CHECKOUT">
                                                            <h5 class="mb-0"><?php esc_html_e("Begin checkout Conversion Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                                            <div class="inlist_text_notconnected">
                                                                <?php esc_html_e("Set to measure & optimize the Google Campaign ROAS", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                            </div>
                                                            <div class="inlist_text_connected d-flex d-none">
                                                                <div class="text-success pe-2"><?php esc_html_e("Connected :", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                                                <div class="inlist_text_connected_convid"></div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-sm ms-auto conv_con_modal_opener px-4" conversion_name="BEGIN_CHECKOUT">
                                                            <?php esc_html_e("Enable Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        </button>
                                                    </li>

                                                <?php } ?>

                                                <li class="d-flex align-items-center my-2">
                                                    <div class="inlist_text_pre" conversion_name="SUBMIT_LEAD_FORM">
                                                        <h5 class="mb-0"><?php esc_html_e("Form Submit Conversion Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                                        <div class="inlist_text_notconnected">
                                                            <?php esc_html_e("Set to measure & optimize the Google Campaign ROAS", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        </div>
                                                        <div class="inlist_text_connected d-flex d-none">
                                                            <div class="text-success pe-2"><?php esc_html_e("Connected :", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                                            <div class="inlist_text_connected_convid"></div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-primary btn-sm ms-auto conv_con_modal_opener px-4" conversion_name="SUBMIT_LEAD_FORM">
                                                        <?php esc_html_e("Enable Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <!-- Tab bottom buttons -->
                                            <div class="tab_bottom_buttons d-flex justify-content-end pt-4">
                                                <div class="ms-auto d-flex align-items-center">
                                                    <button id="save_gads_finish" type="button" class="btn btn-sm btn-outline-primary px-5 ms-3 disabledsection d-none">
                                                        <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                        <?php esc_html_e('Save & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if (CONV_IS_WC) { ?>
        <div class="conwizaccord_item" id="accordion3">
            <div class="conwizaccord_header">
                <div class="conwizaccord_logo-title">
                    <?php echo wp_kses(
                        enhancad_get_plugin_image('/admin/images/logos/conv_gmc_logo.png', '', 'conv_channel_logo me-2 align-self-center'),
                        array(
                            'img' => array(
                                'src' => true,
                                'alt' => true,
                                'class' => true,
                                'style' => true,
                            ),
                        )
                    ); ?>
                    <h5 class="m-0 text-bold h5">Google Merchant Center</h5>
                </div>
                <span class="material-symbols-outlined conwizaccord_icon toggle-icon">expand_more</span>
            </div>
            <div class="conwizaccord_body">
                <form id="gmcsettings_form" class="convgawiz_form_webgmc convpixsetting-inner-box mt-0 convwiz_border" datachannel="GoogleGMC">
                    <div class="mt-0 mb-3">
                        <div class="row row-flex pt-2 align-items-center conv-border-box">
                            <div class="col-8 mt-3 d-flex">
                                <div>
                                    <h5 class="fw-normal mb-1 text-dark">
                                        <b><?php esc_html_e("Select your existing Google Merchant Account", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                    </h5>
                                    <select id="google_merchant_center_id" name="google_merchant_center_id" class="form-select selecttwo" style="width: 100%" disabled>
                                        <?php if (!empty($google_merchant_center_id)) { ?>
                                            <option value="<?php echo esc_attr($google_merchant_center_id); ?>" selected>
                                                <?php echo esc_attr($google_merchant_center_id); ?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="gmc_google_ads_id" value="<?php echo esc_attr($ee_options['google_ads_id']) ?>">
                                    <?php if (CONV_IS_WC && ($conwizenablesuperfeed == "" || $conwizenablesuperfeed == 0)) { ?>
                                        <div id="convsitedomainfeed" class="conv-border-bo mt-0 disabledsection">
                                            <?php if ($conwizenablesuperfeed == "" || $conwizenablesuperfeed == 0) { ?>
                                                <div class="row domain_claimDiv">
                                                    <div class="col-10">
                                                        <small class="fw-normal mb-1 text-dark">
                                                            <b><?php esc_html_e("Send your Woocommerce products to Google", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                                        </small>
                                                    </div>
                                                    <div class="col-2 m-auto text-end">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input ms-auto float-end" type="checkbox" role="switch" id="conwizenablesuperfeed" name="conwizenablesuperfeed" checked>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="align-self-center">
                                    <div class="conv-enable-selection_gmc conv-link-blue">
                                        <span class="material-symbols-outlined pt-1 ps-2">edit</span>
                                        <div class="mb-2 fs-6 text d-inline">Change</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <?php if ($g_email !== "") { ?>
                                    <span class="fs-14">&nbsp; Or &nbsp;</span>
                                    <div class="createNewGMC btn btn-outline-primary px-5 shadow">Create New</div>
                                <?php } ?>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</div>


<div class="tab_bottom_buttons d-flex justify-content-end pt-4">
    <div class="ms-auto d-flex align-items-center">
        <button id="save_gmc" type="button" class="conv_save_gmc btn btn-primary px-5 ms-3 disabledsection">
            <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <?php esc_html_e('Save & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
        </button>
    </div>
</div>


<!-- Modals No GA account found-->
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- GAds Creation POpup -->
<div class="modal fade" id="conv_create_gads_new" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    <span id="before_gadsacccreated_title" class="before-ads-acc-creation"><?php esc_html_e("Enable Google Ads Account", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                    <span id="after_gadsacccreated_title" class="d-none after-ads-acc-creation"><?php esc_html_e("Account Created", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start pt-0">
                <span id="before_gadsacccreated_text" class="mb-1 lh-lg fs-6 before-ads-acc-creation">
                    <?php if (!CONV_IS_WC) { ?>
                        <div class="col-12 flex-row pt-3">
                            <div class="d-flex justify-content-between align-items-center conv_create_gads_new_card rounded px-3 py-3">

                                <?php
                                if ($off_credit_amt == "") {
                                    $off_credit_amt = 'USD 500.00';
                                }
                                ?>
                                <?php echo wp_kses(
                                    enhancad_get_plugin_image('/admin/images/logos/conv_gads_logo.png', '', 'me-2 align-self-center'),
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
                                    <h5 class="text-dark mb-0">
                                        <?php
                                        $credit_message = "Your " . $off_credit_amt . " in Ads Credit is ready to be claimed";
                                        echo esc_html($credit_message);
                                        ?>
                                    </h5>
                                    <div class="text-dark fs-12 pt-2">
                                        <?php esc_html_e("Sign up for Google Ads and complete your payment information to apply the offer to your account.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        <a href="https://www.google.com/intl/en_in/ads/coupons/terms/cyoi/" class="" target="_blank">
                                            <u><?php esc_html_e("Terms and conditions apply.", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="pt-3 col-6">
                                <label for="gads_country" class="form-label mb-0" id="gads_country_lbl">
                                    <small>
                                        Select Your Country
                                        <span class="text-danger">*</span>
                                        <span class="text-danger d-none newgads_error">Required</span>
                                    </small>
                                </label>
                                <select class="selectthree form-select" name="gads_country" id="gads_country">
                                    <option value="">Select Country</option>
                                    <?php
                                    $getCountris = $wp_filesystem->get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json");
                                    $contData = json_decode($getCountris);
                                    foreach ($contData as $key => $value) {
                                    ?>
                                        <option value="<?php echo esc_attr($value->code) ?>">
                                            <?php echo esc_html($value->name) ?></option>"
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="pt-3 col-6">
                                <label for="gads_currency" class="form-label mb-0" id="gads_currency_lbl">
                                    <small>
                                        Select Your Currency
                                        <span class="text-danger">*</span>
                                        <span class="text-danger d-none newgads_error">Required</span>
                                    </small>
                                </label>
                                <select class="selectthree form-select" name="gads_currency" id="gads_currency">
                                    <option value="">Select Currency</option>
                                    <?php
                                    $getCurrency = $wp_filesystem->get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/currency.json");
                                    $currencyData = json_decode($getCurrency);
                                    foreach ($currencyData as $key => $value) {
                                    ?>
                                        <option value="<?php echo esc_attr($key) ?>" isothreeval="<?php echo esc_attr($value) ?>">
                                            <?php echo esc_html($value) ?>
                                        </option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <h5 class="pt-3 text-primary">Accept Google Ads Invitation & Claim Your Offer - </h5>
                    <ol class="ms-0 ps-3">
                        <li>
                            <h6>Using Popup:</h6>
                            <p>If popups are enabled, a window will appear. Just click <strong>"Accept"</strong> to access the account.</p>
                        </li>
                        <li class="text-center my-0 py-0 lh-1" style="list-style: none;">
                            <strong>OR</strong>
                        </li>
                        <li>
                            <h6>Using Email (if popup is blocked):</h6>
                            <p>Check your email for an invitation from <strong>webdev@conversios.io </strong>. Click <strong>"Accept Invitation"</strong> in the email and sign in to confirm access.</p>
                        </li>
                    </ol>
                    <?php //esc_html_e("You’ll receive an invite from Google on your email. Accept the invitation to enable your Google Ads Account.", "enhanced-e-commerce-for-woocommerce-store"); 
                    ?>
                </span>
                <div class="onbrdpp-body alert alert-primary text-start d-none after-ads-acc-creation" id="new_google_ads_section">
                    <p>
                        <?php esc_html_e("Your Google Ads Account has been created", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <strong>
                            (<b><span id="new_google_ads_id"></span></b>).
                        </strong>
                    </p>
                    <h6>
                        <?php esc_html_e("Steps to claim your Google Ads Account:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h6>
                    <ol>
                        <li>
                            <?php esc_html_e("Accept invitation mail from Google Ads sent to your email address", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            <em><?php echo (isset($tvc_data['g_mail'])) ? esc_attr($tvc_data['g_mail']) : ""; ?></em>
                            <span id="invitationLink">
                                <br>
                                <em><?php esc_html_e("OR", "enhanced-e-commerce-for-woocommerce-store"); ?></em>
                                <?php esc_html_e("Open", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                <a class="btn btn-sm btn-primary" href="" target="_blank" id="ads_invitationLink"><?php esc_html_e("Invitation Link", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                            </span>
                        </li>
                        <li><?php esc_html_e("Log into your Google Ads account and set up your billing preferences", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                    </ol>
                </div>

            </div>
            <div class="modal-footer">
                <button id="ads-continue" class="btn btn-success w-50 m-auto text-white before-ads-acc-creation">
                    <span id="gadsinviteloader" class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <?php esc_html_e("Send Invite", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </button>

                <button id="ads-continue-close" class="btn btn-secondary m-auto text-white d-none after-ads-acc-creation" data-bs-dismiss="modal">
                    <?php esc_html_e("Close", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Gads Creation POPup -->

<!-- Conversion creation edit popup start -->
<div class="modal fade" id="conv_con_modal" tabindex="-1" aria-labelledby="conv_con_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="loadingbar_blue_popup" class="progress-materializecss d-none ps-2 pe-2 w-100">
                <div class="indeterminate"></div>
            </div>
            <div class="modal-header conv-blue-bg">
                <h4 id="convconmodtitle" class="modal-title text-white"></h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="conversion_setting_form" class="disabledsection">
                    <div class="row">
                        <div class="col-12">

                            <h5 for="conv_conversion_select" class="form-label" id="conv_con_modalLabel"></h5>
                            <div class="placeholder-glow">
                                <div id="conv_conversion_selectHelp" class="form-text"></div>
                                <input type="text" id="conv_conversion_textbox" class="form-control d-none" name="conv_conversion_textbox">
                                <div id="conv_conversion_selectbox">
                                    <select id="conv_conversion_select" class="form-control mw-100" name="conv_conversion_select" readonly>
                                        <option value="">
                                            <?php esc_html_e("Select Conversion Label and ID", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="my-4"><?php esc_html_e("OR", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>

                        <div id="create_conversion_box" class="col-12">
                            <div class="col-12">
                                <button id="convcon_create_but" type="button" class="btn btn-outline-primary">
                                    <?php esc_html_e("Create Conversion", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                                <div>
                                    <small><?php esc_html_e(" If you haven't yet created a conversion ID and label in your Google Ads account, you can create a new one by clicking here.", "enhanced-e-commerce-for-woocommerce-store"); ?></small>
                                </div>

                                <input type="hidden" class="form-control" id="concre_name">
                                <input type="hidden" class="form-control" id="concre_value">
                                <input type="hidden" class="form-control" id="concre_category">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="selected_conversion" id="selected_conversion">
                </div>
            </div>
            <div class="modal-footer d-flex">
                <button id="convsave_conversion_but" type="button" class="btn btn-success disabled">
                    <?php esc_html_e("Save", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    <div class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Conversion creation edit popup end -->

<!-- GAds Chnage Popup -->
<div class="modal fade" id="convgadseditconfirm" tabindex="-1" aria-labelledby="convgadseditconfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="convgadseditconfirmLabel">
                    <?php esc_html_e("Change Google Ads Account", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php esc_html_e("Changing your Google Ads account will remove the selected conversion IDs and labels, as they are specific to each account.", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <?php esc_html_e("Close", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </button>
                <button id="conv_changegadsacc_but" type="button" class="btn btn-primary">
                    <?php esc_html_e("Change Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    <div class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<?php if (CONV_IS_WC) { ?>
    <!-- Create GMC Modal -->
    <div class="modal fade" id="conv_create_gmc_new" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="feedForm" onfocus="this.className='focused'">
                    <div class="modal-header bg-light p-2 ps-4">
                        <h5 class="modal-title fs-16 fw-500" id="feedType">
                            <?php esc_html_e("Create New Google Merchant Center Account", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                        <button type="button" class="btn-close pe-4 closeButton" data-bs-dismiss="modal" aria-label="Close" onclick="jQuery('#feedForm')[0].reset()"></button>
                    </div>
                    <!-- <div id="create_gmc_loader" class="progress-materializecss d-none ps-2 pe-2" style="width:98%">
                    <div class="indeterminate"></div>
                </div> -->
                    <div class="modal-body text-start">
                        <div class="row">
                            <div class="col-7 pe-4">
                                <div id="before_gadsacccreated_text" class="mb-1 fs-6 before-gmc-acc-creation">
                                    <div id="create_gmc_error" class="alert alert-danger d-none" role="alert">
                                        <small></small>
                                    </div>
                                    <form id="conv_form_new_gmc">
                                        <div class="mb-3">
                                            <span class="inner-text">Your Website URL</span> <span class="text-danger">
                                                *</span>
                                            <input class="form-control mb-2" type="text" id="gmc_website_url" name="website_url" value="<?php echo esc_attr($tvc_data['user_domain']); ?>" placeholder="Enter Website" required>
                                            <span class="inner-text">Your Email</span><span class="text-danger"> *</span>
                                            <input class="form-control mb-2" type="text" id="gmc_email_address" name="email_address" value="<?php echo isset($tvc_data['g_mail']) ? esc_attr($tvc_data['g_mail']) : ""; ?>" placeholder="Enter email address" required>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="gmc_adult_content" name="adult_content" value="1" style="float:none">
                                                <label class="form-check-label fs-14" for="flexCheckDefault">
                                                    <?php esc_html_e("My site contain", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                    <b class="inner-text">
                                                        <?php esc_html_e("Adult Content", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                    </b>
                                                </label>
                                            </div>
                                            <span class="inner-text">Your Store Name</span><span class="text-danger">
                                                *</span>
                                            <input class="form-control mb-0" type="text" id="gmc_store_name" name="store_name" value="" placeholder="Enter Store Name" required>
                                            <small>
                                                <?php esc_html_e("This name will appear in your Shopping Ads.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                            </small>

                                            <div class="mb-3 mt-2" id="conv_create_gmc_selectthree">
                                                <select id="gmc_country" name="country" class="form-select form-select-lg mb-3" style="width: 100%" placeholder="Select Country" required>
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    //$getCountris = file_get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json");

                                                    global $wp_filesystem;
                                                    $getCountris = $wp_filesystem->get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json");

                                                    $contData = json_decode($getCountris);
                                                    foreach ($contData as $key => $value) {
                                                    ?>
                                                        <option value="<?php echo esc_attr($value->code) ?>" <?php echo $tvc_data['user_country'] == $value->code ? 'selected = "selecetd"' : '' ?>>
                                                            <?php echo esc_attr($value->name) ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-check">
                                                <input id="gmc_concent" name="concent" class="form-check-input" type="checkbox" value="1" required style="float:none">
                                                <label class="form-check-label fs-12" for="concent">
                                                    <?php esc_html_e("I accept the", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                    <a class="fs-14" target="_blank" href="<?php echo esc_url("https://support.google.com/merchants/answer/160173?hl=en"); ?>"><?php esc_html_e("terms & conditions", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                                    <span class="text-danger"> *</span>
                                                </label>
                                            </div>

                                        </div>

                                    </form>
                                </div>
                                <!-- Show this after creation -->
                                <div class="onbrdpp-body alert alert-primary text-start d-none after-gmc-acc-creation">
                                    New Google Merchant Center Account With Id: <span id="new_gmc_id"></span> is created
                                    successfully.
                                </div>
                            </div>
                            <div class="col-5 ps-4 border-start">
                                <div>
                                    <h6 class="text-grey">
                                        <?php esc_html_e("To use Google Shopping, your website must meet these requirements:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </h6>
                                    <ul class="p-0">
                                        <li><a target="_blank" href="<?php echo esc_url("https://support.google.com/merchants/answer/6149970?hl=en"); ?>"><?php esc_html_e("Google Shopping ads policies", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                        </li>
                                        <li><a target="_blank" href="<?php echo esc_url("https://support.google.com/merchants/answer/6150127"); ?>"><?php esc_html_e("Accurate Contact Information", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                        </li>
                                        <li><a target="_blank" href="<?php echo esc_url("https://support.google.com/merchants/answer/6150122"); ?>"><?php esc_html_e("Secure collection of process and personal data", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                        </li>
                                        <li><a target="_blank" href="<?php echo esc_url("https://support.google.com/merchants/answer/6150127"); ?>"><?php esc_html_e("Return Policy", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                        </li>
                                        <li><a target="_blank" href="<?php echo esc_url("https://support.google.com/merchants/answer/6150127"); ?>"><?php esc_html_e("Billing terms & conditions", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                        </li>
                                        <li><a target="_blank" href="<?php echo esc_url("https://support.google.com/merchants/answer/6150118"); ?>"><?php esc_html_e("Complete checkout process", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" style="width:112px; height:38px; border-radius: 4px; padding: 8px; gap:10px; border: 1px solid #ccc" class="btn btn-light fs-14 fw-medium" id="model_close_gmc_creation">Close</button>
                    <button id="create_merchant_account_new" style="width:112px; height:38px; border-radius: 4px; padding: 8px; gap:10px;" class="btn btn-primary fs-14 fw-medium">Create</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Create GMC Modal -->
<?php } ?>

<!-- Accordion JS -->
<script>
    jQuery(document).ready(function() {
        jQuery('.conwizaccord_header').on('click', function() {
            var item = jQuery(this).closest('.conwizaccord_item');
            var body = item.find('.conwizaccord_body');
            var icon = jQuery(this).find('.toggle-icon');

            jQuery('.conwizaccord_body').not(body).slideUp(300);
            jQuery('.toggle-icon').not(icon).text('expand_more');

            if (body.is(':visible')) {
                body.slideUp(300);
                icon.text('expand_more');
            } else {
                body.slideDown(300);
                icon.text('expand_less');
            }
        });

        function openAccordionById(id) {
            var item = jQuery('#' + id);
            var body = item.find('.conwizaccord_body');
            var icon = item.find('.toggle-icon');

            jQuery('.conwizaccord_body').not(body).slideUp(300);
            jQuery('.toggle-icon').not(icon).text('expand_more');

            body.slideDown(300);
            icon.text('expand_less');
        }

        window.openAccordionById = openAccordionById;
    });
</script>

<!-- Google Analytics Settings -->
<script>
    function toggleSaveButton_wiz1() {
        var hasMeasurementId = jQuery("#ga4_property_id").val();
        var hasGoogleAnaId = jQuery("#ga4_analytic_account_id").val();
        var hasGoogleAdsId = jQuery("#google_ads_id").val();

        console.log("Measurement ID:", hasMeasurementId);
        console.log("GA4 Account ID:", hasGoogleAnaId);
        console.log("Google Ads ID:", hasGoogleAdsId);

        if (hasGoogleAnaId && hasMeasurementId && hasGoogleAdsId) {
            jQuery("#save_gmc").removeClass("disabledsection");
        } else {
            jQuery("#save_gmc").addClass("disabledsection");
        }
    }
    // get list of google analytics account
    function list_analytics_account(tvc_data, selelement, currele, page = 1) {
        //conv_change_loadingbar_popup("show");
        openAccordionById("accordion1");
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
                toggleSaveButton_wiz1();
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
                toggleSaveButton_wiz1();
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


    function save_ga_data(tvc_data) {
        conv_change_loadingbar("show");
        // jQuery(this).find(".spinner-border").removeClass("d-none");
        // jQuery(this).addClass('disabledsection');
        // changeTabBox("webadsbox-tab");
        var tracking_option = 'GA4';
        var box_id = "#analytics_box_" + tracking_option;
        var has_error = 0;
        var selected_vals = {};
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
                list_google_ads_account(tvc_data);
            }
        });
    }

    //Onload functions
    jQuery(function() {
        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        var tvc_ajax_url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        let subscription_id = "<?php echo esc_attr($subscription_id); ?>";
        let plan_id = "<?php echo esc_attr($plan_id); ?>";
        let app_id = "<?php echo esc_attr($app_id); ?>";
        let cust_g_email = "<?php echo esc_attr($cust_g_email); ?>";

        jQuery(".selecttwo_search").select2({
            minimumResultsForSearch: 1,
            placeholder: function() {
                jQuery(this).data('placeholder');
            }
        });

        jQuery('#ga4_property_id, #ga4_analytic_account_id').on('select2:select', function(e) {
            if (jQuery('#ga4_property_id').val() == "" || jQuery('#ga4_analytic_account_id').val() == "") {
                jQuery("#save_gahotclcr").addClass("disabledsection");
            } else {
                jQuery("#save_gahotclcr").removeClass("disabledsection");
            }
        });

        jQuery(document).on("change", "#ga4_analytic_account_id, #ga4_property_id, #google_ads_id", toggleSaveButton_wiz1);

        jQuery('#ga4_property_id').on('select2:select', function(e) {
            if (jQuery('#ga4_property_id').val() != "" && jQuery('#ga4_property_id').val() != undefined)
                save_ga_data(tvc_data);
        });

        jQuery(document).on("click", "#save_gahotclcr", function() {
            save_ga_data(tvc_data);
        });

        jQuery(".conv-enable-selection_ga").click(function() {
            conv_change_loadingbar("show");
            jQuery(".conv-enable-selection_ga").addClass('disabled');
            var selele = jQuery(".conv-enable-selection_ga").closest(".conv-hideme-gasettings").find(
                "select.ga_analytic_account_id");
            var currele = jQuery(this).closest(".conv-hideme-gasettings").find(
                "select.ga_analytic_account_id");
            list_analytics_account(tvc_data, selele, currele);
        });

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
                    console.log('GTM Set');
                }
            });
        }


    });
</script>
<!-- END Google Analytics Settings -->


<!-- Google Ads Settings JS -->
<script>
    function showGAdsModalPopUp(url) {
        //calcualte popUp size
        var h = Math.max(800, window.screen.availHeight * 0.66) // try to use 66% of height, but no smaller than 800
        var w = Math.max(500, window.screen.availWidth * 0.25) // try to use 25% of width, but no smaller than 800
        //find popUp center
        var windowLocation = {
            left: (window.screen.availLeft + (window.screen.availWidth / 2)) - (w / 2),
            top: (window.screen.availTop + (window.screen.availHeight / 2)) - (h / 2)
        };
        const confignew = "ModalPopUp" +
            ", toolbar=no" +
            ", scrollbars=no," +
            ", location=no" +
            ", statusbar=no" +
            ", menubar=no" +
            ", resizable=0" +
            ", width=" + w +
            ", height=" + h +
            ", left=" + windowLocation.left +
            ", top=" + windowLocation.top;
        newWindow_wgadswin = window.open(url, 'Google Ads', confignew);
        if (newWindow_wgadswin) {
            newWindow_wgadswin.focus();
            jQuery("#conv_create_gads_new").modal("hide");
        }
    }

    jQuery(function() {
        jQuery(".selectthree").select2({
            dropdownParent: jQuery("#conv_create_gads_new"),
            placeholder: function() {
                jQuery(this).data('placeholder');
            }
        });

        jQuery("#gads_country").change(function() {
            let concontry = jQuery(this).val();
            jQuery("#gads_currency").val(concontry).trigger('change');
        });

        jQuery("#conv_skip_gads").click(function() {
            changeTabBox("webgmcbox-tab");
        });

        jQuery(document).on("change", "#conv_conversion_select", function() {
            jQuery("#conv_conversion_textbox").val(jQuery(this).val());
            jQuery("#conv_conversion_textbox").trigger('change');
        });

        jQuery(document).on("change", "#conv_conversion_textbox", function() {
            if (jQuery(this).val() != "") {
                jQuery("#convsave_conversion_but").removeClass("disabled");
            } else {
                jQuery("#convsave_conversion_but").addClass("disabled");
            }
        });


    });
</script>
<!-- END Google Ads Settings JS -->

<!-- Google Ads Setting -->
<script>
    function convpopuploading(state = "loading") {
        if (state == "loading") {
            jQuery("#conversion_setting_form").addClass("disabledsection");
            jQuery('#conv_conversion_select').removeAttr("readonly");
            jQuery("#loadingbar_blue_popup").removeClass("d-none");
        } else {
            jQuery("#conversion_setting_form").removeClass("disabledsection");
            jQuery('#conv_conversion_select').attr("readonly");
            jQuery("#loadingbar_blue_popup").addClass("d-none");
        }

    }


       // get list google ads dropdown options
       function list_google_ads_account(tvc_data, new_ads_id) {
        conv_change_loadingbar_popup("show");
        conv_change_loadingbar("show");
        openAccordionById("accordion2");

        jQuery("#ee_conversio_send_to_static").removeClass("conv-border-danger");
        jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled");
        jQuery(".conv-btn-connect").addClass("conv-btn-connect-enabled-google");
        jQuery(".conv-btn-connect").text('Save');

        cleargadsconversions();

        var selectedValue = jQuery("#google_ads_id").val();
        var conversios_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>";
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "list_googl_ads_account",
                tvc_data: tvc_data,
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
            success: function(response) {
                var btn_cam = 'ads_list';
                if (response.error === false) {
                    var error_msg = 'null';
                    if (response.data.length == 0) {
                        //showtoastdynamically("There are no Google ads accounts associated with email.");
                        jQuery('#conv_create_gads_new').modal('show');
                    } else {
                        if (response.data.length > 0) {
                            var AccOptions = '';
                            var selected = '';
                            if (new_ads_id != "" && new_ads_id != undefined) {
                                AccOptions = AccOptions + '<option value="' + new_ads_id + '">' + new_ads_id + '</option>';
                            }
                            response?.data.forEach(function(item) {
                                AccOptions = AccOptions + '<option value="' + item + '">' + item + '</option>';
                            });
                            jQuery('#google_ads_id').append(AccOptions);
                            jQuery('#google_ads_id').prop("disabled", false);
                            jQuery(".conv-enable-selection").addClass('d-none');
                            jQuery("#gadsConversionAcco .accordion-body").removeClass("disabledsection");
                            jQuery(".accordion-button").removeClass("text-dark");

                            if (jQuery("#ga4_property_id").val() != "") {
                                jQuery("#link_google_analytics_with_google_ads").removeAttr("disabled");
                                jQuery("#ga_GMC").removeAttr("disabled");
                            }
                            setTimeout(function() {

                                if (new_ads_id != undefined && new_ads_id == "") {
                                    jQuery("#google_ads_id").val(new_ads_id).trigger('change');
                                } else {
                                    jQuery("#google_ads_id").select2('open');
                                }
                            }, 1000);
                        }
                    }
                } else {
                    var error_msg = response.errors;
                    jQuery('#conv_create_gads_new').modal('show');
                }
                jQuery('#ads-account').prop('disabled', false);
                conv_change_loadingbar_popup("hide");
                conv_change_loadingbar("hide");


            }

        });

    }

    //Get GAds conversion list
    function get_conversion_list(conversionCategory = "", selectedVal = "") {
        //conv_change_loadingbar("show");
        //jQuery("#conversion_idlabel_box").addClass("d-none");
        convpopuploading("loading");
        var data = {
            action: "conv_get_conversion_list_gads_bycat",
            gads_id: jQuery("#google_ads_id").val(),
            TVCNonce: "<?php echo esc_js(wp_create_nonce('con_get_conversion_list-nonce')); ?>",
            conversionCategory: conversionCategory
        };
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: data,
            success: function(response) {
                if (response == 0) {
                    jQuery('#conv_conversion_select').html("<option value=''>No Conversion Label and ID Found for " + conversionCategory + "</option>");
                    jQuery("#conversion_idlabel_box").removeClass("d-none");
                    jQuery("#conv_conversion_selectHelp").html("<span class='text-danger'>No conversion labels are retrived, if conversion label is available in your google ads account kindly Enter it manually in below input box.");
                    jQuery("#conv_conversion_selectbox").addClass("d-none");
                    jQuery("#conv_conversion_textbox").removeClass("d-none");
                    //conv_change_loadingbar("hide");
                } else {
                    var AccOptions = '<option value="">Select Conversion ID and Label</option>';
                    var selected = '';
                    Object.keys(response)?.forEach(item => {
                        //if (selectedVal == item) {
                        if (item.includes(selectedVal)) {
                            selected = response[item];
                        }
                        AccOptions = AccOptions + '<option value="' + response[item] + '">' + response[item] + ' / ' + item + '</option>';
                    });
                    jQuery('#conv_conversion_select').html(AccOptions);
                    jQuery('#conv_conversion_select').prop("disabled", false);
                    jQuery("#conv_conversion_selectHelp").html("");
                }

                convpopuploading("notloading");
                jQuery("#conv_conversion_select").select2({
                    dropdownParent: jQuery("#conv_con_modal"),
                    minimumResultsForSearch: -1,
                    placeholder: function() {
                        jQuery(this).data('placeholder');
                    }
                });
                jQuery("#conv_conversion_select").val(selected).trigger("change");
            }

        });
    }


    // Create new gads acc function
    function create_google_ads_account(tvc_data) {
        var conversios_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>";
        var error_msg = 'null';
        var btn_cam = 'create_new';
        var ename = 'conversios_onboarding';
        var event_label = 'ads';

        <?php if (!CONV_IS_WC) { ?>
            jQuery(".newgads_error").addClass('d-none');
            var decodedString = tvc_data.replace(/&quot;/g, '"');
            var jsonObject = JSON.parse(decodedString);

            if (jQuery("#gads_country").val() == "") {
                jQuery("#gads_country_lbl .newgads_error").removeClass('d-none');
                return false;
            }
            if (jQuery("#gads_currency").val() == "") {
                jQuery("#gads_currency_lbl .newgads_error").removeClass('d-none');
                return false;
            }

            jsonObject['user_country'] = jQuery("#gads_country").val();
            var gads_currency_val = jQuery("#gads_currency").val();
            jsonObject['currency_code'] = jQuery("#gads_currency").find(":selected").attr("isothreeval");

            var tvc_data_json = JSON.stringify(jsonObject);
            tvc_data = tvc_data_json.replace(/"/g, "&quot;");

        <?php } ?>


        //user_tracking_data(btn_cam, error_msg,ename,event_label);
        var is_woocommerce_active = <?php echo (is_plugin_active_for_network('woocommerce/woocommerce.php') || in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) ? 'true' : 'false'; ?>;
        var postData = {
            action: "create_google_ads_account",
            tvc_data: tvc_data,
            conversios_onboarding_nonce: conversios_onboarding_nonce
        };
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: postData,
            beforeSend: function() {
                jQuery("#gadsinviteloader").removeClass('d-none');
                jQuery("#ads-continue").addClass('disabled');
            },
            success: function(response) {
                if (response) {
                    error_msg = 'null';
                    var btn_cam = 'complate_new';
                    var ename = 'conversios_onboarding';
                    var event_label = 'ads';

                    //add_message("success", response.data.message);
                    jQuery("#new_google_ads_id").text(response.data.adwords_id);
                    if (response.data.invitationLink != "") {
                        jQuery("#ads_invitationLink").attr("href", response.data.invitationLink);
                        //jQuery("#conv_newgads_accbtn").click();
                        showGAdsModalPopUp(response.data.invitationLink);
                    } else {
                        jQuery("#invitationLink").html("");
                    }
                    jQuery(".before-ads-acc-creation").addClass("d-none");
                    jQuery(".after-ads-acc-creation").removeClass("d-none");
                    //localStorage.setItem("new_google_ads_id", response.data.adwords_id);
                    var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
                    list_google_ads_account(tvc_data, response.data.adwords_id);
                    jQuery("#save_gads_finish").removeClass("disabledsection");
                } else {
                    var error_msg = response.errors;
                    add_message("error", response.data.message);
                }
                //user_tracking_data(btn_cam, error_msg,ename,event_label);
            }
        });
    }

    function cleargadsconversions() {
        var data = {
            action: "conv_save_gads_conversion",
            cleargadsconversions: "yes",
            CONVNonce: "<?php echo esc_js(wp_create_nonce('conv_save_gads_conversion-nonce')); ?>",
        };
        jQuery.ajax({
            type: "POST",
            url: tvc_ajax_url,
            data: data,
            success: function(response) {
                jQuery('.inlist_text_pre').find(".inlist_text_notconnected").removeClass("d-none");
                jQuery('.inlist_text_pre').find(".inlist_text_connected").addClass("d-none");
                jQuery('.inlist_text_pre').find(".inlist_text_connected").find(".inlist_text_connected_convid").html("");
                jQuery('.inlist_text_pre').next().html("Add");
                jQuery("#convgadseditconfirm").modal("hide");
            }
        });
    }

    //Onload functions
    jQuery(function() {
        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        var tvc_ajax_url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        let subscription_id = "<?php echo esc_attr($subscription_id); ?>";
        let plan_id = "<?php echo esc_attr($plan_id); ?>";
        let app_id = "<?php echo esc_attr($app_id); ?>";

        <?php if (empty($measurement_id) || (isset($_GET['g_mail']) && sanitize_text_field(wp_unslash($_GET['g_mail'])))) : ?>
            load_ga_accounts(tvc_data);
        <?php elseif (empty($google_ads_id)) : ?>
            //openAccordionById("accordion2");
            list_google_ads_account(tvc_data);
        <?php elseif (empty($google_merchant_center_id) && CONV_IS_WC === 1) : ?>
            list_google_merchant_account(tvc_data);
        <?php endif; ?>


        jQuery(".conv-enable-selection_gmc").click(function() {
            conv_change_loadingbar("show");
            jQuery(".conv-enable-selection_gmc").addClass('hidden');
            var selele = jQuery(".conv-enable-selection_gmc").closest(".conv-gmcsettings").find(
                "select.google_merchant_center_id");
            var currele = jQuery(this).closest(".conv-gmcsettings").find(
                "select.google_merchant_center_id");
            list_google_merchant_account(tvc_data, selele);
        });

        jQuery(".selecttwo").select2({
            minimumResultsForSearch: -1,
            placeholder: function() {
                jQuery(this).data('placeholder');
            }
        });

        jQuery(".conv-enable-selection_gads").click(function() {
            jQuery("#convgadseditconfirm").modal('show');
        });

        jQuery("#conv_changegadsacc_but").click(function() {
            jQuery("#conv_changegadsacc_but").addClass("disabled");
            jQuery("#conv_changegadsacc_but").find(".spinner-border").removeClass("d-none");

            conv_change_loadingbar("show");
            jQuery(".conv-enable-selection").addClass('disabled');
            list_google_ads_account(tvc_data);
            conv_change_loadingbar("hide");
        });

        <?php if ($cust_g_email != "" && $measurement_id != "" && $google_ads_id == "") { ?>
            list_google_ads_account(tvc_data);
        <?php } ?>


        jQuery("#google_ads_conversion_tracking").click(function() {
            if (jQuery("#google_ads_conversion_tracking").is(":checked")) {
                jQuery('#ga_EC').removeAttr('disabled');
                jQuery("#ga_EC").prop("checked", true);
                jQuery("#ga_EC").attr('checked', true);
                jQuery("#analytics_box_adstwo").removeClass("d-none");
            } else {
                jQuery('#ga_EC').attr('disabled', true);
                jQuery("#ga_EC").prop("checked", false);
                jQuery("#ga_EC").attr('checked', false);
                jQuery("#analytics_box_adstwo").addClass("d-none");
            }
        });


        jQuery("#save_gads_finish").click(function() {
            jQuery(this).find(".spinner-border").removeClass("d-none");
            jQuery("#save_gads_finish").addClass("disabledsection");
            save_gads_data()
        });

        <?php
        $gads_conversions = [];
        if (array_key_exists("gads_conversions", $ee_options)) {

            $gads_conversions = $ee_options["gads_conversions"];
        }
        ?>

        gads_conversions = <?php echo wp_json_encode($gads_conversions); ?>;
        jQuery.each(gads_conversions, function(key, value) {
            jQuery('.inlist_text_pre[conversion_name="' + key + '"]').find(".inlist_text_notconnected").addClass("d-none");
            jQuery('.inlist_text_pre[conversion_name="' + key + '"]').find(".inlist_text_connected").removeClass("d-none");
            jQuery('.inlist_text_pre[conversion_name="' + key + '"]').find(".inlist_text_connected").find(".inlist_text_connected_convid").html(value);
            jQuery('.inlist_text_pre[conversion_name="' + key + '"]').next().html("Edit");
        });

        <?php
        $ee_conversio_send_to = !empty(get_option('ee_conversio_send_to')) ? get_option('ee_conversio_send_to') : "";
        if ($ee_conversio_send_to != "") {
        ?>
            jQuery('.inlist_text_pre[conversion_name="PURCHASE"]').find(".inlist_text_notconnected").addClass("d-none");
            jQuery('.inlist_text_pre[conversion_name="PURCHASE"]').find(".inlist_text_connected").removeClass("d-none");
            jQuery('.inlist_text_pre[conversion_name="PURCHASE"]').find(".inlist_text_connected").find(".inlist_text_connected_convid").html('<?php echo esc_js($ee_conversio_send_to); ?>');
            jQuery('.inlist_text_pre[conversion_name="PURCHASE"]').next().html("Edit");
        <?php } ?>

        // Save data
        function save_webadsdata() {
            var has_error = 0;
            var selected_vals_webads = {};
            selected_vals_webads["subscription_id"] = "<?php echo esc_html($tvc_data['subscription_id']) ?>";
            selected_vals_webads["conv_onboarding_done_step"] = "<?php echo esc_js("3"); ?>";

            //selected_vals_webads['gtm_channel_settings'] = selected_event_checkboxes;
            var data_webadsclcr = {
                action: "conv_save_pixel_data",
                pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                conv_options_data: selected_vals_webads,
                conv_options_type: ["eeoptions", "eeapidata", "middleware"],
                conv_tvc_data: tvc_data,
            };
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: data_webadsclcr,
                success: function(response) {
                    console.log('stepsavedfor gads');
                }
            });
        };

        function save_gads_data() {
            conv_change_loadingbar("show");

            jQuery("#save_gads_finish").find(".spinner-border").addClass("d-none");
            jQuery("#save_gads_finish").removeClass('disabledsection');
            //changeTabBox("webgmcbox-tab");

            var feedType = jQuery('#feedType').val();
            var google_ads_id = jQuery("#google_ads_id").val();
            var remarketing_tags = jQuery("#remarketing_tags").val();
            var dynamic_remarketing_tags = jQuery("#dynamic_remarketing_tags").val();
            var link_google_analytics_with_google_ads = "1";
            var google_ads_conversion_tracking = jQuery("#google_ads_conversion_tracking").val();
            var ga_EC = jQuery("#ga_EC").val();
            var ee_conversio_send_to = jQuery("#ee_conversio_send_to").val();
            var ga_GMC = jQuery('#ga_GMC').val();

            var selectedoptions = {};

            selectedoptions['google_ads_id'] = jQuery("#google_ads_id").val();
            selectedoptions["subscription_id"] = "<?php echo esc_html($tvc_data['subscription_id']) ?>";
            selectedoptions['merchant_id'] = jQuery("#merchant_id").val();
            selectedoptions['google_merchant_id'] = jQuery("#google_merchant_id").val();
            selectedoptions['link_google_analytics_with_google_ads'] = "1";
            selectedoptions['ga_GMC'] = ga_GMC;
            selectedoptions['remarketing_tags'] = 1;

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "conv_save_googleads_data",
                    pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                    conv_options_data: selectedoptions,
                    conv_tvc_data: tvc_data,
                    conv_options_type: ["eeoptions"]
                },
                beforeSend: function() {
                    jQuery(".conv-btn-connect-enabled-google").text("Saving...");
                    jQuery('.conv-btn-connect-enabled-google').addClass('disabled');
                },
                success: function(response) {
                    <?php if (CONV_IS_WC) { ?>
                        list_google_merchant_account(tvc_data);
                    <?php } ?>
                    save_webadsdata();
                    conv_change_loadingbar("hide");
                }
            });
        };

        // Create new gads acc
        jQuery("#ads-continue").on('click', function(e) {
            e.preventDefault();
            create_google_ads_account(tvc_data);
            cleargadsconversions();
            jQuery('.ggladspp').removeClass('showpopup');
        });

        jQuery('#conv_con_modal').modal({
            backdrop: 'static',
            keyboard: false
        })

        jQuery(".conv_con_modal_opener").click(function() {
            jQuery("#gadssettings_form").addClass("formchanged_webads");
            var conversion_name = jQuery(this).attr("conversion_name");
            if (conversion_name == "PURCHASE") {
                jQuery("#enhmsg").removeClass("d-none");
            }

            conversion_title_arr = {
                ADD_TO_CART: "Settings for Conversion",
                BEGIN_CHECKOUT: "Settings for Conversion",
                PURCHASE: "Settings for Conversion",
                SUBMIT_LEAD_FORM: "Settings for Conversion",
            }

            conversion_label_arr = {
                ADD_TO_CART: "Select Conversion ID Label For Add to Cart",
                BEGIN_CHECKOUT: "Select Conversion ID Label For Begin Checkout",
                PURCHASE: "Select Conversion ID Label For Purchase",
                SUBMIT_LEAD_FORM: "Select Conversion ID Label For Form Lead Submit",
            }

            conversion_value_arr = {
                ADD_TO_CART: "Product Value",
                BEGIN_CHECKOUT: "Order Total",
                PURCHASE: "Order Total",
                SUBMIT_LEAD_FORM: "Value"
            }

            conversion_name_arr = {
                ADD_TO_CART: "Conversios-AddToCart",
                BEGIN_CHECKOUT: "Conversios-BeginCheckout",
                PURCHASE: "Conversios-Purchase",
                SUBMIT_LEAD_FORM: "Conversios-SubmitLeadForm",
            }

            jQuery("#conv_con_modalLabel").html(conversion_label_arr[conversion_name]);
            jQuery("#convconmodtitle").html(conversion_title_arr[conversion_name]);
            jQuery("#concre_name").val(conversion_name_arr[conversion_name]);
            jQuery("#concre_value").val(conversion_value_arr[conversion_name]);
            jQuery("#concre_category").val(conversion_name);
            jQuery("#conv_con_modal").modal("show");
            get_conversion_list(conversion_name);
        });

        jQuery('#conv_con_modal').on('hide.bs.modal', function() {

            jQuery("#ee_conversio_send_to_static").removeClass("conv-border-danger");
            jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled");
            jQuery(".conv-btn-connect").addClass("conv-btn-connect-enabled-google");
            jQuery(".conv-btn-connect").text('Save');

            jQuery("#conv_con_modalLabel").html("");
            jQuery("#concre_name").val("");
            jQuery("#concre_value").val("");
            jQuery("#concre_category").val("");

            jQuery("#enhmsg").addClass("d-none");

            convpopuploading("show");

            var AccOptions = '<option value="">Select Conversion ID and Label</option>';
            jQuery('#conv_conversion_select').html(AccOptions);

            //jQuery("#conv_conversion_select").select2("destroy");

            jQuery(this).find(".spinner-border").addClass("d-none");
            jQuery(this).removeClass("disabled");

            jQuery("#convsave_conversion_but").addClass("disabled");

            jQuery("#conv_conversion_selectbox").removeClass("d-none");
            jQuery("#conv_conversion_textbox").addClass("d-none");
            jQuery("#conv_conversion_selectHelp").html("");
        })

        //Create GAds conversion action
        function create_gads_conversion(conversionCategory, conversionName) {
            var data = {
                action: "conv_create_gads_conversion",
                gads_id: jQuery("#google_ads_id").val(),
                TVCNonce: "<?php echo esc_js(wp_create_nonce('con_get_conversion_list-nonce')); ?>",
                conversionCategory: conversionCategory,
                conversionName: conversionName,
            };
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: data,
                success: function(response) {
                    if (response.status == "200" && response.data != undefined && response.data != "") {
                        var responsearr = response.data.split("/");
                        get_conversion_list(conversionCategory, responsearr[responsearr.length - 1]);
                    }
                    get_conversion_list(conversionCategory);
                    jQuery("#convcon_create_but").find(".spinner-border").addClass("d-none");
                }
            });
        }

        jQuery("#convcon_create_but").click(function() {
            convpopuploading("loading");
            jQuery("#convcon_create_but").find(".spinner-border").removeClass("d-none");
            create_gads_conversion(jQuery("#concre_category").val(), jQuery("#concre_name").val());
        });

        jQuery("#convsave_conversion_but").on("click", function() {
            jQuery("#convsave_conversion_but").addClass("disabled");
            jQuery("#convsave_conversion_but").find(".spinner-border").removeClass("d-none");
            var conversion_action = jQuery("#conv_conversion_textbox").val();
            var conversion_category = jQuery("#concre_category").val();
            var data = {
                action: "conv_save_gads_conversion",
                conversion_action: conversion_action,
                conversion_category: conversion_category,
                CONVNonce: "<?php echo esc_js(wp_create_nonce('conv_save_gads_conversion-nonce')); ?>",
            };
            jQuery.ajax({
                type: "POST",
                url: tvc_ajax_url,
                data: data,
                success: function(response) {
                    jQuery("#convsave_conversion_but").find(".spinner-border").addClass("d-none");

                    jQuery('.inlist_text_pre[conversion_name="' + conversion_category + '"]').find(".inlist_text_notconnected").addClass("d-none");
                    jQuery('.inlist_text_pre[conversion_name="' + conversion_category + '"]').find(".inlist_text_connected").removeClass("d-none");
                    jQuery('.inlist_text_pre[conversion_name="' + conversion_category + '"]').find(".inlist_text_connected").find(".inlist_text_connected_convid").html(conversion_action);
                    jQuery('.inlist_text_pre[conversion_name="' + conversion_category + '"]').next().html("Edit");

                    jQuery("#conv_con_modal").modal("hide");
                }
            });

        });

        jQuery(document).on("change", "#google_ads_id", function() {
            if (jQuery("#google_ads_conversion_tracking").is(":checked")) {
                get_conversion_list();
            }
            var selectedAcc = jQuery("#google_ads_id").val();
            if (selectedAcc != "") {
                jQuery("#spinner_mcc_check").removeClass("d-none");
                jQuery("#conv_mcc_alert").addClass("d-none");
                //console.log("selected ads acc is "+selectedAcc);
                var data = {
                    action: "conv_checkMcc",
                    ads_accountId: selectedAcc,
                    subscription_id: "<?php echo esc_attr($subscription_id); ?>",
                    CONVNonce: "<?php echo esc_js(wp_create_nonce('conv_checkMcc-nonce')); ?>"
                };
                jQuery.ajax({
                    type: "POST",
                    url: tvc_ajax_url,
                    data: data,
                    success: function(response) {
                        var newResponse = JSON.parse(response);
                        if (newResponse.status == 200 && newResponse.data !== null) {
                            if (newResponse.data[0] !== undefined) {
                                var managerStatus = newResponse.data[0]?.managerStatus;
                                if (managerStatus) { //mcc true
                                    jQuery("#conv_mcc_alert").removeClass("d-none");
                                    jQuery("#google_ads_id").val('').trigger('change');
                                    jQuery("#save_gads_finish").addClass("disabledsection");
                                } else {
                                    jQuery("#save_gads_finish").removeClass("disabledsection");
                                    save_gads_data();
                                }
                            }
                        }
                        jQuery("#spinner_mcc_check").addClass("d-none");
                        jQuery("#accordionFlushExample .accordion-body").removeClass("disabledsection");
                    }
                });
            } else {
                jQuery("#accordionFlushExample .accordion-body").addClass("disabledsection");
                jQuery("#save_gads_finish").addClass("disabledsection");
            }
            //cleargadsconversions();
        });

    });
</script>
<!-- End google ads settings -->


<?php if (CONV_IS_WC) { ?>
    <!-- GMC Settings JS -->
    <script>
        function call_site_verified() {
            jQuery.post(tvc_ajax_url, {
                action: "tvc_call_site_verified",
                SiteVerifiedNonce: "<?php echo esc_js(wp_create_nonce('tvc_call_site_verified-nonce')); ?>"
            }, function(response) {
                var rsp = JSON.parse(response);
                console.log(rsp.message);
                user_tracking_data('refresh_call', 'null', 'product-feed-manager-for-woocommerce',
                    'call_site_verified');
            });
            jQuery('#conwizverifysite').addClass('disabledsection');
        }

        function call_domain_claim() {
            jQuery.post(tvc_ajax_url, {
                action: "tvc_call_domain_claim",
                apiDomainClaimNonce: "<?php echo esc_js(wp_create_nonce('tvc_call_domain_claim-nonce')); ?>"
            }, function(response) {
                var rsp = JSON.parse(response);
                console.log(rsp.message);
                user_tracking_data('refresh_call', 'null', 'product-feed-manager-for-woocommerce', 'call_domain_claim');
            });
            jQuery('#conwizverifydomain').addClass('disabledsection');
        }

        /*************************Create Super AI Feed Start ************************************************************************/
        function createSuperAIFeed() {

            if (jQuery("#convsitedomainfeed").hasClass("superfeedcreated")) {
                console.log('superfeed already created');
                return;
            }
            jQuery("#convsitedomainfeed").addClass("superfeedcreated");
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "ee_super_AI_feed",
                    create_superFeed_nonce: "<?php echo esc_js(wp_create_nonce('create_superFeed_nonce_val')); ?>",
                    type: 'GMC',
                },
                success: function(response) {
                    console.log("SAI Feed total=" + response.total_product);
                },
                error: function(error) {

                }
            });
            jQuery('#conwizenablesuperfeed').addClass('disabledsection');
        }

        /*************************Create Super AI Feed End ***************************************************************************/

        <?php if ((isset($cust_g_email) && $cust_g_email != "")) { ?>
            jQuery('.pawizard_tab_but').on('shown.bs.tab', function(e) {
                if (jQuery(e.target).attr('aria-controls') == "webgmcbox") {
                    var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
                    list_google_merchant_account(tvc_data);
                }
            });
        <?php } ?>



        //Create GMC Id POP-up call
        jQuery(document).on('click', '.createNewGMC', function() {
            jQuery("#create_gmc_error").addClass("d-none");
            jQuery(".before-gmc-acc-creation").removeClass("d-none");
            jQuery(".after-gmc-acc-creation").addClass("d-none");
            jQuery('#create_merchant_account_new').removeClass('disabled')
            jQuery('#gmc_store_name').val('')
            jQuery('#gmc_concent').prop('checked', false)
            jQuery('#conv_create_gmc_new').modal('show')
            jQuery("#gmc_country").select2({
                minimumResultsForSearch: 5,
                dropdownParent: jQuery('#conv_create_gmc_selectthree'),
                placeholder: function() {
                    jQuery(this).data('placeholder');
                }
            });
        })
        //Create GMC Id under our MCC account
        jQuery(document).on('click', "#create_merchant_account_new", function() {
            jQuery('.selection').find("[aria-labelledby='select2-google_merchant_center_id-container']").removeClass(
                'selectError');
            var is_valide = true;
            var website_url = jQuery("#gmc_website_url").val();
            var email_address = jQuery("#gmc_email_address").val();
            var store_name = jQuery("#gmc_store_name").val();
            var country = jQuery("#gmc_country").val();
            var customer_id = '<?php echo esc_js($get_site_domain['setting']->customer_id); ?>';
            var adult_content = jQuery("#gmc_adult_content").is(':checked');
            if (website_url == "") {
                jQuery("#create_gmc_error").removeClass("d-none");
                jQuery("#create_gmc_error small").text("Missing value of website url");
                is_valide = false;
            } else if (email_address == "") {
                jQuery("#create_gmc_error").removeClass("d-none");
                jQuery("#create_gmc_error small").text("Missing value of email address.");
                is_valide = false;
            } else if (store_name == "") {
                jQuery("#create_gmc_error").removeClass("d-none");
                jQuery("#create_gmc_error small").text("Missing value of store name.");
                is_valide = false;
            } else if (country == "") {
                jQuery("#create_gmc_error").removeClass("d-none");
                jQuery("#create_gmc_error small").text("Missing value of country.");
                is_valide = false;
            } else if (jQuery('#gmc_concent').prop('checked') == false) {
                jQuery("#create_gmc_error").removeClass("d-none");
                jQuery("#create_gmc_error small").text("Please accept the terms and conditions.");
                is_valide = false;
            }

            if (is_valide == true) {
                var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
                var data = {
                    action: "create_google_merchant_center_account",
                    website_url: website_url,
                    email_address: email_address,
                    store_name: store_name,
                    country: country,
                    concent: 1,
                    customer_id: customer_id,
                    adult_content: adult_content,
                    tvc_data: tvc_data,
                    conversios_onboarding_nonce: "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>"
                };
                jQuery.ajax({
                    type: "POST",
                    dataType: "json",
                    url: tvc_ajax_url,
                    data: data,
                    beforeSend: function() {
                        jQuery('#create_merchant_account_new, #model_close_gmc_creation, .closeButton')
                            .addClass('disabled')
                    },
                    success: function(response, status) {
                        jQuery('#model_close_gmc_creation, .closeButton').removeClass('disabled')
                        if (response.error === true) {
                            var error_msg = 'Check your inputs!!!';
                            jQuery("#create_gmc_error").removeClass("d-none");
                            jQuery('#create_gmc_error small').text(error_msg)
                            jQuery('#create_merchant_account_new').removeClass('disabled')
                        } else if (response.account.id) {
                            jQuery("#new_gmc_id").text(response.account.id);
                            jQuery(".before-gmc-acc-creation").addClass("d-none");
                            jQuery(".after-gmc-acc-creation").removeClass("d-none");
                            var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
                            list_google_merchant_account(tvc_data, "", response.account.id, response.merchant_id);
                        } else {}
                    }
                });
            }
        });


        //Save GMC channel       
        jQuery(document).on('click', '.conv_save_gmc', function() {
            save_gmc_settings('GMC', jQuery(this));
        });

        function save_gmc_settings(Channel, buttoncalled) {
            jQuery("#convsitedomainfeed").addClass("disabledsection");
            if (jQuery('#conwizenablesuperfeed').length) {
                var conwizenablesuperfeed = 0;
                if (jQuery("#conwizenablesuperfeed").is(':checked')) {
                    conwizenablesuperfeed = 1;
                    conwizverifysite = 1;
                    conwizverifydomain = 1;
                }
            }

            if (jQuery('#conwizverifysite').length) {
                var conwizverifysite = 0;
                if (jQuery("#conwizverifysite").is(':checked')) {
                    conwizverifysite = 1;
                }
            }

            if (jQuery('#conwizverifydomain').length) {
                var conwizverifydomain = 0;
                if (jQuery("#conwizverifydomain").is(':checked')) {
                    conwizverifydomain = 1;
                }
            }

            jQuery(".conv_save_gmc").find(".spinner-border").addClass("d-none");
            //jQuery(".conv_save_gmc").removeClass('disabledsection');
            changeTabBox("webotherbox-tab");
            var selected_vals = {};
            var conv_options_type = [];
            var data = {};
            if (Channel == 'GMC') {
                var update_site_domain = '';
                if (google_merchant_center_id != jQuery("#google_merchant_center_id").val()) {
                    update_site_domain = 'update';
                }
                conv_options_type = ["eeoptions", "eeapidata", "middleware"];
                selected_vals["subscription_id"] = "<?php echo esc_js($subscription_id) ?>";
                selected_vals["google_merchant_center_id"] = jQuery("#google_merchant_center_id").val();
                selected_vals["google_merchant_id"] = jQuery("#google_merchant_center_id").val();
                selected_vals["merchant_id"] = jQuery('#google_merchant_center_id').find(':selected').data('merchant_id');
                selected_vals["website_url"] = "<?php echo esc_js(get_site_url()); ?>";
                selected_vals["conv_onboarding_done_step"] = "<?php echo esc_js("4"); ?>";
                selected_vals["conwizenablesuperfeed"] = conwizenablesuperfeed;
                selected_vals["conwizverifysite"] = conwizverifysite;
                selected_vals["conwizverifydomain"] = conwizverifydomain;

                var google_ads_id = jQuery('#google_ads_id').val();

                if (google_ads_id !== '') {
                    selected_vals["google_ads_id"] = google_ads_id;
                    selected_vals["ga_GMC"] = '1';
                }
                data = {
                    action: "conv_save_pixel_data",
                    pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                    conv_options_data: selected_vals,
                    conv_options_type: conv_options_type,
                    update_site_domain: update_site_domain,
                }
            }

            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: data,
                success: function(response) {
                    jQuery(".conv_save_gmc").find(".spinner-border").addClass("d-none");
                    if (jQuery("#google_merchant_center_id").val() != "" &&
                        jQuery("#google_merchant_center_id").val() != undefined &&
                        jQuery("#google_merchant_center_id").val() != null
                    ) {
                        jQuery("#save_gmc").removeClass('disabledsection');

                        <?php if (CONV_IS_WC) { ?>
                            if (jQuery('#conwizenablesuperfeed').length && conwizenablesuperfeed == 1) {
                                call_domain_claim();
                                call_site_verified();
                                createSuperAIFeed();
                            }
                        <?php } ?>
                    }

                }
            });


        }


        //Get Google Merchant Id
        function list_google_merchant_account(tvc_data, selelement, new_gmc_id = "", new_merchant_id = "") {
            openAccordionById("accordion3");
            conv_change_loadingbar_popup("show");
            conv_change_loadingbar("show");
            jQuery(".conv-enable-selection_gmc").addClass('hidden');
            let google_merchant_center_id = jQuery('#google_merchant_center_id').val();
            var selectedValue = '0';
            var conversios_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>";
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "list_google_merchant_account",
                    tvc_data: tvc_data,
                    conversios_onboarding_nonce: conversios_onboarding_nonce
                },
                success: function(response) {
                    var btn_cam = 'gmc_list';
                    jQuery('#google_merchant_center_id').removeAttr('disabled')
                    if (response.error === false) {
                        var error_msg = 'null';
                        jQuery('#google_merchant_center_id').empty();
                        jQuery('#google_merchant_center_id').append(jQuery('<option>', {
                            value: "",
                            text: "Select Google Merchant Center Account"
                        }));
                        if (response.data.length > 0) {
                            jQuery.each(response.data, function(key, value) {
                                jQuery('#google_merchant_center_id').append(jQuery('<option>', {
                                    value: value.account_id,
                                    "data-merchant_id": value.merchant_id,
                                    text: value.account_id,
                                    selected: (value.account_id === google_merchant_center_id)
                                }));
                            });

                            if (new_gmc_id != "" && new_gmc_id != undefined) {
                                jQuery('#google_merchant_center_id').append(jQuery('<option>', {
                                    value: new_gmc_id,
                                    "data-merchant_id": new_merchant_id,
                                    text: new_gmc_id,
                                    selected: "selected"
                                }));
                                jQuery('.getGMCList').addClass('d-none')
                                jQuery('.conv_save_gmc').prop('disabled', false)
                            }
                        } else {
                            if (new_gmc_id != "" && new_gmc_id != undefined) {
                                jQuery('#google_merchant_center_id').append(jQuery('<option>', {
                                    value: new_gmc_id,
                                    "data-merchant_id": new_merchant_id,
                                    text: new_gmc_id,
                                    selected: "selected"
                                }));
                                jQuery('.getGMCList').addClass('d-none')
                                jQuery('.conv_save_gmc').prop('disabled', false)
                            }
                            // console.log("error", "There are no Google merchant center accounts associated with email.");
                        }
                        conv_change_loadingbar_popup("hide");
                        conv_change_loadingbar("hide");
                    } else {
                        var error_msg = response.errors;
                        // console.log("error", "There are no Google merchant center  accounts associated with email.");
                        conv_change_loadingbar_popup("hide");
                        conv_change_loadingbar("hide");
                    }
                    jQuery("#save_gmc").removeClass("disabledsection");
                    setTimeout(function() {
                        jQuery("#google_merchant_center_id").select2('open');
                    }, 1000);
                }
            });
        }
    </script>
    <!-- End of GMC settings -->
<?php } else { ?>
    <script>
        jQuery(document).on('click', '.conv_save_gmc', function() {
            changeTabBox("webotherbox-tab");
        });
    </script>
<?php } ?>