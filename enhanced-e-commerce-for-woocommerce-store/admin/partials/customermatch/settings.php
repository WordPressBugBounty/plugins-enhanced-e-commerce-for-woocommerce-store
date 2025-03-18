<?php
if ( ! defined( 'ABSPATH' ) ) exit; 

class Conv_Settings{
    private static $instance;
    var $settings;
    var $key;
    var $contexts;
    var $current_context;

    function __construct( $current_context = '' ){
        $this->settings = apply_filters( 'conv_export_customer_csv_settings', array(
            'import_common' => array(
                'path_to_file' => array( 
                    'sanitization' => 'text',
                    'default' => ''
                ),
                'role' => array( 
                    'sanitization' => 'array_text',
                    'default' => array( 'subscriber' )
                ),
                'empty_cell_action'  => array( 
                    'sanitization' => 'text',
                    'default' => 'leave'
                ),
                'sends_email' => array(
                    'sanitization' => 'checkbox',
                    'value' => 'no',
                ),
                'send_email_updated' => array(
                    'sanitization' => 'checkbox',
                    'value' => 'no',
                ),
                'update_existing_users' => array( 
                    'sanitization' => 'checkbox',
                    'default' => 'no'
                ),
                'force_user_reset_password' => array( 
                    'sanitization' => 'checkbox',
                    'default' => 'no'
                ),
                'update_emails_existing_users' => array( 
                    'sanitization' => 'text',
                    'default' => 'no'
                ),
                'update_roles_existing_users' => array( 
                    'sanitization' => 'text',
                    'default' => 'no'
                ),
                'update_allow_update_passwords' => array( 
                    'sanitization' => 'text',
                    'default' => 'no'
                ),
                'delete_users_not_present' => array(
                    'sanitization' => 'checkbox',
                    'value' => 'no',
                ),
                'delete_users_assign_posts' => array( 
                    'sanitization' => 'text',
                    'default' => '0'
                ),
                'change_role_not_present' => array(
                    'sanitization' => 'checkbox',
                    'value' => 'no',
                ),
                'change_role_not_present_role' => array( 
                    'sanitization' => 'text',
                    'default' => 'subscriber'
                ),
            ),
            'import_backend' => array(),
            'import_frontend' => array(),
            'import_cron' => array(),
            'export_common' => array(
                'role' => array( 
                    'sanitization' => 'text',
                    'default' => ''
                ),
                'columns' => array( 
                    'sanitization' => 'text',
                    'default' => ''
                ),
                'from' => array( 
                    'sanitization' => 'text',
                    'default' => ''
                ),
                'to' => array( 
                    'sanitization' => 'text',
                    'default' => ''
                ),
                'delimiter' => array( 
                    'sanitization' => 'text',
                    'default' => ''
                ),
                'convert_timestamp' => array( 
                    'sanitization' => 'checkbox',
                    'default' => false
                ),
                'datetime_format' => array( 
                    'sanitization' => 'text',
                    'default' => ''
                ),
                'order_fields_alphabetically' => array( 
                    'sanitization' => 'checkbox',
                    'default' => false
                ),
                'double_encapsulate_serialized_values' => array( 
                    'sanitization' => 'checkbox',
                    'default' => false
                ),
                'display_arrays_as_comma_separated_list_of_values' => array( 
                    'sanitization' => 'checkbox',
                    'default' => false
                ),
            ),
            'export_backend' => array(),
            'export_backend' => array(),
            'export_frontend' => array(),
        ));

        $this->key = 'conv_export_customer_csv_settings';
        $this->contexts = apply_filters( 'conv_contexts', array( 'import_backend', 'import_frontend', 'import_cron', 'export_backend') );
        $this->current_context = $current_context;

        $this->initialize_settings();
    }

    private static function is_instantiated() {
		if ( ! empty( self::$instance ) && ( self::$instance instanceof Conv_Settings ) ) {
			return true;
		}

		return false;
	}

    private static function setup_instance() {
		self::$instance = new Conv_Settings;
	}

    static function instance() {
		if ( self::is_instantiated() ) {
			return self::$instance;
		}

		self::setup_instance();

		return self::$instance;
	}

    function initialize_settings(){
        $options = get_option( $this->key );
        if( !is_array( $options ) ){
            $options = array();

            foreach( $this->contexts as $context ){
                $options[ $context ] = array();
            }

            update_option( $this->key, $options );
        }
    }

    function get_settings_from_context( $context ){
        switch( $context ){
            case 'import_backend':
                return array_merge( $this->settings['import_common'], $this->settings['import_backend'] );

            case 'import_frontend':
                return array_merge( $this->settings['import_common'], $this->settings['import_frontend'] );
        
            case 'import_cron':
                return array_merge( $this->settings['import_common'], $this->settings['import_cron'] );

            case 'export_backend':
                return array_merge( $this->settings['export_common'] );
        }

        return array();
    }

    function sanitize( $value, $sanitize_type ){
        switch( $sanitize_type ){
            case 'text':
                return sanitize_text_field( $value );

            case 'array_text':
                return array_map( 'sanitize_text_field', $value );

            case 'checkbox':
                return ( $value != 'yes' ) ? 'no' : 'yes';
        }
    }

    function save_multiple( $context, $data ){
        $settings_to_save = $this->get_settings_from_context( $context );

        $values = array();

        foreach( $settings_to_save as $setting => $setting_options ){
            $sanitize_type = $setting_options['sanitization'];
            if( !isset( $data[ $setting ] ) && $sanitize_type != 'checkbox' )
                continue;

            $values[ $setting ] = isset( $data[ $setting ] ) ? $this->sanitize( $data[ $setting ], $sanitize_type ) : 'no';
        }

        $options = get_option( $this->key );
        $options[ $context ] = $values;
        update_option( $this->key, $options );
    }

    function save( $option, $value, $context = '' ){
        $context = empty( $context ) ? $this->current_context : $context;
        $settings = $this->get_settings_from_context( $context );        
        $options = get_option( $this->key );
        $values = $options[ $context ];
        $values[ $option ] = $this->sanitize( $value, $settings[ $option ]['sanitization'] );
        $options[ $context ] = $values;
        update_option( $this->key, $options );
    }

    function get( $option, $context = '' ){
        $options = get_option( $this->key );
        $context = empty( $context ) ? $this->current_context : $context;

        if( !isset( $options[ $context ] ) || !is_array( $options[ $context ]  ) )
            return $this->default_option( $option, $context );    

        return isset( $options[ $context ][ $option ] ) ? $options[ $context ][ $option ] : $this->default_option( $option, $context );
    }

    function default_option( $option, $context = '' ){
        $context = empty( $context ) ? $this->current_context : $context;
        $settings = $this->get_settings_from_context( $context );

        if( !isset( $settings[ $option ] ) )
            return false;

        if( !isset( $settings[ $option ]['default'] ) ){
            switch( $settings[ $option ] ){
                case 'text':
                    return '';
    
                case 'array_text':
                    return array();
    
                case 'checkbox':
                    return false;

                default:
                    return false;
            }
        }

        return $settings[ $option ]['default'];        
    }

}

function conv_settings(){
    return Conv_Settings::instance();
}