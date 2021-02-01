<?php
  define ( 'turn-theme-version', '1.1.0' );

  class ORBIT_COMPARE{

		function __construct(){
			add_shortcode( 'orbit_compare_form', array( $this , 'form' ) );

			add_shortcode( 'orbit_compare_result', array( $this, 'result' ) );
		}

		function result( $atts ){

			if ( !isset( $_GET['submit'] ) ) return "<p>Make a selection and press compare</p>";

			$atts = shortcode_atts( array(
	      'tax' 		=> 'categories', //default, but works for any taxonomy
	      'cf' 			=> null,
				'style'		=> 'table'
	    ), $atts, 'orbit_compare_result' );

	    $cf = explode( ',', $atts['cf'] ); //store custom field values from shortcode in array

			ob_start();
			$tmp_file = 'orbit_compare_result_' . $atts[ 'style' ] . '.php';
			include( 'templates/' . $tmp_file );
			return ob_get_clean();
		}

		function form( $atts ){
			$atts = shortcode_atts( array(
	      'type' => 'post' //default, but works for any post-type
	    ), $atts, 'orbit_compare_form' );

	    ob_start();
			include( 'templates/orbit_compare_form.php' );
			return ob_get_clean();
		}

		function dropdownHtml( $select_name, $label, $options_list, $required ){
			ob_start();
			include( 'templates/orbit_dropdown_posts.php' );
			return ob_get_clean();
		}

	}
	new ORBIT_COMPARE;
