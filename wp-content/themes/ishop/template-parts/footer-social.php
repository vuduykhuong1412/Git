<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    echo '<ul class="social">';

    /* facebook */
    if( get_theme_mod('ishop_facebook') ):
            echo '<a target="_blank" alt="Facebook" class="hvr-float-shadow" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_facebook','ishop')).'"><i class="fa fa-facebook"></i></a>';
    endif;
    /* twitter */
    if(get_theme_mod('ishop_twitter') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_twitter','ishop')).'"><i class="fa fa-twitter"></i></a>';
    endif;
    /* googleplus */
    if(get_theme_mod('ishop_googleplus') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_googleplus','ishop')).'"><i class="fa fa-google-plus"></i></a>';
    endif;
    /* linkedin */
    if( get_theme_mod('ishop_linkedin') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_linkedin','ishop')).'"><i class="fa fa-linkedin"></i></a>';
    endif;
    /* dribbble */
    if(get_theme_mod('ishop_dribbble') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_dribbble','ishop')).'"><i class="fa fa-dribbble"></i></a>';
    endif;
    /* vimeo */
    if( get_theme_mod('ishop_vimeo')):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_vimeo','ishop')).'"><i class="fa fa-vimeo-square"></i></a>';
    endif;
    /* rss */
    if( get_theme_mod('ishop_rss') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_rss','ishop')).'"><i class="fa fa-rss"></i></a>';
    endif;
    /* instagram */
    if( get_theme_mod('ishop_instagram') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_instagram','ishop')).'"><i class="fa fa-instagram"></i></a>';
    endif;
    /* pinterest */
    if( get_theme_mod('ishop_pinterest') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_pinterest','ishop')).'"><i class="fa fa-pinterest"></i></a>';
    endif;
    /* youtube */
    if( get_theme_mod('ishop_youtube')):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_youtube','ishop')).'"><i class="fa fa-youtube"></i></a>';
    endif;
    /* skype */
    if( get_theme_mod('ishop_skype') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_skype','ishop')).'"><i class="fa fa-skype"></i></a>';
    endif;
    /* flickr */
    if( get_theme_mod('ishop_flickr') ):
            echo '<a target="_blank" class="hvr-float-shadow" href="'.esc_url(get_theme_mod('ishop_flickr','ishop')).'"><i class="fa fa-flickr"></i></a>';
    endif;
    
    echo '</ul>';
