<?php

/* 
 * File contain code for slider
 * @package ishop
 */
if( get_theme_mod('hide_slider')=='show'){
    echo '<ul class="" data-orbit data-orbit data-options="animation_speed:500; bullets:false; slide_number: false; pause_on_hover: false;timer_speed: 5000;">';
        $sa= get_theme_mod('ishop_slider_range','4');
     $i = 1;
        while($i < $sa)
        {
          echo '<li>';
		  if (get_theme_mod('slide_image'.$i)!=='' ){
        echo ' <img src="'. esc_url(get_theme_mod('slide_image'.$i) ). '" alt="'.esc_attr(get_theme_mod('slide_caption'.$i)).'" />';
		if (get_theme_mod('slide_caption'.$i)!==''){
		echo'<div class="orbit-caption">'.esc_html(get_theme_mod('slide_caption'.$i)).'</div>';
		  }}
        echo "</li>";
        $i++;
        } 
        echo '</ul>';
         }
 

?>