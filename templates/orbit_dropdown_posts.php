<div class="dropdown-compare-form <?php _e( $select_name );?>">
	<label for="first" class="compare-select-label"><?php _e( $label );?></label>
	<select class="form-control" name="<?php _e( $select_name );?>" id="<?php _e( $select_name );?>" <?php if( $required ) _e('required="required"');?>>
		<?php $selected_val = isset( $_GET[ $select_name ] ) ? $_GET[ $select_name ] : '0';?>
		<?php foreach( $options_list as $option ): $select_flag = false; if( $selected_val == $option['value'] ) $select_flag = true;?>
		<option <?php if( isset( $option['disabled'] ) && $option['disabled'] ) _e("disabled");?> <?php if( $select_flag ) _e("selected");?> value="<?php _e( $option['value'] );?>"><?php _e( $option['label'] );?></option>
		<?php endforeach;?>
	</select>
</div>
