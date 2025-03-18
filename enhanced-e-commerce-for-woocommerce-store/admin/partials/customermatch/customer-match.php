<?php
$ee_options = unserialize(get_option('ee_options'));
$google_ads_id = isset($ee_options['google_ads_id']) && $ee_options['google_ads_id'] != "" ? $ee_options['google_ads_id'] : "";
$subscription_id = isset($ee_options['subscription_id']) ? sanitize_text_field($ee_options['subscription_id']) : '';

$TVC_Admin_Helper = new TVC_Admin_Helper();
$google_detail = $TVC_Admin_Helper->get_ee_options_data();
$store_id = $google_detail['setting']->store_id;
if (
    isset($google_detail['setting']) &&
    isset($google_detail['setting']->google_ads_id) &&
    $google_detail['setting']->google_ads_id != ""
) {

    $google_ads_id = $google_detail['setting']->google_ads_id;
}
if (!class_exists('Conversios_Customer_Segment_Helper')) {
    require_once(ENHANCAD_PLUGIN_DIR . 'admin/helper/class-customer-segment-helper.php');
}
$customer_segment_helper = new Conversios_Customer_Segment_Helper();
$results = [];
if ($google_ads_id) {
    $results = $customer_segment_helper->get_customer_segment_list($subscription_id, $store_id);
}
$allresult = array();
if (!empty($results) && is_object($results) && isset($results->error) && empty($results->error)) {
    if (!empty($results->data) && is_array($results->data)) {
        $allresult = $results->data; // Assign the segments
    }
} else {
    // Handle API error
    echo '<div class="alert alert-danger">Error fetching segments. Please try again later.</div>';
}
?>
<style>
    input[type=radio]:checked::before {
        content: "";
        border-radius: 50%;
        width: .5rem;
        height: .5rem;
        margin-top: 0.28rem !important;
        background-color: #3582c4 !important;
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

    .dataTables_paginate {
        width: 50%;
        float: right;
        text-align: right;
    }

    #open-segment-popup {
        position: relative;
        right: 20px;
        top: 50px;
    }
