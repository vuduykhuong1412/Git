<nav class="topnavi top-bar" data-topbar>
<div class="widthnav"> 
      <li class="toggle-topbar left menu-icon">
                    <a href="#"></a>
                </li> 
            <section class="top-bar-section">                 
                <?php wp_nav_menu( array(
                        'menu' => 'topmenu',
                        'menu_class' => 'top-bar-menu left',
                        'container' => '',
						'theme_location' => 'topmenu',
                        'depth' => '0',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'fallback_cb' => 'wp_page_menu',
                        'walker' => new ishop_Walker_Nav_Menu()
                    ) ); ?>                 
                <!-- Left Nav Section -->                 
            </section>  			
    <ul class="title-area right"> 
         <?php if (class_exists('woocommerce')) {ishop_wooaccinfo(); } ?>
            </ul>
</div>
</nav>

