<?php

/**
 * The Author template for our theme.
 *
 *
 * @package ishop
 */
get_header(); ?>

<div id="primary" class="medium-8 large-8 columns content-area">
		<main id="main" class="site-main" role="main">
<div id="content" class="narrowcolumn">

<!-- This sets the $curauth variable -->
<div class="author-bio">
    <?php 
    
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
     echo '<h2>'; _e('About:','ishop'); echo get_avatar( get_the_author_meta( 'ID' ), 96 ); 
     echo esc_attr($curauth->nickname); echo '</h2>';
    
     if($curauth->first_name){echo '('.esc_attr($curauth->first_name) .' '. esc_attr($curauth->last_name).')';}
     if($curauth->description) { echo '</p>'.esc_html($curauth->description);}
     
    if($curauth->user_email) { echo '</p><i class="fa fa-envelope-o"></i>'.esc_attr($curauth->user_email);}
    if($curauth->user_registered) { 
        $author_registered = $curauth->user_registered;
if($author_registered){
    echo '<i class="fa fa-clock-o"></i>'.date("n/j/Y", strtotime($author_registered));
}
    }
        
     if ($curauth->user_url) { echo '<i class="fa fa-external-link"></i>'.esc_url($curauth->user_url); }
        
 ?>
<!-- The Loop -->
</div>
  <h2><?php _e('Posts by','ishop'); ?> <?php echo esc_attr($curauth->nickname); ?>:</h2>
   <ul class="medium-block-grid-3 large-block-grid-3 latest-post">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>

    <?php endwhile; else: ?></ul>
        <p><?php _e('No posts by this author.','ishop'); ?></p>

    <?php endif; ?>

<!-- End Loop -->
</div>
                </main>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>