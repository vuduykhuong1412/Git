<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function ishop_notice() {
	if ( isset( $_GET['activated'] ) ) {
		$return = '<div class="updated activation"><p><strong>';
					$my_theme = wp_get_theme();
		if ( isset( $_GET['previewed'] ) ) {
			$return .= sprintf( __( 'Settings saved and %s activated successfully.', 'ishop' ), $my_theme->get( 'Name' ) );
		} else {
			$return .= sprintf( __( '%s activated successfully.', 'ishop' ), $my_theme->get( 'Name' ) );
		}
		$return .= '</strong> <a href="' . esc_url(home_url('/')) . '">' . __( 'Visit site', 'ishop' ) . '</a></p>';
		$return .= '<p>';
		$return .= ' <a class="button button-primary theme-options" href="' . admin_url( 'customize.php' ) . '">' . __( 'Theme Options', 'ishop' ) . '</a>';
		$return .= ' <a class="button button-primary help" href="http://www.insertcart.com/contact-us">' . __( 'Need Help?', 'ishop' ) . '</a>';
		$return .= '</p></div>';
		echo $return;
	}
}
add_action( 'admin_notices', 'ishop_notice' );

/*
 * Hide core theme activation message.
 */
function ishop_admincss() { ?>
	<style>
	.themes-php #message2 {
		display: none;
	}
	.themes-php div.activation a {
		text-decoration: none;
	}
	</style>
<?php }
add_action( 'admin_head', 'ishop_admincss' );
