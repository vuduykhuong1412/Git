<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ishop
 */
?>

	</div><!-- #content -->
<?php get_template_part('template-parts/footer-widget'); ?>

	<footer id="colophon" class="large-12 columns" role="contentinfo">
            <div class="site-footer">
		<div class="large-6 columns site-info">
                    <?php do_action( 'ishop_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'ishop' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'ishop' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php _e( 'Theme :', 'ishop' ); ?><a href="<?php echo esc_url( __( 'http://www.insertcart.com/product/ishop-wordpress-theme/', 'ishop' ) ); ?>"><?php printf( __( 'iShop', 'ishop' ), 'WordPress' ); ?></a>
		
		</div><!-- .site-info -->
                <div class="large-6 columns footer-social">
			<?php get_template_part('template-parts/footer-social'); ?>
                </div><!-- .site-info -->
            </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
