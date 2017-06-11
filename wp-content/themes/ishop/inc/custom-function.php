<?php
/***********************************************
* Custom Function Related to Theme
*
* http://www.insertcart.com/product/ishop-wordpress-theme/
***********************************************/

/***********************************************
* Woocommerce theme support 
***********************************************/
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );

/* ----------------------------------------------------------------------------------- */
/* Breadcrumbs Support
  /*----------------------------------------------------------------------------------- */

function ishop_breadcrumbs() {
    $delimiter = '';
	$brdparentschema = '<span rel="v:child" typeof="v:Breadcrumb">';
    $home = __('Home', 'ishop'); // text for the 'Home' link
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb
    echo '<ul xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Breadcrumb" class="breadcrumbs">';
    global $post;
    $homeLink = esc_url(home_url('/'));
    echo '<li><a href="' . $homeLink . '" rel="v:url" property="v:title">' . $home . '</a></li> ' . $delimiter . ' ';

    if (is_category()) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
        if ($thisCat->parent != 0)
            echo (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
        echo $before . __('Archive by category "','ishop') . single_cat_title('', false) . '"' . $after;
    } elseif (is_day()) {
        echo '<li><a rel="v:child" typeof="v:Breadcrumb"  href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo '<li><a rel="v:child" typeof="v:Breadcrumb" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('d') . $after;
    } elseif (is_month()) {
        echo '<li><a rel="v:child" typeof="v:Breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('F') . $after;
    } elseif (is_year()) {
        echo $before . get_the_time('Y') . $after;
    } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<li><a rel="v:child" typeof="v:Breadcrumb" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
            echo  $before . esc_html(get_the_title()) . $after;
        } else {
            $cat = get_the_category();
            $cat = $cat[0];
            echo $brdparentschema . get_category_parents($cat, TRUE, ' ' . $delimiter . ' ') . $after;
            echo $before . esc_html(get_the_title()) . $after;
        }
    } elseif (is_attachment()) {
        $parent = get_post($post->post_parent);
        //$cat = get_the_category($parent->ID); $cat = $cat[0];
        //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo '<li><a rel="v:child" typeof="v:Breadcrumb" href="' . esc_url(get_permalink($parent)) . '">' . esc_attr($parent->post_title). '</a></li> ' . $delimiter . ' ';
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_page() && !$post->post_parent) {
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_page() && $post->post_parent) {
        $parent_id = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<li><a rel="v:child" typeof="v:Breadcrumb" href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a></li>';
            $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb)
            echo $crumb . ' ' . $delimiter . ' ';
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_search()) {
        echo $before . __('Search results for "','ishop') . get_search_query() . '"' . $after;
    } elseif (is_tag()) {
        echo $before . __('Posts tagged "','ishop') . single_tag_title('', false) . '"' . $after;
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo $before . __('Articles posted by ','ishop') . esc_attr($userdata->display_name) . $after;
    } elseif (is_404()) {
        echo $before . __('Error 404','ishop') . $after;
    }

    if (get_query_var('paged')) {
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
            echo ' (';
        echo __('Page','ishop') . ' ' . get_query_var('paged','ishop');
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
            echo ')';
    }

    echo '</ul>';
}


/* ----------------------------------------------------------------------------------- */
/* Pagination
  /*----------------------------------------------------------------------------------- */

if ( ! function_exists( 'ishop_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function ishop_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 2,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&laquo; Previous', 'ishop' ),
		'next_text' => __( 'Next &raquo;', 'ishop' ),
                'type'     => 'list',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'ishop' ); ?></h1>
		<ul class="pagination loop-pagination">
			<?php echo $links; ?>
		</ul><!-- .pagination -->
	</nav><!-- .navigation -->
	<style>div#infinite-handle{display:none;} </style>
	<?php
	endif;
}
endif;

/* ----------------------------------------------------------------------------------- */
/* Customize Comment Form
  /*----------------------------------------------------------------------------------- */
