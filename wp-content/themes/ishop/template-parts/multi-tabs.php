<?php

/**
 * The multi-tab containing the front page area.
 *
 * @package ishop
 */
?>

<div class="large-12 column">
<?php do_action('front_page_column1'); ?>
    
<?php if (get_theme_mod("hide_blog_post")==''){ ?>
 <span class="label alert front-label"><?php echo esc_attr(get_theme_mod('blog_front_name','Blog') ); ?></span><div style="clear:both;"></div>
<ul class="large-block-grid-4 latest-post">

  <?php
     $ishop_args = array( 
    'ignore_sticky_posts' => true,
    'showposts' => 8,
    'orderby' => 'date',  );
    $the_query = new WP_Query( $ishop_args );
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();

     echo '<li>';
	 if (get_theme_mod('hide_comenticon')=='show' ) {	echo '<div class="comment"><p>'; printf( _nx( '1', '%1$s', get_comments_number(), 'comments title', 'ishop' ), number_format_i18n( get_comments_number() ) ); echo '<p></div>'; }
    if ( has_post_thumbnail() ) {
    echo '<a href="';
     the_permalink();
     echo '">';
    the_post_thumbnail('postthumbnail');
    echo '</a>';
    }
    else {
  
    echo'<a href="';
    the_permalink();
    echo '"><img src="';
    echo esc_url(get_template_directory_uri() ); 
    echo '/images/thumb.jpg" class="blog-post-img"></a>';
    }
    echo '<h2><a title="';
    the_title();
    echo'" href="';
    the_permalink();
    echo '" rel="bookmark">';
     the_title();
    echo '</a></h2><br />';
   if( get_theme_mod('hide_blog_postdec')==''){  the_excerpt();} 
    echo '<div class="clear"></div></li>';
    endwhile; endif; wp_reset_postdata(); 
 
  
  ?>  
</ul>
<?php }?>
</div>