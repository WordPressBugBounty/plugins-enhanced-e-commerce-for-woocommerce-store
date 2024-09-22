<?php
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

$get_site_domain = unserialize(get_option('ee_api_data'));
$is_domain_claim = (isset($get_site_domain['setting']->is_domain_claim)) ? esc_attr($get_site_domain['setting']->is_domain_claim) : 0;
$is_site_verified = (isset($get_site_domain['setting']->is_site_verified)) ? esc_attr($get_site_domain['setting']->is_site_verified) : 0;
$plan_id = isset($get_site_domain['setting']->plan_id) ? $get_site_domain['setting']->plan_id : 1;
$connect_gmc_url = $TVC_Admin_Helper->get_custom_connect_url(admin_url() . 'admin.php?page=conversios&wizard=productFeedEven_gmcsetting');

$google_merchant_center_id  = '';
$merchan_id = '';
$is_channel_connected = false;
if (isset($ee_options['google_merchant_center_id']) && $ee_options['google_merchant_center_id'] !== '') {
    $google_merchant_center_id  = $ee_options['google_merchant_center_id'];
    $merchan_id = isset($ee_options['merchant_id']) ? $ee_options['merchant_id'] : '';
}
?>


<div class="convgads_mainbox">
    <form id="gadssetings_form" class="convgawiz_form_webgmc convpixsetting-inner-box mt-3 pb-4 convwiz_border"
        datachannel="GoogleGMC">
        <div class="convwizard_pixtitle mt-0 mb-3">
            <div class="d-flex flex-row align-items-center">
                <h5 class="m-0 h5">
                    <?php esc_html_e("Google Merchant Center", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </h5>
            </div>
            <div class="mt-1">
                <?php esc_html_e("Easily Set up product feed creation and campaign management using the simple steps given below.", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </div>

            <?php if (!CONV_IS_WC) { ?>
            <div class="mt-1 fw-bold">
                <?php esc_html_e("This feature is exclusively for WooCommerce websites.", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </div>
            <?php } ?>

            <div class="convpixsetting-inner-box pt-3">
                <h5 class="fw-normal mb-1">
                    <?php esc_html_e("Successfully signed in with account:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </h5>
                <span>
                    <?php echo ($g_mail == "") ? "Your email" : esc_attr($g_mail); ?>
                    <span class="conv-link-blue ps-2 conv_change_gauth">
                        <?php esc_html_e("Change", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </span>
                </span>
            </div>

            <div class="row">
                <div class="col-8 d-flex pt-4">
                    <img class="conv_channel_logo me-2 align-self-center"
                        src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_gmc_logo.png'); ?>">
                    <select id="google_merchant_center_id" name="google_merchant_center_id"
                        class="form-select selecttwo" style="width: 100%" disabled>
                        <?php if (!empty($google_merchant_center_id)) { ?>
                        <option value="<?php echo esc_attr($google_merchant_center_id); ?>" selected>
                            <?php echo esc_attr($google_merchant_center_id); ?></option>
                        <?php } ?>
                    </select>

                    <?php if ($g_email !== "") { ?>
                    <div class="col-4">
                        <span class="fs-14">&nbsp; Or &nbsp;</span>
                        <div class="createNewGMC btn btn-primary ">Create New</div>
                    </div>
                    <?php } ?>

                    <input type="hidden" id="gmc_google_ads_id"
                        value="<?php echo esc_attr($ee_options['google_ads_id']) ?>">
                </div>
            </div>
        </div>
    </form>

    <!-- Tab bottom buttons -->
    <div class="tab_bottom_buttons d-flex justify-content-end pt-4">

        <div class="ms-auto d-flex align-items-center">
            <button class="btn btn-outline-primary" style="width:184px" onclick="changeTabBox('webadsbox-tab')">
                <?php esc_html_e('Go Back', "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
            <button id="save_gmc" type="button" class="btn btn-primary px-5 ms-3">
                <span class="spinner-border text-light spinner-border-sm d-none" role="status"
                    aria-hidden="true"></span>
                <?php esc_html_e('Save & Next', "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
        </div>

    </div>
</div>

<!--Modal -->
<div class="modal fade" id="conv_create_gmc_new" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="feedForm" onfocus="this.className='focused'">
                <div class="modal-header bg-light p-2 ps-4">
                    <h5 class="modal-title fs-16 fw-500" id="feedType">
                        <?php esc_html_e("Create New Google Merchant Center Account", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h5>
                    <button type="button" class="btn-close pe-4 closeButton" data-bs-dismiss="modal" aria-label="Close"
                        onclick="jQuery('#feedForm')[0].reset()"></button>
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
                                        <input class="form-control mb-2" type="text" id="gmc_website_url"
                                            name="website_url" value="<?php echo esc_attr($tvc_data['user_domain']); ?>"
                                            placeholder="Enter Website" required>
                                        <span class="inner-text">Your Email</span><span class="text-danger"> *</span>
                                        <input class="form-control mb-2" type="text" id="gmc_email_address"
                                            name="email_address"
                                            value="<?php echo isset($tvc_data['g_mail']) ? esc_attr($tvc_data['g_mail']) : ""; ?>"
                                            placeholder="Enter email address" required>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="gmc_adult_content"
                                                name="adult_content" value="1" style="float:none">
                                            <label class="form-check-label fs-14" for="flexCheckDefault">
                                                <?php esc_html_e("My site contain", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                <b class="inner-text">
                                                    <?php esc_html_e("Adult Content", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                </b>
                                            </label>
                                        </div>
                                        <span class="inner-text">Your Store Name</span><span class="text-danger">
                                            *</span>
                                        <input class="form-control mb-0" type="text" id="gmc_store_name"
                                            name="store_name" value="" placeholder="Enter Store Name" required>
                                        <small>
                                            <?php esc_html_e("This name will appear in your Shopping Ads.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </small>

                                        <div class="mb-3 mt-2" id="conv_create_gmc_selectthree">
                                            <select id="gmc_country" name="country"
                                                class="form-select form-select-lg mb-3" style="width: 100%"
                                                placeholder="Select Country" required>
                                                <option value="">Select Country</option>
                                                <?php
                                                //$getCountris = file_get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json");

                                                $filesystem = new WP_Filesystem_Direct(true);
                                                $getCountris = $filesystem->get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json");

                                                $contData = json_decode($getCountris);
                                                foreach ($contData as $key => $value) {
                                                ?>
                                                <option value="<?php echo esc_attr($value->code) ?>"
                                                    <?php echo $tvc_data['user_country'] == $value->code ? 'selected = "selecetd"' : '' ?>>
                                                    <?php echo esc_attr($value->name) ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-check">
                                            <input id="gmc_concent" name="concent" class="form-check-input"
                                                type="checkbox" value="1" required style="float:none">
                                            <label class="form-check-label fs-12" for="concent">
                                                <?php esc_html_e("I accept the", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                                <a class="fs-14" target="_blank"
                                                    href="<?php echo esc_url("https://support.google.com/merchants/answer/160173?hl=en"); ?>"><?php esc_html_e("terms & conditions", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
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
                                    <li><a target="_blank"
                                            href="<?php echo esc_url("https://support.google.com/merchants/answer/6149970?hl=en"); ?>"><?php esc_html_e("Google Shopping ads policies", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                    </li>
                                    <li><a target="_blank"
                                            href="<?php echo esc_url("https://support.google.com/merchants/answer/6150127"); ?>"><?php esc_html_e("Accurate Contact Information", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                    </li>
                                    <li><a target="_blank"
                                            href="<?php echo esc_url("https://support.google.com/merchants/answer/6150122"); ?>"><?php esc_html_e("Secure collection of process and personal data", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                    </li>
                                    <li><a target="_blank"
                                            href="<?php echo esc_url("https://support.google.com/merchants/answer/6150127"); ?>"><?php esc_html_e("Return Policy", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                    </li>
                                    <li><a target="_blank"
                                            href="<?php echo esc_url("https://support.google.com/merchants/answer/6150127"); ?>"><?php esc_html_e("Billing terms & conditions", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                    </li>
                                    <li><a target="_blank"
                                            href="<?php echo esc_url("https://support.google.com/merchants/answer/6150118"); ?>"><?php esc_html_e("Complete checkout process", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button data-bs-dismiss="modal"
                    style="width:112px; height:38px; border-radius: 4px; padding: 8px; gap:10px; border: 1px solid #ccc"
                    class="btn btn-light fs-14 fw-medium" id="model_close_gmc_creation">Cancel</button>
                <button id="create_merchant_account_new"
                    style="width:112px; height:38px; border-radius: 4px; padding: 8px; gap:10px;"
                    class="btn btn-primary fs-14 fw-medium">Create</button>
            </div>
        </div>
    </div>
</div>
<script>
<?php if ((isset($cust_g_email) && $cust_g_email != "")) { ?>
jQuery('.pawizard_tab_but').on('shown.bs.tab', function(e) {
    if (jQuery(e.target).attr('aria-controls') == "webgmcbox") {
        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        list_google_merchant_account(tvc_data);
    }
});
<?php } ?>

// jQuery(document).on("change", "#google_merchant_center_id", function() {
//     if (jQuery(this).val() == "") {
//         jQuery("#save_gmc").addClass("disabledsection");
//     } else {
//         jQuery("#save_gmc").removeClass("disabledsection");
//     }
// });

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
                    list_google_merchant_account(tvc_data, "", response.account.id, response
                        .merchant_id);
                } else {}
            }
        });
    }
});
//Remove Error class on change
// jQuery(document).on("change", "#google_merchant_center_id", function() {
//     jQuery('.selection').find("[aria-labelledby='select2-google_merchant_center_id-container']").removeClass('selectError');
//     if (jQuery('#google_merchant_center_id').find(':selected').val() !== '') {
//         jQuery('.gmc_account_id_step').removeClass('disabled')
//     } else {
//         jQuery('.gmc_account_id_step').addClass('disabled')
//     }
// })

//Save GMC channel       
jQuery(document).on('click', '#save_gmc', function() {
    save_gmc_settings('GMC');
});

function save_gmc_settings(Channel) {
    jQuery("#save_gmc").find(".spinner-border").addClass("d-none");
    jQuery("#save_gmc").removeClass('disabledsection');
    changeTabBox("webfbbox-tab");
    var selected_vals = {};
    var conv_options_type = [];
    var data = {};
    if (Channel == 'GMC') {
        var update_site_domain = '';
        if (google_merchant_center_id != jQuery("#google_merchant_center_id").val()) {
            update_site_domain = 'update';
        }
        conv_options_type = ["eeoptions", "eeapidata", "middleware"];
        selected_vals["subscription_id"] = "<?php echo esc_js($subscriptionId) ?>";
        selected_vals["google_merchant_center_id"] = jQuery("#google_merchant_center_id").val();
        selected_vals["google_merchant_id"] = jQuery("#google_merchant_center_id").val();
        selected_vals["merchant_id"] = jQuery('#google_merchant_center_id').find(':selected').data('merchant_id');
        selected_vals["website_url"] = "<?php echo esc_js(get_site_url()); ?>";
        selected_vals["conv_onboarding_done_step"] = "<?php echo esc_js("4"); ?>";

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
            jQuery("#save_gmc").find(".spinner-border").addClass("d-none");
            jQuery("#save_gmc").removeClass('disabledsection');
        }
    });

}


//Get Google Merchant Id
function list_google_merchant_account(tvc_data, selelement, new_gmc_id = "", new_merchant_id = "") {
    conv_change_loadingbar_popup("show");
    conv_change_loadingbar("show");
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
                        jQuery('#save_gmc').prop('disabled', false)
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
                        jQuery('#save_gmc').prop('disabled', false)
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
        }
    });
}
</script>