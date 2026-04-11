<?php
$TVC_Admin_Helper = new TVC_Admin_Helper();
$ee_options = unserialize(get_option('ee_options'));
$sch_email_toggle_check = isset($ee_options['sch_email_toggle_check']) ? sanitize_text_field($ee_options['sch_email_toggle_check']) : '1';
$sch_custom_email = isset($ee_options['sch_custom_email']) ? sanitize_text_field($ee_options['sch_custom_email']) : '';
$sch_email_frequency = isset($ee_options['sch_email_frequency']) ? sanitize_text_field($ee_options['sch_email_frequency']) : 'Weekly';
$g_mail = get_option('ee_customer_gmail');
$ga4_measurement_id = isset($ee_options['gm_id']) && $ee_options['gm_id'] != "" ? $ee_options['gm_id'] : "";
$ga4_analytic_account_id = isset($ee_options['ga4_analytic_account_id']) && $ee_options['ga4_analytic_account_id'] != "" ? $ee_options['ga4_analytic_account_id'] : "";
$google_ads_id = isset($ee_options['google_ads_id']) && $ee_options['google_ads_id'] != "" ? $ee_options['google_ads_id'] : "";
$last_fetched_prompt_date = isset($ee_options['last_fetched_prompt_date']) && $ee_options['last_fetched_prompt_date'] != "" ? $ee_options['last_fetched_prompt_date'] : "";
$ecom_reports_ga_currency = isset($ee_options['ecom_reports_ga_currency']) ? sanitize_text_field($ee_options['ecom_reports_ga_currency']) : '';
$ecom_reports_gads_currency = isset($ee_options['ecom_reports_gads_currency']) ? sanitize_text_field($ee_options['ecom_reports_gads_currency']) : '';
$connect_url = $TVC_Admin_Helper->get_custom_connect_url_wizard(admin_url() . 'admin.php?page=conversios-analytics-reports');
$subpage = (isset($_GET["subpage"]) && $_GET["subpage"] != "") ? sanitize_text_field(wp_unslash($_GET['subpage'])) : "ga4general";

$options = get_option("ee_options");
if ($options) {
    $options = is_array($options) ? $options : unserialize($options);
    if (!isset($options['save_email_bydefault'])) {
        $options['save_email_bydefault'] = null;
        update_option('ee_options', serialize($options));
    }
}
$report_settings_arr = array("ga4ecommerce", "gads", "ga4general");
if ($subpage == "ga4ecommerce") {
    $ga4page_cls = "btn-outline-primary";
    $gadspage_cls = "btn-outline-secondary alt-btn-reports";
    $ga4general_cls = "btn-outline-secondary alt-btn-reports";
} else if ($subpage == "gads") {
    $ga4page_cls = "btn-outline-secondary alt-btn-reports";
    $gadspage_cls = "btn-outline-primary";
    $ga4general_cls = "btn-outline-secondary alt-btn-reports";
} else if ($subpage == "ga4general") {
    $ga4page_cls = "btn-outline-secondary alt-btn-reports";
    $gadspage_cls = "btn-outline-secondary alt-btn-reports";
    $ga4general_cls = "btn-outline-primary";
}
if (isset($_GET['subscription_id']) && isset($_GET['g_mail'])) {
    $g_mail = sanitize_email($_GET['g_mail']);
    update_option('ee_customer_gmail', $g_mail);
}
?>
<style>
    ol,
    ul {
        padding-left: 0rem;
    }

    .big-checkbox {
        transform: scale(1.3);
        /* makes checkbox bigger */
        margin-right: 8px;
    }

    #configurationMessage {
        font-size: 13px;
        padding: 4px 8px;
        margin: 5px 0;
        line-height: 1.3;
    }
