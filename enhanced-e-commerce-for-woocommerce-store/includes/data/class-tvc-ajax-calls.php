<?php

/**
 * TVC Ajax Calls Class.
 *
 * @package TVC Product Feed Manager/Data/Classes
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TVC_Ajax_Calls' ) ) :
	/**
	 * Feed Controller Class
	 */
	class TVC_Ajax_Calls {
		public function __construct() { }

		/**
		 * Verify nonce and manage_options for admin AJAX.
		 *
		 * @param string $nonce                 Request nonce.
		 * @param string $registered_nonce_name Registered nonce action.
		 * @return bool
		 */
		protected function safe_ajax_call( $nonce, $registered_nonce_name ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				return false;
			}
			if ( wp_verify_nonce( $nonce, $registered_nonce_name ) ) {
				return true;
			}
			return false;
		}

		/**
		 * Require manage_options for privileged admin AJAX handlers.
		 *
		 * @return bool True when the current user may proceed.
		 */
		protected function conv_require_manage_options() {
			return current_user_can( 'manage_options' );
		}
	}
	// End TVC_Ajax_Calls class.
endif;