add_filter( 'comment_form_default_fields', 'ishop_comment_form_fields' );
function ishop_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    
    $fields   =  array(
        'author' => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-2 columns">' . '<span class="prefix"><i class="fa fa-user"></i>' . ( $req ? ' <span class="required">*</span>' : '' ) . '</span> </div>' .
                    '<div class="small-10 columns"><input class="form-control" placeholder="' . __( 'Your Name','ishop' ) .'" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'email'  => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-2 columns">' . '<span class="prefix"><i class="fa fa-envelope-o"></i>' . ( $req ? ' <span class="required">*</span>' : '' ) . '</span></div> ' .
                    '<div class="small-10 columns"><input class="form-control" placeholder="' . __( 'Your Email','ishop' ) .'" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'url'    => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-2 columns">' . '<span class="prefix"><i class="fa fa-external-link"></i></span> </div>' .
                    '<div class="small-10 columns"><input class="form-control" placeholder="' . __( 'Website','ishop' ) .'" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div></div>'        
    );
    
    return $fields;
    
    
}

add_filter( 'comment_form_defaults', 'ishop_comment_form' );
function ishop_comment_form( $argsbutton ) {
        $argsbutton['class_submit'] = 'button expand'; 
    
    return $argsbutton;
}


/* ----------------------------------------------------------------------------------- */
/* Custom Search Form
  /*----------------------------------------------------------------------------------- */
function ishop_search_form( $form ) {
	$form = '<form role="search" placeholder="'. esc_attr__( 'Search','ishop' ) .'" method="get" id="searchform" class="searchform" action="' . esc_url(home_url( '/' )) . '" >
            <div class="row">
            <div class="searchbox large-12 columns">
            <div class="row collapse">
            <div class="small-10 columns">
             <input type="text" placeholder="'.__('Search','ishop').'" value="' . get_search_query() . '" name="s" id="s" />
            </div>
            <div class="small-2 columns">
           <input type="submit" class="button postfix" value="'. esc_attr__( 'Go','ishop' ) .'" />
            </div>
            </div>
            </div>
            </div>  
        </form>';

	return $form;
}

add_filter( 'get_search_form', 'ishop_search_form' );



///////////////////Menu
/**
 * Primary Menu
 */
function ishop_display_primary_menu() {
	wp_nav_menu( array(
		'theme_location' => 'topmenu',
		'menu' => 'Top Menu',
		'container' => false, // remove nav container
		'container_class' => '', // class of container
		'menu_class' => 'top-bar-menu right', // adding custom nav class
		'before' => '', // before each link <a>
		'after' => '', // after each link </a>
		'link_before' => '', // before each link text
		'link_after' => '', // after each link text
		'depth' => 5, // limit the depth of the nav
		'fallback_cb' => false, // fallback function (see below)
		'walker' => new top_bar_walker()
	) );
}


/**
 * Customized menu output
 */
class top_bar_walker extends Walker_Nav_Menu {

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		$element->has_children = !empty( $children_elements[$element->ID] );
		$element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
		$element->classes[] = ( $element->has_children ) ? 'has-dropdown not-click' : '';

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $object, $depth, $args );

		

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;
		if ( in_array('label', $classes) ) {
			
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
		}

		if ( in_array('divider', $classes) ) {
			$item_html = preg_replace( '/<a[^>]*>( .* )<\/a>/iU', '', $item_html );
		}

		$output .= $item_html;
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"sub-menu dropdown\">\n";
	}

}

/* ----------------------------------------------------------------------------------- */
/* Woocommerce account infobar
  /*----------------------------------------------------------------------------------- */


function ishop_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php _e( 'View your shopping cart' ,'ishop'); ?>"><?php echo sprintf (_n( '%d item', '%d items','ishop'), WC()->cart->cart_contents_count, WC()->cart->cart_contents_count ); ?> - <?php echo wp_kses_post(WC()->cart->get_cart_total()); ?></a> 
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'ishop_woocommerce_header_add_to_cart_fragment' );

function ishop_wooaccinfo(){
        if ( is_user_logged_in() ) {

	echo '<li>';
	$myaccountbutton = esc_attr(get_theme_mod('ishop_myaccount_button','My Account'));
	echo '<a class="myacc" href="';
	echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ));
	echo '" title="'.$myaccountbutton.'">'.$myaccountbutton.'</a></li>';
	}
