<?php
/**
 * Add meta box
 *
 */
function ishoppage_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Page Layout Select [Pro Only]', 'ishop' ), 'ishoppage_build_meta_box', 'page', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'ishoppage_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function ishoppage_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'ishoppagemeta_meta_box_nonce' );
	// retrieve the _food_ishoppagemeta current value
	$current_ishoppagemeta = get_post_meta( $post->ID, '_food_ishoppagemeta', true );

	?>
	<div class='inside'>

		<h4><?php _e( 'Current page layout - for website layout please choose from theme options', 'ishop' ); ?></h4>
		<p>
			<input type="radio" name="ishoppagemeta" value="rsd" <?php checked( $current_ishoppagemeta, 'rsd' ); ?> /> <?php _e('Right Sidebar - Default','ishop'); ?><br />
			<input type="radio" name="ishoppagemeta" value="ls" <?php checked( $current_ishoppagemeta, 'ls' ); ?> /> <?php _e('Left Sidebar','ishop'); ?><br/>			
			<input type="radio" name="ishoppagemeta" value="fc" <?php checked( $current_ishoppagemeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar','ishop'); ?>
		</p>

		

	</div>
	<?php
}
/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
function ishoppage_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['ishoppagemeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ishoppagemeta_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// store custom fields values
	// ishoppagemeta string
	if ( isset( $_REQUEST['ishoppagemeta'] ) ) {
		update_post_meta( $post_id, '_food_ishoppagemeta', sanitize_text_field( $_POST['ishoppagemeta'] ) );
	}

}
add_action( 'save_post', 'ishoppage_save_meta_box_data' );