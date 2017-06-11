<?php
/**
 * @package ishop
 */
?>
<li>	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if (get_theme_mod('hide_comenticon')=='show' ) {	echo '<div class="comment"><p>'; printf( _nx( '1', '%1$s', get_comments_number(), 'comments title', 'ishop' ), number_format_i18n( get_comments_number() ) ); echo '<p></div>'; } ?>
	<div class="entry-content">
<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	<?php the_post_thumbnail('postthumbnail'); ?>
	</a>
<?php endif; ?>
<div class="entry-meta">
			<?php ishop_posted_on(); ?>
		</div><!-- .entry-meta -->
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>		
		<?php endif; ?>
	</header><!-- .entry-header -->

		<?php if( get_theme_mod('hide_blog_postdec')==''){  the_excerpt();} ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ishop' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
</li>