<?php

	//$post_data = array( get_post( $_GET['select-first'] ), get_post( $_GET['select-second'] ), get_post( $_GET['select-third'] ) );

	// GET THE SELECTED POSTS IN AN ARRAY OF POSTS
	$post_data = array();
	foreach( array( 'select-first', 'select-second', 'select-third' ) as $post_slug ){
		if( isset( $_GET[ $post_slug ] ) ){
			array_push( $post_data, get_post( $_GET[ $post_slug ] ) );
		}
	}

	//echo count( $post_data );

	// DETERMINE THE COLUMN OF THE GRID BY THE NUMBER OF POSTS SELECTED
	$grid_template_cols = "1fr 1fr 1fr";
	if( count( $post_data ) > 2 ){
		$grid_template_cols = "1fr 1fr 1fr 1fr";
	}

?>
<div class="result-container">
	<h3>Comparison table:</h3>
	<div class="result-table" style="display:inline-grid;grid-template-columns:<?php echo $grid_template_cols; ?>;gap:20px 10px;">
		<!-- FIRST ROW - TITLES -->
		<div class="first-col"><h6>Name</h6></div>
		<?php foreach ( $post_data as $key => $p ):?>
			<div class="data-title"><h4><?php echo $p->post_title; ?></h4></div>
		<?php endforeach;?>

		<!-- SECOND ROW - TAXONOMY -->
		<div class="first-col"><?php echo ucwords( $atts['tax'] );?></div>
		<?php foreach ( $post_data as $key => $p ): $post_terms = get_the_terms( $p->ID, $atts['tax'] );?>
			<div class="data-tax"><?php echo join( ", ", wp_list_pluck( $post_terms, 'name' ) );?></div>
		<?php endforeach;?>

		<!-- CUSTOM FIELD ROWS -->
		<?php foreach ( $cf as $key => $field ):?>
			<div class="first-col"><?php echo ucwords( str_replace( "-", " ", $field ) );?></div>
			<?php foreach ( $post_data as $key => $p ) : $f_value = get_post_meta($p->ID, $field, true);?>
				<?php if ( is_array($f_value) ):?>
					<div class="data-cf"><?php echo implode( ", ", $f_value );?></div>
				<?php elseif ( substr( $f_value, 0, 4 ) === "http" ):?>
					<div class="data-cf"><p><a href='<?php echo $f_value;?>' target="_blank">Link</a></p></div>
				<?php else:?>
					<div class="data-title"><?php echo $f_value;?></div>
				<?php endif;?>
			<?php endforeach;?>
		<?php endforeach;?>
	</div> <!-- result-table -->
</div> <!-- result-container -->
