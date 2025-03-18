<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
class Conv_HTML{
    private static $instance;
    var $settings;

    function __construct(){
    }

    private static function is_instantiated() {
		if ( ! empty( self::$instance ) && ( self::$instance instanceof Conv_HTML ) ) {
			return true;
		}

		return false;
	}

    private static function setup_instance() {
		self::$instance = new Conv_HTML;
	}

    static function instance() {
		if ( self::is_instantiated() ) {
			return self::$instance;
		}

		self::setup_instance();

		return self::$instance;
	}


    function sanitize_key( $key ) {
        $raw_key = $key;
        return preg_replace( '/[^a-zA-Z0-9_\-\.\:\/]/', '', $key );
    }

	function select( $args = array() ) {
		$defaults = array(
            'echo'             => true,
			'options'          => array(),
			'name'             => null,
			'class'            => 'form-control',
			'id'               => '',
			'selected'         => array(),
			'chosen'           => false,
			'placeholder'      => null,
			'multiple'         => false,
			'show_option_all'  => _x( 'All', 'all dropdown items', 'enhanced-e-commerce-for-woocommerce-store' ),
			'show_option_none' => _x( 'None', 'no dropdown items', 'enhanced-e-commerce-for-woocommerce-store' ),
			'data'             => array(),
			'readonly'         => false,
			'disabled'         => false,
		);

		$args = wp_parse_args( $args, $defaults );

        if( empty( $args['id'] ) )
            $args['id'] = $args['name'];

		$data_elements = '';
		foreach ( $args['data'] as $key => $value ) {
			$data_elements .= ' data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
		}

		if( $args['multiple'] ) {
			$multiple = ' MULTIPLE';
		} else {
			$multiple = '';
		}

		if( $args['placeholder'] ) {
			$placeholder = $args['placeholder'];
		} else {
			$placeholder = '';
		}

		if ( isset( $args['readonly'] ) && $args['readonly'] ) {
			$readonly = ' readonly="readonly"';
		} else {
			$readonly = '';
		}

		if ( isset( $args['disabled'] ) && $args['disabled'] ) {
			$disabled = ' disabled="disabled"';
		} else {
			$disabled = '';
		}

		$class  = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $args['class'] ) ) );
		$output = '<select' . $disabled . $readonly . ' name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( $this->sanitize_key( $args['id'] ) ) . '" class="conv-select ' . $class . '"' . $multiple . ' data-placeholder="' . $placeholder . '"'. $data_elements . '>';

		if ( ! isset( $args['selected'] ) || ( is_array( $args['selected'] ) && empty( $args['selected'] ) ) || ! $args['selected'] ) {
			$selected = "";
		}

		if ( $args['show_option_all'] ) {
			if ( $args['multiple'] && ! empty( $args['selected'] ) ) {
				$selected = selected( true, in_array( 0, (array) $args['selected'] ), false );
			} else {
				$selected = selected( $args['selected'], 0, false );
			}
			$output .= '<option value="all"' . $selected . '>' . esc_html( $args['show_option_all'] ) . '</option>';
		}

		if ( ! empty( $args['options'] ) ) {
			if ( $args['show_option_none'] ) {
				if ( $args['multiple'] ) {
					$selected = selected( true, in_array( "", $args['selected'] ), false );
				} elseif ( isset( $args['selected'] ) && ! is_array( $args['selected'] ) && ! empty( $args['selected'] ) ) {
					$selected = selected( $args['selected'], "", false );
				}
				$output .= '<option value=""' . $selected . '>' . esc_html( $args['show_option_none'] ) . '</option>';
			}

			foreach ( $args['options'] as $key => $option ) {
				if ( $args['multiple'] && is_array( $args['selected'] ) ) {
					$selected = selected( true, in_array( (string) $key, $args['selected'] ), false );
				} elseif ( isset( $args['selected'] ) && ! is_array( $args['selected'] ) ) {
					$selected = selected( $args['selected'], $key, false );
				}

				$output .= '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option ) . '</option>';
			}
		}

		$output .= '</select>';

        if( $args['echo'] )
            echo $output;

		return $output;
	}

	function text( $args = array() ) {
		$defaults = array(
            'echo'         => true,
			'id'           => '',
			'name'         => isset( $name )  ? $name  : 'text',
			'value'        => isset( $value ) ? $value : null,
			'label'        => isset( $label ) ? $label : null,
			'desc'         => isset( $desc )  ? $desc  : null,
			'placeholder'  => '',
			'class'        => 'form-control',
			'disabled'     => false,
			'autocomplete' => '',
			'data'         => false,
            'type'         => 'text',
            'readonly'     => false,
			'required'	   => false,
			'attributes'   => array()
		);

		$args = wp_parse_args( $args, $defaults );

        if( empty( $args['id'] ) )
            $args['id'] = $args['name'];

        if ( isset( $args['readonly'] ) && $args['readonly'] ) {
            $readonly = ' readonly="readonly"';
        } else {
            $readonly = '';
        }

		if ( isset( $args['required'] ) && $args['required'] ) {
            $required = ' required="required"';
        } else {
            $required = '';
        }

		$class = implode( ' ', array_map( 'sanitize_html_class', explode( ' ', $args['class'] ) ) );
		$disabled = '';
		if( $args['disabled'] ) {
			$disabled = ' disabled="disabled"';
		}

		$data = '';
		if ( ! empty( $args['data'] ) ) {
			foreach ( $args['data'] as $key => $value ) {
				$data .= 'data-' . $this->sanitize_key( $key ) . '="' . esc_attr( $value ) . '" ';
			}
		}

		$output = '<span id="conv-' . $this->sanitize_key( $args['name'] ) . '-wrap">';
			if ( ! empty( $args['label'] ) ) {
				$output .= '<label class="conv-label" for="' . $this->sanitize_key( $args['id'] ) . '">' . esc_html( $args['label'] ) . '</label>';
			}

			if ( ! empty( $args['desc'] ) ) {
				$output .= '<span class="conv-description">' . esc_html( $args['desc'] ) . '</span>';
			}

			$output .= '<input type="' . esc_attr( $args['type'] ) . '" name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( $args['id'] )  . '" autocomplete="' . esc_attr( $args['autocomplete'] )  . '" value="' . esc_attr( $args['value'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" class="' . $class . '" ' . $data . '' . $disabled . '' . $readonly . '' . $required;
			
			foreach( $args['attributes'] as $key => $value ){
				$output .= ' ' . $key . '="' . $value . '"';
			}

			$output .= '/>';

		$output .= '</span>';

        if( $args['echo'] )
            echo $output;

		return $output;
	}
}

function conv_html(){
    return Conv_HTML::instance();
}