else {
$ishopcartlogin = esc_attr(get_theme_mod('ishop_login_button','Login/Register'));
	echo '<li><a class="myacclo" href="';
	echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id')) ); 
	echo '" title="'.$ishopcartlogin.'">'.$ishopcartlogin.'</a></li>';
	}
	global $woocommerce;
		
	echo ' <li><a class="cart-contents" href="';
	echo esc_url($woocommerce->cart->get_cart_url());
	echo '" title="'.__('View your shopping cart','ishop').'">';
        echo esc_html(sizeof( $woocommerce->cart->get_cart()));
        echo _e(' items -','ishop');
        echo $woocommerce->cart->get_cart_subtotal();
        echo '</a></li>';

        }
        
        
 function ishop_before_shop_item_buttons() {
				global $post;
				$html = '';
				$buttons_container = '<div class="product-buttons"><div class="product-buttons-container clearfix">';
				if( isset( $_SERVER['QUERY_STRING'] ) ) {
					parse_str( $_SERVER['QUERY_STRING'], $params );
					if( isset ( $params['product_view'] ) ){
						$product_view = $params['product_view'];
						if( $product_view == 'list' ){
							$html = '<div class="product-excerpt product-' . esc_attr($product_view) . '">';
							$html .= '<div class="product-excerpt-container">';
							$html .= '<div class="post-content">';
							$html .= apply_filters( 'woocommerce_short_description', esc_html($post->post_excerpt ));
							$html .= '</div>';
							$html .= '</div>';
							$html .= $buttons_container;
							$html .= ' </div>';
							
							echo $html;
						} else {
							echo $buttons_container;
						}
					} else {
						echo $buttons_container;
					}
				} else {
					echo $buttons_container;
				}
			}
                        
                        
                        
function ishop_after_shop_item_buttons() {
             global $product;

             $styles = '';
			 	$morebuttonname= esc_attr(get_theme_mod('ishop_detail_button','Detail'));
             if ( ! $product->is_purchasable() || 
                      ! $product->is_in_stock()
             ) {
                     $styles = ' style="float:none;max-width:none;text-align:center;"';
             }
           echo sprintf( '<a href="%s" class="show_details_button"%s>%s</a></div></div>', get_permalink(), $styles, $morebuttonname );
     }

    add_action( 'woocommerce_after_shop_loop_item','ishop_before_shop_item_buttons', 9 );
    add_action( 'woocommerce_after_shop_loop_item', 'ishop_after_shop_item_buttons', 11 );
