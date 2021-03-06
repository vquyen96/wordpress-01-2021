<?php
/* 
 * Child theme main functions.
 */
	
define('retail_shop_THEME_DOC', 'https://demo.ceylonthemes.com');
define('retail_shop_THEME_URI', 'https://www.ceylonthemes.com/product/wordpress-storefront-theme/');

/* 
 * default settings
 */
require_once  get_stylesheet_directory().'/inc/settings.php';

/*
 * get_parent theme settings and override with child theme settings
 */
$retail_shop_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings()); 


function retail_shop_styles() {
	//enqueue parent styles
	wp_enqueue_style( 'retail-shop-parent-styles', get_template_directory_uri().'/style.css' );
} 

add_action( 'wp_enqueue_scripts', 'retail_shop_styles' );



/**
 * Return rgb value of a $hex - hexadecimal color value with given $a - alpha value
**/
 
function retail_shop_rgba($hex,$a){
 
	$r = hexdec(substr($hex,1,2));
	$g = hexdec(substr($hex,3,2));
	$b = hexdec(substr($hex,5,2));
	$result = 'rgba('.$r.','.$g.','.$b.','.$a.')';
	
	return $result;
}


/* 
 * allowed html tags 
 */
$retail_shop_allowed_html = array(
		'a'          => array(
			'href'  => true,
			'title' => true,
			'class'  => true,			
		),
		'option'          => array(
			'selected'  => true,
			'value' => true,
			'class'  => true,			
		),		
		'p'          => array(
			'class'  => true,
		),		
		'abbr'       => array(
			'title' => true,
		),
		'acronym'    => array(
			'title' => true,
		),
		'b'          => array(),
		'blockquote' => array(
			'cite' => true,
		),
		'cite'       => array(),
		'code'       => array(),
		'del'        => array(
			'datetime' => true,
		),
		'em'         => array(),
		'i'          => array(),
		'q'          => array(
			'cite' => true,
		),
		's'          => array(),
		'strike'     => array(),
		'strong'     => array(),
	);

/* 
 * wp body open 
 */
function retail_shop_body_open(){
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
}

add_action('retail_shop_wp_body_open', 'retail_shop_body_open');

require_once   get_stylesheet_directory().'/inc/post-widget.php';
require_once   get_stylesheet_directory().'/inc/product-widget.php';
/*
 * override parent theme custom css
 */
function ecommerce_star_custom_css(){
	require_once  get_stylesheet_directory().'/inc/styles.php';
}

ecommerce_star_custom_css();

/*
 * header_background 
 */

add_action( 'customize_register', 'retail_shop_customizer_settings' );

