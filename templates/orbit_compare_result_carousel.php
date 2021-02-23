<?php

	// GET THE SELECTED POSTS IN AN ARRAY OF POSTS
	$post_data = array();
	foreach( array( 'select-first', 'select-second', 'select-third' ) as $post_slug ){
		if( isset( $_GET[ $post_slug ] ) ){
			array_push( $post_data, get_post( $_GET[ $post_slug ] ) );
		}
	}

	$no_slides = count( $cf );
	if( isset( $atts['tax'] ) && !empty( $atts['tax' ] ) ){
		$no_slides += 1;
	}

?>
<div class="result-container">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">
			<?php $i = 0; if( isset( $atts['tax'] ) && !empty( $atts['tax' ] ) ):?>
			<div class="item <?php if( !$i ) _e( 'active' );?>">
				<h3><?php echo ucwords( $atts['tax'] );?></h3>
				<hr>
				<?php foreach ( $post_data as $key => $p ): $post_terms = get_the_terms( $p->ID, $atts['tax'] );?>
					<div class='item-inner'>
						<div class="data-title"><strong><?php echo $p->post_title; ?></strong></div>
						<div class="data-tax"><?php echo join( ", ", wp_list_pluck( $post_terms, 'name' ) );?></div>
					</div>
				<?php endforeach;?>
			</div>
			<?php $i++;endif;?>

			<?php foreach( $cf as $field ):?>
			<div class="item <?php if( !$i ) _e( 'active' );?>">
				<h3><?php echo ucwords( str_replace( "-", " ", $field ) ); $i++;?></h3>
				<hr>
				<?php foreach ( $post_data as $key => $p ) : $f_value = get_post_meta($p->ID, $field, true);?>
					<div class='item-inner'>
						<div class="data-title"><strong><?php echo $p->post_title; ?></strong></div>
						<?php if ( is_array( $f_value ) ):?>
							<div class="data-cf"><?php echo implode( ", ", $f_value );?></div>
						<?php elseif ( substr( $f_value, 0, 4 ) === "http" ):?>
							<div class="data-cf"><p><a href='<?php echo $f_value;?>' target="_blank">Link</a></p></div>
						<?php else:?>
							<div class="data-title"><?php echo $f_value;?></div>
						<?php endif;?>
					</div>
				<?php endforeach;?>
			</div>
			<?php endforeach;?>
		</div>

		<!-- Indicators -->
	  <ol class="carousel-indicators">
			<?php for( $i = 0; $i < $no_slides; $i++ ):?>
	    <li data-target="#carousel-example-generic" data-slide-to="<?php _e( $i );?>" class="<?php if( !$i ) _e('active');?>"></li>
			<?php endfor;?>
	  </ol>

	  <!-- Controls -->
	  <div class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </div>
	  <div class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </div>
	</div>

</div>

<style>
	.result-container{
		padding: 0 60px 60px;
		margin-bottom: 30px;
	}
	.result-container #carousel-example-generic{
		border: #999 solid 1px;
		background: #fcfcfc;
		padding: 20px;
		position: relative;
	}

	.result-container .item-inner{
		padding: 20px 0;
	}
	.result-container .carousel-indicators{ bottom: -50px; }
	.result-container .carousel-indicators li{ background-color: #ccc; }
	.result-container .carousel-indicators li.active{ background-color: #999; }
	.result-container .carousel-control.left, .result-container .carousel-control.right{
		background-image: none;
		width: 50px;
		height: 100px;
		top: 50%;
		transform: translateY( -50% );
	}
	.result-container .carousel-control.left{ left:-60px; }
	.result-container .carousel-control.right{ right: -60px; }
</style>
