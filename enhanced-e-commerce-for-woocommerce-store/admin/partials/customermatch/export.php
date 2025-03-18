<?php
if (! defined('ABSPATH'))
    exit; // Exit if accessed directly
require_once(ENHANCAD_PLUGIN_DIR . 'admin/partials/customermatch/html.php');
require_once(ENHANCAD_PLUGIN_DIR . 'admin/partials/customermatch/batch_exporter.php');
require_once(ENHANCAD_PLUGIN_DIR . 'admin/partials/customermatch/settings.php');

class Conv_Exporter
{
    private $path_csv;
    protected $subscription_id;
    protected $store_id;

    function __construct()
    {
        $upload_dir = wp_upload_dir();
        $this->path_csv = $upload_dir['basedir'] . "/export-users.csv";
        add_action('wp_ajax_conv_export_save_settings', array($this, 'conv_ajax_save_settings'));
    }

    static function conv_enqueue()
    {
        wp_enqueue_script('conv_export_js', plugins_url('export.js', __FILE__), array(), false, true);
        wp_localize_script('conv_export_js', 'conv_export_js_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'starting_process' => __('Starting process', 'enhanced-e-commerce-for-woocommerce-store'),
            'step' => __('Step', 'enhanced-e-commerce-for-woocommerce-store'),
            'of_approximately' => __('of approximately', 'enhanced-e-commerce-for-woocommerce-store'),
            'steps' => __('steps', 'enhanced-e-commerce-for-woocommerce-store'),
            'error_thrown' => __('Error thrown on the server, cannot continue. Please check console to see full details about the error.', 'enhanced-e-commerce-for-woocommerce-store'),
        ));
    }
    static function conv_styles()
    {
?>
        <style>
            .dataTables_paginate {
                width: auto;
                float: right;
            }

            .dataTable tbody tr:nth-child(even) {
                background-color: #F9F9FB;
            }
        </style>
    <?php
    }

    static function conv_admin_gui()
    {
        $customer_segment_helper = new Conversios_Customer_Segment_Helper();
        $segmentId = $_GET['segment_id'] ?? NULL;
        $list_id = isset($_GET['segment_id']) && $_GET['segment_id'] != "" ? $_GET['segment_id'] : "";
        $conv_ee_options_settings = unserialize(get_option('ee_options'));
        $conv_ee_api_data = unserialize(get_option('ee_api_data'));
        $listdetails = $customer_segment_helper->get_segment_details($list_id, $conv_ee_options_settings['subscription_id'], $conv_ee_api_data['setting']->store_id);
        $data = $listdetails->data->userList;
        // Access specific fields
        $resourceName = $data->resourceName;
        $membershipStatus = $data->membershipStatus;
        $sizeRangeForDisplay = $data->sizeRangeForDisplay;
        $sizeRangeForSearch = $data->sizeRangeForSearch;
        $type = $data->type;
        $accountUserListStatus = $data->accountUserListStatus;
        $id = $data->id;
        $name = $data->name;
        $description = $data->description;
        $membershipLifeSpan = $data->membershipLifeSpan;
        $sizeForDisplay = $data->sizeForDisplay;
        $sizeForSearch = $data->sizeForSearch;
        $eligibleForSearch = $data->eligibleForSearch;
        $eligibleForDisplay = $data->eligibleForDisplay;
        $settings = new Conv_Settings('export_backend');
    ?>

        <div id="conv_export_results "></div>
        <div class="modal fade" id="editSegmentModal" tabindex="-1" role="dialog" aria-labelledby="editSegmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSegmentModalLabel">Edit Segment</h5>
                    </div>
                    <div class="modal-body" style="position: relative;">
                        <form id="edit-segment-form">
                            <div class="form-group">
                                <label for="modal-segment-name">Segment Name</label>
                                <input type="text" class="form-control" id="modal-segment-name" value="<?php echo esc_attr($name); ?>">
                            </div>
                            <div class="form-group">
                                <label for="modal-segment-description">Description</label>
                                <textarea class="form-control"
                                    id="modal-segment-description"><?php echo esc_textarea($description); ?></textarea>
                            </div>
                        </form>
                    </div>
                    <div id="modal-loader" class="spinner-border text-primary" role="status"
                        style="display: none; position: absolute; left: 50%; top: 50%; z-index: 1051;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div id="modal-overlay"
                        style="display: none; position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1050;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelBtn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" id="updateBtn" class="btn btn-primary" id="save-segment-changes">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>
        <form class="conv_exporter conv_container p-4 m-4">
            <!-- Modal -->
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Segment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this segment?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="div" style="display:flex; justify-content:space-between;">
                <div>
                    <a id="backtolist" href="<?php echo esc_url_raw('admin.php?page=conversios-audience-manager'); ?>"
                        class="btn-withborder"><img
                            src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . "/admin/images/icon/left-angle-arrow.svg"); ?>"
                            alt="back" />
                        <?php esc_html_e("Back to segment List", "enhanced-e-commerce-for-woocommerce-store"); ?></a>
                    <h3 id="convpfm_header" class="m-0 p-0 mt-3">
                        <?php esc_html_e('Export users', 'enhanced-e-commerce-for-woocommerce-store'); ?>
                    </h3>
                    <small><?php esc_html_e('Send your woocommerce or wordpress users to google ads to create custom audience', 'enhanced-e-commerce-for-woocommerce-store'); ?></small>
                </div>

            </div>
            <br />
            <div class="segment-details"
                style="display: flex; flex-wrap: wrap; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background-color: #fafafa;">
                <div class="detail-item" style="width: 20%;">
                    <label style="display: block; font-size: 0.9em; color: #666;"><strong>Segment Name:</strong></label>
                    <span style="font-size: 1em; color: #333;"><?php echo esc_html($name); ?></span>
                </div>
                <div class="detail-item" style="width: 20%;">
                    <label style="display: block; font-size: 0.9em; color: #666;"><strong>Description:</strong></label>
                    <span style="font-size: 1em; color: #333;"><?php echo esc_html($description); ?></span>
                </div>
                <div class="detail-item" style="width: 20%;">
                    <label style="display: block; font-size: 0.9em; color: #666;"><strong>Membership Duration:</strong></label>
                    <span style="font-size: 1em; color: #333;"><?php echo esc_html($membershipLifeSpan); ?> Days</span>
                </div>
                <div class="detail-item" style="width: 20%;">
                    <label style="display: block; font-size: 0.9em; color: #666;"><strong>Segment ID:</strong></label>
                    <span style="font-size: 1em; color: #333;"><?php echo esc_html($id); ?></span>
                </div>
                <div style="position:relative; width: 20%;" class="text-end">
                    <button type="button" class="btn btn-primary" id="update-segment">Edit</button>
                    <button type="button" class="btn btn-danger" id="delete-segment">Delete</button>
                </div>
            </div>
            <table class="form-table">
                <tbody>
                    <tr id="conv_role_wrapper" valign="top" style="width: 523px; height: 40px; Gap:12px;">
                        <th scope="row"><?php esc_html_e('Role', 'enhanced-e-commerce-for-woocommerce-store'); ?></th>
                        <td>
                            <?php
                            $roles = array(
                                'subscriber' => __('Subscriber', 'enhanced-e-commerce-for-woocommerce-store'),
                                'customer' => __('Customer', 'enhanced-e-commerce-for-woocommerce-store')
                            );

                            conv_html()->select(array(
                                'options' => $roles,
                                'name' => 'role',
                                'show_option_all' => false,
                                'show_option_none' => false,
                                'selected' => $settings->get('role'),
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr id="conv_columns" valign="top" style="display:none;">
                        <td>
                            <input type="hidden" name="columns"
                                value="user_email,first_name,last_name,billing_country,billing_postcode,billing_phone,billing_address_1,billing_state,billing_city" />
                        </td>
                    </tr>
                    <tr id="conv_delimiter_wrapper" valign="top" style="display:none;">
                        <td>
                            <input type="hidden" name="delimiter" value="COMMA" />
                        </td>
                    </tr>
                    <tr id="conv_user_created_wrapper" valign="top">
                        <th scope="row"><?php esc_html_e('User created', 'enhanced-e-commerce-for-woocommerce-store'); ?></th>
                        <td>
                            <label for="from">
                                <span style="font-weight: 500;">From</span>
                                <?php
                                $fromconv_date = $settings->get('from');
                                if (empty($fromconv_date) || $fromconv_date === "") {
                                    $fromconv_date =  gmdate("Y-m-d", strtotime("-1 year"));
                                }
                                conv_html()->text(array('type' => 'date', 'name' => 'from', 'id' => 'from', 'class' => 'form-control', 'value' => $fromconv_date));
                                ?>
                            </label>
                            <label for="to">
                                <span style="font-weight: 600;">To</span>
                                <?php
                                $toconv_date = $settings->get('to');
                                if (empty($toconv_date) || $toconv_date === "") {
                                    $toconv_date =  gmdate("Y-m-d");
                                }
                                conv_html()->text(array('type' => 'date', 'name' => 'to', 'id' => 'to', 'class' => 'form-control', 'value' => $toconv_date));
                                ?>
                            </label>
                        </td>
                    </tr>
                    <div id="apiModal" class="d-none alert alert-info mt-4">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-info me-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="div">
                                <h5 class="p-0 m-0">Please wait users sending via API in real time</h5>
                            </div>

                        </div>
                    </div>
                    <tr id="conv_export_type_wrapper" valign="top">
                        <th scope="row"></th>
                        <td>
                            <input type="hidden" name="segment_id" id="segment_id" value="<?php echo esc_attr($segmentId); ?>" />
                            <input type="hidden" name="export_type" id="conv_export_type" value="api" />
                            <div>
                                <!-- <ol id="conv-api-instruction" class="ps-1"> -->
                                <div>Selected users will send to Google Ads the under the audience manager</div>
                                <div>By clicking the export button you agrees that this data was collected and is being
                                    shared with Google in compliance with <a target="_blank"
                                        href="https://support.google.com/adspolicy/answer/6299717">Google's Customer Match
                                        policies</a></div>
                                <!-- </ol> -->
                            </div>
                        </td>
                    </tr>
                    <tr id="conv_download_csv_wrapper" valign="top">
                        <th scope="row"></th>
                        <td>
                            <input class="btn btn-primary" type="submit" id="export_button"
                                value="<?php esc_attr_e('Export', 'enhanced-e-commerce-for-woocommerce-store'); ?>" />
                        </td>
                    </tr>
                    <div id="customer-sync-message" class="alert alert-info mt-4"
                        style="border-left: 5px solid #007bff; background-color: lightgoldenrodyellow; padding: 15px; border-radius: 5px;">
                        <div style="display: flex; align-items: center;">
                            <span class="material-symbols-outlined"
                                style="font-size: 24px; margin-right: 10px; color: #007bff;">
                                info
                            </span>
                            <div style="font-weight:500;">
                                <strong>Important Notice:</strong>
                                <br>Google Ads processing for customer match data may take up to 24 hours.
                                <br>During this time, your data is being securely processed and evaluated.
                                <br>We appreciate your patience and recommend checking back later for audience availability.
                            </div>
                        </div>
                    </div>

                </tbody>
            </table>

            <div class="accordion" id="accordionExample" style="width: 100%;">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" style="background-color: #fafafa;" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                            Segment Members (Customers based on email, phone, and/or mailing address uploads)
                        </button>
                    </h2>
                    <div id="collapseOne" style="background-color: white; border-radius: 6px; border: 1px solid #ddd;"
                        class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table id="jobTable" class="dshreporttble" style="width: 100%;font-size: initial; margin-bottom: 25px;">
                                <thead style="background-color:#F1F3FA; height: 40px; color: rgba(0, 0, 0, 0.5);">
                                    <tr>
                                        <th>Job ID</th>
                                        <th>Source</th>
                                        <th>Status</th>
                                        <th>Resource Name</th>
                                        <th>Match Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($listdetails->data->offlineJobData) && is_array($listdetails->data->offlineJobData)): ?>
                                        <?php foreach ($listdetails->data->offlineJobData as $job): ?>
                                            <tr style="height: 40px;">
                                                <td><?php echo esc_html($job->offlineUserDataJob->id); ?></td>
                                                <td><?php echo esc_html($job->offlineUserDataJob->type); ?></td>
                                                <td><?php echo esc_html($job->offlineUserDataJob->status); ?></td>
                                                <td><?php echo esc_url($job->offlineUserDataJob->resourceName); ?></td>
                                                <td><?php
                                                    if (isset($job->offlineUserDataJob->operationMetadata->matchRateRange)) {
                                                        $matchRateRange = $job->offlineUserDataJob->operationMetadata->matchRateRange;

                                                        if (preg_match('/MATCH_RANGE_LESS_THAN_(\d+)/', $matchRateRange, $matches)) {
                                                            echo '&lt;' . esc_html($matches[1]) . '%';
                                                        } else {
                                                            echo esc_html($matchRateRange);
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center fs-5">No recent uploads.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <input id="gotobackurl" type="hidden"
                value="<?php echo esc_url_raw('admin.php?page=conversios-audience-manager&tab=customer_export&segment_id=' . $segmentId); ?>">
            <input type="hidden" name="action" value="conv_export_users_csv" />

            <?php wp_nonce_field('conversios_nonce', 'security'); ?>
        </form>

        <script type="text/javascript">
            var subscription_id = <?php echo json_encode($conv_ee_options_settings['subscription_id']); ?>;
            var store_id = <?php echo json_encode($conv_ee_api_data['setting']->store_id); ?>;
            let originalName = jQuery('#modal-segment-name').val();
            let originalDescription = jQuery('#modal-segment-description').val();
            jQuery(document).ready(function() {
                function validateDates() {
                    const fromVal = jQuery('#from').val();
                    const toVal = jQuery('#to').val();

                    if (!fromVal || !toVal) {
                        alert('Both date fields must be filled out.');
                        return false;
                    }

                    const fromDate = new Date(fromVal);
                    const toDate = new Date(toVal);

                    // Check if the dates are valid
                    if (isNaN(fromDate) || isNaN(toDate)) {
                        alert('Please select valid dates.');
                        return false;
                    }

                    // Check if the 'to' date is in the future compared to 'from' date
                    if (toDate < fromDate) {
                        alert('The "To" date must be in the future compared to the "From" date.');
                        jQuery('#to').val(''); // Clear the invalid input
                        return false;
                    }

                    return true; // Allow form submission
                }

                // Attach click event to the export button
                jQuery('#export_button').on('click', function(e) {
                    if (!validateDates()) {
                        e.preventDefault(); // Prevent form submission if validation fails
                    }
                });
            });

            jQuery(document).ready(function() {
                jQuery('#update-segment').click(function() {
                    jQuery('#editSegmentModal').modal('show');
                });
                jQuery('#cancelBtn').click(function() {
                    $('#modal-segment-name').val(originalName);
                    $('#modal-segment-description').val(originalDescription);
                    jQuery('#editSegmentModal').modal('hide');
                });
                jQuery('#updateBtn').on('click', function() {
                    jQuery('#modal-loader').show();
                    jQuery('#modal-overlay').show(); // Show overlay
                    jQuery('#modal-segment-name').prop('disabled', true); // Disable name field
                    jQuery('#modal-segment-description').prop('disabled', true);
                    var segmentId = <?php echo json_encode($segmentId); ?>;
                    let updatedName = $('#modal-segment-name').val().trim();
                    let updatedDescription = $('#modal-segment-description').val().trim();
                    if (!updatedName || !updatedDescription) {
                        alert('Name and Description cannot be empty. Please fill in both fields.');
                        jQuery('#modal-loader').hide();
                        jQuery('#modal-overlay').hide(); // Hide overlay
                        jQuery('#modal-segment-name').prop('disabled', false); // Re-enable name field
                        jQuery('#modal-segment-description').prop('disabled', false);
                        return;
                    }
                    jQuery.ajax({
                        url: tvc_ajax_url,
                        method: 'POST',
                        data: {
                            action: 'update_segment',
                            store_id: store_id,
                            subscription_id: subscription_id,
                            list_id: segmentId,
                            name: updatedName,
                            description: updatedDescription,
                            conversios_nonce: '<?php echo esc_js(wp_create_nonce('conversios_nonce')); ?>'
                        },
                        success: function(response) {
                            jQuery('#modal-loader').hide();
                            jQuery('#modal-overlay').hide(); // Hide overlay
                            jQuery('#modal-segment-name').prop('disabled', false); // Re-enable name field
                            jQuery('#modal-segment-description').prop('disabled', false);
                            if (response.success) {
                                alert('Segment data updated successfully!');
                                jQuery('#editSegmentModal').modal('hide');
                                window.location.reload();
                                window.location.href = 'admin.php?page=conversios-audience-manager&tab=customer_export&segment_id=' + segmentID;
                            } else {
                                alert('Error updating segment: ' + (response.data ? response.data.errors : 'Unknown error'));
                            }
                        },
                        error: function(xhr, status, error) {
                            jQuery('#modal-loader').hide();
                            jQuery('#modal-overlay').hide(); // Hide overlay
                            jQuery('#modal-segment-name').prop('disabled', false); // Re-enable name field
                            jQuery('#modal-segment-description').prop('disabled', false);
                            alert('AJAX Error: ' + error);
                        }
                    });
                });
            })
            jQuery(document).ready(function() {
                jQuery('#delete-segment').on('click', function(e) {
                    e.preventDefault();
                    var segmentId = <?php echo json_encode($segmentId); ?>;
                    jQuery('#deleteConfirmationModal').modal('show');
                });
                jQuery('#confirmDeleteBtn').on('click', function() {
                    var segmentId = <?php echo json_encode($segmentId); ?>;
                    jQuery.ajax({
                        url: tvc_ajax_url,
                        method: 'POST',
                        data: {
                            action: 'delete_segment',
                            store_id: store_id,
                            subscription_id: subscription_id,
                            list_id: segmentId,
                            conversios_nonce: '<?php echo esc_js(wp_create_nonce('conversios_nonce')); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Segment deleted successfully!');
                                jQuery('#deleteConfirmationModal').modal('hide');
                                window.location.href = 'admin.php?page=conversios-audience-manager';
                            } else {
                                alert('Error deleting segment: ' + (response.data ? response.data.errors : 'Unknown error'));
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('AJAX Error: ' + error);
                        }
                    });
                });
            });
            <?php if (isset($listdetails->data->offlineJobData) && is_array($listdetails->data->offlineJobData) && !empty($listdetails->data->offlineJobData)): ?>
                jQuery(document).ready(function() {
                    // Initialize DataTable
                    jQuery('#jobTable').DataTable({
                        paging: true,
                        searching: false,
                        ordering: true,
                        info: true,
                        lengthChange: true,
                        columnDefs: [{
                                orderable: false,
                                targets: [1, 3]
                            },
                            {
                                orderable: true,
                                targets: [0, 2, 4]
                            },
                        ],
                    });
                });
            <?php endif; ?>
            jQuery(document).ready(function($) {
                jQuery('#conv_export_type').on('change', function() {
                    var selectedValue = jQuery(this).val();
                    if (selectedValue === 'csv') {
                        jQuery('#conv-csv-instruction').removeClass("d-none");
                        jQuery('#conv-api-instruction').addClass("d-none");
                    } else {
                        jQuery('#conv-csv-instruction').addClass("d-none");
                        jQuery('#conv-api-instruction').removeClass("d-none");
                    }
                });
            });
            jQuery(document).ready(function($) {
                jQuery("input[name='from']").change(function() {
                    jQuery("input[name='to']").attr('min', jQuery(this).val());
                })

                jQuery('#convert_timestamp').on('click', function() {
                    if (jQuery('#convert_timestamp').is(':checked')) {
                        jQuery('#datetime_format').prop('disabled', false);
                    } else {
                        jQuery('#datetime_format').prop('disabled', true);
                    }
                });

                jQuery('#save-without-exporting').click(function() {
                    var data = {
                        'action': 'conv_export_save_settings',
                        'settings': jQuery('.conv_exporter').serialize(),
                        'security': '<?php echo esc_attr(wp_create_nonce("conversios_nonce")); ?>'
                    };

                    $.post(ajaxurl, data, function(response) {
                        alert(response.data.message);
                    });
                });
            })
        </script>
<?php
    }

    function conv_export_users_csv()
    {
        $TVC_Admin_Helper = new TVC_Admin_Helper();
        check_ajax_referer('conversios_nonce', 'security');

        if (!current_user_can(apply_filters('conv_capability', 'create_users')))
            wp_die(esc_html__('Only users who are allowed to create users can export them.', 'enhanced-e-commerce-for-woocommerce-store'));

        $step = isset($_POST['step']) ? absint($_POST['step']) : 1;

        $exporter = new Conv_Batch_Exporter();

        if ($step == 1) {
            delete_transient('conv_export_bad_character_formulas_values_cleaned');
            $this->conv_save_settings();
        }

        $exporter->conv_set_role(isset($_POST['role']) ? sanitize_text_field($_POST['role']) : '');
        $exporter->conv_set_from(isset($_POST['from']) ? sanitize_text_field($_POST['from']) : '');
        $exporter->conv_set_to(isset($_POST['to']) ? sanitize_text_field($_POST['to']) : '');
        $export_type = $_POST['exportType'];
        $segment_id = $_POST['segmentId'];
        $exporter->conv_generate_file($export_type, $segment_id);
    }

    function conv_ajax_save_settings()
    {
        check_ajax_referer('conversios_nonce', 'security');

        if (!current_user_can(apply_filters('conv_capability', 'create_users')))
            wp_die(esc_html__('Only users who are able to create users can save settings about exporting them.', 'enhanced-e-commerce-for-woocommerce-store'));

        $this->conv_save_settings();

        wp_send_json_success(array('message' => __('Settings saved', 'enhanced-e-commerce-for-woocommerce-store'),));
    }

    function conv_save_settings()
    {
        $settings = array();

        isset($_POST['settings']) ? parse_str($_POST['settings'], $settings) : parse_str($_POST['form'], $settings);

        conv_settings()->save_multiple('export_backend', $settings);
    }
}
