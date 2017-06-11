<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package ishop
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ishop' ); ?></a>
  <?php get_template_part('template-parts/topmenu'); ?>
	<header id="masthead" class="site-header" role="banner">

    <div class="header-area">
        
	 <div class="large-6 columns">
             <?php
		$ishop_logo = get_theme_mod('ishop_logo');
			if(isset($ishop_logo) && $ishop_logo != ""):
				echo '<a href="'.esc_url( home_url( '/' ) ).'" class="site-branding">';
					echo '<img src="'.esc_url($ishop_logo).'" alt="'.get_bloginfo('title').'">';
				echo '</a>';
			else: ?>
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->
                <?php endif; ?>
                 </div> 
            <div class="large-6 columns asidelogo">
                 <?php if (!dynamic_sidebar('topright') ) : endif; ?>              

            </div>
    </div>
		</header><!-- #masthead -->
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ishop' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->    

	
	<div id="content" class="site-content">
		<div class="large-12 columns belownavi">
			<?php
				if (!dynamic_sidebar('belownavi') ) : endif;
				get_template_part('template-parts/slider');
				if (get_theme_mod('hide_news_ticker')==''){
				echo ishop_ticker(); }
			?>
	</div>