if (get_theme_mod('woocommerce_imageflip')==''){
 function ishop_woocommerce_thumbnail() {
		global $product, $woocommerce;

		$items_in_cart = array();

		if ( $woocommerce->cart->get_cart() && is_array( $woocommerce->cart->get_cart() ) ) {
			foreach ( $woocommerce->cart->get_cart() as $cart ) {
				$items_in_cart[] = $cart['product_id'];
			}
		}

		$id      = get_the_ID();
		$in_cart = in_array( $id, $items_in_cart );
		$size    = 'shop_catalog';

		$gallery          = get_post_meta( $id, '_product_image_gallery', true );
		$attachment_image = '';
		if ( ! empty( $gallery ) ) {
			$gallery          = explode( ',', $gallery );
			$first_image_id   = $gallery[0];
			$attachment_image = wp_get_attachment_image( $first_image_id, $size, false, array( 'class' => 'hover-image' ) );
		}
		$thumb_image = get_the_post_thumbnail( $id, $size );

		if ( $attachment_image ) {
			$classes = 'crossfade-images';
		} else {
			$classes = '';
		}

		echo '<span class="' . $classes . '">';
		echo $attachment_image;
		echo $thumb_image;
		
		echo '</span>';
	}
	
	add_action( 'woocommerce_before_shop_loop_item_title', 'ishop_woocommerce_thumbnail', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', create_function('', 'echo "<div class=\"product-images\">";'), 5, 2);
	add_action( 'woocommerce_before_shop_loop_item_title',create_function('', 'echo "</div>";'), 12, 2);
}       

/* ----------------------------------------------------------------------------------- */
/* Woocommerce single product share
/*----------------------------------------------------------------------------------- */
function ishop_close_summary_div()
{

	$currentlink = esc_url( get_permalink() );
	echo "<div class='woosingle-sidebar2'>";
	echo '<div class="icon-bar five-up">
  <a href="http://www.facebook.com/sharer.php?u='.$currentlink.'" class="item facebook">
   <i class="fa fa-facebook-f"></i>
  </a>
  <a href="https://twitter.com/share?url=' . $currentlink .'" class="item twitter">
    <i class="fa fa-twitter"></i>
  </a>
  <a href="https://plus.google.com/share?url=' . $currentlink .'" class="item google">
    <i class="fa fa-google-plus"></i>
  </a>
  
  <a href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20' . $currentlink .'" class="item envelope">
   <i class="fa fa-envelope"></i>
  </a>
  <a href="http://pinterest.com/pin/create/button/?url=' . $currentlink .'" class="item pinterest">
    <i class="fa fa-pinterest-p"></i>
  </a>
</div>';
	echo "</div>";
}               
  
if (get_theme_mod('woocommerce_share_buttons')!=='disable'){
add_action( 'woocommerce_share',  'ishop_close_summary_div', 3);
}
/* ----------------------------------------------------------------------------------- */
/* Footer scroll to top
  /*----------------------------------------------------------------------------------- */
if (get_theme_mod('hide_backtotop')=='show' ) {
function ishop_backtotop_function() {
    echo '<a href="#" class="scrollup backtoup"><i class="fa fa-chevron-up"></i></a>';
}
add_action( 'wp_footer', 'ishop_backtotop_function' );
}
/* ----------------------------------------------------------------------------------- */
/* Tabs Blog Post
/*----------------------------------------------------------------------------------- */
function ishop_blogpoststabs(){ 
    $args = array( 
    'ignore_sticky_posts' => true,
    'showposts' => 6,
    'orderby' => 'date',  );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();

     echo '<div class="latest-post">';
    if ( has_post_thumbnail() ) {the_post_thumbnail();}
    else {
    echo '<img src="';
    echo esc_url(get_template_directory_uri()); 
    echo '/images/thumb.jpg" class="blog-post-img"/>';
    }
    echo '<a title="';
    the_title();
    echo'" href="';
    the_permalink();
    echo '" rel="bookmark">';
     the_title();
    echo '</a><br />';
    echo '<div class="clear"></div></div>';
    endwhile; endif; wp_reset_postdata(); 
    echo '<div style="clear:both;"></div>';

}
add_action('ishop_tabs_blog_posts', 'ishop_blogpoststabs');

/* ----------------------------------------------------------------------------------- */
/* Comment Reply Link
  /*----------------------------------------------------------------------------------- */

function ishop_comment_reply_link_filter($content){
    return '<div class="button replybutton">' . wp_kses_post($content) . '</div>';
}
add_filter('comment_reply_link', 'ishop_comment_reply_link_filter', 99);

/* ----------------------------------------------------------------------------------- */
/* Excerpt for Post
/*----------------------------------------------------------------------------------- */
function ishop_custom_excerpt_length( $length ) {
        $length = 20;
	return $length;
}
add_filter( 'excerpt_length', 'ishop_custom_excerpt_length', 999 );

/* ----------------------------------------------------------------------------------- */
/* Popular\Recent Post Wedget Hide or show
/*----------------------------------------------------------------------------------- */
function ishop_custom_widget1(){
if (get_theme_mod("hide_sidebar_widget")==''){
    get_template_part('template-parts/widget-sidebar');
  
}}
  add_action('before_sidebar','ishop_custom_widget1');
/* ----------------------------------------------------------------------------------- */
/* Woocommerce at Front Page Hide or show
/*----------------------------------------------------------------------------------- */
function ishop_woocommerce_hide(){
if (get_theme_mod("hide_woocommerce_shop")=='' and class_exists( 'WooCommerce' ) ){
    echo '<a href="';
    global $woocommerce; 
    echo esc_url(get_permalink( woocommerce_get_page_id( 'shop' ) )); 
    echo '" class="label success front-label">';
    echo esc_attr(get_theme_mod('shop_front_name','Shop'));
    echo '</a><div style="clear:both;"></div>';
    if (class_exists('woocommerce')) { 
       echo '<div class="woocommerce columns-4"><ul class="products">';
		
		$args = array(
			'post_type' => 'product',
			'orderby' => 'menu_order',			
			'posts_per_page' => 13
			);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
		} else {
			echo __( 'No products found','ishop' );
		}
		wp_reset_postdata();
        }
		echo '</ul></div>';
  
}}
  add_action('front_page_column1','ishop_woocommerce_hide');


