<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

$TVC_Admin_Helper = new TVC_Admin_Helper();
$ee_additional_data = $TVC_Admin_Helper->get_ee_additional_data();
$tvc_data = $TVC_Admin_Helper->get_store_data();
if ((isset($_GET['g_mail']) && sanitize_text_field(wp_unslash($_GET['g_mail']))) && (isset($_GET['subscription_id']) && sanitize_text_field(wp_unslash($_GET['subscription_id'])))) {
    if (isset($_GET['wizard_channel']) && sanitize_text_field(wp_unslash($_GET['wizard_channel'])) == "gtmsettings") {
        update_option('ee_customer_gtm_gmail', sanitize_email(wp_unslash($_GET['g_mail'])));
        $red_url = 'admin.php?page=conversios&wizard=pixelandanalytics';
        //header("Location: ".$red_url);
    }

    if (isset($_GET['wizard_channel']) && (sanitize_text_field(wp_unslash($_GET['wizard_channel'])) == "gasettings" || sanitize_text_field(wp_unslash($_GET['wizard_channel'])) == "gadssettings")) {
        update_option('ee_customer_gmail', sanitize_email(wp_unslash($_GET['g_mail'])));  
            $eeapidata = unserialize(get_option('ee_api_data'));
            $eeapidata_settings = new stdClass();
        //is not work for existing user && $ee_additional_data['con_created_at'] != "" 
        if (isset($ee_additional_data['con_created_at'])) {
            $ee_additional_data = $TVC_Admin_Helper->get_ee_additional_data();
            $ee_additional_data['con_updated_at'] = gmdate('Y-m-d');
            $TVC_Admin_Helper->set_ee_additional_data($ee_additional_data);
        } else {
            $ee_additional_data = $TVC_Admin_Helper->get_ee_additional_data();
            $ee_additional_data['con_created_at'] = gmdate('Y-m-d');
            $ee_additional_data['con_updated_at'] = gmdate('Y-m-d');
            $TVC_Admin_Helper->set_ee_additional_data($ee_additional_data);
        }
    }
}



$ee_options = unserialize(get_option("ee_options"));
$ee_api_data_all = unserialize(get_option("ee_api_data"));
$ee_api_data = $ee_api_data_all['setting'];
$plan_id = $ee_api_data->plan_id;
$store_id = $ee_api_data->store_id;

// From gtm file
$g_gtm_email = get_option('ee_customer_gtm_gmail');
// perform validation on the user email
$g_gtm_email =  ($g_gtm_email != '') ? $g_gtm_email : "";
$stepCls = $g_gtm_email != "" ? "" : "stepper-conv-bg-grey";
$disableTextCls = $g_gtm_email != "" ? "" : "conv-link-disabled";
$select2Disabled = $g_gtm_email != "" ? "" : "disabled";

$gtm_account_id = isset($ee_options['gtm_settings']['gtm_account_id']) ? $ee_options['gtm_settings']['gtm_account_id'] : "";
$gtm_container_id = isset($ee_options['gtm_settings']['gtm_container_id']) ? $ee_options['gtm_settings']['gtm_container_id'] : "";
$gtm_container_publicId = isset($ee_options['gtm_settings']['gtm_public_id']) ? $ee_options['gtm_settings']['gtm_public_id'] : "";
$gtm_account_container_name = isset($ee_options['gtm_settings']['gtm_account_container_name']) ? $ee_options['gtm_settings']['gtm_account_container_name'] : "";
$is_gtm_automatic_process = isset($ee_options['gtm_settings']['is_gtm_automatic_process']) ? $ee_options['gtm_settings']['is_gtm_automatic_process'] : false;
$automation_status =  isset($ee_options['gtm_settings']['status']) ? $ee_options['gtm_settings']['status'] : "";

$selectedGtmEvents = isset($ee_options['gtm_channel_settings']) ? $ee_options['gtm_channel_settings'] : [];

// From single pixel main
$googleDetail = $ee_api_data;
$tracking_option = "UA";
$login_customer_id = "";

$customApiObj = new CustomApi();
$app_id = 1;
//get user data
$ee_options = $TVC_Admin_Helper->get_ee_options_settings();

$get_ee_options_data = $TVC_Admin_Helper->get_ee_options_data();

$subscriptionId =  $ee_options['subscription_id'];

