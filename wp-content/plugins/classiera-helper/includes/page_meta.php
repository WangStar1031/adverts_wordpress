<?php
add_action( 'add_meta_boxes', 'classiera_meta_box_add' );
function classiera_meta_box_add(){
	add_meta_box( 'page_metabox', __( 'Page Meta', 'classiera' ), 'classiera_page_metabox', 'page', 'normal', 'high' );
}
function classiera_page_metabox( $post ){
	
	$values = get_post_custom( $post->ID );
	$layerslider_shortcode = isset( $values['layerslider_shortcode'] ) ? esc_attr( $values['layerslider_shortcode'][0] ) : '';
	$selected = isset( $values['page_slider'] ) ? esc_attr( $values['page_slider'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
		<div id="pageSliderOption" style="display: none;">
			<span style="font-size: 16px; font-family: 'Armata','Helvetica Neue',Arial,Helvetica,Geneva,sans-serif; font-weight: lighter;"><?php esc_html_e( 'Page Sliders', 'classiera' ); ?></span><br/>			
			<div style="margin-top: 20px; margin-bottom: 20px; float: left; width: 100%; border-top: solid 1px #d7d7d7;">
			</div>
			<div style="float: left; margin-bottom: 40px; width: 100%;">
				<label style="float: left; width: 160px;" for="page_slider">
					<strong><?php esc_html_e( 'Page slider', 'classiera' ); ?></strong>
				</label>
				<div style="margin-left: 30px; float: left;">
					<select name="page_slider" id="page_slider" style="width: 260px;">
						<option value="none" <?php selected( $selected, 'none' ); ?>>
							<?php esc_html_e( 'none', 'classiera' ); ?>
						</option>
						<option value="LayerSlider" <?php selected( $selected, 'LayerSlider' ); ?>>
							<?php esc_html_e( 'LayerSlider', 'classiera' ); ?>
						</option>
					</select>
					<span style="font-style: italic; float: left; margin-top: 5px;">
						<?php esc_html_e( 'Select page slider.', 'classiera' ); ?>
					</span>
				</div>
			</div>			
			<div id="layerslidershortcode" style="display: none; float: left; margin-bottom: 40px; width: 100%;">			
				<label style="float: left; width: 160px;" for="layerslider_shortcode">
					<strong><?php esc_html_e( 'LayeSlider Shortcode', 'classiera' ); ?></strong>
				</label>
				<div style="margin-left: 30px; float: left;">
					<input style="width: 260px;" type="text" name="layerslider_shortcode" id="layerslider_shortcode" value="<?php echo esc_attr($layerslider_shortcode); ?>" />
					<span style="font-style: italic; float: left; margin-top: 5px;">
						<?php esc_html_e( 'Enter layerslider shortcode (leave empty for):', 'classiera' ); ?> "[layerslider id="1"]".
					</span>
				</div>
			</div>
		</div>
		<script>
		jQuery(document).ready(function(){ 

			var val = jQuery("#page_template").val();
			if( val === "template-homepage-listing.php" || val === "template-homepage-v1.php"   || val === "template-homepage-v2.php" || val === "template-homepage-v3.php" || val === "template-homepage-v4.php" || val === "template-homepage-v5.php" || val === "template-homepage-v6.php" || val === "template-homepage-v7.php" || val === "template-landing.php") {
			    jQuery("#pageSliderOption").css({"display":"block"});
			} else {
			    jQuery("#pageSliderOption").css({"display":"none"});
			}

			jQuery("#page_template").change(function() {
			    var val = jQuery(this).val();
			   if( val === "template-homepage-listing.php" || val === "template-homepage-v1.php"   || val === "template-homepage-v2.php" || val === "template-homepage-v3.php" || val === "template-homepage-v4.php" || val === "template-homepage-v5.php" || val === "template-homepage-v6.php" || val === "template-homepage-v7.php" || val === "template-landing.php") {
			        jQuery("#pageSliderOption").css({"display":"block"});
			    } else {
			        jQuery("#pageSliderOption").css({"display":"none"});
			    }
			});


			var val2 = jQuery("#page_slider").val();
			if( val2 === "LayerSlider" ) {
			    jQuery("#layerslidershortcode").css({"display":"block"});
			} else {
			    jQuery("#layerslidershortcode").css({"display":"none"});
			}
			
			jQuery("#page_slider").change(function() {
			    var val2 = jQuery(this).val();
			    if( val2 === "LayerSlider" ) {
			        jQuery("#layerslidershortcode").css({"display":"block"});
			    } else {
			        jQuery("#layerslidershortcode").css({"display":"none"});
			    }
			});

		});
		</script>
		
		<span style="visibility: hidden;"><p><?php esc_html_e( 'Page meta end', 'classiera' ); ?></p></span>
	
	</div>
	
	<?php	
}


add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id ){
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if ( !current_user_can( 'edit_post', $post_id )) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['layerslider_shortcode'])){
		update_post_meta($post_id, 'layerslider_shortcode', wp_kses( $_POST['layerslider_shortcode'], $allowed));
	}
	if( isset( $_POST['page_slider'])){
		update_post_meta($post_id, 'page_slider', esc_attr($_POST['page_slider']));
	}		
}
?>