</style>
<?php if (!$google_ads_id) { ?>
    <div class="col-12 alert alert-danger alert alert-danger h5 py-4 mb-0 mt-4 d-flex justify-content-center" role="alert">
        <span class="material-symbols-outlined">
            error
        </span>
        Please connect Google Ads account to create audience. <a class="conv-link-blue d-flex ps-3" href="admin.php?page=conversios-google-analytics&subpage=gadssettings">
            Click here to connect <span class="material-symbols-outlined">
                arrow_forward
            </span>
        </a>
    </div>
<?php } ?>
<div class="container-fluid px-50 mt-4 w-96 campaignTableDiv 
    <?php echo isset($_GET['cid']) && sanitize_text_field(wp_unslash($_GET['cid'])) != '' ? 'd-none' : '' ?> 
    <?php echo esc_attr($google_ads_id ? '' : 'disabledsection'); ?>
    ">
    <h3>
        <?php esc_html_e("Data Segments", "enhanced-e-commerce-for-woocommerce-store") ?>
    </h3>
    <div class="h6 alert alert-success p-2 m-0 mt-2 fw-light text-dark">
        <?php esc_html_e("Manage Customer Match segments in Google Ads to target, re-engage, and personalize campaigns across Search, YouTube, Gmail, and Display", "enhanced-e-commerce-for-woocommerce-store") ?>
    </div>
    <div class="d-flex">
        <div class="ms-auto">
            <button class="btn btn-sm btn-primary" id="open-segment-popup">
                <?php esc_html_e("Create a New Segment", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </button>
        </div>
    </div>
    <div class="table-responsive shadow-sm convo-table-manegment" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px;">
        <table class="table" id="all_segment_list_table" style="width:100%;">
            <thead style="border-bottom: none !important; border-style: none !important;height: 40px;">
                <tr class="heading-row">
                    <th scope="col" class="text-start">Segment Name</th>
                    <th scope="col" class="text-center">Membership Status</th>
                    <th scope="col" class="text-center">Type</th>
                    <th scope="col" class="text-center">Size (Display)</th>
                    <th scope="col" class="text-center">Size (Search)</th>
                    <th scope="col" class="text-center">Segment ID</th>
                    <th scope="col" class="text-center">Membership Lifespan (Days)</th>
                    <th scope="col" class="text-center">Match Rate (%)</th>
                </tr>
            </thead>
            <tbody class="table-body bg-white" style="border-top: none !important;">
                <?php
                function convert_words_to_number($word, $mapping)
                {
                    $parts = explode("_", $word);
                    $number = 0;
                    foreach ($parts as $part) {
                        if (isset($mapping[$part])) {
                            $number += $mapping[$part];
                        }
                    }
                    return $number;
                }
                function format_size_range($size_range)
                {
                    $number_mapping = [
                        "ONE" => 1,
                        "TEN" => 10,
                        "HUNDRED" => 100,
                        "THOUSAND" => 1000,
                        "TEN_THOUSAND" => 10000,
                        "HUNDRED_THOUSAND" => 100000,
                        "MILLION" => 1000000,
                        "BILLION" => 1000000000,
                    ];

                    if (strpos($size_range, "LESS_THAN_") === 0) {
                        $word_number = str_replace("LESS_THAN_", "", $size_range);
                        $number = convert_words_to_number($word_number, $number_mapping);
                        return "<" . number_format($number);
                    } elseif (strpos($size_range, "_TO_") !== false) {
                        list($start_word, $end_word) = explode("_TO_", $size_range);
                        $start_number = convert_words_to_number($start_word, $number_mapping);
                        $end_number = convert_words_to_number($end_word, $number_mapping);
                        return number_format($start_number) . " - " . number_format($end_number);
                    } elseif (strpos($size_range, "OVER_") === 0) {
                        $word_number = str_replace("OVER_", "", $size_range);
                        $number = convert_words_to_number($word_number, $number_mapping);
                        return ">" . number_format($number);
                    }
                    return $size_range;
                }

                if (!empty($allresult)) {
                    foreach ($allresult as $result) {
                        if (isset($result->userList)) {
                            $userList = $result->userList;
                            $matchRate = isset($userList->matchRatePercentage) ? $userList->matchRatePercentage . '%' : 'N/A';

                            // Convert Type if CRM_BASED
                            $type = ($userList->type === "CRM_BASED") ? "Customer List" : esc_html($userList->type);
                ?>
                            <tr data-from="middle">
                                <td class="prdnm-cell sorting_1">
                                    <a href="#" class="segment-link" data-segment-id="<?php echo esc_attr($userList->id); ?>" data-segment-name="<?php echo esc_attr($userList->name); ?>" data-membership-status="<?php echo esc_attr($userList->membershipStatus); ?>" data-membership-lifespan="<?php echo esc_attr($userList->membershipLifeSpan); ?>" style="color: #0083FC; cursor: pointer;">
                                        <?php echo esc_html($userList->name); ?>
                                    </a>
                                </td>

                                <td class="text-center">
                                    <span class="status-text"><?php echo esc_html($userList->membershipStatus); ?></span>
                                </td>
                                <td class="text-center"><?php echo esc_html($type); ?></td>
                                <td class="text-center"><?php echo esc_html(format_size_range($userList->sizeRangeForDisplay)); ?></td>
                                <td class="text-center"><?php echo esc_html(format_size_range($userList->sizeRangeForSearch)); ?></td>
                                <td class="text-center"><?php echo esc_html($userList->id); ?></td>
                                <td class="text-center"><?php echo esc_html($userList->membershipLifeSpan); ?></td>
                                <td class="text-center"><?php echo esc_html($matchRate); ?></td>
                            </tr>
                <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- segment creation popup -->
<div class="modal fade" id="segmentModal" tabindex="-1" aria-labelledby="segmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="segmentModalLabel"> <?php esc_html_e("Create Segment", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="message-container"></div>
                <form id="create-segment-form" method="post">
                    <div class="mb-3">
                        <label class="form-label"> <?php esc_html_e("Segment Name *", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="<?php esc_html_e("Enter Segment Name", "enhanced-e-commerce-for-woocommerce-store"); ?>" required>
                        <small class="text-danger"> <?php esc_html_e("Note: Segment name should be unique and should not match any existing segment name.", "enhanced-e-commerce-for-woocommerce-store"); ?></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> <?php esc_html_e("Description", "enhanced-e-commerce-for-woocommerce-store"); ?> *</label>
                        <textarea rows="4" class="form-control" name="description" id="description" placeholder="<?php esc_html_e("Enter Description", "enhanced-e-commerce-for-woocommerce-store"); ?>" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> <?php esc_html_e("Membership Duration (Days)", "enhanced-e-commerce-for-woocommerce-store"); ?> *</label>
                        <input type="number" min="1" max="540" value="540" name="life_span" class="form-control" placeholder="<?php esc_html_e("Enter lifespan in Days", "enhanced-e-commerce-for-woocommerce-store"); ?>" required>
                        <small id="lifespan-message" class="text-danger" style="display: none;">Please enter a value between 1 and 540.</small>
                    </div>
                    <input type="hidden" name="subscription_id" value="<?php echo esc_attr($subscription_id); ?>">
                    <input type="hidden" name="store_id" value="<?php echo esc_attr($google_detail['setting']->store_id); ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"> <?php esc_html_e("Save", "enhanced-e-commerce-for-woocommerce-store"); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    jQuery(document).ready(function(jQuery) {
        jQuery('#all_segment_list_table').DataTable({
            "paging": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100],
            "language": {
                "emptyTable": "No segments available"
            },
            "columnDefs": [{
                "orderable": false,
                "targets": [7]
            }]
        });

        jQuery(document).on("click", ".segment-link", function(e) {
            e.preventDefault(); // Prevent default anchor behavior

            var segmentId = jQuery(this).data("segment-id");

            if (segmentId) {
                var redirectUrl = "admin.php?page=conversios-audience-manager&tab=customer_export&segment_id=" + segmentId;
                window.location.href = redirectUrl;
            } else {
                alert("Segment ID not found.");
            }
        });

        jQuery('#open-segment-popup').click(function() {
            $('#segmentModal').modal('show');
        });

        jQuery('input[name="life_span"]').on('input', function() {
            var lifespan = jQuery(this).val();

            if (lifespan < 1 || lifespan > 540) {
                jQuery('#lifespan-message').show();
            } else {
                jQuery('#lifespan-message').hide();
            }
        });

        jQuery(document).on('submit', '#create-segment-form', function(event) {
            event.preventDefault();
            var fdata = jQuery(this).serialize();
            console.log(fdata);
            var post_data = {
                action: 'create_segment',
                tvc_data: fdata,
                conversios_nonce: '<?php echo esc_js(wp_create_nonce('conversios_nonce')); ?>'
            };
            jQuery(':input[type="submit"]').prop('disabled', true);
            jQuery("#add_loading").addClass("is_loading");
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: post_data,
                success: function(response) {
                    jQuery(':input[type="submit"]').prop('disabled', false);
                    jQuery("#add_loading").removeClass("is_loading");
                    if (response.error == false) {
                        var parts = response.data.resourceName.split('/');
                        var listid = parts[parts.length - 1];
                        var redurl = "<?php echo esc_url_raw('admin.php?page=conversios-audience-manager&tab=customer_export&segment_id='); ?>" + listid;
                        jQuery("#message-container").html(
                            '<div class="alert alert-success">Segment created successfully! Redirecting...</div>'
                        ).fadeIn();
                        setTimeout(function() {
                            window.location.href = redurl;
                        }, 3000);
                    } else {
                        var errorMessage = response.errors || "Name is already being used for another segment. Please rename and try again.";
                        jQuery("#message-container").html(
                            '<div class="alert alert-danger">' + errorMessage + '</div>'
                        ).fadeIn();
                    }
                }
            });
        });
    });
</script>