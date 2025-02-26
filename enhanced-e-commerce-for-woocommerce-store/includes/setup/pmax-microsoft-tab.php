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
                        title="Select Feed from below to create performance max campaign in Microsoft Ads." style="pointer-events: auto !important">
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
                    <!-- <th scope="col" class="text-end">Clicks</th> -->
                    <!-- <th scope="col" class="text-end">Cost (<?php //echo esc_html($ecom_reports_gads_currency); ?>)</th> -->
                    <!-- <th scope="col" class="text-end">Conversions</th>
                    <th scope="col" class="text-end">Sales</th> -->
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="table-body bg-white" style="border-top: none !important;">
                <?php
                foreach ($allresult as $result) {
                    $status = $result->Status;
                    $dailyBudget = number_format($result->DailyBudget);//number_format((float)$result->DailyBudget / 1000000, 2, '.', '');
                    $sales = isset($result->metrics->conversionsValue) ? $result->metrics->conversionsValue : 0;
                ?>
                    <tr data-from="middle">
                        <td scope="row" data-sort="<?php echo esc_html($result->Id) ?>" class="text-start">
                            <div class="selling-head"><?php echo esc_html(stripslashes($result->Name)) ?></div>
                        </td>

                        <td class="status-class text-center">
                            <span class="status-text" data-status="<?php echo esc_html(strtolower($status)) ?>">
                                <?php echo esc_html($status) ?> </span>
                        </td>
                        <td class="text-end"><?php echo esc_html($dailyBudget) ?></td>
                        <!-- <td class="text-end"><?php //echo esc_html($result->metrics->clicks) ?></td>
                        <td class="text-end"><?php //echo esc_html(number_format((float)$result->metrics->costMicros / 1000000, 2, '.', '')) ?></td>
                        <td class="text-end"><?php //echo esc_html($result->metrics->conversions) ?></td>
                        <td class="text-end"><?php //echo esc_html($sales) ?></td> -->
                        <td data-id="<?php echo esc_html($result->Id) ?>" class="text-center">
                            <span class="d-none"><?php // echo esc_html($result->Id) ?></span>
                            <label class="text-primary pointer edit-btn" onclick="editCampaign_ms(<?php echo esc_html($result->Id) ?>)">Edit</label>
                        </td>
                    </tr>
                    <?php }
                //$microsoft_detail = $TVC_Admin_Helper->get_ee_options_data();
                $microsoft_detail = $TVC_Admin_Helper->get_user_subscription_data();
                $store_id = (isset($microsoft_detail) && isset($microsoft_detail->store_id)) ? $microsoft_detail->store_id : '';
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
                                <!-- <td class="text-end">NA</td>
                                <td class="text-end">NA</td>
                                <td class="text-end">NA</td>
                                <td class="text-end">NA</td> -->
                                <td>
                                    <span class="d-none"><?php // echo esc_html($result->Id) ?></span>
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
        <?php esc_html_e("Manage your Performance Max (PMax) campaigns to reach customers across all Microsoft channels. This involves setting up, optimizing, and monitoring your campaigns to ensure they are effectively driving conversions.
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
                            <img style="width:32px; height:32px" class="" src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/ms-logo.png'); ?>" alt="">
                            <span class="fw-600 fs-24 ms-2 campaign-pmax-title">Create Pmax Campaign</span>
                        </div>
                        <div><span class="campaign-go-back" id="cancel"><span class="dashicons dashicons-arrow-left-alt"></span>&nbsp;Go Back</span></div>
                    </div>
                    <div class="mt-3">
                        
                        <div class="row">

                            <div class="d-none hidden">
                                <span class="fs-16 mb-2" style="font-weight:700; color: #5F6368">Product Source</span>
                                <div class="col-12" style="padding-left: 1.2rem !important">
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="productSource" id="allproduct" value="All Product" <?php echo isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? '' : 'checked' ?>>
                                        <label class="form-check-label" for="allproduct">All Products From Microsoft Merchant Center</label>
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
                            </div>

                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Campaign Name&nbsp;<span class="text-danger fs-16">*</span></span>
                                <input type="text" id="campaignName" name="campaignName" class="form-control flex-grow-1" placeholder="Enter Campaign Name">
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Daily Budget&nbsp;<span class="text-danger fs-16">*</span></span>
                                <input type="text" id="daily_budget" name="daily_budget" class="form-control" placeholder="Enter Daily Budget">
                            </div>
                            <?php /* ?>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Country</span>
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
                                <span class="fs-14 fw-500 me-2" style="width: 145px">Start Date</span>
                                <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Start Date">
                                <span class="startDateError text-danger fs-10"></span>
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fs-14 fw-500 me-2" style="width: 145px">End Date</span>
                                <input type="date" id="end_date" name="end_date" class=form-control placeholder="End Date">
                                <span class="endDateError text-danger fs-10"></span>
                            </div> <?php */ ?>
                            <div class="col-12 mt-3 d-none for now">
                                <div class="form-check form-check-inline" style="margin-left: 5px">
                                    <input class="form-check-input" type="radio" name="status" id="Active" value="Active" checked>
                                    <label class="form-check-label" for="Active">Active</label>
                                </div>
                                <div class="form-check form-check-inline ml-2">
                                    <input class="form-check-input" type="radio" name="status" id="Paused" value="Paused">
                                    <label class="form-check-label" for="Paused">Paused</label>
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
                                <button class="btn mt-3 fs-14" id="submitCampaign_ms" style="width: 180px; height: 38px; background-color: #1967D2; color:#fff">
                                    Create Campaign
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-5 p-4" style="background-color: #1967D2; border-top-right-radius:8px;border-bottom-right-radius:8px; margin:0 12px 0 -12px; min-height: 678px; /*background:linear-gradient(135deg, hsl(219deg 96.83% 65.26%) 0%, hsl(171deg 63.72% 55.29%) 50%, hsl(47deg 97.61% 80.27%) 100%)*/">

                    <h4 class="fw-bold text-white">Ads Preview:</h4>
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="campaignTab" role="tablist">
                        <li class="nav-item me-2 mb-2" role="presentation">
                            <button class="nav-link active" id="msndotcom-tab" data-bs-toggle="tab" data-bs-target="#msndotcom" type="button" role="tab" aria-controls="msndotcom" aria-selected="true">msn.com</button>
                        </li>
                        <li class="nav-item me-2 mb-2" role="presentation">
                            <button class="nav-link" id="bingsearch-tab" data-bs-toggle="tab" data-bs-target="#bingsearch" type="button" role="tab" aria-controls="bingsearch" aria-selected="false">Bing Search</button>
                        </li>
                        <li class="nav-item me-2 mb-2" role="presentation">
                            <button class="nav-link" id="edge-tab" data-bs-toggle="tab" data-bs-target="#edge" type="button" role="tab" aria-controls="edge" aria-selected="false">Edge</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="outlook-tab" data-bs-toggle="tab" data-bs-target="#outlook" type="button" role="tab" aria-controls="outlook" aria-selected="false">Outlook</button>
                        </li>
                    </ul>
                    <!-- Tab Content -->
                    <div class="tab-content pt-2" id="campaignTabContent">
                        <div class="tab-pane fade show active" id="msndotcom" role="tabpanel" aria-labelledby="msndotcom-tab">

                            <!-- MSN.com slider                                             -->
                            <div id="carouselCampainMsn" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

                                <ol class="carousel-indicators">
                                    <li class="carousel-ind active" data-bs-target="#carouselCampainMsn" data-bs-slide-to="0" aria-current="true"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainMsn" data-bs-slide-to="1"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainMsn" data-bs-slide-to="2"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainMsn" data-bs-slide-to="3"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainMsn" data-bs-slide-to="4"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainMsn" data-bs-slide-to="5"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainMsn" data-bs-slide-to="6"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <!-- Slide 1 -->
                                    <div class="carousel-item active text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/msn/bingads_microsoft_com-2024_12_19-14_54_48.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/msn/bingads_microsoft_com-2024_12_19-14_55_40.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/msn/bingads_microsoft_com-2024_12_19-14_57_02.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/msn/bingads_microsoft_com-2024_12_19-14_57_43.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/msn/bingads_microsoft_com-2024_12_19-14_58_30.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/msn/bingads_microsoft_com-2024_12_19-14_59_43.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/msn/microsoft_com-2024_12_19-15_00_17.png'); ?>" class="">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCampainMsn" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselCampainMsn" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="bingsearch" role="tabpanel" aria-labelledby="bingsearch-tab">

                            <!-- Bing slider -->
                            <div id="carouselCampainBing" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

                                <ol class="carousel-indicators">
                                    <li class="carousel-ind active" data-bs-target="#carouselCampainBing" data-bs-slide-to="0" aria-current="true"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainBing" data-bs-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <!-- Slide 1 -->
                                    <div class="carousel-item active text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/bing/bingads_microsoft_com-2024_12_19-15_01_17.png'); ?>" class="">
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/bing/bingads_microsoft_com-2024_12_19-15_02_00.png'); ?>" class="">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCampainBing" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselCampainBing" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="edge" role="tabpanel" aria-labelledby="edge-tab">

                            <!-- Edge slider -->
                            <div id="carouselCampainEdge" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

                                <ol class="carousel-indicators">
                                    <li class="carousel-ind active" data-bs-target="#carouselCampainEdge" data-bs-slide-to="0" aria-current="true"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainEdge" data-bs-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <!-- Slide 1 -->
                                    <div class="carousel-item active text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/edge/bingads_microsoft_com-2024_12_19-15_03_04.png'); ?>" class="">
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/edge/bingads_microsoft_com-2024_12_19-15_03_53.png'); ?>" class="">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCampainEdge" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselCampainEdge" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="outlook" role="tabpanel" aria-labelledby="outlook-tab">

                            <!-- Outlook slider -->
                            <div id="carouselCampainOutlook" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

                                <ol class="carousel-indicators">
                                    <li class="carousel-ind active" data-bs-target="#carouselCampainOutlook" data-bs-slide-to="0" aria-current="true"></li>
                                    <li class="carousel-ind" data-bs-target="#carouselCampainOutlook" data-bs-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <!-- Slide 1 -->
                                    <div class="carousel-item active text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/outlook/bingads_microsoft_com-2024_12_19-15_04_30.png'); ?>" class="">
                                    </div>
                                    <div class="carousel-item text-center">
                                        <img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/microsoft/outlook/bingads_microsoft_com-2024_12_19-15_05_33.png'); ?>" class="">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCampainOutlook" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselCampainOutlook" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
    jQuery(document).on('click', '#submitCampaign_ms', function() {
        if (jQuery('#resourceName').val() == '' && jQuery('#campaign_id').val() == '') {
            submitCampaign_ms()
        } else {
            updateCampaign_ms()
        }

    });
});
function submitCampaign_ms() {
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
    let arrValidate = ['campaignName', 'daily_budget'];
    jQuery.each(arrValidate, function(i, v) {
        if (jQuery('#' + v).val() == '') {
            jQuery('#' + v).addClass('errorInput');
            hasError = true
        }
    })
    if (hasError == true) {
        return false;
    }

    //let store_id = "<?php echo esc_js($store_id) ?>";
    var conv_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conv_onboarding_nonce')); ?>";
    var data = {
        action: "ee_createPmaxCampaign_ms",
        campaign_name: jQuery('#campaignName').val(),
        budget: jQuery('#daily_budget').val(),
        //target_country: jQuery('#target_country_campaign').find(":selected").val(),
        //start_date: jQuery('#start_date').val(),
        //end_date: jQuery('#end_date').val(),
        //target_roas: jQuery('#target_roas').val() == '' ? 0 : jQuery('#target_roas').val(),
        status: jQuery('input[name=status]:checked').val(),
        subscription_id: "<?php echo esc_js($subscription_id) ?>",
        //ms_catalog_id: "<?php //echo esc_js($ms_catalog_id) ?>",
        microsoft_ads_id: "<?php echo esc_js($microsoft_ads_manager_id) ?>",
        microsoft_ads_sub_id: "<?php echo esc_js($microsoft_ads_subaccount_id) ?>",
        sync_item_ids: feed_ids,
        //domain: "<?php echo esc_js(get_site_url()) ?>",
        //store_id: "<?php echo esc_js($store_id) ?>",
        productSource: productSource,
        //sync_type: "feed",
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
            jQuery('#submitCampaign_ms').attr('disabled', true);
        },
        error: function(err, status) {
            jQuery("#loadingbar_blue_modal_campign").addClass('d-none');
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery('#submitCampaign_ms').attr('disabled', false);
        },
        success: function(response) {
            jQuery("#loadingbar_blue_modal_campign").addClass('d-none');
            jQuery("#wpbody").css("pointer-events", "auto");
            jQuery('#submitCampaign_ms').attr('disabled', false);
            if (response.error == true) {
                var html = '<img class="" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/errorImg.png'); ?>" alt="" style="width:150px; height:150px;">';
                html += '<div class="text-danger">Failed! Your operation was failed.</div>';
                html += '<div class="text-dark fs-12 mt-2">' + response.message + '</div>';
                jQuery('.infoBody').html(html)
                jQuery('#infoModal').modal('show')
            } else {
                var html = '<img class="" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/successImg.png'); ?>" alt="" style="width:150px; height:150px;">';
                html += '<div class="text-success">Success! Your operation was completed.</div>';
                html += '<div class="text-dark fs-12 mt-2">Exciting things are happening behind the scenes! We\'re crafting your Pmax campaign for Microsoft Ads with precision. Your products are gearing up to shine. Sit tight, and get ready for an amplified reach and increased sales.</div>';

                jQuery('.infoBody').html(html)
                jQuery('#infoModal').modal('show')
            }
        }
    });
}

