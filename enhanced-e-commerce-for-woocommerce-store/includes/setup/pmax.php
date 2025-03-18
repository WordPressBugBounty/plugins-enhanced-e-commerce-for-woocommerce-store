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
$ecom_reports_ga_currency = isset($ee_options['ecom_reports_ga_currency']) ? sanitize_text_field($ee_options['ecom_reports_ga_currency']) : '';
$ecom_reports_gads_currency = isset($ee_options['ecom_reports_gads_currency']) ? sanitize_text_field($ee_options['ecom_reports_gads_currency']) : '';
$subscription_id = isset($ee_options['subscription_id']) ? sanitize_text_field($ee_options['subscription_id']) : '';
$google_merchant_id = isset($ee_options['google_merchant_id']) ? sanitize_text_field($ee_options['google_merchant_id']) : '';

$microsoft_ads_manager_id = isset($ee_options['microsoft_ads_manager_id']) ? $ee_options['microsoft_ads_manager_id'] : "";
$microsoft_ads_subaccount_id = isset($ee_options['microsoft_ads_subaccount_id']) ? $ee_options['microsoft_ads_subaccount_id'] : "";

$subpage = (isset($_GET["subpage"]) && $_GET["subpage"] != "") ? sanitize_text_field(wp_unslash($_GET['subpage'])) : "ga4general";
$TVC_Admin_Helper = new TVC_Admin_Helper();
$PMax_Helper = new Conversios_PMax_Helper();
$allresult = array();
// when viewing google campaign
if (isset($_GET['campaign']) && $_GET['campaign'] == 'google' || !isset($_GET['campaign'])) {
    $results = $PMax_Helper->campaign_pmax_list($google_ads_id, '10000', '', '');
}
// when viewing microsoft campaign
else {
    $results = $PMax_Helper->campaign_pmax_list_microsoft($microsoft_ads_manager_id, $microsoft_ads_subaccount_id, $subscription_id);
    //$results = $PMax_Helper->campaign_pmax_list_microsoft(252077508, 180741369,$subscription_id); 
    //echo '<pre>'; print_r($results); echo '</pre>';
}

