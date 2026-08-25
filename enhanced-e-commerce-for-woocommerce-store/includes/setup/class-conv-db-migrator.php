<?php
/**
 * Version-gated database migrations for Conversios Free.
 *
 * @package Enhanced_Ecommerce_Google_Analytics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Runs ee_product_feed schema migrations once per conv_db_version.
 */
class Conv_DB_Migrator {

	const OPTION_KEY = 'conv_db_version';

	/**
	 * Target schema version handled by this migrator.
	 *
	 * @var string
	 */
	const TARGET_VERSION = '7.2.8';

	/**
	 * Boot the migrator on plugins_loaded.
	 */
	public static function init() {
		add_action( 'plugins_loaded', array( __CLASS__, 'maybe_migrate' ), 5 );
	}

	/**
	 * Run pending migrations when conv_db_version is behind TARGET_VERSION.
	 */
	public static function maybe_migrate() {
		$current_version = get_option( self::OPTION_KEY, '' );
		$legacy_version  = get_option( 'ee_conv_plugin_version', '' );
		if ( self::TARGET_VERSION === $current_version ) {
			return;
		}
		if ( self::TARGET_VERSION === $legacy_version ) {
			update_option( self::OPTION_KEY, self::TARGET_VERSION );
			return;
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'ee_product_feed';

		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) !== $table_name ) {
			update_option( self::OPTION_KEY, self::TARGET_VERSION );
			update_option( 'ee_conv_plugin_version', self::TARGET_VERSION );
			return;
		}

		self::maybe_set_row_format_dynamic( $table_name );

		$columns = array(
			'ms_status'                => 'TEXT DEFAULT NULL',
			'IncProductVar'            => 'VARCHAR(20) DEFAULT 1',
			'IncDefProductVar'         => 'VARCHAR(20) DEFAULT 0',
			'IncLowestPriceProductVar' => 'VARCHAR(20) DEFAULT 0',
			'gmc_datasource_id'        => 'VARCHAR(25) DEFAULT NULL',
		);

		foreach ( $columns as $column_name => $column_definition ) {
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$exists = $wpdb->get_results(
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				$wpdb->prepare( "SHOW COLUMNS FROM `$table_name` LIKE %s", $column_name )
			);

			if ( empty( $exists ) ) {
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				$wpdb->query( "ALTER TABLE `$table_name` ADD `$column_name` $column_definition" );
			}
		}

		update_option( self::OPTION_KEY, self::TARGET_VERSION );
		update_option( 'ee_conv_plugin_version', self::TARGET_VERSION );
	}

	/**
	 * Set InnoDB ROW_FORMAT=DYNAMIC only when the table is not already dynamic.
	 *
	 * Legacy COMPACT tables can hit "Row size too large" on ee_product_feed; skip when already fixed.
	 *
	 * @param string $table_name Fully qualified table name (with prefix).
	 */
	private static function maybe_set_row_format_dynamic( $table_name ) {
		global $wpdb;

		$row_format = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT ROW_FORMAT FROM information_schema.TABLES WHERE table_schema = %s AND table_name = %s',
				DB_NAME,
				$table_name
			)
		);

		if ( 'DYNAMIC' === strtoupper( (string) $row_format ) ) {
			return;
		}

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$wpdb->query( "ALTER TABLE `$table_name` ROW_FORMAT=DYNAMIC" );
	}
}
