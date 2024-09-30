<?php
if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly
$is_sel_disable_gads = 'disabled';
$cust_g_email_gads = (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";
$tvs_admin = new TVC_Admin_Helper();
$tvs_admin_data = $tvs_admin->get_ee_options_data();
$store_id = $tvs_admin_data['setting']->store_id;
$gtm_account_id = isset($ee_options['gtm_settings']['gtm_account_id']) ? $ee_options['gtm_settings']['gtm_account_id'] : "";
$gtm_container_id = isset($ee_options['gtm_settings']['gtm_container_id']) ? $ee_options['gtm_settings']['gtm_container_id'] : "";
$is_gtm_automatic_process = isset($ee_options['gtm_settings']['is_gtm_automatic_process']) ? $ee_options['gtm_settings']['is_gtm_automatic_process'] : false;

$site_url_feedlist = "admin.php?page=conversios-google-shopping-feed&tab=feed_list";
$g_email = (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";
$google_ads_id = (isset($googleDetail->google_ads_id) && $googleDetail->google_ads_id != "") ? $googleDetail->google_ads_id : "";
?>

<div class="convgads_mainbox mt-3">
    <div class="convwiz_pixtitle mt-0 mb-3 d-flex justify-content-between align-items-center py-0">
        <div class="col-7">
            <div class="convwizlogotitle">
                <div class="d-flex flex-row align-items-center">
                    <img class="conv_channel_logo me-2 align-self-center" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_gads_logo.png'); ?>" />
                    <div>
                        <h5 class="m-0 text-bold h5">
                            <?php esc_html_e("Google Ads", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                    </div>
                </div>
            </div>

            <ul class="conv-green-checklis list-unstyled mt-3">
                <li class="d-flex">
                    <span class="material-symbols-outlined text-success md-18">
                        check_circle
                    </span>
                    <?php esc_html_e("Google Ads Purchase & Lead Generation Conversion Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </li>
                <li class="d-flex">
                    <span class="material-symbols-outlined text-success md-18">
                        check_circle
                    </span>
                    <?php esc_html_e("Easy-to-Set-Up Google Ads Pmax Campaign Creation", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-html="true" data-bs-original-title="<b>What is Pmax campaigns? </b><br>Performance max campaign are like a personal shopper for your WooCommerce store, automatically finding the best customers and showing them your ads at the perfect time.">
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
                            <span class="conv-link-blue ps-2 conv_change_gauth">
                                <?php esc_html_e("Change", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </span>
                        </span>
                    </div>

                <?php } else { ?>

                    <div class="tvc_google_signinbtn_box " style="width: 185px;">
                        <div class="tvc_google_signinbtn_ga google-btn">
                            <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/btn_google_signin_dark_normal_web.png'); ?>">
                        </div>
                    </div>
                    <div class="ps-1">We only require Google authorization to access your Google Analytics 4 Account and Measurement ID for data tracking. Your personal information and account details remain completely secure and private.</div>
                <?php } ?>
            </div>
            <!-- Google SignIn End -->
        </div>



    </div>


    <form id="gadssetings_form" class="convgawiz_form_webads convpixsetting-inner-box mt-3 pb-4 convwiz_border formchanged_webads" datachannel="GoogleAds">
        <div class="product-feed">
            <div class="progress-wholebox">
                <div class="card-body p-0">
                    <ul class="progress-steps-list p-0">

                        <li class="gmc_account_id_step">

                            <!-- GAds Acc Selection -->
                            <div id="analytics_box_ads" class="py-1">
                                <?php
                                global $wp_filesystem;
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
                                <div class="row">
                                    <div class="col-7 pt-2">
                                        <h5 class="fw-normal mb-1 text-dark">
                                            <b><?php esc_html_e("Select your existing Google Ads Account", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                        </h5>
                                        <select id="google_ads_id" name="google_ads_id" class="valtoshow_inpopup_this form-select form-select-lg mb-3 selecttwo google_ads_id" style="width: 100%" <?php echo esc_attr($is_sel_disable_gads); ?>>
                                            <?php if (!empty($google_ads_id)) { ?>
                                                <option value="<?php echo esc_attr($google_ads_id); ?>" selected><?php echo esc_html($google_ads_id); ?></option>
                                            <?php } ?>
                                            <option value="">Select Account</option>
                                        </select>
                                    </div>
                                    <div id="spinner_mcc_check" class="mt-4 spinner-border text-primary d-none" role="status" style="margin-top: 38px !important;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    <div id="conv_mcc_alert" class="my-3 mx-2 alert alert-danger d-none" role="alert">
                                        <?php esc_html_e("You have selected a MCC account. Please select other google ads account to proceed further.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </div>


                                    <div class="col-12 flex-row pt-2">
                                        <h5 class="fw-normal mb-1 text-dark">
                                            <b><?php esc_html_e("Don't have a Gogole Ads account?", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-center conv_create_gads_new_card rounded px-3 py-3">

                                            <?php if ($off_credit_amt != "") { ?>
                                                <div class="amtbtn">
                                                    <?php echo esc_html($off_credit_amt); ?>
                                                </div>
                                                <div class="div">
                                                    <h5 class="text-dark mb-0">
                                                        <?php esc_html_e("Your " . $off_credit_amt . " in Ads Credit is ready to be claimed", "enhanced-e-commerce-for-woocommerce-store") ?>
                                                    </h5>
                                                    <span class="text-dark fs-12">
                                                        <?php esc_html_e("Sign up for Google Ads and complete your payment information to apply the offer to", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        <br>
                                                        <?php esc_html_e("your account.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                        <a href="https://www.google.com/intl/en_in/ads/coupons/terms/cyoi/" class="" target="_blank">
                                                            <u><?php esc_html_e("Terms and conditions apply.", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                                                        </a>
                                                    </span>
                                                </div>
                                            <?php } else { ?>
                                                <div class="d-flex">
                                                    <span class="text-dark d-flex align-items-center">
                                                        <?php esc_html_e("Sign up for Google Ads and complete your payment information to apply the offer to your account.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                    </span>
                                                </div>
                                            <?php } ?>

                                            <div class="align-self-center">
                                                <button id="conv_create_gads_new_btn" type="button" class="btn btn-primary px-5" data-bs-toggle="modal" data-bs-target="#conv_create_gads_new">
                                                    <?php esc_html_e("Create Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- GAds Acc Selection End -->

                            <div class="pt-2">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="d-flex fw-normal mb-1 text-dark">
                                            <a target="_blank" href="<?php echo esc_url('https://www.conversios.io/checkout/?pid=wpAIO_SY1&utm_source=woo_aiofree_plugin&utm_medium=onboarding&utm_campaign=gadseec'); ?>" class="align-middle conv-link-blue fw-bold-500">
                                                <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                                               <u><?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                                            </a>
                                        </h5>
                                        <ul class="conv-green-checklis list-unstyled mt-1">
                                            <li class="d-flex">
                                                <span class="material-symbols-outlined text-success md-18">
                                                    check_circle
                                                </span>
                                                <?php esc_html_e("Google Ads Enhance Conversion for Ecommerce Purchase Event", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                            </li>
                                            <li class="d-flex">
                                                <span class="material-symbols-outlined text-success md-18">
                                                    check_circle
                                                </span>
                                                <?php esc_html_e("Google Ads Conversion Tracking for Add to cart and Begin checkout", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>


                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <input type="hidden" id="merchant_id" name="merchant_id" value="<?php echo esc_attr($googleDetail->merchant_id) ?>">
        <input type="hidden" id="google_merchant_id" name="google_merchant_id" value="<?php echo esc_attr($googleDetail->google_merchant_id) ?>">
        <input type="hidden" id="ga_GMC" name="ga_GMC" value="<?php echo isset($googleDetail->google_merchant_id) && $googleDetail->google_merchant_id !== null ? 1 : 0 ?>">
        <input type="hidden" id="feedType" name="feedType" value="<?php echo isset($_GET['feedType']) && $_GET['feedType'] != '' ? esc_attr(sanitize_text_field(wp_unslash($_GET['feedType']))) : '' ?>" />
    </form>


    <!-- Tab bottom buttons -->
    <div class="tab_bottom_buttons d-flex justify-content-end pt-0">

        <div class="ms-auto d-flex align-items-center">
            <button class="btn btn-outline-primary" onclick="changeTabBox('webpixbox-tab')">
                <?php esc_html_e('Go Back', "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
            <?php
            $conv_isgadsdisabled = "";
            if (empty($google_ads_id)) {
                $conv_isgadsdisabled = "disabledsection";
            }
            ?>
            <button id="save_gads_finish" type="button" class="btn btn-primary px-5 ms-3 <?php esc_attr($isgsdisabled); ?>">
                <span class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <?php esc_html_e('Save & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
        </div>

    </div>
</div>

<!-- Create New Ads Account Modal -->
<div class="modal fade" id="conv_create_gads_new" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    <span id="before_gadsacccreated_title" class="before-ads-acc-creation"><?php esc_html_e("Enable Google Ads Account", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                    <span id="after_gadsacccreated_title" class="d-none after-ads-acc-creation"><?php esc_html_e("Account Created", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <span id="before_gadsacccreated_text" class="mb-1 lh-lg fs-6 before-ads-acc-creation">
                    <?php esc_html_e("You’ll receive an invite from Google on your email. Accept the invitation to enable your Google Ads Account.", "enhanced-e-commerce-for-woocommerce-store"); ?>
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
                                <a href="" target="_blank" id="ads_invitationLink"><?php esc_html_e("Invitation Link", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                            </span>
                        </li>
                        <li><?php esc_html_e("Log into your Google Ads account and set up your billing preferences", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                    </ol>
                </div>

            </div>
            <div class="modal-footer">
                <button id="ads-continue" class="btn conv-blue-bg m-auto text-white before-ads-acc-creation">
                    <span id="gadsinviteloader" class="spinner-border text-light spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <?php esc_html_e("Send Invite", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </button>

                <button id="ads-continue-close" class="btn btn-secondary m-auto text-white d-none after-ads-acc-creation" data-bs-dismiss="modal">
                    <?php esc_html_e("Ok, close", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </button>
            </div>
        </div>
    </div>
</div>



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
                                    <?php esc_html_e("Create Conversion id and label", "enhanced-e-commerce-for-woocommerce-store"); ?>
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
                    <?php esc_html_e("Save and Finish", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    <div class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Conversion creation edit popup end -->

<script>
    jQuery(function() {

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

        // Only for Bing
        jQuery('.convchkbox_setting').change(function() {
            this.value = (Number(this.checked));
        });

        if (jQuery("#microsoft_ads_pixel_id").val() == "") {
            jQuery("#msbing_conversion").attr('disabled', true);
            jQuery("#msbing_conversion").prop("checked", false);
            jQuery("#msbing_conversion").attr('checked', false);
        }

        jQuery("#microsoft_ads_pixel_id").change(function() {
            if (jQuery(this).hasClass('conv-border-danger') || jQuery(this).val() == "") {
                jQuery("#msbing_conversion").attr('disabled', true);
                jQuery("#msbing_conversion").prop("checked", false);
                jQuery("#msbing_conversion").attr('checked', false);
            } else {
                jQuery("#msbing_conversion").removeAttr('disabled');
            }
        });
    });
</script>

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
        jQuery("#ee_conversio_send_to_static").removeClass("conv-border-danger");
        jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled");
        jQuery(".conv-btn-connect").addClass("conv-btn-connect-enabled-google");
        jQuery(".conv-btn-connect").text('Save');

        //cleargadsconversions();

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
                        getAlertMessageAll(
                            'info',
                            'Error',
                            message = 'No Google Ads Account Found please create a new account by clicking on Create Now.',
                            icon = 'info',
                            buttonText = 'Ok',
                            buttonColor = '#FCCB1E',
                            iconImageSrc = '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                        );
                        //showtoastdynamically("There are no Google ads accounts associated with email.");
                    } else {
                        if (response.data.length > 0) {
                            var AccOptions = '';
                            var selected = '';
                            if (new_ads_id != "" && new_ads_id != undefined) {
                                AccOptions = AccOptions + '<option value="' + new_ads_id + '" selected>' + new_ads_id + '</option>';
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
                        }
                    }
                } else {
                    var error_msg = response.errors;
                    getAlertMessageAll(
                        'info',
                        'Error',
                        message = 'No Google Ads Account Found Please create a new account by clicking on Create Now.',
                        icon = 'info',
                        buttonText = 'Ok',
                        buttonColor = '#FCCB1E',
                        iconImageSrc = '<img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_error_logo.png'); ?>"/ >'
                    );
                }
                jQuery('#ads-account').prop('disabled', false);
                conv_change_loadingbar_popup("hide");
                conv_change_loadingbar("hide");
            }

        });

        <?php if ($google_ads_id != "") { ?>
            jQuery("#conv_conversion_select").trigger("change");
        <?php } ?>


    }


    // Create new gads acc function
    function create_google_ads_account(tvc_data) {
        var conversios_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>";
        var error_msg = 'null';
        var btn_cam = 'create_new';
        var ename = 'conversios_onboarding';
        var event_label = 'ads';
        //user_tracking_data(btn_cam, error_msg,ename,event_label);
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "create_google_ads_account",
                tvc_data: tvc_data,
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
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

    //Onload functions
    jQuery(function() {
        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        var tvc_ajax_url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        let subscription_id = "<?php echo esc_attr($subscriptionId); ?>";
        let plan_id = "<?php echo esc_attr($plan_id); ?>";
        let app_id = "<?php echo esc_attr($app_id); ?>";
        let bagdeVal = "yes";
        let convBadgeVal = "<?php echo esc_attr($convBadgeVal); ?>";

        jQuery(".selecttwo").select2({
            minimumResultsForSearch: -1,
            placeholder: function() {
                jQuery(this).data('placeholder');
            }
        });


        <?php if ($cust_g_email == "") { ?>
            jQuery("#conv_create_gads_new_btn").addClass("disabled");
            jQuery(".conv-enable-selection, .conv-enable-selection_cli").addClass("d-none");
            jQuery('.event-setting-row').addClass("convdisabledbox")
        <?php } ?>

        <?php if ((isset($cust_g_email) && $cust_g_email != "")) { ?>
            jQuery('.pawizard_tab_but').on('shown.bs.tab', function(e) {
                if (jQuery(e.target).attr('aria-controls') == "webadsbox") {
                    list_google_ads_account(tvc_data);
                }
            });
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
            changeTabBox("webgmcbox-tab");

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
                    save_webadsdata();
                    conv_change_loadingbar("hide");
                }
            });
        };

        // Create new gads acc
        jQuery("#ads-continue").on('click', function(e) {
            e.preventDefault();
            create_google_ads_account(tvc_data);
            //cleargadsconversions();
            jQuery('.ggladspp').removeClass('showpopup');
        });

        jQuery('#conv_con_modal').modal({
            backdrop: 'static',
            keyboard: false
        })

        jQuery(".conv_con_modal_opener").click(function() {
            jQuery("#gadssetings_form").addClass("formchanged_webads");
            var conversion_name = jQuery(this).attr("conversion_name");
            if (conversion_name == "PURCHASE") {
                jQuery("#enhmsg").removeClass("d-none");
            }

            conversion_title_arr = {
                ADD_TO_CART: "Setup Conversion tracking for Add To Cart",
                BEGIN_CHECKOUT: "Setup Conversion tracking for Begin Checkout",
                PURCHASE: "Setup Conversion tracking for Purchase",
                SUBMIT_LEAD_FORM: "Setup Conversion tracking for Submit Lead Form",
            }

            conversion_label_arr = {
                ADD_TO_CART: "Select conversion id and label from below",
                BEGIN_CHECKOUT: "Select conversion id and label from below",
                PURCHASE: "Select conversion id and label from below",
                SUBMIT_LEAD_FORM: "Select conversion id and label from below",
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

                    if (conversion_category == "ADD_TO_CART") {
                        jQuery("input[name='COV - GAds - AddToCart - Conversion']").prop('checked', true);
                    } else if (conversion_category == "BEGIN_CHECKOUT") {
                        jQuery("input[name='COV - GAds - BeginCheckout - Conversion']").prop('checked', true);
                    } else if (conversion_category == "SUBMIT_LEAD_FORM") {
                        jQuery("input[name='COV - GAds - Form Submit - Conversion']").prop('checked', true);
                    } else {
                        jQuery("input[name='COV - Google Ads Conversion Tracking Purchase']").prop('checked', true);
                        jQuery("input[name='COV - Google ads dynamic remarketing purchase']").prop('checked', true)
                    }

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
                    subscription_id: "<?php echo esc_attr($subscriptionId); ?>",
                    CONVNonce: "<?php echo esc_js(wp_create_nonce('conv_checkMcc-nonce')); ?>"
                };
                jQuery.ajax({
                    type: "POST",
                    url: tvc_ajax_url,
                    data: data,
                    success: function(response) {
                        var newResponse = JSON.parse(response);
                        if (newResponse.status == 200 && newResponse?.data[0] != "") {
                            var managerStatus = newResponse.data[0]?.managerStatus;
                            if (managerStatus) { //mcc true
                                //console.log("mcc is there");
                                jQuery("#conv_mcc_alert").removeClass("d-none");
                                jQuery("#google_ads_id").val('').trigger('change');
                                jQuery("#save_gads_finish").addClass("disabledsection");
                            } else {
                                jQuery("#save_gads_finish").removeClass("disabledsection");
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