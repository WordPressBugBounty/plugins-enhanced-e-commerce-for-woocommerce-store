<?php
$is_sel_disable = 'disabled';


$cust_g_email =  (isset($tvc_data['g_mail']) && esc_attr($subscriptionId)) ? esc_attr($tvc_data['g_mail']) : "";

$selectedEvents = isset($ee_options['gtm_channel_settings']["GoogleAds"]["tag"]) ? $ee_options['gtm_channel_settings']["GoogleAds"]["tag"] : [];

$selectedEventNames = array_column($selectedEvents, 'name');
$selectedEventId = array_column($selectedEvents, 'tagId');


// Number of columns for event setting
$columns = 2;

// get store id
$tvs_admin = new TVC_Admin_Helper();
$tvs_admin_data = $tvs_admin->get_ee_options_data();
$store_id = $tvs_admin_data['setting']->store_id;

$gtm_account_id = isset($ee_options['gtm_settings']['gtm_account_id']) ? $ee_options['gtm_settings']['gtm_account_id'] : "";
$gtm_container_id = isset($ee_options['gtm_settings']['gtm_container_id']) ? $ee_options['gtm_settings']['gtm_container_id'] : "";
?>



<div class="convgads_mainbox">

    <form id="gadssetings_form" class="convpixsetting-inner-box mt-4">

        <div class="convcard p-4 mt-0 rounded-3 shadow-sm">
            <?php
            $connect_url = $TVC_Admin_Helper->get_custom_connect_url_subpage(admin_url() . 'admin.php?page=conversios-google-analytics', "gadssettings");
            require_once("googlesignin.php");
            $site_url_feedlist = "admin.php?page=conversios-google-shopping-feed&tab=feed_list";
            ?>

            <!-- Google Ads  -->
            <?php
            $google_ads_id = (isset($googleDetail->google_ads_id) && $googleDetail->google_ads_id != "") ? $googleDetail->google_ads_id : "";
            $countries = json_decode(file_get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json"));
            $credit = json_decode(file_get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/country_reward.json"));
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
            <div id="analytics_box_ads" class="py-1">
                <div class="row pt-2">
                    <div class="col-7">
                        <h5 class="fw-normal mb-1">
                            <?php esc_html_e("Select Google Ads Account:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h5>
                        <select id="google_ads_id" name="google_ads_id" class="form-select form-select-lg mb-3 selecttwo google_ads_id" style="width: 100%" <?php echo esc_attr($is_sel_disable); ?>>
                            <?php if (!empty($google_ads_id)) { ?>
                                <option value="<?php echo esc_attr($google_ads_id); ?>" selected><?php echo esc_attr($google_ads_id); ?></option>
                            <?php } ?>
                            <option value="">Select Account</option>
                        </select>
                    </div>
                    <div id="spinner_mcc_check" class="mt-4 spinner-border text-primary d-none" role="status" style="margin-top: 32px !important;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="col-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm d-flex conv-enable-selection conv-link-blue align-items-center">
                            <span class="material-symbols-outlined md-18">edit</span>
                            <span class="px-1">
                                <?php esc_html_e("Edit", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </span>
                        </button>
                    </div>
                    <div id="conv_mcc_alert" class="my-3 mx-2 alert alert-danger d-none" role="alert">
                        <?php esc_html_e("You have selected a MCC account. Please select other google ads account to proceed further.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </div>
                    <div class="col-12 flex-row pt-1">
                        <h6 class="fw-normal mb-1">
                            <?php esc_html_e("OR", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </h6>

                        <div class="d-flex conv_create_gads_new_card rounded px-3 py-3">

                            <?php if ($off_credit_amt != "") { ?>
                                <div class="div">
                                    <h4 class="text-white">
                                        <?php esc_html_e("Redeem upto " . $off_credit_amt, "enhanced-e-commerce-for-woocommerce-store") ?>
                                    </h4>
                                    <span class="text-white">
                                        <?php esc_html_e("Create your first Google Ads account with us and redeem upto " . esc_attr($off_credit_amt) . " on the spend you make in the next 60 days.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </span>
                                </div>
                            <?php } else { ?>
                                <div class="d-flex">
                                    <span class="text-white d-flex align-items-center">
                                        <?php esc_html_e("Create your first Google Ads account with us and receive a credit of up to " . esc_attr($off_credit_amt) . " on your spending in the next 60 days.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </span>
                                </div>
                            <?php } ?>

                            <div class="align-self-end ms-auto">
                                <button id="conv_create_gads_new_btn" type="button" class="bg-white btn btn-outline-primary px-5 me-3" data-bs-toggle="modal" data-bs-target="#conv_create_gads_new">
                                    <?php esc_html_e("Create Now", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- Google Ads End-->
        </div>

        <!-- Accordion start -->
        <div class="accordion accordion-flush" id="accordionFlushExample">

            <div class="accordion-item mt-3 rounded-3 shadow-sm">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed conv-link-blue" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <?php esc_html_e("Enhance Conversions Tracking", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <small class="ms-2 fw-normal">
                            <?php esc_html_e("(For google ads conversion tracking)", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </small>
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo">
                    <div class="accordion-body pt-0">
                        <ul class="ps-0">

                            <li class="<?php echo !CONV_IS_WC ? 'hidden' : 'd-flex align-items-center my-2' ?>">
                                <div class="inlist_text_pre_pro ms-2 disabledsection" conversion_name="">
                                    <h5 class="mb-0"><?php esc_html_e("Add to Cart (Woocommerce)", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                    <div class="inlist_text_notconnected">
                                        <?php esc_html_e("Track 'add to cart' events to evaluate campaign effectiveness.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </div>
                                    <div class="inlist_text_connected d-flex d-none">
                                        <div class="text-success"><?php esc_html_e("Connected with Conversion ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                        <div class="inlist_text_connected_convid ps-2"></div>
                                    </div>
                                </div>

                                <span class="conv-link-blue ms-2 fw-bold-500 upgradetopro_badge ms-auto" popupopener="gadseec_inner">
                                    <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                                    <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </span>
                            </li>

                            <li class="<?php echo !CONV_IS_WC ? 'hidden' : 'd-flex align-items-center my-2' ?>">
                                <div class="inlist_text_pre_pro ms-2 disabledsection" conversion_name="">
                                    <h5 class="mb-0"><?php esc_html_e("Begin Checkout (Woocommerce)", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                    <div class="inlist_text_notconnected">
                                        <?php esc_html_e("Track 'begin checkout' events to evaluate campaign effectiveness.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </div>
                                    <div class="inlist_text_connected d-flex d-none">
                                        <div class="text-success"><?php esc_html_e("Connected with Conversion ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                        <div class="inlist_text_connected_convid ps-2"></div>
                                    </div>
                                </div>

                                <span class="conv-link-blue ms-2 fw-bold-500 upgradetopro_badge ms-auto" popupopener="gadseec_inner">
                                    <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                                    <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </span>
                            </li>

                            <li class="<?php echo !CONV_IS_WC ? 'hidden' : 'd-flex align-items-center my-2' ?>">
                                <div class="inlist_text_pre ms-2" conversion_name="PURCHASE">
                                    <h5 class="mb-0"><?php esc_html_e("Purchase (Woocommerce)", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                    <div class="inlist_text_notconnected">
                                        <?php esc_html_e("You can track all the Purchase events by adding the conversion label", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </div>
                                    <div class="inlist_text_connected d-flex d-none">
                                        <div class="text-success"><?php esc_html_e("Connected with Conversion ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                        <div class="inlist_text_connected_convid"></div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm ms-auto conv_con_modal_opener px-4 py-2" conversion_name="PURCHASE">
                                    <?php esc_html_e("Add", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </button>
                            </li>

                            <li class="d-flex align-items-center my-2">
                                <div class="inlist_text_pre ms-2" conversion_name="SUBMIT_LEAD_FORM">
                                    <h5 class="mb-0"><?php esc_html_e("Form Lead Submit", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                                    <div class="inlist_text_notconnected">
                                        <?php esc_html_e("You can track all the Form Submit events by adding the conversion label", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </div>
                                    <div class="inlist_text_connected d-flex d-none">
                                        <div class="text-success"><?php esc_html_e("Connected with Conversion ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                                        <div class="inlist_text_connected_convid ps-2"></div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm ms-auto conv_con_modal_opener px-4 py-2" conversion_name="SUBMIT_LEAD_FORM">
                                    <?php esc_html_e("Add", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </button>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item mt-3 rounded-3 shadow-sm">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed conv-link-blue" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        <?php esc_html_e("Audience Building", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <small class="ms-2 fw-normal">
                            <?php esc_html_e("(For google ads conversion tracking)", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </small>
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse show" aria-labelledby="flush-headingThree">
                    <div class="accordion-body pt-0">

                        <!-- Checkboxes -->
                        <div id="checkboxes_box">

                            <div class="d-flex pt-2 align-items-center">
                                <input class="form-check-input" type="checkbox" value="1" id="remarketing_tags" name="remarketing_tags" <?php echo (esc_attr($googleDetail->remarketing_tags) == 1) ? 'checked="checked"' : ''; ?>>
                                <label class="form-check-label ps-2" for="remarketing_tags">
                                    <b><?php esc_html_e("Enable remarketing tags: ", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                </label>
                            </div>
                            <div class="ps-4 pb-2">
                                <?php esc_html_e("Show ads to people who have previously visited your website ", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </div>

                            <div class="conv_highlightedcard">
                                <div class="d-flex pt-2 align-items-center">
                                    <input class="form-check-input" type="checkbox" value="1" style="pointer-events: none;">
                                    <label class="form-check-label ps-2 readonly disabled">
                                        <b><?php esc_html_e("Enable dynamic remarketing tags", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                                    </label>
                                    <span class="conv-link-blue ms-2 fw-bold-500 upgradetopro_badge ms-auto" popupopener="gadseec_inner">
                                        <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                                        <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    </span>
                                </div>
                                <div class="pb-2">
                                    <ul class="pt-2">
                                        <li><b><?php esc_html_e("View_item:", "enhanced-e-commerce-for-woocommerce-store"); ?></b> <?php esc_html_e("Retarget users who browsed specific products.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                        <li><b><?php esc_html_e("Add_to_cart:", "enhanced-e-commerce-for-woocommerce-store"); ?></b> <?php esc_html_e("Remarket to users who added items to their cart but abandoned it.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                        <li><b><?php esc_html_e("Begin_checkout:", "enhanced-e-commerce-for-woocommerce-store"); ?></b> <?php esc_html_e("Target users who initiated checkout but didn't complete the purchase.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                        <li><b><?php esc_html_e("Purchase:", "enhanced-e-commerce-for-woocommerce-store"); ?></b> <?php esc_html_e("Include past purchasers in retargeting campaigns for upsell or cross-sell opportunities.", "enhanced-e-commerce-for-woocommerce-store"); ?></li>
                                    </ul>
                                </div>
                            </div>


                            <div class="d-flex py-2 align-items-center">
                                <input class="form-check-input" type="checkbox" value="1" id="link_google_analytics_with_google_ads" name="link_google_analytics_with_google_ads" <?php echo (esc_attr($googleDetail->link_google_analytics_with_google_ads) == 1) ? 'checked="checked"' : ''; ?>>
                                <label class="form-check-label ps-2" for="link_google_analytics_with_google_ads">
                                    <?php esc_html_e("Link Google analytics with Google ads", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </label>
                            </div>


                            <div class="d-flex pt-2 align-items-center">
                                <?php $ga_GMC = isset($get_ee_options_data['setting']->ga_GMC) ? $get_ee_options_data['setting']->ga_GMC : 0; ?>
                                <input class="form-check-input" type="checkbox" value="1" id="ga_GMC" name="ga_GMC" <?php echo isset($_GET['feedType']) && (esc_attr($googleDetail->google_merchant_id) !== '') || esc_attr($ga_GMC) == 1 ? 'checked' : ''; ?> <?php echo ($googleDetail->google_merchant_id == "" ? "disabled" : "") ?>>
                                <label class="form-check-label ps-2" for="ga_EC">
                                    <?php esc_html_e("Link Google ads with Google Merchant Center", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                </label>
                            </div>

                        </div>
                        <!-- Checkboxes end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Accordion End -->


        <input type="hidden" id="merchant_id" name="merchant_id" value="<?php echo esc_html($googleDetail->merchant_id) ?>">
        <input type="hidden" id="google_merchant_id" name="google_merchant_id" value="<?php echo esc_html($googleDetail->google_merchant_id) ?>">
        <input type="hidden" id="feedType" name="feedType" value="<?php echo isset($_GET['feedType']) && $_GET['feedType'] != '' ? esc_attr(sanitize_text_field($_GET['feedType'])) : '' ?>" />


    </form>

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
                    <span id="gadsinviteloader" class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
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
                <h4 class="modal-title text-white"><?php esc_html_e("Settings for Conversion", "enhanced-e-commerce-for-woocommerce-store"); ?></h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="conversion_setting_form" class="disabledsection">
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
                                    <?php esc_html_e("Create New Conversion Action", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                                <div>
                                    <small><?php esc_html_e("If you haven't yet created a conversion ID and label in your Google Ads account, you can create a new one by clicking here.", "enhanced-e-commerce-for-woocommerce-store"); ?></small>
                                </div>

                                <input type="hidden" class="form-control" id="concre_name">
                                <input type="hidden" class="form-control" id="concre_value">
                                <input type="hidden" class="form-control" id="concre_category">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="selected_conversion" id="selected_conversion">
                </form>
            </div>
            <div class="modal-footer d-flex">
                <button id="convsave_conversion_but" type="button" class="btn btn-success disabled">
                    Save changes
                    <div class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Conversion creation edit popup end -->


<!-- Modal -->
<div class="modal fade" id="convgadseditconfirm" tabindex="-1" aria-labelledby="convgadseditconfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="convgadseditconfirmLabel">Change Google Ads Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Changing Google Ads Account will remove selected conversions ID and Labels
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="conv_changegadsacc_but" type="button" class="btn btn-primary">
                    Change Now
                    <div class="spinner-border spinner-border-sm d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>


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
    });
</script>

<script>
    function clearallcheck() {
        jQuery("#checkboxes_box input.form-check-input").prop('checked', false);
        jQuery("#checkboxes_box input.form-check-input").removeAttr('checked');
    }

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
                        add_message("warning", "There are no Google ads accounts associated with email.");
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

                            jQuery("#accordionFlushExample .accordion-body").removeClass("disabledsection");
                            jQuery(".accordion-button").removeClass("text-dark");
                        }
                    }
                } else {
                    var error_msg = response.errors;
                }
                jQuery('#ads-account').prop('disabled', false);
            }

        });

        jQuery("#conv_conversion_select").trigger("change");
    }


    //Get conversion list
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
                        if (selectedVal == item) {
                            selected = response[item];
                        }
                        AccOptions = AccOptions + '<option value="' + response[item] + '">' + response[item] + ' - ' + item + '</option>';
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
                console.log(response);
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
        var tvc_ajax_url = '<?php echo esc_url_raw(admin_url('admin-ajax.php')); ?>';
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

        jQuery(".conv-enable-selection").click(function() {
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

        <?php
        $gads_conversions = [];
        if (array_key_exists("gads_conversions", $ee_options)) {

            $gads_conversions = $ee_options["gads_conversions"];
            // When GTM automation is selected and if value not exist in the DB, below code will need to use, but for now on hold.
            /*if( !in_array(241,$selectedEventId) ) {
                unset($gads_conversions['ADD_TO_CART']);
            }
            if( !in_array(240,$selectedEventId) ) {
                unset($gads_conversions['BEGIN_CHECKOUT']);
            }
            if( !in_array(56,$selectedEventId) ) {
                unset($gads_conversions['PURCHASE']);
            }
            if( !in_array(256,$selectedEventId) ) {
                unset($gads_conversions['SUBMIT_LEAD_FORM']);
            }*/
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


        // jQuery(".conv-enable-selection_cli").click(function() {
        //     jQuery(".conv-enable-selection_cli").addClass('disabled');
        //     get_conversion_list(tvc_data);
        // });


        jQuery(document).on("change", "form#gadssetings_form", function() {
            <?php if ($cust_g_email != "") { ?>

                var ee_conversio_send_to_static = jQuery("#ee_conversio_send_to_static").val();
                jQuery("#ee_conversio_send_to_static").removeClass("conv-border-danger");
                jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled");
                jQuery(".conv-btn-connect").addClass("conv-btn-connect-enabled-google");
                jQuery(".conv-btn-connect").text('Save');
            <?php } else { ?>
                jQuery(".tvc_google_signinbtn").trigger("click");
            <?php } ?>
        });


        <?php if ($cust_g_email == "") { ?>
            jQuery("#conv_create_gads_new_btn").addClass("disabled");
            jQuery(".conv-enable-selection, .conv-enable-selection_cli").addClass("d-none");
            jQuery('.event-setting-row').addClass("convdisabledbox")
        <?php } ?>


        <?php if (isset($_GET['subscription_id']) && sanitize_text_field($_GET['subscription_id'])) { ?>
            list_google_ads_account(tvc_data);
            jQuery(".conv-enable-selection").addClass("d-none");
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

        // jQuery(document).on("change", "#google_ads_id", function() {
        //     if (jQuery("#google_ads_conversion_tracking").is(":checked")) {
        //         get_conversion_list();
        //     }
        // })


        jQuery(document).on("click", ".conv-btn-connect-enabled-google", function() {
            conv_change_loadingbar("show");
            var feedType = jQuery('#feedType').val();
            var google_ads_id = jQuery("#google_ads_id").val();
            var remarketing_tags = jQuery("#remarketing_tags").val();
            var link_google_analytics_with_google_ads = jQuery("#link_google_analytics_with_google_ads").val();
            var google_ads_conversion_tracking = jQuery("#google_ads_conversion_tracking").val();
            var ga_EC = jQuery("#ga_EC").val();
            var ee_conversio_send_to = jQuery("#ee_conversio_send_to").val();
            var ga_GMC = jQuery('#ga_GMC').val();

            var selectedoptions = {};

            selectedoptions['google_ads_id'] = jQuery("#google_ads_id").val();

            selectedoptions["subscription_id"] = "<?php echo esc_js($tvc_data['subscription_id']) ?>";
            selectedoptions['merchant_id'] = jQuery("#merchant_id").val();
            selectedoptions['google_merchant_id'] = jQuery("#google_merchant_id").val();


            jQuery('#checkboxes_box input[type="checkbox"]').each(function() {

                if (jQuery(this).is(':checked') && !jQuery(this).hasClass('tracking_event_selection')) {
                    selectedoptions[jQuery(this).attr("name")] = jQuery(this).val();
                } else {
                    selectedoptions[jQuery(this).attr("name")] = "0";
                }
            });
            // get selected tracking
            let checkedVals = jQuery('.tracking_event_selection:checkbox:checked').map(function() {
                return {
                    "tagId": this.id.replaceAll('et_id_', ''),
                    "name": this.value,
                    "label": jQuery(this).data('label')
                }
            }).get();

            let channel_data = {
                "GoogleAds": {
                    "tag": (jQuery('#google_ads_id').val() != '' && checkedVals.length > 0) ? checkedVals : ['']
                }
            };
            let selected_event_checkboxes = {
                "GoogleAds": {
                    "tag": checkedVals.length > 0 ? checkedVals : ['']
                }
            }
            selectedoptions['gtm_channel_settings'] = selected_event_checkboxes;
            selectedoptions['gtm_channel_settings']['channel'] = 'GoogleAds';
            selectedoptions['web_property_id'] = "<?php echo esc_js($googleDetail->ga4_analytic_account_id); ?>";
            selectedoptions['web_property'] = "<?php echo esc_js($googleDetail->measurement_id); ?>";

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
                    var user_modal_txt = "Congratulations, you have successfully connected your <br> Google Ads Account ID: " + google_ads_id + ".";
                    if (feedType !== '') {
                        window.location.replace("<?php echo esc_url_raw($site_url_feedlist); ?>");
                    } else if (response == "0" || response == "1") {
                        jQuery(".conv-btn-connect-enabled-google").text("Connect");
                        jQuery("#conv_save_success_txt").html(user_modal_txt);

                        if (channel_data['GoogleAds']['tag'].length > 0) {
                            let selectedEventHtml = '<h4 class="fw-normal pt-3"><span><?php esc_html_e("Selected Events:", "enhanced-e-commerce-for-woocommerce-store"); ?></span></h4><div class="row p-3 pt-0 pb-0">';
                            channel_data['GoogleAds']['tag'].map(function(v, i) {
                                if (v['label'] != undefined) {
                                    selectedEventHtml += '<div class="col-md-6 d-flex"> <img class="align-self-center p-2 pt-0 pb-0" src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . "/admin/images/icon/check_circle_black.png"); ?>" /> <label class="p-2">' + v['label'] + '</label></div>';
                                }

                            })

                            selectedEventHtml += '</div>'
                            jQuery("#conv_save_event_txt").html(selectedEventHtml)
                        }


                        jQuery("#conv_save_success_modal").modal("show");
                    }
                    conv_change_loadingbar("hide");
                }
            });

        });

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
            var conversion_name = jQuery(this).attr("conversion_name");
            conversion_label_arr = {
                ADD_TO_CART: "Select Conversion ID Label For Add To Cart",
                BEGIN_CHECKOUT: "Select Conversion ID Label For Begin Checkout",
                PURCHASE: "Select Conversion ID Label For Purchase",
                SUBMIT_LEAD_FORM: "Select conversion id and label from below"
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
                SUBMIT_LEAD_FORM: "Conversios-FormSubmit",
            }

            jQuery("#conv_con_modalLabel").html(conversion_label_arr[conversion_name]);
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
                    } else if (conversion_category == "SUBMIT_LEAD_FORM") {
                        jQuery("input[name='COV - GAds - Form Submit - Conversion']").prop('checked', true);
                    } else if (conversion_category == "BEGIN_CHECKOUT") {
                        jQuery("input[name='COV - GAds - BeginCheckout - Conversion']").prop('checked', true);
                    } else {
                        jQuery("input[name='COV - Google Ads Conversion Tracking Purchase']").prop('checked', true);
                        jQuery("input[name='COV - Google ads dynamic remarketing purchase']").prop('checked', true)
                    }


                }
            });

        });
        <?php if ($google_ads_id == "" || $cust_g_email == "") { ?>
            jQuery("#accordionFlushExample .accordion-body").addClass("disabledsection");
            jQuery(".accordion-button").addClass("text-dark");
        <?php } ?>

        jQuery(document).on("change", "#google_ads_id", function() {
            if (jQuery("#google_ads_id").val() != "") {
                jQuery("#accordionFlushExample .accordion-body").removeClass("disabledsection");
            } else {
                jQuery("#accordionFlushExample .accordion-body").addClass("disabledsection");
            }
            cleargadsconversions();
        })

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
                    CONVNonce: "<?php echo esc_html(wp_create_nonce('conv_checkMcc-nonce')); ?>"
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