if (isset($results) && is_object($results) && isset($results->error) && empty($results->error)) {
    if (isset($results->data) && is_object($results->data) && isset($results->data->results) && is_array($results->data->results)) {
        $allresult = $results->data->results;
    } elseif (isset($results->data) && is_array($results->data)) {
        $allresult = $results->data;
    }
}
global $wpdb;
$table_name = $wpdb->prefix . 'ee_product_feed';
$query = $wpdb->prepare(
    "SELECT `id`, `feed_name` FROM $table_name WHERE status = %s AND channel_ids = %d",
    'synced',
    1
);
$feed_results = $wpdb->get_results($query);
global $wp_filesystem;
//$credentials = json_decode($wp_filesystem->get_contents(ENHANCAD_PLUGIN_DIR . 'includes/setup/json/client-secrets.json'), true);
$getCountris = $wp_filesystem->get_contents(__DIR__ . "/json/countries.json");
$contData = json_decode($getCountris);
$conv_data = $TVC_Admin_Helper->get_store_data();
?>
<style>
    input[type=radio]:checked::before {
        content: "";
        border-radius: 50%;
        width: .5rem;
        height: .5rem;
        margin-top: 0.28rem !important;
        background-color: ##3582c4 !important;
        line-height: 1.14285714;
    }

    .form-check-input:checked {
        background-color: #ffff !important;
        border-color: #94979A !important;
        border-radius: 50% !important;
    }

    .fs-24 {
        font-size: 24px;
    }

    .fw-600 {
        font-weight: 600;
    }

    .dataTables-search,
    .dataTables-paging {
        float: right;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .paginate_button {
        position: relative;
        /*display: block; */
        color: #0d6efd;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        font-size: 12px;
        padding: 0.375rem 0.75rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .dataTables_info {
        width: 50%;
        float: left;
    }

    .dataTables_paginate {
        width: 50%;
        float: right;
    }

    thead {
        background: #f0f0f1;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: 1px solid #C6C6C6;
    }

    .loading-row {
        position: relative;
        overflow: hidden;
        /* Prevent overflow from the animated border */
    }

    .loading-row::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50%;
        height: 3px;
        /* Height of the border */
        background: linear-gradient(to right, #3498db, #387ef5, #387ef5, #387ef5);
        /* Gradient colors */
        animation: loading 2s linear infinite;
        /* Animation properties */
    }

    @-webkit-keyframes loading {
        0% {
            left: 0;
        }

        100% {
            left: 100%;
        }
    }

    @-moz-keyframes loading {
        0% {
            left: 0;
        }

        100% {
            left: 100%;
        }
    }
</style>

<div class="container-fluid px-50 mt-4">
    <!-- Parent Tabs -->
    <ul class="nav nav-tabs" id="parentTabs" role="tablist">
        <li class="nav-item m-0" role="presentation">
            <a class="nav-link d-flex align-items-center <?php echo (isset($_GET['campaign']) && $_GET['campaign'] == 'google' || !isset($_GET['campaign'])) ? 'active' : ''; ?>" href="<?php echo esc_url('admin.php?page=conversios-pmax&campaign=google'); ?>" role="tab" aria-controls="home" aria-selected="true">
                <?php echo wp_kses(
                    enhancad_get_plugin_image('/admin/images/logos/conv_gmc_logo.png', '', 'align-self-center me-2', 'width: 24px;'),
                    array(
                        'img' => array(
                            'src' => true,
                            'alt' => true,
                            'class' => true,
                            'style' => true,
                        ),
                    )
                ); ?>
                <h4 class="m-0">Google PMAX (GMC)</h4>
            </a>
        </li>
        <li class="nav-item m-0" role="presentation">
            <a class="nav-link d-flex align-items-center <?php echo (isset($_GET['campaign']) && $_GET['campaign'] == 'microsoft') ? 'active' : ''; ?>" href="<?php echo esc_url('admin.php?page=conversios-pmax&campaign=microsoft'); ?>" role="tab" aria-controls="home" aria-selected="true">
                <?php echo wp_kses(
                    enhancad_get_plugin_image('/admin/images/logos/ms-logo.png', '', 'align-self-center me-2', ''),
                    array(
                        'img' => array(
                            'src' => true,
                            'alt' => true,
                            'class' => true,
                            'style' => true,
                        ),
                    )
                ); ?>
                <h4 class="m-0">Microsoft PMAX (MMC)</h4>
            </a>
        </li>
    </ul>
    <!-- Parent Tab Content -->
    <div class="tab-content px-3" style="background: white; border-left: 1px; border-right: 1px; border-color: rgb(0 0 0 / 8%); border-style: solid; border-top: 0;">
        <!-- Tab1 -->
        <div class="google-camp tab-pane fade pt-4 pb-4 <?php echo (isset($_GET['campaign']) && $_GET['campaign'] == 'google' || !isset($_GET['campaign'])) ? 'show active' : ''; ?>" id="content1" role="tabpanel" aria-labelledby="#tab1">
            <h3>
                <?php esc_html_e("Google Campaign Management", "enhanced-e-commerce-for-woocommerce-store") ?>
            </h3>
            <p class="text-grey mt-2 fs-16">
                <?php esc_html_e("Manage your Performance Max (PMax) campaigns to reach customers across all Google channels. This involves setting up, optimizing, and monitoring your campaigns to ensure they are effectively driving conversions.
                ", "enhanced-e-commerce-for-woocommerce-store") ?>
            </p>
            <?php
            /**
             * Include Google Tab
             */
            if (isset($_GET['campaign']) && $_GET['campaign'] == 'google' || !isset($_GET['campaign'])) {
                require_once(ENHANCAD_PLUGIN_DIR . '/includes/setup/pmax-google-tab.php');
            }
            ?>
        </div>
        <!-- Tab2 -->
        <div class="microsoft-camp tab-pane fade pt-4 pb-4 <?php echo (isset($_GET['campaign']) && $_GET['campaign'] == 'microsoft') ? 'show active' : ''; ?>" id="content2" role="tabpanel" aria-labelledby="#tab2">
            <h3>
                <?php esc_html_e("Microsoft Campaign Management", "enhanced-e-commerce-for-woocommerce-store") ?>
            </h3>
            <p class="text-grey mt-2 fs-16">
                <?php esc_html_e("Manage your Performance Max (PMax) campaigns to reach customers across all Microsoft channels. This involves setting up, optimizing, and monitoring your campaigns to ensure they are effectively driving conversions.
                ", "enhanced-e-commerce-for-woocommerce-store") ?>
            </p>
            <?php
            /**
             * Include Microsoft Tab
             */
            if (isset($_GET['campaign']) && $_GET['campaign'] == 'microsoft') {
                require_once(ENHANCAD_PLUGIN_DIR . '/includes/setup/pmax-microsoft-tab.php');
            }
            ?>
        </div>
    </div>
</div>

<!-- If not found Google Ads ID or Microsoft Ads ID or Mercent ID then show this modal -->
<div class="modal fade" id="warningModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center warningBody">
                <div class="text-success">
                    <h5 class="text-uppercase text-black-50 fw-500">Before You Create a Campaign</h5>
                </div>
                <span class="material-symbols-outlined text-warning" style=" font-size: 60px; "> warning </span>
                <div class="text-dark fs-12 mt-2">
                    <p class="justify-content-around d-flex text-black-50">
                        <?php
                        if (isset($_GET['campaign']) && $_GET['campaign'] == 'google' || !isset($_GET['campaign'])) {
                            if (empty($google_ads_id))
                                $redirect_to_auth = 'admin.php?page=conversios-google-analytics&subpage=gadssettings&redirectBack=googleCamp';
                            else
                                $redirect_to_auth = 'admin.php?page=conversios-google-shopping-feed&subpage=gmcsettings&redirectBack=googleCamp';

                            if (empty($google_ads_id)) {
                                esc_html_e('Google Ads ID required !', 'enhanced-e-commerce-for-woocommerce-store');
                                echo '<br>';
                            }
                            if (empty($google_merchant_id)) {
                                esc_html_e('Google Merchant ID required !', 'enhanced-e-commerce-for-woocommerce-store');
                                echo '<br>';
                            }
                        } else {
                            if (empty($microsoft_ads_manager_id) || empty($microsoft_ads_subaccount_id))
                                $redirect_to_auth = 'admin.php?page=conversios-google-analytics&subpage=bingsettings&redirectBack=microsoftCamp';
                            else
                                $redirect_to_auth = 'admin.php?page=conversios-google-shopping-feed&subpage=mmcsettings&redirectBack=microsoftCamp';

                            if (empty($microsoft_ads_manager_id)) {
                                esc_html_e('Microsoft Ads Manager ID required !', 'enhanced-e-commerce-for-woocommerce-store');
                                echo '<br>';
                            }
                            if (empty($microsoft_ads_subaccount_id)) {
                                esc_html_e('Microsoft Ads Sub Account ID required !', 'enhanced-e-commerce-for-woocommerce-store');
                                echo '<br>';
                            }
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center" style="border-top:none">
                <a href="<?php echo esc_url($redirect_to_auth); ?>" class="btn btn-warning text-white fw-bold">Do Configure Now</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="infoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center infoBody">
                <?php echo wp_kses(
                    enhancad_get_plugin_image('/admin/images/logos/successImg.png', '', '', 'width:150px; height:150px;'),
                    array(
                        'img' => array(
                            'src' => true,
                            'alt' => true,
                            'class' => true,
                            'style' => true,
                        ),
                    )
                ); ?>
                <div class="text-success">
                    Success! Your operation was completed.
                </div>
                <div class="text-dark fs-12 mt-2">
                    Exciting things are happening behind the scenes! We're crafting your Pmax campaign for Google Ads with precision. Your products are gearing up to shine. Sit tight, and get ready for an amplified reach and increased sales.
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center" style="border-top:none">
                <?php
                if (isset($_GET['campaign']) && $_GET['campaign'] == 'google' || !isset($_GET['campaign'])) {
                    $redirect_to_auth = 'admin.php?page=conversios-pmax&campaign=google';
                } else {
                    $redirect_to_auth = 'admin.php?page=conversios-pmax&campaign=microsoft';
                }
                ?>
                <a href="<?php echo esc_url($redirect_to_auth); ?>" class="btn btn-dark">Close</a>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        jQuery(document).on('click', 'input[type=date]', function() {
            this.showPicker(); // Show the date picker
        });
        jQuery('#selecetdCampaign').select2({
            multiple: true,
            placeholder: "Select feeds",
            allowClear: true
        });

        jQuery('#target_country_campaign').select2();

        jQuery('#all_campagin_list_table').DataTable({
            "searching": false,
            "order": [
                [0, "desc"]
            ],
            columnDefs: [{
                orderable: false,
                targets: -1
            }],
        });

        jQuery('#all_campagin_list_table_length').addClass('d-flex align-items-center justify-content-between mb-1');
        jQuery('.createCampaign').insertAfter('#all_campagin_list_table_length label');


        jQuery(document).on('click', '#cancel', function() {
            jQuery('#campaignName').val('').attr('readonly', false)
            jQuery('#daily_budget').val('')
            jQuery('#target_roas').val('')
            jQuery('#start_date').val('').attr('readonly', false)
            jQuery('#end_date').val('')
            jQuery('input[name=status][value="ENABLED"]').val()
            jQuery('#resourceName').val('')
            jQuery('#campaignBudget').val('')
            jQuery('#campaign_id').val('')
            jQuery('#allproduct').attr('disabled', false)
            jQuery('#specific_feeds').attr('disabled', false)
            jQuery('#edit_country_campaign').val('')
            jQuery('#target_country_campaign').attr('disabled', false)
            jQuery('#selecetdCampaign').next('span').find('.select2-selection--multiple').removeClass('errorInput')
            jQuery('.errorInput').removeClass('errorInput')
            jQuery('.errorInput').next('span').find('.select2-selection--multiple').removeClass('errorInput')
            jQuery('.errorInput').next('span').find('.select2-selection--single').removeClass('errorInput')
            jQuery('.endDateError').html('')
            jQuery('.startDateError').html('')
            jQuery('input[name="productSource"][value="All Product"]').prop('checked', true)
            jQuery('#selecetdCampaign').attr('disabled', true)
            jQuery('#selecetdCampaign').val('').trigger('change')
            jQuery('.infoMsg').addClass('d-none')
            jQuery('.campaignTableDiv').removeClass('d-none')
            jQuery('.createCampaignDiv').addClass('d-none');
        })

        jQuery(document).on('click', '.createCampaign', function() {
            jQuery('.campaign-pmax-title').text('Create Pmax Campaign');
            jQuery('#submitCampaign').text('Create New Campaign');
            jQuery('.createCampaignDiv').removeClass('d-none');
            jQuery('.campaignTableDiv').addClass('d-none');

            setTimeout(function() {
                <?php if ((empty($google_ads_id) || empty($google_merchant_id)) && (isset($_GET['campaign']) && $_GET['campaign'] == 'google' || !isset($_GET['campaign']))) { ?>
                    jQuery('#warningModal').modal("show");
                <?php } elseif ((empty($microsoft_ads_manager_id) || empty($microsoft_ads_subaccount_id)) && (isset($_GET['campaign']) && $_GET['campaign'] == 'microsoft')) { ?>
                    jQuery('#warningModal').modal("show");
                <?php } ?>
            }, 3000);

        })

        jQuery(document).on('change', '#allproduct', function() {
            jQuery('#selecetdCampaign').attr('disabled', true)
            jQuery('#selecetdCampaign').val('').trigger('change')
            jQuery('.infoMsg').addClass('d-none')
            jQuery('#selecetdCampaign').next('span').find('.select2-selection--multiple').removeClass('errorInput')
        })

        jQuery(document).on('change', '#specific_feeds', function() {
            jQuery('#selecetdCampaign').attr('disabled', false)
            jQuery('.infoMsg').removeClass('d-none')
        })

        jQuery(document).on('keyup change', '.errorInput', function() {
            jQuery(this).removeClass('errorInput')
            jQuery(this).next('span').find('.select2-selection--multiple').removeClass('errorInput')
            jQuery(this).next('span').find('.select2-selection--single').removeClass('errorInput')
            jQuery('.endDateError').html('')
            jQuery('.startDateError').html('')
        })
        jQuery(document).on('keyup change', '#selecetdCampaign', function() {
            jQuery(this).next('span').find('.select2-selection--multiple').removeClass('errorInput')
        })

        jQuery(document).on('keydown', 'input[name="daily_budget"], input[name="target_roas"],input[name="edit_daily_budget"], input[name="edit_target_roas"]', function() {
            if (event.shiftKey == true) {
                event.preventDefault();
            }
            if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

            } else {
                event.preventDefault();
            }

            if (jQuery(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();
        })
    });
</script>