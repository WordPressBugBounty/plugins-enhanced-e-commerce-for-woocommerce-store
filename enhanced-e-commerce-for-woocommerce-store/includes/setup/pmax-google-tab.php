<div class="w-96 campaignTableDiv <?php echo isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? 'd-none' : '' ?> ">
    <nav class="navbar navbar-light bg-white shadow-sm topNavBar d-none" style="display:none">
        <div class="col-12">
            <div class="row ms-0 p-1">
                <div class="col-6 mt-2">
                    <!-- <div class="form-check form-check-inline all-campign">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                    <label class="form-check-label" for="inlineRadio1">All Campaigns</label>
                    </div>
                    <div class="form-check form-check-inline fail-campign ">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">Failed Campaigns</label>
                    </div> -->
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <button
                        class="createCampaign btn btn-soft-primary fs-14 me-3 campaignClass create-campaign pointer"
                        title="Select Feed from below to create performance max campaign in Google Ads." style="pointer-events: auto !important">
                        <?php esc_html_e("Create New Campaign", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>

                </div>
            </div>
        </div>
    </nav>
    <div class="table-responsive shadow-sm convo-table-manegment" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px;">
        <table class="table" id="all_campagin_list_table" style="width:100%">
            <thead style="border-bottom: none !important; border-style: none !important;height: 40px;">
                <tr class="heading-row">
                    <th scope="col" class="text-start">Campaign Name</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-end">Daily Budget</th>
                    <th scope="col" class="text-end">Clicks</th>
                    <th scope="col" class="text-end">Cost (<?php echo esc_html($ecom_reports_gads_currency); ?>)</th>
                    <th scope="col" class="text-end">Conversions</th>
                    <th scope="col" class="text-end">Sales</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="table-body bg-white" style="border-top: none !important;">
                <?php
                foreach ($allresult as $result) {
                    $status = $result->campaign->status; // == 'ENABLED' ? 'Enabled':'Paused';
                    $dailyBudget = number_format((float)$result->campaignBudget->amountMicros / 1000000, 2, '.', '');
                    $sales = isset($result->metrics->conversionsValue) ? $result->metrics->conversionsValue : 0;
                ?>
                    <tr data-from="middle">
                        <td scope="row" data-sort="<?php echo esc_html($result->campaign->id) ?>" class="text-start">
                            <div class="selling-head"><?php echo esc_html(stripslashes($result->campaign->name)) ?></div>
                        </td>

                        <td class="status-class text-center">
                            <span class="status-text" data-status="<?php echo esc_html(strtolower($status)) ?>">
                                <?php echo esc_html($status) ?> </span>
                        </td>
                        <td class="text-end"><?php echo esc_html($dailyBudget) ?></td>
                        <td class="text-end"><?php echo esc_html($result->metrics->clicks) ?></td>
                        <td class="text-end"><?php echo esc_html(number_format((float)$result->metrics->costMicros / 1000000, 2, '.', '')) ?></td>
                        <td class="text-end"><?php echo esc_html($result->metrics->conversions) ?></td>
                        <td class="text-end"><?php echo esc_html($sales) ?></td>
                        <td data-id="<?php echo esc_html($result->campaign->id) ?>" class="text-center">
                            <span class="d-none"><?php // echo esc_html($result->campaign->id) ?></span>
                            <label class="text-primary pointer edit-btn" onclick="editCampaign(<?php echo esc_html($result->campaign->id) ?>)">Edit</label>
                        </td>
                    </tr>
                    <?php }
                //$google_detail = $TVC_Admin_Helper->get_ee_options_data();
                $google_detail = $TVC_Admin_Helper->get_user_subscription_data();
                $store_id = (isset($google_detail) && isset($google_detail->store_id)) ? $google_detail->store_id : '';
                $campaign_data = $TVC_Admin_Helper->ee_get_results('ee_pmax_campaign');
                if (empty($campaign_data) === FALSE) {
                    $subscriptionId = $subscription_id;
                    $customObj = new CustomApi();
                    foreach ($campaign_data as $value) {
                        $request_id = sanitize_text_field($value->request_id);
                        $campaign_name = sanitize_text_field($value->campaign_name);
                        $daily_budget = sanitize_text_field($value->daily_budget);
                        $target_country_campaign = sanitize_text_field($value->target_country_campaign);
                        $start_date = sanitize_text_field($value->start_date);
                        $target_roas = sanitize_text_field($value->target_roas);
                        $end_date = sanitize_text_field($value->end_date);
                        $status = sanitize_text_field($value->status);
                        $feed_id = sanitize_text_field($value->feed_id);
                        $updated_date = sanitize_text_field($value->updated_date);

                        $data = ['request_id' => $request_id, 'subscription_id' => $subscriptionId, 'store_id' => $store_id];
                        $pmaxStatus = $customObj->pMaxRetailStatus($data);

                        $pStatus = '';
                        if (isset($pmaxStatus->data->request_status) && ($pmaxStatus->data->request_status == 1 || $pmaxStatus->data->request_status == 0)) {
                            $pStatus = 'Created Successfully';
                        } else {
                            $pStatus = 'Failed'; ?>
                            <tr>
                                <td scope="row" class="text-start">
                                    <div class="selling-head"><?php echo esc_html($campaign_name); ?></div>
                                </td>

                                <td class="status-class">
                                    <span class="status-text" data-status="<?php echo esc_html(strtolower($pStatus)) ?>">
                                        <?php echo esc_html($pStatus); ?></span>
                                </td>
                                <td class="text-end"><?php echo esc_html($daily_budget) ?></td>
                                <td class="text-end">NA</td>
                                <td class="text-end">NA</td>
                                <td class="text-end">NA</td>
                                <td class="text-end">NA</td>
                                <td>
                                    <span class="d-none"><?php // echo esc_html($result->campaign->id) ?></span>
                                    <label class="text-primary pointer" onclick="editFailedCampaign(<?php echo esc_html($value->id) ?>)">Edit</label>
                                </td>
                            </tr>
                <?php }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<div class="w-96 createCampaignDiv <?php echo isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? '' : 'd-none' ?>">
    <!-- <span class="fw-bold text-dark fs-20">
        <?php esc_html_e("Campaign Management*", "enhanced-e-commerce-for-woocommerce-store") ?>
    </span>
    <p class="text-grey fs-16 fw-400 mt-2">
        <?php esc_html_e("Manage your Performance Max (PMax) campaigns to reach customers across all Google channels. This involves setting up, optimizing, and monitoring your campaigns to ensure they are effectively driving conversions.
    ", "enhanced-e-commerce-for-woocommerce-store") ?>
    </p> -->
    <div class="campaign-shadow-sm bg-white" style="border-radius:8px;min-height: 678px;">
        <div id="loadingbar_blue_modal_campign" class="progress-materializecss d-none ps-2 pe-2" style="width:65.5%; position: absolute;">
            <div class="indeterminate"></div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-7 py-4 px-5">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <img style="width:32px; height:32px" class="" src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/google_ads_icon.png'); ?>" alt="">
                            <span class="fw-600 fs-24 ms-2 campaign-pmax-title">Create Pmax Campaign</span>
                        </div>
                        <div><span class="campaign-go-back" id="cancel"><span class="dashicons dashicons-arrow-left-alt"></span>&nbsp;Go Back</span></div>
                    </div>
                    <div class="mt-3">
                        <span class="fs-16" style="font-weight:700; color: #5F6368">Product Source</span>
                        <div class="row mt-2">
                            <div class="col-12" style="padding-left: 1.2rem !important">
                                <div class="form-check form-check">
                                    <input class="form-check-input" type="radio" name="productSource" id="allproduct" value="All Product" <?php echo isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? '' : 'checked' ?>>
                                    <label class="form-check-label" for="allproduct">All Products From Google Merchant Center</label>
                                </div>
                            </div>
                            <div class="col-5 mt-2" style="padding-left: 1.2rem !important">
                                <div class="form-check form-check">
                                    <input class="form-check-input" type="radio" name="productSource" id="specific_feeds" value="Feeds" <?php echo isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="specific_feeds">Select Specific Product Feed</label>
                                </div>
                            </div>
                            <div class="col-7">
                                <select id="selecetdCampaign" multiple="multiple" class="form-control" name="selecetdCampaign[]"
                                    placeholder="Enter Campaign Name" style="width: 100%;" aria-labelledby="dropdownMenuButton" <?php echo isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? '' : 'disabled' ?>>

                                    <?php
                                    $selected_cid = isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? explode(',', urldecode(sanitize_text_field(wp_unslash($_GET['cid'])))) : [];
                                    foreach ($feed_results as $row) {
                                        $feed_name = sanitize_text_field($row->feed_name);
                                        $selected = is_array($selected_cid) && in_array($row->id, $selected_cid) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo esc_attr($row->id); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_html($feed_name); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 d-flex align-items-center infoMsg mt-2 d-none">
                                <span class="material-symbols-outlined fs-16 me-2" style="color:#1967D2; font-weight:500">
                                    info
                                </span>
                                <span class="fs-12" style="color:#1967D2; font-weight:500">Creating feed-wise campaigns are limited to 1,000 products. Select your feed accordingly.</span>
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Campaign Name &nbsp;<span class="text-danger fs-16">*</span></span>
                                <input type="text" id="campaignName" name="campaignName" class="form-control flex-grow-1" placeholder="Enter Campaign Name">
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Daily Budget &nbsp;<span class="text-danger fs-16">*</span></span>
                                <input type="text" id="daily_budget" name="daily_budget" class="form-control" placeholder="Enter Daily Budget">
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Country &nbsp;<span class="text-danger fs-16">*</span></span>
                                <select id="target_country_campaign" name="target_country_campaign" class="form-control" style="width:100%">
                                    <option value="">Select Country</option>
                                    <?php
                                    $selecetdCountry = $conv_data['user_country'];
                                    foreach ($contData as $country) { ?>
                                        <option value="<?php echo esc_html($country->code) ?>" <?php echo $selecetdCountry === $country->code ? 'selected = "selecetd"' : '' ?>><?php echo esc_html($country->name) ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">ROAS</span>
                                <span class="fs-10" style="width:100%"><input type="text" id="target_roas" name="target_roas" class="form-control" placeholder="Add Target ROAS (%)">Formula: Conversion value ÷ ad spend x 100% = target ROAS percentage</span>
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Start Date &nbsp;<span class="text-danger fs-16">*</span></span>
                                <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Start Date">
                                <span class="startDateError text-danger fs-10"></span>
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">End Date &nbsp;<span class="text-danger fs-16">*</span></span>
                                <input type="date" id="end_date" name="end_date" class=form-control placeholder="End Date">
                                <span class="endDateError text-danger fs-10"></span>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-check form-check-inline" style="margin-left: 5px">
                                    <input class="form-check-input" type="radio" name="status" id="ENABLED" value="ENABLED" checked>
                                    <label class="form-check-label" for="ENABLED">Enable</label>
                                </div>
                                <div class="form-check form-check-inline ml-2">
                                    <input class="form-check-input" type="radio" name="status" id="PAUSED" value="PAUSED">
                                    <label class="form-check-label" for="PAUSED">Pause</label>
                                </div>
                            </div>
                            <input type="hidden" name="campaignBudget" id="campaignBudget">
                            <input type="hidden" name="resourceName" id="resourceName">
                            <input type="hidden" name="campaign_id" id="campaign_id">
                            <input type="hidden" name="edit_country_campaign" id="edit_country_campaign">
                            <div>
                                <!-- <button class="btn mt-3 fs-14" id="cancel" style="width: 180px; height: 38px;border-color:#1967D2; background-color: #fff; color:#1967D2">
                                    Cancel
                                </button> -->
                                <button class="btn mt-3 fs-14" id="submitCampaign" style="width: 180px; height: 38px; background-color: #1967D2; color:#fff">
                                    Create Campaign
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-5 p-4" style="background-color: #1967D2; border-top-right-radius:8px;border-bottom-right-radius:8px; margin:0 12px 0 -12px">

                    <h4 class="fw-bold text-white">Ads Preview:</h4>
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="campaignTab" role="tablist">
                        <li class="nav-item me-4" role="presentation">
                            <button class="nav-link active" id="desktop-tab" data-bs-toggle="tab" data-bs-target="#desktop" type="button" role="tab" aria-controls="desktop" aria-selected="true">Desktop</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="mobile-tab" data-bs-toggle="tab" data-bs-target="#mobile" type="button" role="tab" aria-controls="mobile" aria-selected="false">Mobile</button>
                        </li>
                    </ul>
                    <!-- Tab Content -->
                    <div class="tab-content pt-2" id="campaignTabContent">
                        <div class="tab-pane fade show active" id="desktop" role="tabpanel" aria-labelledby="desktop-tab">

                            <!-- Desktop slider                                             -->
                            <div id="carouselCampainDesk" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                                <div class="carousel-indicators">
                                    <div class="carousel-ind active" data-bs-target="#carouselCampainDesk" data-bs-slide-to="0" aria-current="true">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/logo_youtube.png'); ?>" class="">
                                        <h6 class="m-0">Youtube</h6>
                                    </div>
                                    <div class="carousel-ind" data-bs-target="#carouselCampainDesk" data-bs-slide-to="1">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/gmail-logo.svg'); ?>" class="">
                                        <h6 class="m-0">Gmail</h6>
                                    </div>
                                    <div class="carousel-ind" data-bs-target="#carouselCampainDesk" data-bs-slide-to="2">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_galpha_logo.png'); ?>" class="">
                                        <h6 class="m-0">Search</h6>
                                    </div>
                                    <div class="carousel-ind" data-bs-target="#carouselCampainDesk" data-bs-slide-to="3">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/display_icon_48.svg'); ?>" class="">
                                        <h6 class="m-0">Display</h6>
                                    </div>
                                    <!-- <div class="carousel-ind" data-bs-target="#carouselCampainDesk" data-bs-slide-to="4">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/discover_icon_48.svg'); ?>" class="">
                                        <h6 class="m-0">Discover</h6>
                                    </div> -->
                                </div>
                                <div class="carousel-inner">
                                    <!-- Slide 1 -->
                                    <div class="carousel-item active text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/desk-youtube.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/desk-gmail.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/desk-search.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center desk-display">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/desk-display.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <!-- <div class="carousel-item text-center">
                                        <p class="text-white">Discover ads are not available on desktop devices</p>
                                        <div class="carousel-caption">
                                        </div>
                                    </div> -->

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="mobile" role="tabpanel" aria-labelledby="mobile-tab">

                            <!-- Mobile slider -->
                            <div id="carouselCampainMobi" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                                <div class="carousel-indicators">
                                    <div class="carousel-ind active" data-bs-target="#carouselCampainMobi" data-bs-slide-to="0" aria-current="true">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/logo_youtube.png'); ?>" class="">
                                        <h6 class="m-0">Youtube</h6>
                                    </div>
                                    <div class="carousel-ind" data-bs-target="#carouselCampainMobi" data-bs-slide-to="1">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/gmail-logo.svg'); ?>" class="">
                                        <h6 class="m-0">Gmail</h6>
                                    </div>
                                    <div class="carousel-ind" data-bs-target="#carouselCampainMobi" data-bs-slide-to="2">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/conv_galpha_logo.png'); ?>" class="">
                                        <h6 class="m-0">Search</h6>
                                    </div>
                                    <div class="carousel-ind" data-bs-target="#carouselCampainMobi" data-bs-slide-to="3">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/display_icon_48.svg'); ?>" class="">
                                        <h6 class="m-0">Display</h6>
                                    </div>
                                    <div class="carousel-ind" data-bs-target="#carouselCampainMobi" data-bs-slide-to="4">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/discover_icon_48.svg'); ?>" class="">
                                        <h6 class="m-0">Discover</h6>
                                    </div>
                                </div>
                                <div class="carousel-inner">
                                    <!-- Slide 1 -->
                                    <div class="carousel-item active text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/mobile-youtube.png'); ?>" class="">
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/mobile-gmail.png'); ?>" class="">
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/mobile-search.png'); ?>" class="">
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/mobile-display.png'); ?>" class="">
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/campaign/mobile-discover.png'); ?>" class="">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    jQuery(document).on('click', '#submitCampaign', function() {
        if (jQuery('#resourceName').val() == '' && jQuery('#campaign_id').val() == '') {
            submitCampaign();
        } else {
            updateCampaign();
        }
    });
});
function submitCampaign() {
    let hasError = false;
    let productSource = jQuery('input[name="productSource"]:checked').val();
    let feed_ids = '';
    if (productSource == 'Feeds') {
        var feed_id = jQuery('#selecetdCampaign option:selected').map(function() {
            return $(this).val();
        }).get();
        feed_ids = feed_id.join(', ');
        if (feed_ids == '') {
            jQuery('#selecetdCampaign').next('span').find('.select2-selection--multiple').addClass('errorInput')
            hasError = true
        }
    }
    let arrValidate = ['campaignName', 'daily_budget', 'target_country_campaign', 'start_date', 'end_date'];

    jQuery.each(arrValidate, function(i, v) {
        if (jQuery('#' + v).val() == '' && v !== 'target_country_campaign') {
            jQuery('#' + v).addClass('errorInput');
            hasError = true
        }
        if (v == 'target_country_campaign' && jQuery('select[name="' + v + '"] option:selected').val() == '') {
            jQuery('select[name="' + v + '"]').addClass('errorInput');
            jQuery('select[name="' + v + '"]').next('span').find('.select2-selection--single').addClass('errorInput');
            hasError = true
        }
    })
    var todayDate = new Date();
    var eDate = new Date(jQuery('#end_date').val());
    var sDate = new Date(jQuery('#start_date').val());
    if (new Date(sDate.toDateString()) < new Date(todayDate.toDateString())) {
        jQuery('#start_date').addClass('errorInput');
        jQuery(".startDateError").html("Start date is less than today's date.")
        hasError = true
    }
    if (sDate > eDate) {
        jQuery('#end_date').addClass('errorInput');
        jQuery('.endDateError').html('Check End Date.')
        return false;
    }
    if (hasError == true) {
        return false;
    }
    let subscriptionId = "<?php echo esc_js($subscription_id) ?>";
    let google_merchant_center_id = "<?php echo esc_js($google_merchant_id) ?>";
    let google_ads_id = "<?php echo esc_js($google_ads_id) ?>";
    let store_id = "<?php echo esc_js($store_id) ?>";
    var conv_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conv_onboarding_nonce')); ?>";
    var data = {
        action: "ee_createPmaxCampaign",
        campaign_name: jQuery('#campaignName').val(),
        budget: jQuery('#daily_budget').val(),
        target_country: jQuery('#target_country_campaign').find(":selected").val(),
        start_date: jQuery('#start_date').val(),
        end_date: jQuery('#end_date').val(),
        target_roas: jQuery('#target_roas').val() == '' ? 0 : jQuery('#target_roas').val(),
        status: jQuery('input[name=status]:checked').val(),
        subscription_id: "<?php echo esc_js($subscription_id) ?>",
        google_merchant_id: "<?php echo esc_js($google_merchant_id) ?>",
        google_ads_id: "<?php echo esc_js($google_ads_id) ?>",
        sync_item_ids: feed_ids,
        domain: "<?php echo esc_js(get_site_url()) ?>",
        store_id: "<?php echo esc_js($store_id) ?>",
        productSource: productSource,
        sync_type: "feed",
        conv_onboarding_nonce: conv_onboarding_nonce
    }
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: tvc_ajax_url,
        data: data,
        beforeSend: function() {
            jQuery("#loadingbar_blue_modal_campign").removeClass('d-none');
            jQuery("#wpbody").css("pointer-events", "none");
            jQuery('#submitCampaign').attr('disabled', true);
        },
        error: function(err, status) {
            jQuery("#loadingbar_blue_modal_campign").addClass('d-none');
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery('#submitCampaign').attr('disabled', false);
        },
        success: function(response) {
            jQuery("#loadingbar_blue_modal_campign").addClass('d-none');
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery('#submitCampaign').attr('disabled', false);
            if (response.error == true) {
                var html = '<img class="" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/errorImg.png'); ?>" alt="" style="width:150px; height:150px;">';
                html += '<div class="text-danger">Failed! Your operation was failed.</div>';
                html += '<div class="text-dark fs-12 mt-2">' + response.message + '</div>';
                jQuery('.infoBody').html(html)
                jQuery('#infoModal').modal('show')
            } else {
                var html = '<img class="" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/successImg.png'); ?>" alt="" style="width:150px; height:150px;">';
                html += '<div class="text-success">Success! Your operation was completed.</div>';
                html += '<div class="text-dark fs-12 mt-2">Exciting things are happening behind the scenes! We\'re crafting your Pmax campaign for Google Ads with precision. Your products are gearing up to shine. Sit tight, and get ready for an amplified reach and increased sales.</div>';

                jQuery('.infoBody').html(html)
                jQuery('#infoModal').modal('show')
            }
        }
    });
}

