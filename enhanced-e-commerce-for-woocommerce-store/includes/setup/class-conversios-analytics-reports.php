<?php
$ee_options = unserialize(get_option('ee_options'));
$sch_email_toggle_check = isset($ee_options['sch_email_toggle_check']) ? sanitize_text_field($ee_options['sch_email_toggle_check']) : '1';
$sch_custom_email = isset($ee_options['sch_custom_email']) ? sanitize_text_field($ee_options['sch_custom_email']) : '';
$sch_email_frequency = isset($ee_options['sch_email_frequency']) ? sanitize_text_field($ee_options['sch_email_frequency']) : 'Weekly';
$g_mail = get_option('ee_customer_gmail');
$ga4_measurement_id = isset($ee_options['gm_id']) && $ee_options['gm_id'] != "" ? $ee_options['gm_id'] : "";
$google_ads_id = isset($ee_options['google_ads_id']) && $ee_options['google_ads_id'] != "" ? $ee_options['google_ads_id'] : "";
$last_fetched_prompt_date = isset($ee_options['last_fetched_prompt_date']) && $ee_options['last_fetched_prompt_date'] != "" ? $ee_options['last_fetched_prompt_date'] : "";
$ecom_reports_ga_currency = isset($ee_options['ecom_reports_ga_currency']) ? sanitize_text_field($ee_options['ecom_reports_ga_currency']) : '';
$ecom_reports_gads_currency = isset($ee_options['ecom_reports_gads_currency']) ? sanitize_text_field($ee_options['ecom_reports_gads_currency']) : '';

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
?>
<div id="conv-report-main-div" class="container-fluid conv_report_mainbox p-4">

    <div class="row">
        <div class="d-flex">
            <div class="conv_pageheading d-flex align-items-end">
                <h2>
                    <?php esc_html_e("Reports & Insights", "enhanced-e-commerce-for-woocommerce-store") ?>
                </h2>
                <h5 id="conv_pdf_logo" class="d-none ms-2">by <img style="width: 120px;" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logo.png'); ?>" /></h5>
            </div>
            <div class="ms-auto p-2 bd-highlight">
                <div id="reportrange" class="dshtpdaterange upgradetopro_badge" popupopener="generalreport">
                    <div class="dateclndicn">
                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/claendar-icon.png'); ?>" alt="" />
                    </div>
                    <span class="daterangearea report_range_val"></span>
                    <div class="careticn">
                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/caret-down.png'); ?>" alt="" />
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex">

            <div class="conv_pageheading">
                <a href="admin.php?page=conversios-analytics-reports" class="btn <?php echo esc_attr($ga4general_cls); ?> bg-white me-3">
                    <?php esc_html_e("General Reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                </a>
                <a href="admin.php?page=conversios-analytics-reports&subpage=ga4ecommerce" class="btn <?php echo esc_attr($ga4page_cls); ?> bg-white me-3">
                    <?php esc_html_e("Ecommerce Reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                </a>
                <a href="admin.php?page=conversios-analytics-reports&subpage=gads" class="btn <?php echo esc_attr($gadspage_cls); ?> bg-white me-3">
                    <?php esc_html_e("Google Ads Reports", "enhanced-e-commerce-for-woocommerce-store") ?>
                </a>
            </div>
            <?php if ($ga4_measurement_id != "") { ?>
                <div class="ms-auto p-2 bd-highlight d-flex">
                    <h4 class="conv-link-blue d-flex pe-2" data-bs-toggle="modal" data-bs-target="#schedule_email_modal">
                        <span class="material-symbols-outlined conv-link-blue pe-1">check_circle</span>
                        <?php esc_html_e("Schedule Email", "enhanced-e-commerce-for-woocommerce-store") ?>
                    </h4>
                    <h4 class="conv-link-blue d-flex" data-bs-toggle="modal" data-bs-target="#convpdflogoModal">
                        <span class="material-symbols-outlined conv-link-blue pe-1">cloud_download</span>
                        <?php esc_html_e("Download PDF", "enhanced-e-commerce-for-woocommerce-store") ?>
                    </h4>
                </div>
            <?php } ?>
        </div>

        <?php if ($subpage == "ga4general" && $ga4_measurement_id == "") { ?>
            <div class="d-flex">
                <div class="col-12 alert alert-danger alert alert-danger h5 py-4 my-4 d-flex justify-content-center" role="alert">
                    <span class="material-symbols-outlined">
                        error
                    </span>
                    <?php esc_html_e("Please connect Google Analytics account to view the reports.", "enhanced-e-commerce-for-woocommerce-store") ?>
                    <a class="conv-link-blue d-flex ps-3" href="<?php echo esc_url_raw('admin.php?page=conversios-google-analytics"'); ?>">
                        <?php esc_html_e("Click here to connect", "enhanced-e-commerce-for-woocommerce-store") ?>
                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($subpage == "ga4ecommerce" && $ga4_measurement_id == "") { ?>
            <div class="d-flex">
                <div class="col-12 alert alert-danger alert alert-danger h5 py-4 my-4 d-flex justify-content-center" role="alert">
                    <span class="material-symbols-outlined">
                        error
                    </span>
                    <?php esc_html_e("Please connect Google Analytics account to view the reports.", "enhanced-e-commerce-for-woocommerce-store") ?>
                    <a class="conv-link-blue d-flex ps-3" href="<?php echo esc_url_raw('admin.php?page=conversios-google-analytics"'); ?>">
                        <?php esc_html_e("Click here to connect", "enhanced-e-commerce-for-woocommerce-store") ?>
                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php if ($subpage == "gads" && $google_ads_id == "") { ?>
            <div class="d-flex">
                <div class="col-12 alert alert-danger alert alert-danger h5 py-4 my-4 d-flex justify-content-center" role="alert">
                    <span class="material-symbols-outlined">
                        error
                    </span>
                    <?php esc_html_e("Please connect Google Ads account to view the reports.", "enhanced-e-commerce-for-woocommerce-store") ?>
                    <a class="conv-link-blue d-flex ps-3" href="<?php echo esc_url_raw('admin.php?page=conversios-google-analytics"'); ?>">
                        <?php esc_html_e("Click here to connect", "enhanced-e-commerce-for-woocommerce-store") ?>
                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>
                    </a>
                </div>
            </div>
        <?php } ?>

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
                <h5 class="modal-title" id="convpdflogoModalLabel">Download Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Size Message -->
            <div class="alert alert-success text-center text-underline text-success">
                <a href="https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=modal_setlogo&utm_campaign=upgrade" target="_blank">
                    Upgrade to Premium to set your logo in report PDF
                </a>
            </div>

            <!-- Modal Body -->
            <div class="modal-body d-flex justify-content-center align-items-center flex-column disabledsection">
                <!-- Image Preview Container -->
                <div id="image-preview-container" class="border d-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 36px; background-color: #f8f9fa;">
                    <span id="no-image-text" class="text-muted small">No image selected</span>
                    <img id="selected-media-preview" class="d-none img-fluid" src="" alt="Selected Media Preview" style="max-width: 120px; max-height: 36px;">
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <button id="select-media-button" class="btn btn-outline-primary me-2">
                        <i class="bi bi-upload"></i> Select Logo
                    </button>
                    <input type="hidden" id="attachment-id" name="attachment_id" value="">
                    <button id="save-logo-button" class="btn btn-success">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="conv-download-pdf" class="btn btn-primary w-100">
                    <i class="bi bi-file-earmark-pdf"></i>Download Now
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Schedule Email Modal box -->
<div class="modal email-modal fade" id="schedule_email_modal" tabindex="-1" aria-labelledby="schedule_email_modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div id="loadingbar_blue" class="progress-materializecss" style="
    display: none;
">
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
                    <?php
                    if ($sch_email_toggle_check == '0') { //enabled
                        $switch_cls = 'convEmail_default_cls_enabled';
                        $switch_checked = 'checked';
                        $txtcls = "form-fields-dark";
                    } else { //disabled
                        $switch_cls = 'convEmail_default_cls_disabled';
                        $switch_checked = '';
                        $txtcls = "form-fields-light";
                    } ?>
                    <div class="schedule-formbox">
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
                                    <?php esc_html_e("To get emails on your alternate address. ", "enhanced-e-commerce-for-woocommerce-store"); ?><a style="color:  #1085F1;cursor: pointer;" href="https://www.conversios.io/pricing/?utm_source=EE+Plugin+User+Interface&amp;utm_medium=dashboard&amp;utm_campaign=Upsell+at+Conversios" target="_blank"><?php esc_html_e("Upgrade To Pro", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
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
                                    <?php esc_html_e("By default, you will receive a Weekly report in your email inbox.", "enhanced-e-commerce-for-woocommerce-store"); ?><br><?php esc_html_e("To get report ", "enhanced-e-commerce-for-woocommerce-store"); ?><strong>Daily</strong>
                                    . <a href="https://www.conversios.io/pricing/?utm_source=EE+Plugin+User+Interface&amp;utm_medium=dashboard&amp;utm_campaign=Upsell+at+Conversios" target="_blank" style="color:  #1085F1;"><?php esc_html_e("Upgrade To Pro", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                </h5>
                            </div>
                            <div class="form-box">
                                <div class="save">
                                    <button id="schedule_email_save_config" class="btn  save-btn"><?php esc_html_e("Save", "enhanced-e-commerce-for-woocommerce-store"); ?></button>
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
                                    <div role="button" class="fw-bold pt-3" data-bs-dismiss="modal">Click here to close
                                        the popup</div>
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

<script>
    var start = moment().subtract(45, 'days');
    var end = moment().subtract(1, 'days');
    var start_date = "";
    var end_date = "";

    <?php if (!$ga4_measurement_id == "") { ?>
        cb(start, end);
    <?php } ?>


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
            jQuery("#conv_pdf_logo").removeClass('d-none');
            const element = document.getElementById('conv-report-main-div');

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
                const pdfHeight = (canvasHeight * 25.4) / 96; // Convert canvas height from px to mm

                const pdf = new jsPDF('p', 'mm', [pdfWidth, pdfHeight]);

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('ConversiosGA4Report.pdf');
                jQuery("#conv_pdf_logo").addClass('d-none');
            });
        });
    });
</script>