$url = $TVC_Admin_Helper->get_onboarding_page_url();
$is_refresh_token_expire = false; //$TVC_Admin_Helper->is_refresh_token_expire();

//get badge settings
$convBadgeVal = isset($ee_options['conv_show_badge']) ? $ee_options['conv_show_badge'] : "";
$convBadgePositionVal = isset($ee_options['conv_badge_position']) ? $ee_options['conv_badge_position'] : "";

//check last login for check RefreshToken
$g_mail = get_option('ee_customer_gmail');
$cust_g_email = $g_mail;
$tvc_data['g_mail'] = "";
if ($g_mail) {
    $tvc_data['g_mail'] = sanitize_email($g_mail);
}

// for microsoft
$microsoft_mail = get_option('ee_customer_msmail');
$cust_ms_email = $microsoft_mail;
$tvc_data['microsoft_mail'] = "";
if ($microsoft_mail) {
    $tvc_data['microsoft_mail'] = sanitize_email($microsoft_mail);
}




$TVC_Admin_Helper = new TVC_Admin_Helper();

//get account settings from the api
if ($subscriptionId != "") {
    $google_detail = $customApiObj->getGoogleAnalyticDetail($subscriptionId);
    if (property_exists($google_detail, "error") && $google_detail->error == false) {
        if (property_exists($google_detail, "data") && $google_detail->data != "") {
            $googleDetail = $google_detail->data;
            $tvc_data['subscription_id'] = $googleDetail->id;
            $plan_id = $googleDetail->plan_id;
            $login_customer_id = $googleDetail->customer_id;
            $tracking_option = $googleDetail->tracking_option;
            if ($googleDetail->tracking_option != '') {
                $defaulSelection = 0;
            }
        }
    }
}
$pixelprogressbarclass = [18];
$conv_onboarding_done_step = (isset($ee_options["conv_onboarding_done_step"]) && $ee_options["conv_onboarding_done_step"] != "") ? $ee_options["conv_onboarding_done_step"] : "";;

$is_domain_claim = "";
if (isset($googleDetail->is_domain_claim) === TRUE) {
    $is_domain_claim = esc_attr($googleDetail->is_domain_claim);
}

$is_site_verified = "";
if (isset($googleDetail->is_site_verified) === TRUE) {
    $is_site_verified = esc_attr($googleDetail->is_site_verified);
}
?>
<style>
    #conversioshead,
    #conversioshead_notice {
        display: none;
    }

    .progressinfo {
        text-align: right;
        font-size: 12px;
        line-height: 16px;
        color: #515151;
        margin-top: 9px;
    }

    .progress {
        display: -ms-flexbox;
        display: flex;
        height: 10px;
        overflow: hidden;
        line-height: 0;
        background-color: #F3F3F3;
        border-radius: 100px;
    }

    .progress-bar {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        overflow: hidden;
        color: #fff;
        text-align: left;
        padding-left: 24px;
        white-space: nowrap;
        background: #09BD83;
        transition: width 0.6s ease;
        border-radius: 100px;
    }

    .conv-border-box {
        border: 1px solid #ccc;
        border-radius: 12px;
        box-shadow: 0px 0px 4px #ccc;
        padding: 15px;
        margin: 0px;
    }
</style>
<script>
    function conv_change_loadingbar(state = 'show') {
        if (state === 'show') {
            jQuery("#loadingbar_blue").removeClass('d-none');
            jQuery("#wpbody").css("pointer-events", "none");
            jQuery("#convwizard_main").addClass("disabledopc");
        } else {
            jQuery("#loadingbar_blue").addClass('d-none');
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery("#convwizard_main").removeClass("disabledopc");
        }
    }

    function conv_change_loadingbar_popup(state = 'show') {
        if (state === 'show') {
            setTimeout(function() {
                jQuery(".modal.show").find(".topfull_loader").removeClass('d-none');
                jQuery(".modal:visible").find(".modal-content").css("pointer-events", "none");
            }, 1000);
        } else {
            jQuery(".modal:visible").find(".topfull_loader").addClass('d-none');
            jQuery(".modal:visible").find(".modal-content").css("pointer-events", "auto");
        }
    }

    function showtoastdynamically(content) {
        jQuery("#dynamictoastbody").html(content);
        jQuery('.toast').toast('show');
    }


    function getAlertMessageAll(type = 'Success', title = 'Success', message = '', icon = 'success', buttonText = 'Done!', buttonColor = '#1967D2', iconImageTag = '') {
        Swal.fire({
            type: type,
            icon: icon,
            title: title,
            confirmButtonText: buttonText,
            confirmButtonColor: buttonColor,
            text: message,
        })
        let swalContainer = Swal.getContainer();
        jQuery(swalContainer).find('.swal2-icon-show').removeClass('swal2-' + icon).removeClass('swal2-icon')
        jQuery('.swal2-icon-show').html(iconImageTag)

    }
