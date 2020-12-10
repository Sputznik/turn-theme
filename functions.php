<?php
  define ( 'turn-theme-version', '1.0.0' );

  //COMPARE POSTS FORM GENERATOR
  add_shortcode( 'orbit_compare_form', function( $atts ) {

    $atts = shortcode_atts( array(
      'type' => 'posts' //default, but works for any post-type
    ), $atts, 'compare_form');

    $post_type_obj = get_post_type_object( $atts['type'] ); //for post type labels

    $output_list = '<option disabled selected value>Select a ' . $post_type_obj->labels->singular_name . '</option>'; //FOR POST LIST

    //query arguments to pull data
    $q_args = array(
      'post_type' => $atts['type'],
      'post_status' => array( 'published' ),
      'nopaging' => true,
      'posts_per_page' => '50',
      'order' => 'ASC',
      'orderby' => 'name'
    );
    $the_query = new WP_Query($q_args);

    if ( $the_query->have_posts() ) {
      while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $output_list .= '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
      }
    } else {
      $output_list .= 'No posts found';
    }//POST LIST GENERATED IN OUTPUT_LIST

    $output_form = '<form id="orbit-compare-form" method="get" style="display:inline-grid;grid-template-columns:1fr 1fr 1fr;grid-gap:15px;width:100%;">'; //OVERALL FORM
    //first dropdown
    $output_form .= '<div class="dropdown-compare-form select-first"><label for="first" class="compare-select-label">Select First ' . $post_type_obj->labels->singular_name . '</label>';
    $output_form .= '<select class="form-control" name="select-first" id="first" required="required">' . $output_list . '</select></div>';
    //second dropdown
    $output_form .= '<div class="dropdown-compare-form select-second"><label for="select-second" class="compare-select-label">Select Second ' . $post_type_obj->labels->singular_name . '</label>';
    $output_form .= '<select class="form-control" name="select-second" id="select-second" required="required">' . $output_list . '</select></div>';
    //third dropdown
    $output_form .= '<div class="dropdown-compare-form select-third"><label for="select-third" class="compare-select-label">Select third ' . $post_type_obj->labels->singular_name . '</label>';
    $output_form .= '<select class="form-control" name="select-third" id="select-third">' . $output_list . '</select></div>';
    //compare button
    $output_form .= '<input class="compare-form-btn" type="submit" value="Compare" name="submit" class="orbit_compare_btn"><input class="compare-form-reset" type="reset"></form>';

    return $output_form;
  } );

  //COMPARE POST RESULT
  add_shortcode( 'orbit_compare_result', function( $atts ) {

    $atts = shortcode_atts( array(
      'tax' => 'categories', //default, but works for any taxonomy
      'cf' => null
    ), $atts, 'compare_form');

    //var_dump($_GET);

    $cf = explode(',', $atts['cf']); //store custom field values from shortcode in array

		if ( !isset($_GET['submit']) ) return "<p>Make a selection and press compare</p>";

		ob_start();

		include( 'templates/orbit_compare_result.php' );

		return ob_get_clean();
	});
