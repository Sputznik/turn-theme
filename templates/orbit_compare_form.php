<?php
  $output_list = '<option disabled selected value>Select a ' . $post_type_obj->labels->singular_name . '</option>'; //FOR POST LIST
  if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      $output_list .= '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
    }
  } else {
    $output_list .= 'No posts found';
  }//POST LIST GENERATED IN OUTPUT_LIST

?>
<!--OVERALL FORM-->
<form id="orbit-compare-form" method="get" style="display:inline-grid;grid-template-columns:1fr 1fr 1fr;grid-gap:15px;width:100%;">

  <!--first dropdown-->
  <div class="dropdown-compare-form select-first">
    <label for="first" class="compare-select-label">Select First <?php echo $post_type_obj->labels->singular_name ?></label>
    <select class="form-control" name="select-first" id="first" required="required"><?php echo $output_list ?></select>
  </div>

  <!--second dropdown-->
  <div class="dropdown-compare-form select-second">
    <label for="select-second" class="compare-select-label">Select Second <?php echo $post_type_obj->labels->singular_name ?></label>
    <select class="form-control" name="select-second" id="select-second" required="required"><?php echo $output_list ?></select>
  </div>

  <!--third dropdown-->
  <div class="dropdown-compare-form select-third">
    <label for="select-third" class="compare-select-label">Select third <?php echo $post_type_obj->labels->singular_name ?></label>
    <select class="form-control" name="select-third" id="select-third"><?php echo $output_list ?></select>
  </div>

  <!--compare button-->
  <input class="compare-form-btn" type="submit" value="Compare" name="submit" class="orbit_compare_btn"><input class="compare-form-reset" type="reset">

</form>
