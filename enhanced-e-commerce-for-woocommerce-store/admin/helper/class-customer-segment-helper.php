<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       
 * @since      1.0.0
 *
 * Woo Order Reports
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('Conversios_Customer_Segment_Helper')) {
    class Conversios_Customer_Segment_Helper
    {
        protected $TVC_Admin_Helper;
        protected $CustomApi;
        protected $apiDomain;
        protected $token;
        public function __construct()
        {
            $this->req_int();
            $this->apiDomain = TVC_API_CALL_URL;
            $this->token = 'MTIzNA==';
            $this->TVC_Admin_Helper = new TVC_Admin_Helper();
            $this->CustomApi = new CustomApi();
            add_action('wp_ajax_get_customer_segment_list', array($this, 'get_customer_segment_list'));
            add_action('wp_ajax_create_segment', array($this, 'create_segment'));
            add_action('wp_ajax_delete_segment', array($this, 'delete_segment'));
            add_action('wp_ajax_update_segment', array($this, 'update_segment'));
        }

        public function req_int()
        {
            if (!class_exists('CustomApi')) {
                require_once(ENHANCAD_PLUGIN_DIR . 'includes/setup/CustomApi.php');
            }
            if (!class_exists('ShoppingApi')) {
            }
        }
        protected function admin_safe_ajax_call($nonce, $registered_nonce_name)
        {
            if (is_admin() && wp_verify_nonce($nonce, $registered_nonce_name)) {
                return true;
            } else {
                return false;
            }
        }
        // public function get_customer_segment_list($sub_id)
        // {
        //     $nonce = (isset($_POST['conversios_nonce'])) ? sanitize_text_field($_POST['conversios_nonce']) : "";
        //     $return = array();
        //     if ($this->admin_safe_ajax_call($nonce, 'conversios_nonce')) {
        //         $subscription_id = $sub_id;
        //         $store_id = (isset($_POST['store_id'])) ? sanitize_text_field($_POST['store_id']) : "";
        //         if ($store_id != "") {
        //             $api_rs = $this->created_segment_table(   $subscription_id, $store_id);
        //             if (isset($api_rs->error) && $api_rs->error == '') {
        //                 if (isset($api_rs->data) && $api_rs->data != "") {
        //                     $return = array('error' => false, 'data' => $api_rs->data);
        //                 }
        //             } else {
        //                 $errormsg = isset($api_rs->errors[0]) ? $api_rs->errors[0] : "";
        //                 $return = array('error' => true, 'errors' => $errormsg,  'status' => $api_rs->status);
        //             }
        //         }
        //     } else {
        //         $return = array('error' => true, 'errors' => esc_html__("Admin security nonce is not verified.", "enhanced-e-commerce-for-woocommerce-store"));
        //     }
        //     echo json_encode($return);
        //     wp_die();
        // }
        public function create_segment()
        {
            if (!isset($_POST['conversios_nonce']) || !wp_verify_nonce($_POST['conversios_nonce'], 'conversios_nonce')) {
                wp_send_json_error(['message' => 'Invalid request. Please try again.']);
                exit;
            }
            $return = array();
            $data = isset($_POST['tvc_data']) ? sanitize_text_field(urldecode($_POST['tvc_data'])) : "";
            parse_str($data, $form_array);
            if (!empty($form_array)) {
                foreach ($form_array as $key => $value) {
                    $form_array[$key] = sanitize_text_field($value);
                }
            }
            $require_fields = array("name", "description", "subscription_id", "store_id");
            foreach ($require_fields as $val) {
                if (isset($form_array[$val]) && $form_array[$val] == "") {
                    $return = array('error' => true, 'message' => esc_html__(str_replace("_", " ", $val) . " is required field.", "enhanced-e-commerce-for-woocommerce-store"));
                }
            }
            if (!empty($return)) {
                echo json_encode($return);
                wp_die();
            } else	if ((isset($form_array["subscription_id"])) && (isset($form_array["store_id"]))) {
                $api_rs = $this->create_segment_callapi($form_array);
                if (isset($api_rs->error) && $api_rs->error == '') {
                    //print_r($api_rs->data);
                    if (isset($api_rs->data->results[0]->resourceName) && $api_rs->data != "") {
                        // $resource_name = $api_rs->data->results[0]->resourceName;
                        $return = array('error' => false, 'message' => "Segment Created Successfully");
                    } else if (isset($api_rs->data)) {
                        $return = array('error' => false, 'data' => $api_rs->data);
                    }
                } else {
                    $errormsg = "";
                    if (!is_array($api_rs->errors) && is_string($api_rs->errors)) {
                        $errormsg = $api_rs->errors;
                    } else {
                        $errormsg = isset($api_rs->errors[0]) ? $api_rs->errors[0] : "";
                    }
                    $return = array('error' => true, 'message' => $errormsg,  'status' => $api_rs->status);
                }
            }

            echo json_encode($return);
            wp_die();
        }

        public function get_customer_segment_list($subscription_id, $store_id)
        {
            try {
                $url = $this->apiDomain . '/customer-match/list';
                $data = [
                    "store_id" => $store_id,
                    "subscription_id" => $subscription_id
                ];
                $header = array(
                    // "Authorization: Bearer $this->token",
                    "Content-Type" => "application/json"
                );
                $args = array(
                    'timeout' => 10000,
                    'headers' => $header,
                    'method' => 'POST',
                    'body' => wp_json_encode($data)
                );
                // Send remote request
                $request = wp_remote_post(esc_url_raw($url), $args);
                // Retrieve information
                $response_code = wp_remote_retrieve_response_code($request);
                $response_message = wp_remote_retrieve_response_message($request);
                $result = json_decode(wp_remote_retrieve_body($request));
                $return = new \stdClass();
                if (isset($result->error) && isset($result->data) && $result->error == '') {
                    $return->data = (isset($result->data)) ? $result->data : "";
                    $return->error = false;
                    return $return;
                } else {
                    $return->error = true;
                    $return->data = (isset($result->data)) ? $result->data : "";
                    $return->errors = $result->errors;
                    $return->status = $response_code;
                    return $return;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        public function delete_segment()
        {
            if (!isset($_POST['conversios_nonce']) || !wp_verify_nonce($_POST['conversios_nonce'], 'conversios_nonce')) {
                wp_send_json_error(['message' => 'Invalid request. Please try again.']);
                exit;
            }
            if (isset($_POST['store_id'], $_POST['subscription_id'], $_POST['list_id'])) {
                $store_id = sanitize_text_field($_POST['store_id']);
                $subscription_id = sanitize_text_field($_POST['subscription_id']);
                $list_id = sanitize_text_field($_POST['list_id']);
                $post_data = array(
                    'store_id' => $store_id,
                    'subscription_id' => $subscription_id,
                    'list_id' => $list_id
                );
                try {
                    $url = $this->apiDomain . '/customer-match/delete';
                    $header = array(
                        "Content-Type" => "application/json"
                    );
                    $args = array(
                        'timeout' => 1000,
                        'headers' => $header,
                        'method' => 'POST',
                        'body' => wp_json_encode($post_data)
                    );
                    $request = wp_remote_post(esc_url_raw($url), $args);
                    $response_code = wp_remote_retrieve_response_code($request);
                    $result = json_decode(wp_remote_retrieve_body($request));
                    $return = new \stdClass();
                    if (isset($result->error) && empty($result->error)) {
                        $return->data = isset($result->data) ? $result->data : "";
                        $return->error = false;
                        wp_send_json_success($return);
                    } else {
                        $return->error = true;
                        $return->data = isset($result->data) ? $result->data : "";
                        $return->errors = $result->errors ?? 'Unknown error';
                        $return->status = $response_code;
                        wp_send_json_error($return);
                    }
                } catch (Exception $e) {
                    wp_send_json_error(array('error' => true, 'message' => $e->getMessage()));
                }
            }
        }
        public function update_segment()
        {
            if (!isset($_POST['conversios_nonce']) || !wp_verify_nonce($_POST['conversios_nonce'], 'conversios_nonce')) {
                wp_send_json_error(['message' => 'Invalid request. Please try again.']);
                exit;
            }
            if (isset($_POST['store_id'], $_POST['subscription_id'], $_POST['list_id'], $_POST['name'], $_POST['description'])) {
                $store_id = sanitize_text_field($_POST['store_id']);
                $subscription_id = sanitize_text_field($_POST['subscription_id']);
                $list_id = sanitize_text_field($_POST['list_id']);
                $name = sanitize_text_field($_POST['name']);
                $description = sanitize_text_field($_POST['description']);
                $post_data = array(
                    'store_id' => $store_id,
                    'subscription_id' => $subscription_id,
                    'list_id' => $list_id,
                    'name' => $name,
                    'description' => $description
                );
                try {
                    $url = $this->apiDomain . '/customer-match/update';
                    $header = array(
                        "Content-Type" => "application/json"
                    );
                    $args = array(
                        'timeout' => 1000,
                        'headers' => $header,
                        'method' => 'POST',
                        'body' => wp_json_encode($post_data)
                    );
                    $request = wp_remote_post(esc_url_raw($url), $args);
                    $response_code = wp_remote_retrieve_response_code($request);
                    $result = json_decode(wp_remote_retrieve_body($request));
                    $return = new \stdClass();
                    if (isset($result->error) && empty($result->error)) {
                        $return->data = isset($result->data) ? $result->data : "";
                        $return->error = false;
                        wp_send_json_success($return);
                    } else {
                        $return->error = true;
                        $return->data = isset($result->data) ? $result->data : "";
                        $return->errors = $result->errors ?? 'Unknown error';
                        $return->status = $response_code;
                        wp_send_json_error($return);
                    }
                } catch (Exception $e) {
                    wp_send_json_error(array('error' => true, 'message' => $e->getMessage()));
                }
            }
        }
        public function get_segment_details($list_id, $subscription_id, $store_id)
        {
            try {
                $url = $this->apiDomain . '/customer-match/detail';
                $data = [
                    "store_id" => $store_id,
                    "subscription_id" => $subscription_id,
                    "list_id" => $list_id
                ];
                $header = array(
                    "Content-Type" => "application/json"
                );
                $args = array(
                    'timeout' => 10000,
                    'headers' => $header,
                    'method' => 'POST',
                    'body' => wp_json_encode($data)
                );
                $request = wp_remote_post(esc_url_raw($url), $args);
                $response_code = wp_remote_retrieve_response_code($request);
                $response_message = wp_remote_retrieve_response_message($request);
                $result = json_decode(wp_remote_retrieve_body($request));
                $return = new \stdClass();
                if (isset($result->error) && isset($result->data) && $result->error == '') {
                    $return->data = (isset($result->data)) ? $result->data : "";
                    $return->error = false;
                    return $return;
                } else {
                    $return->error = true;
                    $return->data = (isset($result->data)) ? $result->data : "";
                    $return->errors = $result->errors;
                    $return->status = $response_code;
                    return $return;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        public function create_segment_callapi($post_data)
        {
            try {
                $url = $this->apiDomain . '/customer-match/create';
                $header = array(
                    "Authorization" => "Bearer " . $this->token,
                    "Content-Type" => "application/json"
                );
                $args = array(
                    'timeout' => 10000,
                    'headers' => $header,
                    'method' => 'POST',
                    'body' => wp_json_encode($post_data)
                );
                // Send remote request
                $request = wp_remote_post(esc_url_raw($url), $args);

                // Retrieve information
                $response_code = wp_remote_retrieve_response_code($request);
                $response_message = wp_remote_retrieve_response_message($request);
                $result = json_decode(wp_remote_retrieve_body($request));
                $return = new \stdClass();
                // print_r($result);
                if (isset($result->error) && isset($result->data) && $result->error == '') {
                    $return->data = (isset($result->data)) ? $result->data : "";
                    $return->error = false;
                    //print_r($return);
                    return $return;
                } else {
                    $return->error = true;
                    $return->data = (isset($result->data)) ? $result->data : "";
                    $result->errors = (array)$result->errors;
                    if (!empty($result->errors)) {
                        if (count($result->errors) != count($result->errors, COUNT_RECURSIVE)) {
                            $return->errors = implode(" & ", array_map(function ($a) {
                                return implode("~", $a);
                            }, $result->errors));
                        } else {
                            $return->errors = implode(" ", $result->errors);
                        }
                    } else {
                        $return->errors = $result->errors;
                    }
                    $return->status = $response_code;
                    return $return;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
new Conversios_Customer_Segment_Helper();