function editCampaign(id) {
    var conv_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conv_onboarding_nonce')); ?>";
    var data = {
        action: "ee_editPmaxCampaign",
        id: id,
        google_ads_id: "<?php echo esc_js($google_ads_id) ?>",
        conv_onboarding_nonce: conv_onboarding_nonce
    }
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: tvc_ajax_url,
        data: data,
        beforeSend: function() {
            jQuery('td[data-id=' + id + '] label').addClass('loading-row');
            jQuery("#wpbody").css("pointer-events", "none");
        },
        success: function(response) {
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery('.topNavBar').removeClass('loading-row')
            jQuery('#campaignName').val(response.result['campaignName'].replace(/\\/g, '')).attr('readonly', true)
            jQuery('#daily_budget').val(response.result['budget'])
            jQuery('#target_country_campaign').val(response.result['sale_country']).attr('disabled', true)
            jQuery('#edit_country_campaign').val(response.result['sale_country'])
            jQuery('#target_roas').val(response.result['target_roas'])
            jQuery('#start_date').val(response.result['startDate']).attr('readonly', true)
            jQuery('#end_date').val(response.result['endDate'])
            jQuery('input[name=status][value="' + response.result['status'] + '"]').val()
            jQuery('#resourceName').val(response.result['resourceName'])
            jQuery('#campaignBudget').val(response.result['campaignBudget'])
            jQuery('#campaign_id').val(id)
            jQuery('#allproduct').attr('disabled', true)
            jQuery('#specific_feeds').attr('disabled', true)

            jQuery('.campaign-pmax-title').text('Edit Pmax Campaign');
            jQuery('#submitCampaign').text('Update Campaign');
            jQuery('.createCampaignDiv').removeClass('d-none');
            jQuery('.campaignTableDiv').addClass('d-none')
        },
        complete: function(err, status) {
            jQuery('td[data-id=' + id + '] label').removeClass('loading-row')
            jQuery("#wpbody").css("pointer-events", "auto");
        }
    });
}

