<?php

/**
 * Wizard Pixel and Analytics Settings
 *
 * @package Enhanced_Ecommerce_For_Woocommerce_Store
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$tvc_admin_helper = new TVC_Admin_Helper();
$custom_api_obj = new CustomApi();
$ee_additional_data = $tvc_admin_helper->get_ee_additional_data();
$tvc_data = $tvc_admin_helper->get_store_data();
$is_refresh_token_expire = false;
if ((isset($_GET['g_mail']) && sanitize_text_field(wp_unslash($_GET['g_mail']))) && (isset($_GET['subscription_id']) && sanitize_text_field(wp_unslash($_GET['subscription_id'])))) {
    if (isset($_GET['wizard_channel']) && sanitize_text_field(wp_unslash($_GET['wizard_channel'])) == 'gtmsettings') {
        update_option('ee_customer_gtm_gmail', sanitize_email(wp_unslash($_GET['g_mail'])));
        $red_url = 'admin.php?page=conversios&wizard=pixelandanalytics';
        // header( 'Location: ' . $red_url );
    }

    if (isset($_GET['wizard_channel']) && (sanitize_text_field(wp_unslash($_GET['wizard_channel'])) == 'gasettings' || sanitize_text_field(wp_unslash($_GET['wizard_channel'])) == 'gadssettings')) {
        update_option('ee_customer_gmail', sanitize_email(wp_unslash($_GET['g_mail'])));
        $eeapidata = maybe_unserialize(get_option('ee_api_data'));
        $eeapidata_settings = new stdClass();
        // Is not work for existing user && $ee_additional_data['con_created_at'] != ''.
        if (isset($ee_additional_data['con_created_at'])) {
            $ee_additional_data = $tvc_admin_helper->get_ee_additional_data();
            $ee_additional_data['con_updated_at'] = gmdate('Y-m-d');
            $tvc_admin_helper->set_ee_additional_data($ee_additional_data);
        } else {
            $ee_additional_data = $tvc_admin_helper->get_ee_additional_data();
            $ee_additional_data['con_created_at'] = gmdate('Y-m-d');
            $ee_additional_data['con_updated_at'] = gmdate('Y-m-d');
            $tvc_admin_helper->set_ee_additional_data($ee_additional_data);
        }
    }
}

$ee_options = maybe_unserialize(get_option('ee_options'));
$ee_api_data_all = maybe_unserialize(get_option('ee_api_data'));
$ee_api_data = $ee_api_data_all['setting'];

$plan_id = $ee_api_data->plan_id;
$store_id = $ee_api_data->store_id;


// From single pixel main.
$google_detail = $ee_api_data;
$tracking_option = '';
$login_customer_id = '';

$app_id = 1;
// Get user data.
$ee_options = $tvc_admin_helper->get_ee_options_settings();
$get_ee_options_data = $tvc_admin_helper->get_ee_options_data();
$subscription_id = $ee_options['subscription_id'];

// Check last login for check RefreshToken.
$g_mail = get_option('ee_customer_gmail');
$cust_g_email = $g_mail;
$tvc_data['g_mail'] = '';
if ($g_mail) {
    $tvc_data['g_mail'] = sanitize_email($g_mail);
}

// For microsoft.
$microsoft_mail = get_option('ee_customer_msmail');
$cust_ms_email = $microsoft_mail;
$tvc_data['microsoft_mail'] = '';
if ($microsoft_mail) {
    $tvc_data['microsoft_mail'] = sanitize_email($microsoft_mail);
}

$is_sel_disable_ga = 'disabled';
$cust_g_email = (isset($tvc_data['g_mail']) && esc_attr($subscription_id)) ? esc_attr($tvc_data['g_mail']) : '';
$tracking_method = (isset($ee_options['tracking_method']) && '' != $ee_options['tracking_method']) ? $ee_options['tracking_method'] : '';

global $wp_filesystem;

// Get account settings from the api.
if ('' != $subscription_id) {
    $google_detail = $custom_api_obj->getGoogleAnalyticDetail($subscription_id);
    if (property_exists($google_detail, 'error') && false == $google_detail->error) {
        if (property_exists($google_detail, 'data') && '' != $google_detail->data) {
            $google_detail = $google_detail->data;
            $tvc_data['subscription_id'] = $google_detail->id;
            $plan_id = $google_detail->plan_id;
            $login_customer_id = $google_detail->customer_id;
            $tracking_option = $google_detail->tracking_option;
            if ('' != $google_detail->tracking_option) {
                $defaul_selection = 0;
            }
        }
    }
}

$pixel_progress_bar_class = array(18);
$conv_onboarding_done_step = (isset($ee_options['conv_onboarding_done_step']) && '' != $ee_options['conv_onboarding_done_step']) ? $ee_options['conv_onboarding_done_step'] : '';

$is_domain_claim = '';
if (isset($google_detail->is_domain_claim) === true) {
    $is_domain_claim = esc_attr($google_detail->is_domain_claim);
}

$is_site_verified = '';
if (isset($google_detail->is_site_verified) === true) {
    $is_site_verified = esc_attr($google_detail->is_site_verified);
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

    .conv-border-box {
        border: 1px solid #ccc;
        border-radius: 12px;
        box-shadow: 0px 0px 4px #ccc;
        padding: 15px;
        margin: 0px;
    }

    /* CONWIZ SLIDER CSS */
    .conwiz_slide-container {
        max-width: 1200px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        position: relative;
        animation: fadeInUp 0.8s ease-in-out;
        padding-bottom: 1rem;
    }

    .conwiz_slide-inner {
        display: flex;
        height: 500px;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .conwiz_progress-bar {
        position: absolute;
        top: 0;
        left: 0;
        height: 5px;
        width: 0;
        background-color: #444444;
        animation: progressSlide 10s linear forwards;
        z-index: 10;
    }

    @keyframes progressSlide {
        from {
            width: 0%;
        }

        to {
            width: 100%;
        }
    }

    .conwiz_left-buttons {
        width: 285px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1rem;
        gap: 1rem;
        background: #fff;
    }

    .conwiz_slide-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        color: #444444;
        font-weight: 600;
        border-radius: 30px;
        padding: 10px 20px;
        border: 2px solid #444444;
        cursor: pointer;
        height: 50px;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .conwiz_slide-btn:hover {
        background-color: #f1f1f1;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .conwiz_slide-btn.conwiz_btn-purple {
        background-color: #444444;
        color: #fff;
    }

    .conwiz_middle-image {
        width: 45%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        animation: fadeIn 1s ease-in-out;
    }

    .conwiz_middle-image img {
        max-width: 100%;
        /* max-height: 400px; */
        object-fit: contain;
    }

    .conwiz_right-text {
        width: 35%;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        animation: fadeIn 1s ease-in-out;
    }

    .conwiz_right-text h3 {
        font-weight: 700;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .conwiz_google-auth-row {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1.25rem 2rem 0.5rem;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
        margin-bottom: 3rem;
    }

    .google-auth-btn-highlighted {
        background-color: #4285f4;
        color: #fff;
        font-weight: 600;
        font-size: 16px;
        padding: 12px 24px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        border: none;
        box-shadow: 0 4px 10px rgba(66, 133, 244, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .google-auth-btn-highlighted img {
        width: 22px;
        height: 22px;
        margin-right: 12px;
    }

    .google-auth-btn-highlighted:hover {
        background-color: #3367d6;
        box-shadow: 0 6px 14px rgba(66, 133, 244, 0.4);
        text-decoration: none;
        color: #fff;
    }

    .google-auth-benefits {
        font-size: 17px;
        color: #444444;
        text-align: left;
        line-height: 1.4;
    }

    /* CONVWIZ Accordio CSS */
    .conwizaccord_accordion {
        width: 100%;
        font-family: Arial, sans-serif;
    }

    .conwizaccord_item {
        margin-bottom: 10px;
    }

    .conwizaccord_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        cursor: pointer;
    }

    .conwizaccord_logo-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .conwizaccord_logo {
        width: 24px;
        height: 24px;
    }

    .conwizaccord_title {
        font-weight: bold;
        font-size: 16px;
    }

    .conwizaccord_icon {
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .conwizaccord_body {
        display: none;
        padding: 10px 0;
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

        <?php
        $g_email = (isset($tvc_data['g_mail']) && esc_attr($subscription_id)) ? esc_attr($tvc_data['g_mail']) : "";
        if ($g_email === "") {
        ?>
            <div id="conwizwrapper" class="mx-auto mt-1" style="max-width: 1200px;">
                <!-- CONWIZ -->
                <div class="conwiz_slide-container">
                    <div class="conwiz_progress-bar" id="conwiz_progress"></div>

                    <!-- Google Auth Button + CTA -->
                    <div class="conwiz_google-auth-row">
                        <div class="google-auth-benefits">
                            Track traffic, analyze behavior, and optimize with Google Analytics.
                            <br> Connect your Google Account for insights, ads, and shopping sync - no setup hassle.
                        </div>
                        <a href="#" class="google-auth-btn-highlighted">
                            <img class="rounded" src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
                            <?php esc_html_e("Login with Google to Get Started", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </a>
                    </div>

                    <!-- SLIDER INNER WRAPPER -->
                    <div class="conwiz_slide-inner">
                        <!-- Left Panel -->
                        <div class="conwiz_left-buttons">
                            <div class="conwiz_slide-btn" data-index="0">
                                <span><?php esc_html_e("Google Analytics", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                            <div class="conwiz_slide-btn" data-index="1">
                                <span><?php esc_html_e("Google Ads", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                            <div class="conwiz_slide-btn" data-index="2">
                                <span><?php esc_html_e("Google Merchant Center", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                            <div class="conwiz_slide-btn" data-index="3">
                                <span><?php esc_html_e("Other Integrations", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                        </div>

                        <!-- Center Image -->
                        <div class="conwiz_middle-image" id="conwiz_middle-section">
                            <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/dashboardimages/conwiz_gaimage.png') ?>" id="conwiz_slide-image">
                        </div>

                        <!-- Right Text -->
                        <div class="conwiz_right-text" id="conwiz_right-section">
                            <h3 id="conwiz_slide-title">Google Analytics</h3>
                            <div id="conwiz_slide-desc">
                                <?php esc_html_e("Measure your website traffic, understand user behavior, and make data-driven decisions with GA4 integration.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php } else { ?>

            <!-- TABS Started -->
            <div class="mx-auto convcard p-0 mt-0 rounded-3 shadow-lg mt-1" style="max-width: 1072px;">
                <div id="loadingbar_blue" class="progress-materializecss d-none ps-2 pe-2 w-100 topfull_loader">
                    <div class="indeterminate"></div>
                </div>
                <ul class="nav nav-tabs border-0 p-3 pb-0 w-100 pt-4" id="myTab" role="tablist">
                    <li class="nav-item mb-0" role="presentation">
                        <button class="d-inline-flex align-items-center pawizard_tab_but nav-link" id="webpixbox-tab" data-bs-toggle="tab" data-bs-target="#webpixbox" type="button" role="tab" aria-controls="webpixbox" aria-selected="false">
                            <h5 class="text-start m-0 ps-1 d-flex align-items-center">
                                <div class="convdott me-1"></div>
                                <?php esc_html_e("Google Analytics", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h5>
                        </button>
                    </li>

                    <li class="nav-item mb-0" role="presentation">
                        <button class="d-inline-flex align-items-center pawizard_tab_but nav-link" id="webotherbox-tab" data-bs-toggle="tab" data-bs-target="#webotherbox" type="button" role="tab" aria-controls="webotherbox" aria-selected="false">
                            <h5 class="text-start m-0 ps-1 d-flex align-items-center">
                                <div class="convdott d-none  me-1"></div>
                                <?php esc_html_e("Other Pixels", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </h5>
                        </button>
                    </li>

                </ul>

                <div class="tab-content p-3 pt-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="webpixbox" role="tabpanel" aria-labelledby="webpixbox-tab">
                        <?php require_once("wizardsettings/gasettings.php"); ?>
                    </div>
                    <div class="tab-pane fade" id="webotherbox" role="tabpanel" aria-labelledby="webotherbox-tab">
                        <?php require_once("wizardsettings/otherpixsettings.php"); ?>
                    </div>
                </div>
            </div>

        <?php } ?>



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
                            <h6 class="mt-4">Stay connected & Follow us on social media to get product tips, updates & video tutorials.</h6>
                            <div class="d-flex justify-content-center my-4 convsocialicons">
                                <a href="https://facebook.com/Conversios" target="_blank" class="rounded-circle p-2" title="Facebook">
                                    <?php echo wp_kses(
                                        enhancad_get_plugin_image('/admin/images/logos/conv_fb_logo.png', '', ''),
                                        array(
                                            'img' => array(
                                                'src' => true,
                                                'alt' => true,
                                                'class' => true,
                                                'style' => "width:32px",
                                            ),
                                        )
                                    ); ?>
                                </a>
                                <a href="https://www.linkedin.com/company/conversios/" target="_blank" class="rounded-circle p-2" title="Facebook">
                                    <?php echo wp_kses(
                                        enhancad_get_plugin_image('/admin/images/logos/conv_linkedin_logo.png', '', ''),
                                        array(
                                            'img' => array(
                                                'src' => true,
                                                'alt' => true,
                                                'class' => true,
                                                'style' => true,
                                            ),
                                        )
                                    ); ?>
                                </a>

                                <a href="https://www.instagram.com/conversios/" target="_blank" class="rounded-circle p-2" title="Facebook">
                                    <?php echo wp_kses(
                                        enhancad_get_plugin_image('/admin/images/logos/conv_insta_logo.png', '', ''),
                                        array(
                                            'img' => array(
                                                'src' => true,
                                                'alt' => true,
                                                'class' => true,
                                                'style' => true,
                                            ),
                                        )
                                    ); ?>
                                </a>

                                <a href="https://www.youtube.com/@conversios" target="_blank" class="rounded-circle p-2" title="Facebook">
                                    <?php echo wp_kses(
                                        enhancad_get_plugin_image('/admin/images/logos/conv_yt_logo.png', '', ''),
                                        array(
                                            'img' => array(
                                                'src' => true,
                                                'alt' => true,
                                                'class' => true,
                                                'style' => true,
                                            ),
                                        )
                                    ); ?>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer m-auto">
                <a href="<?php echo esc_url('admin.php?page=conversios'); ?>" class="btn btn-primary">
                    Goto Dashboard
                </a>
                <a href="<?php echo esc_url('admin.php?page=conversios-analytics-reports'); ?>" class="btn btn-primary">
                    Explore Reports
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Google Sign In -->

<?php
$connect_url_gagads = $tvc_admin_helper->get_custom_connect_url_wizard(admin_url() . 'admin.php?page=conversios&wizard=pixelandanalytics_gasettings');
$connect_url_gaa = $tvc_admin_helper->get_custom_connect_url_wizard(admin_url() . 'admin.php?page=conversios&wizard=pixelandanalytics_gasettings');
$connect_url_gadss = $tvc_admin_helper->get_custom_connect_url_wizard(admin_url() . 'admin.php?page=conversios&wizard=pixelandanalytics_gadssettings');
require_once ENHANCAD_PLUGIN_DIR . 'admin/partials/singlepixelsettings/googlesigninforga.php';
?>


<?php if ($g_email === "") { ?>
    <script>
        const conwiz_slides = [{
                img: "<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/dashboardimages/conwiz_gaimage.png') ?>",
                title: "Google Analytics",
                desc: "Measure your website traffic, understand user behavior, and make data-driven decisions with GA4 integration."
            },
            {
                img: "<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/dashboardimages/conwiz_gadsimage.png') ?>",
                title: "Google Ads",
                desc: "Create high-converting ads and maximize ROI by connecting your store with Google Ads."
            },
            {
                img: "<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/dashboardimages/conwiz_gmcimage.png') ?>",
                title: "Google Merchant Center",
                desc: "Sync your product feed and show your products across Google Shopping and other surfaces."
            },
            {
                img: "<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/dashboardimages/conwiz_allpixel1.png') ?>",
                title: "All Other Pixels",
                desc: "Sync your product feed and show your products across Google Shopping and other surfaces."
            }
        ];

        let currentIndex = 0;
        const totalSlides = conwiz_slides.length;
        let autoSlideInterval;
        let isHovered = false;

        function updateSlide(index) {
            jQuery('.conwiz_slide-btn')
                .removeClass('conwiz_btn-purple conwiz_active');
            jQuery('.conwiz_slide-btn[data-index="' + index + '"]')
                .addClass('conwiz_active conwiz_btn-purple');
            jQuery('#conwiz_slide-image').attr('src', conwiz_slides[index].img);
            jQuery('#conwiz_slide-title').text(conwiz_slides[index].title);
            jQuery('#conwiz_slide-desc').text(conwiz_slides[index].desc);

            const progress = document.getElementById('conwiz_progress');
            progress.style.animation = 'none';
            void progress.offsetWidth;
            progress.style.animation = null;
            progress.style.animation = 'progressSlide 10s linear forwards';
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                if (!isHovered) {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateSlide(currentIndex);
                }
            }, 10000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        jQuery(document).ready(function() {
            jQuery('.conwiz_slide-btn').click(function() {
                currentIndex = jQuery(this).data('index');
                updateSlide(currentIndex);
                resetAutoSlide();
            });

            jQuery('.conwiz_slide-btn')
                .on('mouseenter', function() {
                    isHovered = true;
                    const progress = document.getElementById('conwiz_progress');
                    if (progress) {
                        progress.style.animationPlayState = 'paused';
                    }
                })
                .on('mouseleave', function() {
                    isHovered = false;
                    const progress = document.getElementById('conwiz_progress');
                    if (progress) {
                        progress.style.animationPlayState = 'running';
                    }
                });
            updateSlide(currentIndex);
            startAutoSlide();
        });
    </script>
<?php } ?>



<script>
    function changeTabBox(tbaname = "webpixbox-tab") {
        console.log(tbaname);
        jQuery("#" + tbaname).tab('show');
    }

    jQuery(function() {
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
            var ecrandomstring = "<?php echo esc_js($tvc_admin_helper->generateRandomStringConv()); ?>";
            var subscription_id = "<?php echo esc_js($subscription_id); ?>";
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
            var activeTabId = jQuery(e.target).attr('id');
            if (activeTabId === 'webpixbox-tab') {
                jQuery('#convwizard_main .tab-content > .active').css('border-radius', '0px 15px 15px 15px');
            } else {
                jQuery('#convwizard_main .tab-content > .active').css('border-radius', '15px');
            }

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

        });

        jQuery(document).on("change", "#google_ads_id", function() {
            var remarketing_tags = '<?php echo isset($google_detail->remarketing_tags) ? esc_js($google_detail->remarketing_tags) : "notset"; ?>';
            var dynamic_remarketing_tags = '<?php echo isset($google_detail->dynamic_remarketing_tags) ? esc_js($google_detail->dynamic_remarketing_tags) : "notset"; ?>';
            var link_google_analytics_with_google_ads = '<?php echo isset($google_detail->link_google_analytics_with_google_ads) ? esc_js($google_detail->link_google_analytics_with_google_ads) : "notset"; ?>';
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