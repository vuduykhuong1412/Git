<?php

/**
 * The front page template for our theme.
 *
 *
 * @package ishop
 */

if(get_option('show_on_front')== 'page') {
   get_template_part('page');
    
} 
 elseif(get_option('show_on_front') == 'Posts') {
     get_template_part('index');
 } 
 else {
      get_template_part('template-parts/featured-home');
     
     
}