function updateCampaign() {
    let arrValidate = ['daily_budget', 'end_date'];
    let hasError = false;
    jQuery.each(arrValidate, function(i, v) {
        if (jQuery('#' + v).val() == '') {
            jQuery('#' + v).addClass('errorInput');
            hasError = true
        }
    })

    if (hasError == true) {
        return false;
    }
    var todayDate = new Date();
    var eDate = new Date(jQuery('#end_date').val());
    var sDate = new Date(jQuery('#start_date').val());
    if (sDate > eDate) {
        jQuery('#end_date').addClass('errorInput');
        jQuery('.endDateError').html('Check End Date.')
        return false;
    }
    let subscriptionId = "<?php echo esc_js($subscription_id) ?>";
    let store_id = "<?php echo esc_js($store_id) ?>";
    var conversios_nonce = "<?php echo esc_js(wp_create_nonce('conversios_nonce')); ?>";
    var data = {
        action: "ee_update_PmaxCampaign",
        campaign_name: jQuery('#campaignName').val(),
        budget: jQuery('#daily_budget').val(),
        target_country: jQuery('#edit_country_campaign').val(),
        start_date: jQuery('#start_date').val(),
        end_date: jQuery('#end_date').val(),
        target_roas: jQuery('#target_roas').val() == '' ? 0 : jQuery('#target_roas').val(),
        status: jQuery('input[name=status]:checked').val(),
        merchant_id: "<?php echo esc_js($google_merchant_id) ?>",
        customer_id: "<?php echo esc_js($google_ads_id) ?>",
        resource_name: jQuery('#resourceName').val(),
        campaign_budget_resource_name: jQuery('#campaignBudget').val(),
        campaign_id: jQuery('#campaign_id').val(),
        conversios_nonce: conversios_nonce
    }
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: tvc_ajax_url,
        data: data,
        beforeSend: function() {
            jQuery("#loadingbar_blue_modal_campign").removeClass('d-none');
            jQuery("#wpbody").css("pointer-events", "none");
            jQuery('#submitCampaign').attr('disabled', true);
        },
        error: function(err, status) {
            jQuery("#loadingbar_blue_modal_campign").addClass('d-none');
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery('#submitEditedCampaign').attr('disabled', false);
        },
        success: function(response) {
            jQuery("#loadingbar_blue_modal_campign").addClass('d-none');
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery('#submitEditedCampaign').attr('disabled', false);
            jQuery('#edit-campign-pop-up').modal('hide');
            if (response.error == true) {
                var html = '<img class="" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/errorImg.png'); ?>" alt="" style="width:150px; height:150px;">';
                html += '<div class="text-danger">Failed! Your operation was failed.</div>';
                html += '<div class="text-dark fs-12 mt-2">' + response.message + '</div>';
                jQuery('.infoBody').html(html)
                jQuery('#infoModal').modal('show')
            } else {
                var html = '<img class="" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/successImg.png'); ?>" alt="" style="width:150px; height:150px;">';
                html += '<div class="text-success">Success! Your operation was completed.</div>';
                html += '<div class="text-dark fs-12 mt-2">' + response.message + '</div>';

                jQuery('.infoBody').html(html)
                jQuery('#infoModal').modal('show')
            }
        }
    });
}
</script>