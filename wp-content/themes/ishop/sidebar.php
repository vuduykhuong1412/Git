<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package ishop
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="medium-4 large-4 columns widget-area" role="complementary">   
    <?php
    do_action('before_sidebar');
    dynamic_sidebar( 'sidebar-1' );
    ?>
    
</div><!-- #secondary -->
