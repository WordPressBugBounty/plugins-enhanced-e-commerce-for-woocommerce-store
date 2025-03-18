<?php
if (!defined('ABSPATH')) {
	exit;
}

class Conv_Batch_Exporter
{
	protected $role = '';
	protected $from = '';
	protected $to = '';
	protected $orderby = '';
	protected $order = '';
	protected $user_data;
	protected $accepted_order_by;
	protected $woocommerce_default_user_meta_keys;
	protected $other_non_date_keys;

	protected $exportType;
	protected $subscription_id;
	protected $TVC_Admin_Helper;
	protected $google_detail;
	protected $apiDomain;
	protected $myExportType;
	function __construct()
	{
		$this->user_data = array("user_login", "user_email", "source_user_id", "user_pass", "user_nicename", "user_url", "user_registered", "display_name");
		$this->accepted_order_by = array('ID', 'display_name', 'name', 'user_name', 'login', 'user_login', 'nicename', 'user_nicename', 'email', 'user_email', 'url', 'user_url', 'registered', 'user_registered', 'post_count');
		$this->woocommerce_default_user_meta_keys = array('billing_first_name', 'billing_last_name', 'billing_email', 'billing_phone', 'billing_country', 'billing_address_1', 'billing_city', 'billing_state', 'billing_postcode', 'shipping_first_name', 'shipping_last_name', 'shipping_country', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state', 'shipping_postcode');
		$this->other_non_date_keys = array('shipping_phone', '_vat_number', '_billing_vat_number');
		// $this->total_rows = $this->conv_get_total_rows();
		$this->TVC_Admin_Helper = new TVC_Admin_Helper();
		$this->subscription_id = $this->TVC_Admin_Helper->get_subscriptionId();
		$this->google_detail = $this->TVC_Admin_Helper->get_ee_options_data();
		$this->apiDomain = TVC_API_CALL_URL;
	}

	function conv_set_role($role)
	{
		$this->role = $role;
	}

	function conv_get_role()
	{
		return empty($this->role) ? '' : explode(',', $this->role);
	}

	function conv_set_from($from)
	{
		$this->from = $from;
	}

	function conv_get_from()
	{
		return $this->from;
	}

	function conv_set_to($to)
	{
		$this->to = $to;
	}

	function conv_get_to()
	{
		return $this->to;
	}

	function conv_get_orderby()
	{
		return $this->orderby;
	}

	function conv_get_order()
	{
		return $this->order;
	}

	function conv_generate_file($export_type, $segment_id)
	{
		$this->exportType = $export_type;
		if ($this->exportType === "api") {
			$api_data = $this->customerMatch();  // Ensure customerMatch returns the data
			$this->conv_write_csv_data($api_data, "api", $segment_id);
		}
	}


	function customerMatch()
	{
		$users = $this->convGetUserList();
		$postUser = $userData = [];
		$userMetaKeys = ['first_name', 'last_name', 'billing_country', 'billing_address_1', 'billing_city', 'billing_postcode', 'billing_state', 'billing_phone'];
		$postKeyMap = [
			'first_name' => 'first_name',
			'last_name' => 'last_name',
			'billing_country' => 'country_code',
			'billing_address_1' => 'street_address',
			'billing_city' => 'city',
			'billing_postcode' => 'postal_code',
			'billing_state' => 'state',
			'billing_phone' => 'phone'
		];

		foreach ($users as $user) {
			$userData['email'] = $user->user_email;
			foreach ($userMetaKeys as $key) {
				$userData[$postKeyMap[$key]] = get_user_meta($user->id, $key, true);
			}
			$postUser[] = $userData;
		}
		return $postUser;
	}

	function convGetUserList()
	{
		// Set the arguments for the user query
		$args = array(
			'fields' => array('ID', 'user_email'), // Fetch only user IDs
			'order' => $this->conv_get_order(), // Order by the desired fieldfunction conv_get_user_id_list($calculate_total = false)
			'number' => -1, // Fetch all users, no pagination
		);

		// Apply role filtering if specified
		if (!empty($this->conv_get_role())) {
			$args['role__in'] = $this->conv_get_role();
		}

		// Prepare date query if 'from' or 'to' dates are set
		$date_query = array();

		if (!empty($this->conv_get_from())) {
			$date_query[] = array('after' => $this->conv_get_from(), 'inclusive' => true);
		}

		if (!empty($this->conv_get_to())) {
			$date_query[] = array(
				'before' => $this->conv_get_to(),
				'inclusive' => true
			);
		}

		// If we have date queries, set them in the args
		if (!empty($date_query)) {
			$args['date_query'] = $date_query;
		}

		// Handle order by
		if (!empty($this->conv_get_orderby())) {
			if (in_array($this->conv_get_orderby(), $this->accepted_order_by)) {
				$args['orderby'] = $this->conv_get_orderby();
			} else {
				$args['orderby'] = "meta_value";
				$args['meta_key'] = $this->conv_get_orderby();
			}
		}

		$users = get_users($args);
		return $users;
	}

	protected function conv_write_csv_data($data, $value, $segment_id)
	{
		$this->myExportType = $value;
		$TVC_Admin_Helper = new TVC_Admin_Helper();
		if ($this->myExportType == "api") {
			$number_of_records = count($data);
			$TVC_Admin_Helper->plugin_log('Number of records: ' . $number_of_records, 'product_sync');

			$subscription_id = $this->subscription_id;
			$store_id = $this->google_detail['setting']->store_id;
			$api_url = $this->apiDomain . '/customer-match/sync';
			$data = [
				"store_id" => $store_id,
				"subscription_id" => $subscription_id,
				"list_id" => $segment_id,
				"customers" => $data
			];

			$json_data = json_encode($data, JSON_PRETTY_PRINT);

			// WordPress HTTP API
			$args = array(
				'body'        => $json_data,
				'timeout'     => 60,  // Increased timeout for large datasets
				'httpversion' => '1.1',
				'headers'     => array(
					'Content-Type' => 'application/json',
					'Content-Length' => strlen($json_data)
				)
			);

			// Make the request
			$response = wp_remote_post($api_url, $args);

			// Get the response
			if (is_wp_error($response)) {
				$response_body = wp_remote_retrieve_body($response);
				$TVC_Admin_Helper->plugin_log('WP Error: ' . $response_body, 'product_sync');
				wp_send_json_success(['response' => $response_body]);
			} else {
				$response_body = wp_remote_retrieve_body($response);
				$TVC_Admin_Helper->plugin_log('API Response: ' . $response_body, 'product_sync');
				wp_send_json_success(['response' => $response_body]);
			}
		}
	}
}
