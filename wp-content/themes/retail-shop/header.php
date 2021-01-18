<?php
/**
 * The header
 * @package retail-shop
 * @since 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php 
	wp_head();
	/* 
	 * get default settings 
	 */ 
	global $retail_shop_option;	
	if ( class_exists( 'WP_Customize_Control' ) ) {
	   $retail_shop_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings());  
	}
?>
</head>
<body <?php body_class(); ?>>

    <header class="custom-header">
        <div class="header-content">
            <div class="header-top">
                <div class="header-top-search">

                    <form class="top-search" action="http://localhost:6060/" method="get">
                        <select class="d-none" name="product_cat">
                            <option value="0" selected>All Categories</option>
                        </select>

                        <label class="screen-reader-text" for="woocommerce-product-search-field">Search for</label>
                        <input type="search" name="s" id="" value="" placeholder="Bạn tìm kiếm gì ...">
                        <button type="submit"><span class="fa icon fa-search"></span></button>
                        <input type="hidden" name="post_type" value="product">
                    </form>

                </div>
                <div class="header-top-nav">
                    <a href="https://dinhduongbabau.net/">Trang chủ</a>
                    <a href="https://dinhduongbabau.net/dinh-duong-ba-bau/">Giới thiệu</a>
                    <a href="https://dinhduongbabau.net/lien-he/">Liên hệ</a>
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
            </div>

        </div>
    </header>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else { 
		do_action( 'wp_body_open' ); 
	}
$retail_shop_option['header_style'] = ecommerce_star_header_class();

?>
<!-- The Search Modal Dialog -->
<div id="myModal" class="modal" aria-hidden="true" tabindex="-1" role="dialog">
  <!-- Modal content -->
  <div class="modal-content"> <span id="search-close" class="close" tabindex="0">&times;</span> 
  <br/><br/><?php get_search_form(); ?><br/>
  </div>
</div>
<!-- end search model-->
<div id="page" class="site">
<?php 
	if($retail_shop_option['box_layout']){
		echo '<div class="wrap-box">';
	}
?>
<a class="skip-link screen-reader-text" href="#primary" ><?php esc_html_e( 'Skip to content', 'retail-shop' ); ?></a>
<header id="masthead" class="<?php echo esc_attr(ecommerce_star_header_class()); ?> site-header" role="banner" >
	
	<?php get_template_part( 'template-parts/header/header', $retail_shop_option['mini_header_style'] );	?>

	<?php	
	if(is_front_page()  ) { 
		get_template_part( 'sections/top', 'widgets' ); 
	}	
	?>

	<div class="container">
		<?php
		if($retail_shop_option['header_woocommerce'] && class_exists( 'WooCommerce' )){
			//ecommerce_star_woocommerce_header();
			ecommerce_star_woocommerce_header();
		} else {
			ecommerce_star_default_header(); 
		}
		?>
	</div><!-- .container -->
	
		<!--display menu bar full row when header options, woocommerce layout with search--> 
		<?php 
		if($retail_shop_option['header_woocommerce'] && class_exists( 'WooCommerce' )){
			ecommerce_star_woocommerce_menu();
		}
		
		if((is_front_page() || is_home()) && $retail_shop_option['slider_in_home_page'] ){
			get_template_part( 'template-parts/slider', 'section' );	
		}
				
		if ($retail_shop_option['enable_breadcrumb'] && $retail_shop_option['header_woocommerce']) {
			get_template_part( 'template-parts/header/breadcrumb'); 
		}
		
		
		if($retail_shop_option['before_shop'] !='' && class_exists( 'WooCommerce' ) && is_shop()){
			get_template_part( 'sections/before', 'shop'); 
		}
?>
</header>		
<?php
if ((is_front_page() || is_home()) && (class_exists( 'WooCommerce' ) && $retail_shop_option['header_slider_nav'])) {
					get_template_part( 'sections/product','section');
} 