/*
 * load customizer control 
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	// Inlcude the Alpha Color Picker control file.
	require get_template_directory().'/inc/color-picker/alpha-color-picker.php';
}

function retail_shop_customizer_settings( $wp_customize ) {

	//widgets section	
	$wp_customize->add_section( 'home_widgets' , array(
		'title'      => __( 'Home Header Widgets', 'retail-shop' ),
		'priority'   => 1,
		'panel' => 'theme_options',
	) );	
	
	//top banner
	$wp_customize->add_setting('ecommerce_star_option[top_widgets]' , array(
		'default'    => 'col-sm-12',
		'sanitize_callback' => 'ecommerce_star_sanitize_select',
		'type'=>'option',

	));

	$wp_customize->add_control('ecommerce_star_option[top_widgets]' , array(
		'label' => __('Select Number of Widgets', 'retail-shop' ),
		'section' => 'home_widgets',
		'type'=>'select',
		'choices'=>array(
			'col-sm-12'=> __('1 Widgets', 'retail-shop' ),
			'col-sm-6'=> __('2 Widgets', 'retail-shop' ),
			'col-sm-4'=> __('3 Widgets', 'retail-shop' ),
			'col-sm-3'=> __('4 Widgets', 'retail-shop' ),
			'col-sm-2'=> __('6 Widgets', 'retail-shop' ),
		),
	) );
	
	//widgets section	
	$wp_customize->add_section( 'shop_page_section' , array(
		'title'      => __( 'Shop Page', 'retail-shop' ),
		'priority'   => 2,
		'panel' => 'theme_options',
	) );
	
	//shop pages 1
	$wp_customize->add_setting('ecommerce_star_option[before_shop]' , array(
		'default'    => 0,
		'sanitize_callback' => 'absint',
		'type'=>'option',

	));

	$wp_customize->add_control('ecommerce_star_option[before_shop]' , array(
		'label' => __('Before Shop', 'retail-shop' ),
		'section' => 'shop_page_section',
		'type'=> 'dropdown-pages',
	) );	

	
	//shop pages 2
	$wp_customize->add_setting('ecommerce_star_option[after_shop]' , array(
		'default'    => 0,
		'sanitize_callback' => 'absint',
		'type'=>'option',

	));

	$wp_customize->add_control('ecommerce_star_option[after_shop]' , array(
		'label' => __('After Shop', 'retail-shop' ),
		'section' => 'shop_page_section',
		'type'=> 'dropdown-pages',
	) );
	
	// contact section header show / hide
	$wp_customize->add_setting( 'ecommerce_star_option[header_slider_nav]' , array(
	'default'    => 1,
	'sanitize_callback' => 'ecommerce_star_sanitize_checkbox',
	'type'=>'option',
	'priority'   => 2,
	));

	$wp_customize->add_control('ecommerce_star_option[header_slider_nav]' , array(
	'label' => __('Enable Home Product Slider|Navigation','retail-shop' ),
	'section' => 'header_section',
	'type'=>'checkbox',
	) );
	
	// category
	$wp_customize->add_setting( 'ecommerce_star_option[slider_nav_cat]' , array(
	'default'    => "",
	'sanitize_callback' => 'ecommerce_star_sanitize_select',
	'type'=>'option'
	));

	$wp_customize->add_control('ecommerce_star_option[slider_nav_cat]' , array(
	'label' => __('Select Product Category','retail-shop' ),
	'section' => 'header_section',
	'type'=>'select',
	'choices'=> retail_shop_get_product_categories(),
	) );		


}


function retail_shop_get_product_categories(){

	$args = array(
			'taxonomy' => 'product_cat',
			'orderby' => 'date',
			'order' => 'ASC',
			'show_count' => 1,
			'pad_counts' => 0,
			'hierarchical' => 0,
			'title_li' => '',
			'hide_empty' => 1,
	);

	$cats = get_categories($args);

	$arr = array();
	$arr[''] = esc_html__('All', 'retail-shop');
	foreach($cats as $cat){
		$arr[$cat->term_id] = $cat->name;
	}
	return $arr;
}


//add child theme widget area

function retail_shop_widgets_init(){

	/* header sidebar */
	global $retail_shop_option;

	register_sidebar(
		array(
			'name'          => __( 'Home Header Widgets', 'retail-shop' ),
			'id'            => 'header-banner',
			'description'   => __( 'Add widgets to appear in Header.', 'retail-shop' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s '.esc_attr($retail_shop_option['top_widgets']).' text-center">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action( 'widgets_init', 'retail_shop_widgets_init' );


/*
 * theme page
 */
require_once  get_stylesheet_directory().'/inc/help.php';



/*
 * WooCommerce Header
 */
function retail_shop_default_header(){
	global $ecommerce_star_option;
?>

 		<!--  menu, search -->
		<div class="vertical-center">
	
		<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12" >
				<?php ecommerce_star_product_search(); ?>
		</div>
		
		
		<!-- .start of site-branding -->
		<div class="col-md-4 col-sm-4 col-xs-12 site-branding text-center" >
		  <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
		  <?php the_custom_logo(); ?>
		  <?php endif; ?>
		  <div class="site-branding-text" style=" <?php if(!$ecommerce_star_option['header_show_title_tag']) echo 'display:none'; ?>" >
			<?php if ( is_front_page() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" >
			  <?php bloginfo( 'name' ); ?>
			  </a></h1>
			<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" >
			  <?php bloginfo( 'name' ); ?>
			  </a></p>
			<?php endif; ?>
			<?php $description = get_bloginfo( 'description', 'display' ); if ( $description || is_customize_preview() ) : ?>
			<p class="site-description"><?php echo esc_html($description); ?></p>
			<?php endif; ?>
		  </div>
		</div>
		<!-- .end of site-branding -->		
		
		
		<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
			<div id="cart-wishlist-container">
				<table class="cart-wishlist-table">
				<tr>
				<td>
				  <?php if(class_exists('YITH_WCWL')): ?>
				  <div id="wishlist-top" class="wishlist-top">
					<div class="wishlist-container">
					  <?php ecommerce_star_wishlist_count(); ?>
					</div>
				  </div>
				  <?php endif; ?>
				</td>
				<td>
				  <div id="cart-top" class="cart-top">
					<div class="cart-container">
					  <?php do_action( 'woocommerce_cart_top' ); ?>
					</div>
					
					<div id="popup-cart-wrap" class="widget woocommerce widget_shopping_cart "><?php woocommerce_mini_cart(); ?></div>

				  </div>
				</td>
				</tr>
				</table>
			</div>
		</div>
		
	</div><!-- end of  .menu, search -->
<?php 
}


function cut_string($text, $length)
{
    if(strlen($text) > $length) {
        $text = $text.' ';
        $text = substr($text, 0, strpos($text, ' ', $length)).'...';
    }
    return $text;
}

function paginate($lastPage, $currentPage, $url) {
    $content = '';
    if ($lastPage > 1) {
        $content = '<nav class="pagination-bg">';
        $content    .= '<ul class="pagination">';
        $content        .= '<li class="page-item ' . ($currentPage == 1 ? "disabled" : "") . '">';
        $content            .= '<a class="page-link" href="' . $url . '&paged=1"><<</a>';
        $content        .= '</li>';
        for ($i = 1; $i <= $lastPage; $i++) {
            if ($i >= ($currentPage-2) && $i <= ($currentPage+2)) {
                $content.= '<li class="page-item ' . ($currentPage == $i ? "disabled" : "") . '">';
                $content    .= '<a class="page-link" href="' . $url . '&paged='. $i .'">'. $i .'</a>';
                $content.= '</li>';
            }
        }
        $content        .= '<li class="page-item ' . ($currentPage == $lastPage ? "disabled" : "") . '">';
        $content            .= '<a class="page-link" href="' . $url . '&paged='. $lastPage .'">>></a>';
        $content        .= '</li>';
        $content    .= '</ul>';
        $content .= '</nav>';
    }
    echo $content;
}


add_action( 'init', 'wpse26388_rewrites_init' );
function wpse26388_rewrites_init(){
    add_rewrite_rule(
        'properties/([0-9]+)/?$',
        'index.php?pagename=properties&property_id=$matches[1]',
        'top' );
}

add_filter( 'query_vars', 'wpse26388_query_vars' );
function wpse26388_query_vars( $query_vars ){
    $query_vars[] = 'property_id';
    return $query_vars;
}