</script>

<div aria-live="polite" aria-atomic="true" class="bg-dark position-relative bd-example-toasts">
    <div id="convdynamictoast" class="toast-container position-absolute p-3 top-0 end-0" id="toastPlacement">
        <div class="toast text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Oops</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="dynamictoastbody" class="toast-body"></div>
        </div>
    </div>
</div>



<div id="convwizard_main" class="container container-old conv-container conv-setting-container">
    <div class="row">

        <div class="mx-auto convcard p-0 mt-0 rounded-3 shadow-lg mt-1" style="max-width: 1072px;">
            <div id="loadingbar_blue" class="progress-materializecss d-none ps-2 pe-2 w-100 topfull_loader">
                <div class="indeterminate"></div>
            </div>
            <ul class="nav nav-tabs border-0 p-3 pb-0 w-100 pt-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="d-inline-flex align-items-center pawizard_tab_but nav-link" id="webpixbox-tab" data-bs-toggle="tab" data-bs-target="#webpixbox" type="button" role="tab" aria-controls="webpixbox" aria-selected="false">
                        <h5 class="text-start m-0 ps-1 d-flex align-items-center">
                            <div class="convdott me-1"></div>
                            <?php esc_html_e("Google Analytics", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="d-inline-flex align-items-center pawizard_tab_but nav-link" id="webadsbox-tab" data-bs-toggle="tab" data-bs-target="#webadsbox" type="button" role="tab" aria-controls="webadsbox" aria-selected="false">
                        <h5 class="text-start m-0 ps-1 d-flex align-items-center">
                            <div class="convdott d-none  me-1"></div>
                            <?php esc_html_e("Google Ads", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="d-inline-flex align-items-center pawizard_tab_but nav-link" id="webgmcbox-tab" data-bs-toggle="tab" data-bs-target="#webgmcbox" type="button" role="tab" aria-controls="webgmcbox" aria-selected="false">
                        <h5 class="text-start m-0 ps-1 d-flex align-items-center">
                            <div class="convdott d-none  me-1"></div>
                            <?php esc_html_e("Google Merchant Center", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="d-inline-flex align-items-center pawizard_tab_but nav-link" id="webfbbox-tab" data-bs-toggle="tab" data-bs-target="#webfbbox" type="button" role="tab" aria-controls="webfbbox" aria-selected="false">
                        <h5 class="text-start m-0 ps-1 d-flex align-items-center">
                            <div class="convdott d-none  me-1"></div>
                            <?php esc_html_e("Meta (Facebook) Pixels", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="d-inline-flex align-items-center pawizard_tab_but nav-link" id="webotherbox-tab" data-bs-toggle="tab" data-bs-target="#webotherbox" type="button" role="tab" aria-controls="webotherbox" aria-selected="false">
                        <h5 class="text-start m-0 ps-1 d-flex align-items-center">
                            <div class="convdott d-none  me-1"></div>
                            <?php esc_html_e("Other Pixels", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                    </button>
                </li>

                <li class="nav-item nav-item ms-auto d-flex align-content-center" role="presentation">
                    <div>
                        <div class="text-center d-none">Need Help?</div>
                        <a target="_blank" href="https://calendly.com/conversios/30min" class="btn border-0 p-0">
                            <span class="material-symbols-outlined">
                                headset_mic
                            </span>
                        </a>
                        <a target="_blank" href="https://conversios.freshdesk.com/support/tickets/new" class="btn border-0 p-0 px-3">
                            <span class="material-symbols-outlined">
                                chat
                            </span>
                        </a>
                    </div>

                    <div class="convexitwizard btn btn-outline-dark btn-sm" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#exitwizardconvmodal">
                        <?php esc_html_e("Exit Wizard", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </div>
                </li>

            </ul>

            <div class="tab-content p-3 pt-0" id="myTabContent">
                <div class="progress">
                    <div class="progress-bar w-<?php echo esc_attr(array_sum($pixelprogressbarclass)); ?>" style="width:<?php echo esc_attr(array_sum($pixelprogressbarclass)); ?>%" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="tab-pane fade show active" id="webpixbox" role="tabpanel" aria-labelledby="webpixbox-tab">
                    <?php require_once("wizardsettings/gasettings.php"); ?>
                </div>
                <div class="tab-pane fade" id="webadsbox" role="tabpanel" aria-labelledby="webadsbox-tab">
                    <?php require_once("wizardsettings/gadssettings.php"); ?>
                </div>
                <div class="tab-pane fade" id="webgmcbox" role="tabpanel" aria-labelledby="webgmcbox-tab">
                    <?php require_once("wizardsettings/gmcsettings.php"); ?>
                </div>
                <div class="tab-pane fade" id="webfbbox" role="tabpanel" aria-labelledby="webfbbox-tab">
                    <?php require_once("wizardsettings/fbsettings.php"); ?>
                </div>
                <div class="tab-pane fade" id="webotherbox" role="tabpanel" aria-labelledby="webotherbox-tab">
                    <?php require_once("wizardsettings/otherpixsettings.php"); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Exit Wizard modal -->
<div class="modal fade" id="exitwizardconvmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3">
                <p class="m-4 text-center h5"><?php esc_html_e("Are you sure you want to exit the setup?", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
            </div>
            <div class="modal-footer p-4">
                <div class="m-auto">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        <?php esc_html_e("Continue Setup", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                    <a href="<?php echo esc_url('admin.php?page=conversios-google-analytics'); ?>" class="btn btn-primary">
                        <?php esc_html_e("Exit Wizard", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Exit wizard modal End -->

<!-- Change GAuth modal -->
<div class="modal fade" id="conv_wizchangeauth" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="conv_wizchangeauth" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 h5"><?php esc_html_e("Would you like to switch the Google account?", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
            </div>
            <div class="modal-body p-3">
                <p class="m-4 text-center"><?php esc_html_e("This will reset your Google account for Google Analytics, Google Ads, and Google Merchant Center.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
            </div>
            <div class="modal-footer p-4">
                <div class="m-auto">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        <?php esc_html_e("Continue Setup", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                    <button id="conv_wizauthbtn" type="button" class="btn btn-primary" style="bacground:#1967D2 !important">
                        <?php esc_html_e("Switch Google Account", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Change GAuth modal End -->

<!-- Modal -->
<div class="modal fade" id="conv_wizfinish" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="conv_wizfinish" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div id="conv_wizfinish_right" class="col-12 py-3 px-4 text-center">
                            <span class="material-symbols-outlined conv-success-check-big">
                                check_circle
                            </span>
                            <h3 class="fw-light h2" style="color:#09bd3a;">Congratulations!!</h3>
                            <h6>Your tracking is now live and data flowing in real time. <br> Reports and insights will be available within the next 24 hours.</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <a href="<?php echo esc_url('admin.php?page=conversios-analytics-reports'); ?>" class="btn btn-secondary d-flex btn-sm">
                    Close
                </a>
                <?php if (CONV_IS_WC) { ?>
                    <a id="aftersetupurlblue" href="<?php echo esc_url('admin.php?page=conversios-google-shopping-feed&tab=gaa_config_page'); ?>" class="aftersetupurl btn btn-primary d-flex btn-sm">
                        Connect Google Merchant Account Now
                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>
                    </a>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- Google Sign In -->



<?php
//echo '<pre>'; print_r($ee_options); echo '</pre>';
$connect_url_gagads = $tvs_admin->get_custom_connect_url_wizard(admin_url() . 'admin.php?page=conversios&wizard=pixelandanalytics_gasettings');
$connect_url_gaa = $tvs_admin->get_custom_connect_url_wizard(admin_url() . 'admin.php?page=conversios&wizard=pixelandanalytics_gasettings');
$connect_url_gadss = $tvs_admin->get_custom_connect_url_wizard(admin_url() . 'admin.php?page=conversios&wizard=pixelandanalytics_gadssettings');
require_once ENHANCAD_PLUGIN_DIR . 'admin/partials/singlepixelsettings/googlesigninforga.php';
?>

<script>
    function changeTabBox(tbaname = "webpixbox-tab") {
        jQuery("#" + tbaname).tab('show');
        window.scrollTo(0, 0);
    }

    jQuery(function() {

        // FreshworksWidget('hide');

        <?php if (!isset($_GET['wizard_channel'])) { ?>
            var conv_onboarding_done_step = "<?php echo esc_js($conv_onboarding_done_step) ?>";
            //console.log(conv_onboarding_done_step);
            if (conv_onboarding_done_step == 1) {
                changeTabBox("webpixbox-tab");
            }
            if (conv_onboarding_done_step == 2) {
                changeTabBox("webadsbox-tab");
            }
            if (conv_onboarding_done_step == 3) {
                changeTabBox("webgmcbox-tab");
            }
            if (conv_onboarding_done_step == 4) {
                changeTabBox("webfbbox-tab");
            }
            if (conv_onboarding_done_step == 5 || conv_onboarding_done_step == 6) {
                changeTabBox("webotherbox-tab");
            }
        <?php } ?>

        <?php if ($cust_g_email == "") { ?>
            jQuery("#save_gahotclcr, #save_gads_finish").addClass("disabledsection");
        <?php } ?>

        if (jQuery("#ga4_property_id").val() == "") {
            jQuery("#save_gahotclcr").addClass("disabledsection");
        }

        jQuery(document).on("click", "#conv_wizauthbtn", function() {
            jQuery("#conv_wizchangeauth").modal("hide");
            jQuery(".tvc_google_signinbtn_ga").click();
        });

        jQuery(document).on("click", ".conv_change_gauth", function() {
            jQuery("#conv_wizchangeauth").modal("show");
            //changeTabBox("webpixbox-tab");
        });

        var conv_bodywid = jQuery("body").outerWidth();
        // if (conv_bodywid <= 1367) {
        //     jQuery("#conv_wizfinish .modal-dialog").removeClass("modal-dialog-centered");
        // } else {
        //     jQuery("#conv_wizfinish .modal-dialog").addClass("modal-dialog-centered");
        // }

        var tabhash = location.hash.replace(/^#/, ''); // ^ means starting, meaning only match the first hash
        if (tabhash) {
            changeTabBox(tabhash);
        }
        <?php if (isset($_GET['wizard_channel']) && $_GET['wizard_channel'] == "gtmsettings") { ?>
            changeTabBox("webpixbox-tab");
        <?php } else if (isset($_GET['wizard_channel']) && $_GET['wizard_channel'] == "gasettings") { ?>
            changeTabBox("webpixbox-tab");
        <?php } else if (isset($_GET['wizard_channel']) && $_GET['wizard_channel'] == "gadssettings") { ?>
            changeTabBox("webadsbox-tab");
        <?php } else if ($conv_onboarding_done_step == "") { ?>
            changeTabBox("webpixbox-tab");
        <?php } ?>

        jQuery(".conv-enable-selection_comman").click(function() {
            jQuery(this).parent().find("input").removeAttr("readonly")
            jQuery(this).parent().find("textarea").removeAttr("readonly")
        });

        //For tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        jQuery(".gtmautotabs button").click(function() {
            if (jQuery("#nav-automatic-tab").hasClass('active')) {
                is_gtm_automatic_process = true;
            } else {
                is_gtm_automatic_process = false;
            }
        });
        jQuery('#convdynamictoast').on('hide.bs.modal', function() {
            jQuery("#dynamictoastbody").html("");
        });
        <?php if ($selectedGtmEvents != true || $is_gtm_automatic_process != "true") { ?>
            jQuery(".event-setting-row").addClass("convdisabledbox");
        <?php } ?>

        jQuery(".event-setting-row").addClass("disabledsection");

        jQuery(".event-setting-row").each(function() {
            jQuery(this).find(".item").each(function() {
                let inpid = jQuery(this).find("input").attr("id");
                jQuery(this).find("label").attr("for", inpid);
            });
        });

        jQuery(".col-md-4 span[data-bs-toggle='tooltip']").addClass("d-flex align-items-center");

        jQuery('#starttrackingbut_wizard').click(function() {
            jQuery('#starttrackingbut_wizard').addClass('convdisabledbox');
            var ecrandomstring = "<?php echo esc_js($TVC_Admin_Helper->generateRandomStringConv()); ?>";
            var subscription_id = "<?php echo esc_js($subscriptionId); ?>";
            var fronturl = '<?php echo esc_url(site_url()); ?>?is_calc_on=1&ec_token=' + ecrandomstring;
            // console.log(fronturl);
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "conv_create_ec_row",
                    pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                    ecrandomstring: ecrandomstring,
                    subscription_id: subscription_id
                },
                success: function(response) {
                    window.open(fronturl, '_blank');
                    location.href = "<?php echo esc_url('admin.php?page=conversios'); ?>";
                }
            });
        });

        jQuery('.pawizard_tab_but').on('shown.bs.tab', function(e) {
            jQuery(".convexitwizard").removeClass('d-none');
            jQuery(".convdott").addClass('d-none');
            jQuery(".pawizard_tab_but.active .convdott").removeClass('d-none');

            if (jQuery("#ga4_property_id").val() == "") {
                jQuery("#link_google_analytics_with_google_ads").attr("disabled", true);
                jQuery("#save_gahotclcr").addClass('disabledsection');
            }

            if (jQuery("#google_ads_id").val() == "") {
                jQuery("#save_gads_finish").addClass('disabledsection');
            }

            if (jQuery(e.target).attr('aria-controls') == "webpixbox") {
                jQuery("#webpixbox-tab").addClass("convtab_blue");
                jQuery("#myTabContent").find(".progress-bar").css("width", "15%");
                jQuery(".convexitwizard").addClass('d-none');
            }
            if (jQuery(e.target).attr('aria-controls') == "webadsbox") {
                jQuery("#webpixbox-tab, #webpixbox-tab").addClass("convtab_blue");
                jQuery("#myTabContent").find(".progress-bar").css("width", "25%");
                jQuery(".convexitwizard").addClass('d-none');
            }
            if (jQuery(e.target).attr('aria-controls') == "webgmcbox") {
                jQuery("#webpixbox-tab, #webpixbox-tab, #webadsbox-tab").addClass("convtab_blue");
                jQuery("#myTabContent").find(".progress-bar").css("width", "44%");
            }
            if (jQuery(e.target).attr('aria-controls') == "webfbbox") {
                jQuery("#webpixbox-tab, #webpixbox-tab, #webadsbox-tab, #webgmcbox-tab").addClass("convtab_blue");
                jQuery("#myTabContent").find(".progress-bar").css("width", "61%");
            }

            if (jQuery(e.target).attr('aria-controls') == "webotherbox") {
                jQuery("#webpixbox-tab, #webpixbox-tab, #webadsbox-tab, #webgmcbox-tab").addClass("convtab_blue");
                jQuery("#myTabContent").find(".progress-bar").css("width", "61%");
            }

        });

        jQuery(document).on("change", "#google_ads_id", function() {
            var remarketing_tags = '<?php echo isset($googleDetail->remarketing_tags) ? esc_js($googleDetail->remarketing_tags) : "notset"; ?>';
            var dynamic_remarketing_tags = '<?php echo isset($googleDetail->dynamic_remarketing_tags) ? esc_js($googleDetail->dynamic_remarketing_tags) : "notset"; ?>';
            var link_google_analytics_with_google_ads = '<?php echo isset($googleDetail->link_google_analytics_with_google_ads) ? esc_js($googleDetail->link_google_analytics_with_google_ads) : "notset"; ?>';
            jQuery("#remarketing_tags").prop('checked', true);
            jQuery("#dynamic_remarketing_tags").prop('checked', true);

            if (jQuery("#ga4_property_id").val() != "") {
                jQuery("#link_google_analytics_with_google_ads").removeAttr("disabled");
                jQuery("#link_google_analytics_with_google_ads").prop('checked', true);
            }
        });

        jQuery(document).on("click", "#ads-continue-close", function() {
            jQuery("#gadsConversionAcco .accordion-body").removeClass("disabledsection");
            if (jQuery("#ga4_property_id").val() == "") {
                jQuery("#link_google_analytics_with_google_ads").attr("disabled", true);
                jQuery("#ga_GMC").attr("disabled", true);
            } else {
                jQuery("#link_google_analytics_with_google_ads").removeClass("disabled");
                jQuery("#ga_GMC").removeClass("disabled");

                jQuery("#remarketing_tags").prop('checked', true);
                jQuery("#dynamic_remarketing_tags").prop('checked', true);

                if (jQuery("#ga4_property_id").val() != "") {
                    jQuery("#link_google_analytics_with_google_ads").removeAttr("disabled");
                    jQuery("#link_google_analytics_with_google_ads").prop('checked', true);
                }
            }
        });

    });
</script>