/* ----------------------------------------------------------------------------------- */
/* News Ticker
/*----------------------------------------------------------------------------------- */
function ishop_ticker(){
      echo '<ul class="ticker" >';
     $ishop_ticker_args = array( 
    'ignore_sticky_posts' => true,
    'showposts' => 8,
    'orderby' => 'date',  );
    $the_query = new WP_Query( $ishop_ticker_args );
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();

    echo '<li><h5><span>'.esc_attr(get_theme_mod('ticker_name','News')).'</span><i class="fa fa-hand-o-right"></i><a title="';
    the_title();
    echo'" href="';
    the_permalink();
    echo '" rel="bookmark">';
     the_title();
    echo '</a></h5>';
    echo '<div class="clear"></div></li>';
    endwhile; endif; wp_reset_postdata();
    echo '</ul>';
}

/* ----------------------------------------------------------------------------------- */
/* Custom CSS Output
/*----------------------------------------------------------------------------------- */


function ishop_css(){
	
	  echo '<style type="text/css">';
 if(! function_exists(' is_home() || is_front_page()') ){	if (get_theme_mod('hide_sliderfront')=='1'){ echo '.orbit-container{display:none;}';}}
    if(! function_exists(' is_page() ')){ if (get_theme_mod('hide_sliderpages')=='1'){ echo '.orbit-container{display:none;}';}}
    if(! function_exists(' is_single()') ){ if (get_theme_mod('hide_sliderpost')=='1'){ echo '.orbit-container{display:none;}';}}
    if(! function_exists(' is_woocommerce() || is_shop() || is_product_category() || is_product() || is_cart() || is_checkout() || is_account_page() || is_product_tag() ')){	if (get_theme_mod('hide_sliderwoo')=='1'){ echo '.orbit-container{display:none;}';}}
	  echo 'nav.top-bar{position: '.get_theme_mod('topmenuposition','fixed').' !important; display: '.get_theme_mod('topmenuhide','block').' !important;}';
	echo 'nav#site-navigation{display: '.get_theme_mod('mainmenuhide','block').' !important;}';
	if (get_theme_mod('topmenuhide')=='none'){echo '#masthead{margin-top: 0 !important;}';}
	   echo '</style>';
	$custom_css = '
	#masthead{background-image:url("'.esc_url(get_theme_mod('header_image')).'");}
	
	'.html_entity_decode(get_theme_mod('custom_css')).'';

	wp_add_inline_style( 'ishop-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ishop_css' );
	


class ishop_Walker_Nav_Menu extends Walker_Nav_Menu {

	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu dropdown\">\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see   Walker::start_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filter the CSS class(es) applied to a menu item's <li>.
		 *
		 * @since 3.0.0
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of arguments. @see wp_nav_menu()
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's <li>.
		 *
		 * @since 3.0.1
		 *
		 * @param        string The ID that is applied to the menu item's <li>.
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of arguments. @see wp_nav_menu()
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		/**
		 * Filter the HTML attributes applied to a menu item's <a>.
		 *
		 * @since 3.6.0
		 *
		 * @param array  $atts   {
		 *                       The HTML attributes applied to the menu item's <a>, empty strings are ignored.
		 *
		 * @type string  $title  The title attribute.
		 * @type string  $target The target attribute.
		 * @type string  $rel    The rel attribute.
		 * @type string  $href   The href attribute.
		 * }
		 *
		 * @param object $item   The current menu item.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes $args->before, the opening <a>,
		 * the menu item's title, the closing </a>, and $args->after. Currently, there is
		 * no filter for modifying the opening and closing <li> for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of arguments. @see wp_nav_menu()
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see   Walker::end_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		if (! $element)
			return;

		$id_field = $this->db_fields['id'];

		$element->has_children = !empty( $children_elements[$element->ID] );

		$element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
		$element->classes[] = ( $element->has_children ) ? 'has-dropdown' : '';

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}


} // Foundation_Walker_Nav_Menu