</style>
<div id="conv-report-main-div" class="container-fluid conv_report_mainbox p-4">

    <div class="row">
        <!-- Header & Date Picker -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div class="conv_pageheading d-flex align-items-center m-0">
                <h2 class="mb-0 fw-bold" style="font-size: 28px;">
                    <?php esc_html_e("Analytics reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                </h2>
                <h5 id="conv_pdf_logo" class="d-none ms-3 mb-0">by <?php echo wp_kses(
                                                                    enhancad_get_plugin_image('/admin/images/logo.png', '', '', 'width:120px;'),
                                                                    array(
                                                                        'img' => array(
                                                                            'src' => true,
                                                                            'alt' => true,
                                                                            'class' => true,
                                                                            'style' => true,
                                                                        ),
                                                                    )
                                                                ); ?></h5>
            </div>
            
            <div class="d-flex align-items-center">
                <style>
                    /* Tooltip for locked date range */
                    .conv-pro-locked-daterange { transition: all 0.2s ease; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 12px; background-color: #ffffff; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
                    .conv-pro-locked-daterange:hover { background-color: #f8fafc; border-color: #cbd5e1; }
                    .conv-hover-text { transition: color 0.2s ease; }
                    .conv-hover-text:hover { color: #0284c7 !important; }
                </style>
                <div id="reportrange" class="dshtpdaterange conv-pro-locked-daterange d-flex align-items-center gap-2" style="cursor:default;" onclick="jQuery('#conv_reports_pro_nudge_modal').modal('show')">
                    <div class="dateclndicn d-flex align-items-center text-secondary">
                        <?php echo wp_kses(
                            enhancad_get_plugin_image('/admin/images/claendar-icon.png', '', '', 'width: 18px;'),
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
                    <span class="daterangearea report_range_val fw-medium text-dark" style="user-select:none; font-size: 14px;"></span>
                    <span class="d-flex align-items-center ms-2 conv-hover-text" style="color:#64748b; font-size:13px; font-weight:500; cursor:pointer;" onclick="event.stopPropagation(); window.open('https://www.conversios.io/pricing/?plugin_name=aio&utm_source=woo_aiofree_plugin&utm_medium=daterange_lock&utm_campaign=daterange','_blank')">
                        <span class="material-symbols-outlined pe-1" style="font-size:15px;">lock</span>Unlock custom range
                    </span>
                </div>
            </div>
        </div>

        <!-- Report Tabs Navigation -->
        <div class="d-flex flex-wrap align-items-center mb-4" style="gap: 12px; row-gap: 12px;">

                <a href="admin.php?page=conversios-analytics-reports" class="btn <?php echo esc_attr($ga4general_cls); ?> bg-white text-nowrap d-flex align-items-center justify-content-center shadow-sm" style="border-radius: 8px; font-weight: 500; border-color: #e2e8f0;">
                    <?php esc_html_e("General Reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                </a>
                <a href="javascript:void(0)" class="btn <?php echo esc_attr($ga4page_cls); ?> bg-white text-nowrap d-flex align-items-center justify-content-center shadow-sm" style="border-radius: 8px; font-weight: 500; border-color: #e2e8f0;" onclick="jQuery('#conv_reports_pro_nudge_modal').modal('show')">
                    <?php esc_html_e("Ecommerce Reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                    <span class="badge ms-2" style="background:#e0f2fe;color:#0369a1;font-size:10px;padding:3px 6px;vertical-align:middle;line-height: normal; border-radius: 4px;">Pro</span>
                </a>
                <a href="javascript:void(0)" class="btn <?php echo esc_attr($gadspage_cls); ?> bg-white text-nowrap d-flex align-items-center justify-content-center shadow-sm" style="border-radius: 8px; font-weight: 500; border-color: #e2e8f0;" onclick="jQuery('#conv_reports_pro_nudge_modal').modal('show')">
                    <?php esc_html_e("Google Ads Reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                    <span class="badge ms-2" style="background:#e0f2fe;color:#0369a1;font-size:10px;padding:3px 6px;vertical-align:middle;line-height: normal; border-radius: 4px;">Pro</span>
                </a>
                <a href="javascript:void(0)" class="btn <?php echo esc_attr($gadspage_cls); ?> bg-white text-nowrap d-flex align-items-center justify-content-center shadow-sm" style="border-radius: 8px; font-weight: 500; border-color: #e2e8f0;" onclick="jQuery('#conv_reports_pro_nudge_modal').modal('show')">
                    <?php esc_html_e("Facebook (Meta) Reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                    <span class="badge ms-2" style="background:#e0f2fe;color:#0369a1;font-size:10px;padding:3px 6px;vertical-align:middle;line-height: normal; border-radius: 4px;">Pro</span>
                </a>

            <?php if ($ga4_measurement_id != "" && $g_mail != "") { ?>
                <div id="conv_report_opright" class="ms-auto d-flex flex-wrap align-items-center justify-content-end" style="gap:20px;">
                    <a class="d-flex align-items-center text-nowrap" data-bs-toggle="modal" data-bs-target="#schedule_email_modal" style="cursor:pointer; color: #475569; font-weight: 500; font-size: 14px; text-decoration: none;">
                        <span class="material-symbols-outlined pe-1" style="font-size:18px; color: #64748b;">check_circle</span>
                        <span class="conv-hover-text"><?php esc_html_e("Schedule Email", "enhanced-e-commerce-for-woocommerce-store") ?></span>
                    </a>
                    <a class="d-flex align-items-center text-nowrap" data-bs-toggle="modal" data-bs-target="#convpdflogoModal" style="cursor:pointer; color: #475569; font-weight: 500; font-size: 14px; text-decoration: none;">
                        <span class="material-symbols-outlined pe-1" style="font-size:18px; color: #64748b;">cloud_download</span>
                        <span class="conv-hover-text"><?php esc_html_e("Download PDF", "enhanced-e-commerce-for-woocommerce-store") ?></span>
                    </a>
                    <style>
                        .conv-hover-text { transition: color 0.2s ease; }
                        .conv-hover-text:hover { color: #0284c7; }
                    </style>
                </div>
            <?php } ?>
        </div>

        <?php if ($subpage == "ga4general" && (empty($g_mail) || empty($ga4_analytic_account_id))) { ?>
            <!-- Alert unchanged -->
            <div class="alert alert-info mt-3 w-100 shadow-sm border-0 rounded-4" role="alert">
                <div class="mx-auto" style="max-width: 600px; padding: 10px;">
                    <h5 class="alert-heading fw-bold mb-3"><?php esc_html_e("Connect Google Analytics to View Reports", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                    <p class="text-secondary"><?php esc_html_e("To view reports in the plugin, please connect your Google account and complete the Google Analytics setup:", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                    <ol class="ms-0 ps-3 text-secondary mb-4">
                        <li class="pb-2"><?php esc_html_e("Click the button below to start the connection.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                        <li class="pb-2"><?php esc_html_e("Authorize access through the Google authentication screen.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                        <li class="pb-2"><?php echo sprintf(esc_html__("Select your %sGoogle Analytics Account ID%s.", "enhanced-e-commerce-for-woocommerce-store"), '<strong class="text-dark">', '</strong>'); ?></li>
                        <li class="pb-2"><?php echo sprintf(esc_html__("Choose your %sMeasurement ID%s and click %sSave%s.", "enhanced-e-commerce-for-woocommerce-store"), '<strong class="text-dark">', '</strong>', '<strong class="text-dark">', '</strong>'); ?></li>
                        <li class="pb-1"><?php echo sprintf(esc_html__("After saving, a success message will appear. Click %s\"View Reports\"%s to access your analytics.", "enhanced-e-commerce-for-woocommerce-store"), '<strong class="text-dark">', '</strong>'); ?></li>
                    </ol>
                    <div>
                        <button type="button" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#prega4AuthModal">
                            <?php esc_html_e("Click here to connect Google", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: #ffffff;">
                <div class="card-body d-flex flex-wrap align-items-center justify-content-between p-3 gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <div class="d-flex flex-column">
                            <span class="text-secondary" style="font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;"><?php esc_html_e("Google Analytics Account ID", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            <span class="text-dark fw-bold" style="font-size: 15px;"><?php echo !empty($ga4_analytic_account_id) ? esc_attr($ga4_analytic_account_id) : '-'; ?></span>
                        </div>
                        <div class="border-start d-none d-md-block" style="height: 30px; border-color: #e2e8f0 !important;"></div>
                        <div class="d-flex flex-column">
                            <span class="text-secondary" style="font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;"><?php esc_html_e("Google Analytics Measurement ID", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            <span class="text-dark fw-bold" style="font-size: 15px;"><?php echo !empty($ga4_measurement_id) ? esc_attr($ga4_measurement_id) : '-'; ?></span>
                        </div>
                        <div class="border-start d-none d-md-block" style="height: 30px; border-color: #e2e8f0 !important;"></div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-secondary" style="font-size: 13px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-right: 4px;"><?php esc_html_e("Status", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            <?php if (!empty($ga4_measurement_id)) { ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1" style="font-size: 12px; font-weight: 600; border-radius: 6px;">
                                    <span class="material-symbols-outlined d-inline-block align-middle pe-1" style="font-size: 14px; margin-top: -2px;">verified</span><?php esc_html_e("Connected", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </span>
                            <?php } else { ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1" style="font-size: 12px; font-weight: 600; border-radius: 6px;">
                                    <span class="material-symbols-outlined d-inline-block align-middle pe-1" style="font-size: 14px; margin-top: -2px;">error</span><?php esc_html_e("Not Connected", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="ms-auto" style="text-align: right;">
                        <button id="opengasettings" class="btn btn-outline-primary d-flex align-items-center fw-medium shadow-sm py-2 px-3" style="border-radius: 8px;">
                            <span class="material-symbols-outlined pe-2" style="font-size: 18px;">edit</span><?php esc_html_e("Edit Details", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="modal fade" id="prega4AuthModal" tabindex="-1" aria-labelledby="prega4AuthModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow rounded-3">
                    <div class="modal-header border-bottom-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column: Google Button -->
                            <div class="col-md-5 d-flex align-items-center justify-content-center mb-4 mb-md-0">
                                <?php if ($g_mail == "") { ?>
                                    <button id="googleSignInBtn" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 shadow-sm google_connect_url">
                                        <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/g-logo.png'); ?>" alt="Google Logo" width="20" height="20">
                                        <span class="fw-semibold"><?php esc_html_e("Sign in with Google", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                                    </button>
                                <?php  } else { ?>
                                    <button id="googleSignInBtn" class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 shadow-sm google_connect_url">
                                        <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/g-logo.png'); ?>" alt="Google Logo" width="20" height="20">
                                        <span class="fw-semibold"><?php esc_html_e("Reauthorize", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                                    </button>
                                <?php } ?>
                            </div>

                            <!-- Right Column: Why we need it -->
                            <div class="col-md-7">
                                <p class="mb-2 h4"><strong><?php esc_html_e("Why do we need your permission?", "enhanced-e-commerce-for-woocommerce-store"); ?></strong></p>
                                <ul class="mb-0">
                                    <li class="pt-2"><strong><?php esc_html_e("Access to Google Analytics 4 (GA4):", "enhanced-e-commerce-for-woocommerce-store"); ?></strong> <?php esc_html_e("We use your GA4 data to generate intelligent profit predictions based on your traffic, conversion, and revenue metrics.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    <li class="pt-2"><?php echo sprintf(esc_html__("Your data is used only to show you insights %s we never store or share your analytics data with anyone.", "enhanced-e-commerce-for-woocommerce-store"), '<br>'); ?></li>
                                    <li class="pt-2"><?php echo sprintf(esc_html__("You can revoke access at any time by visiting your %sGoogle account permissions%s.", "enhanced-e-commerce-for-woocommerce-store"), '<a href="https://myaccount.google.com/permissions" target="_blank" rel="noopener noreferrer">', '</a>'); ?></li>
                                </ul>

                                <p class="text-danger text-fw-bold"><?php esc_html_e("Please use Chrome browser if you face any issues during setup.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ga4Modal" tabindex="-1" aria-labelledby="ga4ModalLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false"> <!-- prevents closing on outside click or Esc -->
            <div class="modal-dialog modal-dialog-centered mt-5">
                <div class="modal-content shadow rounded-4 border-0">

                    <!-- Header with Logo + Close button -->
                    <div class="modal-header border-bottom-0 flex-column text-center bg-light pt-4 pb-3 position-relative">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                        <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_ganalytics_logo.png'); ?>"
                            alt="GA4 Logo" width="48" height="48" class="mb-2">
                        <h5 class="modal-title fw-semibold" id="ga4ModalLabel"><?php esc_html_e("Connect Your GA4 Property", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                    </div>

                    <div class="modal-body px-4 pt-4">
                        <div id="ga4ErrorMessage" class="alert alert-danger d-none" role="alert"></div>
                        <div style="display: flex; align-items: center; margin-bottom: 10px; justify-content: center;" class="alert alert-info">
                            <strong><?php esc_html_e("Successfully logged in with:", "enhanced-e-commerce-for-woocommerce-store"); ?></strong>
                            <span style="margin-left: 6px;"><?php echo !empty($g_mail) ? esc_attr($g_mail) : '-'; ?></span>
                            <span class="conv-link-blue ps-0 ms-2 tvc_google_signinbtn">
                                <?php esc_html_e("Change", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </span>
                        </div>
                        <div id="configurationMessage"
                            class="alert alert-danger d-none p-1 small mx-1 mb-4"
                            role="alert">
                            <?php esc_html_e("To view reports, please configure the following and save.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </div>
                        <form id="ga4SelectionForm" style="margin: 0px 30px;">

                            <!-- GA4 Account -->
                            <div class="mb-4 d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <label for="ga4_analytic_account_id" class="form-label fw-bolder"><?php esc_html_e("GA4 Account", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                                    <select class="form-select" id="ga4_analytic_account_id" name="ga4_account">
                                        <option value=""><?php esc_html_e("-- Select Account --", "enhanced-e-commerce-for-woocommerce-store"); ?></option>
                                    </select>
                                </div>
                            </div>

                            <!-- GA4 Property -->
                            <div class="mb-4 d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <label for="measurement_id" class="form-label fw-bolder"><?php esc_html_e("GA4 Measurement ID", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                                    <select class="form-select" id="measurement_id" name="ga4_property">
                                        <option value=""><?php esc_html_e("-- Select Measurement ID --", "enhanced-e-commerce-for-woocommerce-store"); ?></option>
                                    </select>
                                </div>
                            </div>

                            <!-- Confirmation Checkbox -->
                            <div class="mb-3 form-check ms-1">
                                <input type="checkbox" class="form-check-input big-checkbox" id="ga4midconfirm">
                                <label class="form-check-label" for="ga4midconfirm" id="ga4ConfirmLabel">
                                    Events will be tracked using the selected GA4 Measurement ID, and the in-built reports will reflect data from the same GA4 account.
                                </label>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer border-top-0 px-4 pb-4">
                        <button id="savereportsettings" type="button" class="btn btn-primary w-100 py-2" disabled>
                            <span class="d-inline-flex align-items-center">
                                Save
                                <div class="spinner-border text-light spinner-border-sm ms-2 d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const accountSelect = document.getElementById("ga4_analytic_account_id");
                const propertySelect = document.getElementById("measurement_id");
                const confirmCheckbox = document.getElementById("ga4midconfirm");
                const saveButton = document.getElementById("savereportsettings");

                function toggleSaveButton() {
                    const accountSelected = accountSelect.value.trim() !== "";
                    const propertySelected = propertySelect.value.trim() !== "";
                    const confirmed = confirmCheckbox.checked;

                    saveButton.disabled = !(accountSelected && propertySelected && confirmed);
                }

                accountSelect.addEventListener("change", toggleSaveButton);
                propertySelect.addEventListener("change", toggleSaveButton);
                confirmCheckbox.addEventListener("change", toggleSaveButton);
            });
        </script>


        <?php
        if (in_array($subpage, $report_settings_arr)) {
            require_once(ENHANCAD_PLUGIN_DIR . "admin/partials/reports/" . $subpage . '.php');
        }
        ?>
        <!-- All report section -->

    </div>
</div>
</div>
<!-- logo modal -->
<div class="modal fade" id="convpdflogoModal" tabindex="-1" aria-labelledby="convpdflogoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="convpdflogoModalLabel"><?php esc_html_e("Download Report", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Size Message -->
            <div class="alert alert-success text-center text-underline text-success">
                <a href="https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=modal_setlogo&utm_campaign=upgrade" target="_blank">
                    <?php esc_html_e("Upgrade to Premium to set your logo in report PDF", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </a>
            </div>

            <!-- Modal Body -->
            <div class="modal-body d-flex justify-content-center align-items-center flex-column disabledsection">
                <!-- Image Preview Container -->
                <div id="image-preview-container" class="border d-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 36px; background-color: #f8f9fa;">
                    <span id="no-image-text" class="text-muted small"><?php esc_html_e("No image selected", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                    <?php echo wp_kses(
                        enhancad_get_plugin_image('/admin/images/claendar-icon.png', 'Selected Media Preview', 'd-none img-fluid', 'max-width: 120px; max-height: 36px;', 'selected-media-preview'),
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

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <button id="select-media-button" class="btn btn-outline-primary me-2">
                        <i class="bi bi-upload"></i> <?php esc_html_e("Select Logo", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                    <input type="hidden" id="attachment-id" name="attachment_id" value="">
                    <button id="save-logo-button" class="btn btn-success">
                        <i class="bi bi-save"></i> <?php esc_html_e("Save", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="conv-download-pdf" class="btn btn-primary w-100">
                    <i class="bi bi-file-earmark-pdf"></i><?php esc_html_e("Download Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Schedule Email Modal box -->
<div class="modal email-modal fade" id="schedule_email_modal" tabindex="-1" aria-labelledby="schedule_email_modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div id="loadingbar_blue" class="progress-materializecss" style="display: none;">
            <div class="indeterminate"></div>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="scheduleemail-box">
                    <h2><?php esc_html_e("Smart Emails", "enhanced-e-commerce-for-woocommerce-store"); ?></h2>
                    <p>
                        <?php esc_html_e("Schedule your Google Analytics 4 Insight Report email for", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <br>
                        <?php esc_html_e("data-driven insights", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </p>
                    
                    <div style="background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:12px 16px;margin:10px 0 20px 0;font-size:13px;color:#92400e;text-align:left;">
                        <strong><?php esc_html_e("🔒 PRO FEATURE: ", "enhanced-e-commerce-for-woocommerce-store"); ?></strong> <?php esc_html_e("Customizing Smart Email schedules and alternate sender addresses is available in the Pro version. Upgrade to configure daily, weekly, or monthly automated reports exactly how you want.", "enhanced-e-commerce-for-woocommerce-store"); ?> <br><a href="https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=smart_emails_modal&utm_campaign=upgrade" target="_blank" style="color:#0284c7;font-weight:bold;margin-top:6px;display:inline-block;"><?php esc_html_e("Upgrade to Pro →", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                    </div>

                    <?php
                    // Pro restriction: force UI to disabled view
                    $switch_cls = 'convEmail_default_cls_disabled';
                    $switch_checked = 'disabled';
                    $txtcls = "form-fields-light"; 
                    ?>
                    <div class="schedule-formbox" style="opacity: 0.7; pointer-events: none;">
                        <div class="toggle-switch">
                            <div class="form-check form-switch">
                                <div class="form-check form-switch">
                                    <label id="email_toggle_btnLabel" for="email_toggle_btn" class="form-check-input switch <?php echo esc_attr($switch_cls); ?>" role="switch">
                                        <input id="email_toggle_btn" type="checkbox" class="<?php echo esc_attr($switch_cls); ?>" <?php echo esc_attr($switch_checked); ?>>
                                        <div></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-wholebox">
                            <div class="form-box">
                                <label for="custom_email" class="form-label llabel"><?php esc_html_e("Email address", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                                <input type="email" class="form-control icontrol <?php echo esc_attr($txtcls); ?>" id="custom_email" aria-describedby="emailHelp" placeholder="user@gmail.com" value="<?php echo esc_attr($g_mail); ?>" disabled readonly>
                            </div>
                            <div class="form-box">
                                <h5>
                                    <?php esc_html_e("To get emails on your alternate address. ", "enhanced-e-commerce-for-woocommerce-store"); ?><a style="color:  #1085F1;cursor: pointer;"><?php esc_html_e("Upgrade To Pro", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                </h5>
                            </div>
                            <div class="form-box">
                                <label for="email_frequency" class="form-label llabel">
                                    <?php esc_html_e("Email Frequency", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </label>
                                <input type="text" class="form-control icontrol <?php echo esc_attr($txtcls); ?>" id="email_frequency" value="<?php echo esc_attr($sch_email_frequency); ?>" disabled readonly>
                                <div id="email_frequency_arrow" class="down-arrow"></div>
                            </div>

                            <div class="form-box">
                                <h5>
                                    <?php esc_html_e("By default, you will receive a Weekly report in your email inbox.", "enhanced-e-commerce-for-woocommerce-store"); ?><br><?php esc_html_e("To get report ", "enhanced-e-commerce-for-woocommerce-store"); ?><strong><?php esc_html_e("Daily", "enhanced-e-commerce-for-woocommerce-store"); ?></strong>
                                    . <a style="color:  #1085F1;"><?php esc_html_e("Upgrade To Pro", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                </h5>
                            </div>
                            <div class="form-box">
                                <div class="save">
                                    <button class="btn save-btn" disabled style="opacity: 0.5; background: #94a3b8; border-color: #94a3b8;"><?php esc_html_e("Save (Pro Only)", "enhanced-e-commerce-for-woocommerce-store"); ?></button>
                                </div>
                            </div>
                            <div class="form-box">
                                <div class="save">
                                    <span id="err_sch_msg" style="display: none;color: red;position: absolute;top: -9px;"><?php esc_html_e("Something went wrong, please try again later.", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                                </div>
                            </div>

                            <div id="schedule_email_alert" class="d-none">
                                <div class="alert alert-info" role="alert">
                                    <div id="schedule_email_alert_msg"></div>
                                    <div role="button" class="fw-bold pt-3" data-bs-dismiss="modal"><?php esc_html_e("Click here to close the popup", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--schedule modal end-->


<div class="modal fade" id="upgradetopromodalotherReports" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="position:relative;border-radius:16px;">
            <div class="modal-body p-4 pb-0">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <img width="200" height="200"
                        src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/upgrade-pro-reporting.png'); ?>" />
                    <h2 class="text-fw-bold">Upgrade to Pro Now</h2>
                    <span class="text-secondary text-center">Unlock this premium report with our <span
                            class="fw-bold">Pro version!</span> Upgrade now for comprehensive insights and advanced
                        analytics.</span>
                </div>
            </div>
            <div class="border-0 pb-4 mb-1 pt-4 d-flex flex-row justify-content-center align-items-center p-2">
                <a class="btn bg-white text-black m-auto w-100 mx-2 ms-4 p-2" style="border: 1px solid black;" data-bs-dismiss="modal">
                    <?php esc_html_e("Close", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </a>
                <a id="upgradetopro_modal_link" class="btn conv-yellow-bg m-auto w-100 mx-2 me-4 p-2"
                    href="https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=modal_popup&utm_campaign=upgrade"
                    target="_blank">
                    <?php esc_html_e("Upgrade Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Reports Pro Nudge Modal -->
<div class="modal fade" id="conv_reports_pro_nudge_modal" tabindex="-1" aria-labelledby="convReportsNudgeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
    <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;">
      <div class="modal-body p-0">
        <!-- Header gradient -->
        <div style="background:linear-gradient(135deg,#0284c7,#0369a1);padding:28px 28px 20px;text-align:center;">
          <span class="material-symbols-outlined" style="font-size:44px;color:#fff;opacity:0.9;">analytics</span>
          <h4 style="color:#fff;font-weight:700;margin:12px 0 4px;font-size:20px;"><?php esc_html_e("Unlock Advanced Reports", "enhanced-e-commerce-for-woocommerce-store"); ?></h4>
          <p style="color:#e0f2fe;font-size:13px;margin:0;"><?php esc_html_e("Get deeper insights with Ecommerce, Google Ads & Facebook reporting", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
        </div>
        <!-- Content -->
        <div style="padding:24px 28px;">
          <!-- What Pro unlocks -->
          <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:16px;margin-bottom:16px;">
            <div style="font-size:12px;font-weight:700;color:#0369a1;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;"><?php esc_html_e("🚀 Pro Unlocks", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
            <div style="display:flex;flex-direction:column;gap:6px;">
              <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#0c4a6e;">
                <span class="material-symbols-outlined" style="color:#0284c7;font-size:18px;">star</span>
                <?php esc_html_e("Ecommerce Reports — Orders, Revenue, Top Products", "enhanced-e-commerce-for-woocommerce-store"); ?>
              </div>
              <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#0c4a6e;">
                <span class="material-symbols-outlined" style="color:#0284c7;font-size:18px;">star</span>
                <?php esc_html_e("Google Ads & Facebook Reports — Campaign & ROAS Data", "enhanced-e-commerce-for-woocommerce-store"); ?>
              </div>
              <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#0c4a6e;">
                <span class="material-symbols-outlined" style="color:#0284c7;font-size:18px;">star</span>
                <?php esc_html_e("Full 30/90 Day Trends & Custom Date Range", "enhanced-e-commerce-for-woocommerce-store"); ?>
              </div>
              <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#0c4a6e;">
                <span class="material-symbols-outlined" style="color:#0284c7;font-size:18px;">star</span>
                <?php esc_html_e("Revenue by Source/Medium Attribution", "enhanced-e-commerce-for-woocommerce-store"); ?>
              </div>
              <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#0c4a6e;">
                <span class="material-symbols-outlined" style="color:#0284c7;font-size:18px;">star</span>
                <?php esc_html_e("Scheduled Email Reports (Daily/Weekly/Monthly)", "enhanced-e-commerce-for-woocommerce-store"); ?>
              </div>
            </div>
          </div>
          <!-- Impact note -->
          <div style="background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:10px 14px;margin-bottom:20px;font-size:12px;color:#92400e;">
            <strong><?php esc_html_e("💡 Did you know?", "enhanced-e-commerce-for-woocommerce-store"); ?></strong> <?php esc_html_e("Businesses using advanced analytics reports make 23% more profitable decisions. Don't fly blind — see the full picture.", "enhanced-e-commerce-for-woocommerce-store"); ?>
          </div>
          <!-- Buttons -->
          <div style="display:flex;gap:10px;">
            <a href="https://www.conversios.io/pricing/?plugin_name=aio&utm_source=woo_aiofree_plugin&utm_medium=reports_nudge_modal&utm_campaign=upgrade_cta" target="_blank" class="btn" style="flex:1;background:linear-gradient(135deg,#0284c7,#0369a1);color:#fff;font-weight:600;font-size:14px;border-radius:10px;padding:12px;">
              <?php esc_html_e("Upgrade to Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </a>
            <button type="button" class="btn" data-bs-dismiss="modal" style="flex:1;background:#f1f5f9;color:#334155;font-weight:600;font-size:14px;border-radius:10px;padding:12px;border:1px solid #e2e8f0;">
              <?php esc_html_e("Continue Free →", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Reports Pro Nudge Modal -->

<script>
    jQuery(document).ready(function() {
        var start = moment().subtract(45, 'days');
        var end = moment().subtract(1, 'days');
        var start_date = "";
        var end_date = "";
        <?php if (!$ga4_measurement_id == "" && !empty($g_mail)) { ?>
            cb(start, end);
        <?php } ?>

        const url = window.location.href;
        const params = new URLSearchParams(window.location.search);
        let storedMeasurementId = "<?php echo esc_js($ga4_measurement_id); ?>";
        if (params.has("subscription_id") && params.has("g_mail")) {
            const subscriptionId = params.get("subscription_id");
            const gMail = params.get("g_mail");
            const myModal = new bootstrap.Modal(document.getElementById("ga4Modal"));
            myModal.show();
            list_analytics_account();
        }
    });

    function showGA4ModalInfo(message) {
        jQuery("#ga4Modal .modal-body").prepend(
            '<div class="ga4-info-box alert alert-info rounded-3 py-2 px-3 mb-3">' + message + '</div>'
        );
    }

    jQuery('#measurement_id').on('change', function() {
        let selectedValue = jQuery(this).val().trim();
        if (selectedValue) {
            jQuery('#ga4ConfirmLabel').html(
                `Events will be tracked using the selected GA4 Measurement ID - <strong>${selectedValue}</strong>, and the in-built reports will reflect data from the same GA4 account.`
            );
        } else {
            jQuery('#ga4ConfirmLabel').html(
                `Events will be tracked using the selected GA4 Measurement ID, and the in-built reports will reflect data from the same GA4 account.`
            );
        }
    });


    jQuery(document).on("click", "#opengasettings", function(e) {
        e.preventDefault();
        jQuery("#ga4Modal").modal("show");
        list_analytics_account();
    });
    jQuery(document).on("click", ".tvc_google_signinbtn", function(e) {
        jQuery("#ga4Modal").modal("hide");
        e.preventDefault();
        jQuery("#prega4AuthModal").modal("show");
    });

    jQuery(document).on('change', '#ga4_analytic_account_id', function() {
        let accountId = jQuery(this).val();

        if (accountId) {
            jQuery("#measurement_id").html('<option>Loading...</option>');
            list_analytics_web_properties("GA4", accountId);
        } else {
            jQuery("#measurement_id").html('<option value="">-- Select Property --</option>');
        }
    });

    function showGA4ModalError(message) {
        jQuery("#ga4Modal .modal-body").prepend(
            '<div class="ga4-error-box alert alert-danger rounded-2 py-1 px-2 mb-3">' + message + '</div>'
        );
    }

    function list_analytics_account(page = 1) {
        var conversios_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>";
        jQuery("#ga4_analytic_account_id").html('<option>Loading...</option>');
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "get_analytics_account_list",
                page: page,
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
            success: function(response) {
                // console.log(response);
                if (response && response.error == false) {
                    var error_msg = 'null';
                    if (response?.data?.items.length > 0) {
                        jQuery('#ga4_analytic_account_id').html('<option value="">-- Select Account --</option>');
                        var AccOptions = '';
                        response.data.items.forEach(function(item) {
                            AccOptions += '<option value="' + item.id + '">' + item.name + ' - ' + item.id + '</option>';
                        });
                        jQuery('#ga4_analytic_account_id').append(AccOptions);
                    } else {
                        showGA4ModalError("There are no Google Analytics accounts associated with this email.");
                    }

                } else if (response && response.error == true && response.error != undefined) {
                    const errors = response.errors;
                    showGA4ModalError(errors);
                    var error_msg = errors;
                } else {
                    showGA4ModalError("There are no Google Analytics accounts associated with this email.");
                }
                jQuery("#tvc-ga4-acc-edit-acc_box")?.removeClass('tvc-disable-edits');
                jQuery(".conv-enable-selection").removeClass('disabled');
            }
        });
    }

    function list_analytics_web_properties(type, account_id) {
        jQuery("#measurement_id").html('<option>Loading...</option>');

        var conversios_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conversios_onboarding_nonce')); ?>";

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "get_analytics_web_properties",
                account_id: account_id,
                type: type,
                conversios_onboarding_nonce: conversios_onboarding_nonce
            },
            success: function(response) {
                if (response && response.error == false) {
                    if (type === "GA4") {
                        jQuery('#measurement_id').empty();

                        if (response?.data?.wep_measurement?.length > 0) {
                            let streamOptions = '<option value="">-- Select Measurement Id --</option>';
                            response.data.wep_measurement.forEach(function(item) {
                                streamOptions += `<option value="${item.measurementId}">
                                ${item.measurementId} - ${item.displayName}
                            </option>`;
                            });
                            jQuery('#measurement_id').html(streamOptions).prop("disabled", false);
                        } else {
                            jQuery('#measurement_id')
                                .html('<option value="">No GA4 Property Found</option>')
                                .prop("disabled", true);

                            showGA4ModalError("There are no Google Analytics 4 Properties associated with this analytics account.");
                        }
                    }
                } else if (response && response.error === true) {
                    const errors = response.errors || "Something went wrong";
                    showGA4ModalError(errors);
                } else {
                    jQuery('#measurement_id')
                        .html('<option value="">No Properties Found</option>')
                        .prop("disabled", true);

                    showGA4ModalError("No properties found for this account.");
                }
            },
            error: function() {
                jQuery('#measurement_id')
                    .html('<option value="">Request Failed</option>')
                    .prop("disabled", true);

                showGA4ModalError("Failed to fetch GA4 properties. Please try again.");
            }
        });
    }

    function checkGA4Fields() {
        var ga4Account = jQuery("#ga4_analytic_account_id").val();
        var ga4Property = jQuery("#measurement_id").val();

        // Invalid values include: empty, null, undefined, "Loading..."
        var invalid = ["", null, undefined, "Loading..."];

        if (!invalid.includes(ga4Account) && !invalid.includes(ga4Property)) {
            jQuery("#savereportsettings").removeClass("disabled");
        } else {
            jQuery("#savereportsettings").addClass("disabled");
        }
    }
    jQuery('#ga4_analytic_account_id').on('change', checkGA4Fields);
    jQuery('#measurement_id').on('change', checkGA4Fields);

    jQuery("#savereportsettings").on("click", function() {
        checkGA4Fields();
        jQuery("#savereportsettings").addClass("disabled");
        var ga4Account = jQuery("#ga4_analytic_account_id").val();
        var ga4Property = jQuery("#measurement_id").val();

        if (!ga4Account || !ga4Property) {
            alert("Please select both Account and Property to continue.");
            return;
        }
        var selected_vals = {
            ga4_analytic_account_id: ga4Account,
            measurement_id: ga4Property,
        };
        // Show spinner
        jQuery("#savereportsettings .spinner-border").removeClass("d-none");

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
                jQuery("#savereportsettings .spinner-border").addClass("d-none");

                if (response == "0" || response == "1") {
                    alert("GA4 settings saved successfully!");
                    jQuery("#ga4Modal").modal("hide");
                    jQuery("body").append(`
                <div class="conv-fullscreen-loader" 
                     style="position:fixed; top:0; left:0; width:100%; height:100%;
                            background:rgba(255,255,255,0.8); z-index:9999;
                            display:flex; justify-content:center; align-items:center;">
                    <div class="spinner-border text-primary" style="width:4rem; height:4rem;"></div>
                </div>
            `);
                    // Wait for createDimension to finish, then reload
                    createDimension().then(() => {
                        let url = new URL(window.location.href);
                        url.searchParams.delete("subscription_id");
                        url.searchParams.delete("g_mail");
                        window.location.href = url.toString();
                    });
                } else {
                    alert("Failed to save settings. Please try again.");
                }
            },
            error: function() {
                jQuery("#savereportsettings .spinner-border").addClass("d-none");
                alert("Something went wrong. Please try again.");
            },
        });
    });

    function createDimension() {
        return jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "conv_create_ga4_custom_dimension",
                pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                ga_cid: "1",
                non_woo_tracking: "1"
            },
            success: function(response) {
                console.log('Custom Dimension created successfully');
            }
        });
    }

    jQuery(".google_connect_url").on("click", function() {
        const w = 800;
        const h = 650;
        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - w) / 2 / systemZoom + dualScreenLeft;
        const top = (height - h) / 2 / systemZoom + dualScreenTop;
        var url = '<?php echo esc_url($connect_url); ?>';

        url = url.replace(/&amp;/g, '&');
        url = url.replaceAll('&#038;', '&');
        const newWindow = window.open(url, "newwindow", config = `scrollbars=yes,
            width=${w / systemZoom}, 
            height=${h / systemZoom}, 
            top=${top}, 
            left=${left},toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no
            `);
        if (window.focus) newWindow.focus();
    });
    // Schedule email
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

    function save_local_data(email_toggle_check, custom_email, email_frequency) {
        var selected_vals = {};
        selected_vals['sch_email_toggle_check'] = email_toggle_check;
        selected_vals['sch_custom_email'] = custom_email;
        selected_vals['sch_email_frequency'] = email_frequency;
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "conv_save_pixel_data",
                pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                conv_options_data: selected_vals,
                conv_options_type: ["eeoptions"]
            },
            beforeSend: function() {},
            success: function(response) {
                console.log('Email setting saved in db');
            }
        });
    }
    jQuery(document).ready(function() {
        jQuery("#navbarSupportedContent ul li").removeClass("rich-blue");
        jQuery('#navbarSupportedContent ul > li').eq(0).addClass('rich-blue');

        var save_email_bydefault = '<?php echo esc_js($options["save_email_bydefault"] ?? ""); ?>';
        if (save_email_bydefault === "") {
            let email_toggle_check = '0'; //default
            let custom_email = '<?php echo esc_attr($g_mail); ?>';
            let email_frequency = "Weekly";
            let email_frequency_final = "7_day";
            var data = {
                "action": "set_email_configurationGA4",
                "is_disabled": email_toggle_check,
                "custom_email": custom_email,
                "email_frequency": email_frequency_final,
                "save_email_bydefault": "1",
                "conversios_nonce": '<?php echo esc_js(wp_create_nonce('conversios_nonce')); ?>'
            };
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: data,
                beforeSend: function() {
                    jQuery("#loadingbar_blue").show();
                },
                success: function(response) {
                    if (response.error == false) {
                        jQuery("#err_sch_msg").hide();
                        jQuery("#loadingbar_blue").hide();
                        if (email_toggle_check == "0") {
                            jQuery("#schedule_email_alert_msg").html(
                                "Successfully subscribed to receive analytics reports in your email");
                        } else {
                            jQuery("#schedule_email_alert_msg").html("Successfully Unsubscribed");
                        }

                        jQuery("#schedule_email_alert").removeClass("d-none");

                        jQuery('#sch_ack_msg').show();
                        //local storage
                        save_local_data(email_toggle_check, custom_email, email_frequency);
                        if (email_toggle_check == '0') {
                            jQuery('#schedule_form_btn_set').show();
                            jQuery('#schedule_form_btn_raw').hide();
                        } else {
                            jQuery('#schedule_form_btn_set').hide();
                            jQuery('#schedule_form_btn_raw').show();
                        }
                    } else {
                        jQuery("#err_sch_msg").show();
                        jQuery("#loadingbar_blue").hide();
                    }
                    setTimeout(
                        function() {
                            jQuery("#sch_ack_msg").hide();
                        }, 8000);
                }
            });
        }
    });
    /*schedule email form submit event listner*/
    jQuery("#schedule_email_save_config").on("click", function() {
        let email_toggle_check = '0'; //default
        if (jQuery("#email_toggle_btn").prop("checked")) {
            email_toggle_check = '0'; //enabled
        } else {
            email_toggle_check = '1'; //disabled
        }
        let custom_email = '<?php echo esc_attr($g_mail); ?>';
        let email_frequency = "Weekly";
        let email_frequency_final = "7_day";
        var data = {
            "action": "set_email_configurationGA4",
            "is_disabled": email_toggle_check,
            "custom_email": custom_email,
            "email_frequency": email_frequency_final,
            "conversios_nonce": '<?php echo esc_js(wp_create_nonce('conversios_nonce')); ?>'
        };
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: data,
            beforeSend: function() {
                jQuery("#loadingbar_blue").show();
            },
            success: function(response) {
                if (response.error == false) {
                    jQuery("#err_sch_msg").hide();
                    jQuery("#loadingbar_blue").hide();
                    if (email_toggle_check == "0") {
                        jQuery("#schedule_email_alert_msg").html(
                            "Successfully subscribed to receive analytics reports in your email");
                    } else {
                        jQuery("#schedule_email_alert_msg").html("Successfully Unsubscribed");
                    }

                    jQuery("#schedule_email_alert").removeClass("d-none");

                    jQuery('#sch_ack_msg').show();
                    //local storage
                    save_local_data(email_toggle_check, custom_email, email_frequency);
                    if (email_toggle_check == '0') {
                        jQuery('#schedule_form_btn_set').show();
                        jQuery('#schedule_form_btn_raw').hide();
                    } else {
                        jQuery('#schedule_form_btn_set').hide();
                        jQuery('#schedule_form_btn_raw').show();
                    }
                } else {
                    jQuery("#err_sch_msg").show();
                    jQuery("#loadingbar_blue").hide();
                }
                setTimeout(
                    function() {
                        jQuery("#sch_ack_msg").hide();
                    }, 8000);
            }
        });
    });
    jQuery("#sch_ack_msg_close").on("click", function() {
        jQuery("#sch_ack_msg").hide();
    });
    jQuery('#email_toggle_btn').change(function() {
        if (jQuery(this).prop("checked")) {
            jQuery("#email_toggle_btnLabel").addClass("convEmail_default_cls_enabled");
            jQuery("#email_toggle_btnLabel").removeClass("convEmail_default_cls_disabled");
            jQuery("#email_frequency,#custom_email").attr("style", "color: #2A2D2F !important");
            jQuery("#schedule_email_save_config").html('Save Changes');
        } else {
            jQuery("#email_toggle_btnLabel").addClass("convEmail_default_cls_disabled");
            jQuery("#email_toggle_btnLabel").removeClass("convEmail_default_cls_enabled");
            jQuery("#email_frequency,#custom_email").attr("style", "color: #94979A !important");
            jQuery("#schedule_email_save_config").html('Save Changes');
        }
    });
    jQuery(function() {
        jQuery('#conv-download-pdf').click(function() {
            jQuery("#conv_report_opright").addClass("d-none");
            jQuery("#conv-download-pdf").addClass("disabledsection");
            jQuery("#conv_pdf_logo").removeClass('d-none');
            const element = document.getElementById('conv-report-main-div');
            const watermarkURL = "<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logo.png'); ?>";

            html2canvas(element, {
                scale: 2,
                useCORS: true,
            }).then(function(canvas) {
                const imgData = canvas.toDataURL('image/jpeg');
                const {
                    jsPDF
                } = window.jspdf;

                const canvasWidth = canvas.width;
                const canvasHeight = canvas.height;

                const pdfWidth = (canvasWidth * 25.4) / 96; // Convert canvas width from px to mm
                const pdfHeight = (canvasHeight * 25.4) / 96;

                const pdf = new jsPDF('p', 'mm', [pdfWidth, pdfHeight]);

                // Add the main content image
                pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);

                // Load the watermark image and add it to the center
                const watermark = new Image();
                watermark.src = watermarkURL;
                watermark.onload = function() {
                    const wmWidth = pdfWidth * 0.7; // 50% of PDF width
                    const wmHeight = (watermark.height / watermark.width) * wmWidth;
                    const wmX = (pdfWidth - wmWidth) / 1.3; // Center horizontally
                    const wmY = (pdfHeight - wmHeight) / 1.6; // Center vertically

                    pdf.setGState(new pdf.GState({
                        opacity: 0.1
                    })); // Set low opacity
                    pdf.addImage(watermark, 'PNG', wmX, wmY, wmWidth, wmHeight, undefined, 'NONE', 45);
                    pdf.save('ConversiosGA4Report.pdf');
                    jQuery("#conv_pdf_logo").addClass('d-none');
                };
            });
            jQuery("#conv-download-pdf").removeClass("disabledsection");
            jQuery("#conv_report_opright").removeClass("d-none");
        });
    });
</script>