function editCampaign_ms(id) {
    var conv_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conv_onboarding_nonce')); ?>";
    var data = {
        action: "ee_editPmaxCampaign_ms",
        id: id,
        subscription_id: "<?php echo esc_js($subscription_id) ?>",
        //microsoft_ads_id: "252077508", // 
        //microsoft_ads_sub_id: "180741369", // 
        microsoft_ads_id: "<?php echo esc_js($microsoft_ads_manager_id) ?>",
        microsoft_ads_sub_id: "<?php echo esc_js($microsoft_ads_subaccount_id) ?>",
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
        success: function(response) { console.log(response); // wow
            if( response.error == true){
                var html = '<img class="" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/errorImg.png'); ?>" alt="" style="width:150px; height:150px;">';
                html += '<div class="text-danger">Failed! Your operation was failed.</div>';
                html += '<div class="text-dark fs-12 mt-2">' + response.message + '</div>';
                jQuery('.infoBody').html(html)
                jQuery('#infoModal').modal('show');
            }else{
                jQuery("#wpbody").css("pointer-events", "auto");
                jQuery('#campaignName').val(response.result['campaignName'].replace(/\\/g, '')).attr('readonly', true)
                jQuery('#daily_budget').val(response.result['budget'])
                //jQuery('#target_country_campaign').val(response.result['sale_country']).attr('disabled', true)
                //jQuery('#edit_country_campaign').val(response.result['sale_country'])
                //jQuery('#target_roas').val(response.result['target_roas'])
                //jQuery('#start_date').val(response.result['startDate']).attr('readonly', true)
                //jQuery('#end_date').val(response.result['endDate'])
                jQuery('input[name=status][value="' + response.result['status'] + '"]').val()
                //jQuery('#resourceName').val(response.result['resourceName'])
                //jQuery('#campaignBudget').val(response.result['campaignBudget'])
                jQuery('#campaign_id').val(id)
                jQuery('#allproduct').attr('disabled', true)
                //jQuery('#specific_feeds').attr('disabled', true)

                jQuery('.campaign-pmax-title').text('Edit Pmax Campaign');
                jQuery('#submitCampaign_ms').text('Update Campaign');
                jQuery('.createCampaignDiv').removeClass('d-none');
                jQuery('.campaignTableDiv').addClass('d-none');
            }
        },
        complete: function(err, status) {
            jQuery('td[data-id=' + id + '] label').removeClass('loading-row')
            jQuery("#wpbody").css("pointer-events", "auto");
        }
    });
}

function updateCampaign_ms() {
    let arrValidate = ['daily_budget'];
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

    let store_id = "<?php echo esc_js($store_id) ?>";
    var conv_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conv_onboarding_nonce')); ?>";
    var data = {
        action: "ee_update_PmaxCampaign_ms",
        subscription_id: "<?php echo esc_js($subscription_id) ?>",
        microsoft_ads_id: "<?php echo esc_js($microsoft_ads_manager_id) ?>",
        microsoft_ads_sub_id: "<?php echo esc_js($microsoft_ads_subaccount_id) ?>",
        campaign_id: jQuery('#campaign_id').val(),
        daily_budget: jQuery('#daily_budget').val(),
        status: jQuery('input[name=status]:checked').val(),
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
            jQuery('#submitCampaign_ms').attr('disabled', true);
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