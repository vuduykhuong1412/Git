<?php
/**
 * Add meta box
 *
 */
function ishopsingle_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Post Layout Select [Pro Only]', 'ishop' ), 'ishopsingle_build_meta_box', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'ishopsingle_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function ishopsingle_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'ishopsinglemeta_meta_box_nonce' );
	// retrieve the _food_ishopsinglemeta current value
	$current_ishopsinglemeta = get_post_meta( $post->ID, '_food_ishopsinglemeta', true );
	
	
	
	
	?>
	<div class='inside'>

		<h4><?php _e( 'Layout Select for current post only - for website layout please choose from theme options', 'ishop' ); ?></h4>
		<p>
			<input type="radio" name="ishopsinglemeta" value="rsd" <?php checked( $current_ishopsinglemeta, 'rsd' ); ?> /> <?php _e('Right Sidebar - Default','ishop'); ?><br />
			<input type="radio" name="ishopsinglemeta" value="ls" <?php checked( $current_ishopsinglemeta, 'ls' ); ?> /> <?php _e('Left Sidebar','ishop'); ?><br/>
			<input type="radio" name="ishopsinglemeta" value="fc" <?php checked( $current_ishopsinglemeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar','ishop'); ?>
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
function food_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['ishopsinglemeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['ishopsinglemeta_meta_box_nonce'], basename( __FILE__ ) ) ){
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
	// ishopsinglemeta string
	if ( isset( $_REQUEST['ishopsinglemeta'] ) ) {
		update_post_meta( $post_id, '_food_ishopsinglemeta', sanitize_text_field( $_POST['ishopsinglemeta'] ) );
	}

}
add_action( 'save_post', 'food_save_meta_box_data' );