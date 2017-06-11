<?php

/* 
 *@pacage iShop
 */
?>


<?php if(get_theme_mod('featured_image') !='' || get_theme_mod('featured_textarea')!=''){ ?>
<div id="big-display" class="medium-12 large-12 columns">
    <div class="medium-4 large-4 columans">

<img src="<?php echo esc_url(get_theme_mod('featured_image')); ?>" />
    </div>

    <div class="medium-8 large-8 columns">
        <?php echo esc_html(get_theme_mod('featured_textarea')); ?>

    </div>
    
       
    
</div>
<?php }?>