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
    $output_form .= '<select class="form-control" name="select-third" id="select-third" required="required">' . $output_list . '</select></div>';
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

    $cf = explode(',', $atts['cf']); //store custom field values from shortcode in array
    $result = ''; //store output here

    if ( isset($_GET['submit']) ) {

      $result .= '<h3>Comparison table:</h3><div class="result-table" style="display:inline-grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:10px 5px;">';

      $post_data = array(get_post($_GET['?select-first']), get_post($_GET['select-second']), get_post($_GET['select-third'])); //ISSUE: first parameter name contains the ? character

      //FIRST ROW - TITLES
      $result .= '<div><h6>Name</h6></div>';
      foreach ($post_data as $key => $p) {
        $result .= '<div class="data-title"><h4>' . $p->post_title . '</h4></div>';
      }
      //SECOND ROW - TAXONOMY
      $result .= '<div>' . ucwords($atts['tax']) . '</div>';
      foreach ($post_data as $key => $p) {
        $post_terms = get_the_terms( $p->ID, $atts['tax'] );
        $result .= '<div class="data-tax">' . join(", ", wp_list_pluck($post_terms, 'name')) . '</div>';
      }
      //CUSTOM FIELD ROWS
      foreach ($cf as $key => $field) {
        $result .= '<div>' . ucwords(str_replace("-", " ", $field)) . '</div>';
        foreach ($post_data as $key => $p) {
          $f_value = get_post_meta($p->ID, $field, true);
          if ( is_array($f_value) )
            $result .= '<div class="data-cf">' . implode(", ", $f_value) . '</div>';
          elseif ( substr( $f_value,0,4) === "http" )
            $result .= '<p class="data-cf"><a href=' . $f_value . ' target="_blank">Link</p>';
          else
            $result .= '<div class="data-title">' . $f_value . '</div>';
        }
      }

      $result .= '</div>';
      return $result;
    }
    else return "<p>Make a selection and press compare</p>";

  });

?>
