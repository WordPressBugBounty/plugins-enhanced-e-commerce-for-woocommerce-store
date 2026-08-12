<?php
if (! defined('ABSPATH')) {
	exit;
}
if (! class_exists('TVC_Admin_DB_Helper')) {
	class TVC_Admin_DB_Helper
	{
		public function __construct()
		{
			$this->includes();
		}
		public function includes()
		{
			//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		/**
		 * Sanitize a SQL column identifier from a where-clause fragment.
		 *
		 * @param string $column Raw column name, optionally backtick-wrapped.
		 * @return string Escaped column name without backticks.
		 */
		private function conv_sanitize_column($column)
		{
			return esc_sql(trim($column, " \t\n\r\0\x0B`"));
		}

		public function tvc_row_count($table, $field_name = "*")
		{
			if ($table == "") {
				return;
			} else {
				global $wpdb;
				$tablename = esc_sql($wpdb->prefix . $table);
				$field_name = esc_sql($field_name);
				$sql = $wpdb->prepare("select count(%s) from `$tablename`", $field_name);
				return $wpdb->get_var($sql);
			}
		}

		public function tvc_add_row($table, $t_data = array(), $format = array())
		{
			if ($table == "" || $t_data == "") {
				return;
			} else {
				global $wpdb;
				$tablename = esc_sql($wpdb->prefix . $table);
				return $wpdb->insert($tablename, $t_data, $format);
			}
		}

		public function tvc_update_row($table, $t_data, $where)
		{
			if ($table == "" || $t_data == "" ||  $where == "") {
				return;
			} else {
				global $wpdb;
				$tablename = esc_sql($wpdb->prefix . $table);
				return $wpdb->update($tablename, $t_data, $where);
			}
		}
		public function tvc_delete_row($table, $where)
		{
			if (empty($table) || empty($where)) {
				return false;
			} else {
				global $wpdb;
				$tablename = esc_sql($wpdb->prefix . $table);
				return $wpdb->delete($tablename, $where);
			}
		}

		public function tvc_check_row($table, $key, $value)
		{
			global $wpdb;
			if ($table == "" || $value == "" || $key == "") {
				return;
			}
			$tablename = esc_sql($wpdb->prefix . $table);
			$column    = $this->conv_sanitize_column($key);
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			return $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM `$tablename` WHERE `$column` = %s", $value));
		}

		public function tvc_get_results_in_array($table, $where, $fields, $concat = false, $operator = "")
		{
			global $wpdb;
			if ($table == "" || $where == "" || $fields == "") {
				return;
			}
			$where_parts = explode('=', $where, 2);
			$column      = $this->conv_sanitize_column($where_parts[0]);
			$val         = isset($where_parts[1]) ? trim($where_parts[1]) : '';
			$tablename   = esc_sql($wpdb->prefix . $table);

			if ($operator === 'IN') {
				$val       = trim($val, " \t\n\r\0\x0B()");
				$in_values = array_filter(array_map('trim', explode(',', $val)), 'strlen');
				if (empty($in_values)) {
					return array();
				}
				$placeholders = implode(', ', array_fill(0, count($in_values), '%s'));
				if ($concat === true) {
					$concat_fields = implode(',\'_\',', $fields);
					// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPlaceholder
					$sql = $wpdb->prepare("SELECT CONCAT($concat_fields) AS p_c_id FROM `$tablename` WHERE `$column` IN ($placeholders)", ...$in_values);
					// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter -- Query built via $wpdb->prepare(); table/column names sanitized via esc_sql().
					return $wpdb->get_col($sql);
				}
				$field_list = esc_sql(implode('`,`', $fields));
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPlaceholder
				$sql = $wpdb->prepare("SELECT `$field_list` FROM `$tablename` WHERE `$column` IN ($placeholders)", ...$in_values);
				// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				return $wpdb->get_results($sql, ARRAY_A);
			}

			if ($concat === true) {
				$concat_fields = implode(',\'_\',', $fields);
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				return $wpdb->get_col($wpdb->prepare("SELECT CONCAT($concat_fields) AS p_c_id FROM `$tablename` WHERE `$column` = %s", $val));
			}

			$field_list = esc_sql(implode('`,`', $fields));
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			return $wpdb->get_results($wpdb->prepare("SELECT `$field_list` FROM `$tablename` WHERE `$column` = %s", $val), ARRAY_A);
		}
		public function tvc_get_results($table)
		{
			global $wpdb;
			if ($table == "") {
				return;
			} else {
				$tablename = esc_sql($wpdb->prefix . $table);
				$sql = $wpdb->prepare("select * from %i", $tablename);
				return $wpdb->get_results($sql);
			}
		}

		public function tvc_get_last_row($table, $fields = null)
		{
			if ($table == "") {
				return;
			} else {
				global $wpdb;
				$tablename = esc_sql($wpdb->prefix . $table);
				$sql = $wpdb->prepare("select * from %i ORDER BY id DESC LIMIT 1", $tablename);
				if ($fields) {
					$fields = implode('`,`', $fields);
					// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
					$sql = $wpdb->prepare("select `$fields` from `$tablename` ORDER BY id DESC LIMIT 1");
				}
				// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				return $wpdb->get_row($sql, ARRAY_A);
			}
		}

		public function tvc_get_counts_groupby($table, $fields_by)
		{
			global $wpdb;
			if ($table == "" ||  $fields_by == "") {
				return;
			} else {
				$tablename = esc_sql($wpdb->prefix . $table);
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				return $wpdb->get_results( $wpdb->prepare("select `$fields_by`, count(*) as count from `$tablename` GROUP BY `$fields_by` ORDER BY count DESC ") , ARRAY_A);
			}
		}

		public function tvc_safe_truncate_table($table)
		{
			global $wpdb;
			$query = $wpdb->prepare('SHOW TABLES LIKE %s', '%' . $wpdb->esc_like($table) . '%');
			if ($wpdb->get_var($query) === $table) {
				$table = esc_sql($table);
				$wpdb->query("TRUNCATE TABLE `$table`");
			}
		}
	}
}
