<?php

	$post_type_obj = get_post_type_object( $atts['type'] ); //for post type labels
	$post_type_label = $post_type_obj->labels->singular_name;

	//query arguments to pull data $options_list
	$options_list = array(
		array( 'value' => 0, 'label' => 'Select a ' . $post_type_label, 'disabled' => true  )
	);

	$q_args = array(
		'post_type' 			=> $atts['type'],
		'post_status' 		=> array( 'published' ),
		'nopaging' 				=> true,
		'posts_per_page' 	=> '50',
		'order' 					=> 'ASC',
		'orderby' 				=> 'name'
	);
	$the_query = new WP_Query( $q_args );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			array_push( $options_list, array( 'value' => get_the_ID(), 'label' => get_the_title() ) );
		}
	}
?>
<!--OVERALL FORM-->
<form id="orbit-compare-form" method="get" style="display:inline-grid;grid-template-columns:1fr 1fr 1fr;grid-gap:15px;width:100%;">
	<?php
		$dropdown_list = array(
			array(
				'name' 			=> 'select-first',
				'label'			=> 'Select First ' . $post_type_label,
				'required' 	=> true
			),
			array(
				'name' 			=> 'select-second',
				'label'			=> 'Select Second ' . $post_type_label,
				'required' 	=> true
			),
			array(
				'name' 			=> 'select-third',
				'label'			=> 'Select Third ' . $post_type_label,
				'required' 	=> false
			)
		);

		foreach( $dropdown_list as $dropdown ){
			echo $this->dropdownHtml( $dropdown['name'], $dropdown['label'], $options_list, $dropdown['required'] );
		}
	?>
	<!--compare button-->
  <input class="compare-form-btn" type="submit" value="Compare" name="submit" class="orbit_compare_btn"><input class="compare-form-reset" type="reset">
</form>
