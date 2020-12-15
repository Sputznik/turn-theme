<?php
  define ( 'turn-theme-version', '1.1.0' );

  //COMPARE POSTS FORM GENERATOR
  add_shortcode( 'orbit_compare_form', function( $atts ) {

    $atts = shortcode_atts( array(
      'type' => 'posts' //default, but works for any post-type
    ), $atts, 'compare_form' );

    $post_type_obj = get_post_type_object( $atts['type'] ); //for post type labels

    //query arguments to pull data
    $q_args = array(
      'post_type' => $atts['type'],
      'post_status' => array( 'published' ),
      'nopaging' => true,
      'posts_per_page' => '50',
      'order' => 'ASC',
      'orderby' => 'name'
    );
    $the_query = new WP_Query( $q_args );

    ob_start();

    include( 'templates/orbit_compare_form.php' );

    return ob_get_clean();

  } );

  //COMPARE POST RESULT
  add_shortcode( 'orbit_compare_result', function( $atts ) {

    $atts = shortcode_atts( array(
      'tax' => 'categories', //default, but works for any taxonomy
      'cf' => null
    ), $atts, 'compare_form');

    $cf = explode( ',', $atts['cf'] ); //store custom field values from shortcode in array

		if ( !isset($_GET['submit']) ) return "<p>Make a selection and press compare</p>";

		ob_start();

		include( 'templates/orbit_compare_result.php' );

		return ob_get_clean();
	});
