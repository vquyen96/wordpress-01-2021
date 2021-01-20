<?php
/**
 * The header
 * @package retail-shop
 * @since 1.0
 */

global $wpdb;
$args = array(
    'taxonomy' => 'category',
    'orderby' => 'date',
    'order' => 'DESC',
    'show_count' => 1,
    'pad_counts' => 0,
    'hierarchical' => 0,
    'title_li' => '',
    'hide_empty' => 1,
);
$cats = get_categories($args);
//$moderation = $wpdb->get_col( $wpdb->prepare( "SELECT * FROM {$wpdb->ca} WHERE comment_approved = '0' LIMIT %d OFFSET %d", $limit, $start ) );


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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>
<body <?php body_class(); ?>>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=196414931235563&autoLogAppEvents=1" nonce="12bKG53Q"></script>

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
            <div class="header-home">
                <a href="<?php echo esc_url( home_url( '/' )) ?>"></a>
            </div>
        </div>
    </header>
    <nav class="nav-menu">
        <ul>
            <?php
            $content = "";
            foreach ($cats as $cat) {
                if ($cat->category_parent == 0) {
                    $content .= "<li><a href='" . esc_url( home_url( '/' )."?cat=".$cat->term_id ) . "'>$cat->name</a>";
                    $hasCateChild = false;
                    foreach ($cats as $catChild) {
                        if ($catChild->category_parent == $cat->term_id) {
                            if (!$hasCateChild) {
                                $content .= "<ul>";
                                $hasCateChild = true;
                            }
                            $content .= "<li><a href='" . esc_url( home_url( '/' )."?cat=".$catChild->term_id ) . "'>$catChild->name</a></li>";
                        }
                    }
                    if ($hasCateChild) {
                        $content .= "</ul></li>";
                    } else {
                        $content .= "</li>";
                    }
                }

            }
            echo $content;
            ?>
        </ul>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="focal">
                    <div class="focal-title">
                        Tin tiêu điểm
                    </div>
                    <div class="focal-content">
                        <ul>
                            <li>
                                <a href="#">Sản phẩm PM Procare</a>
                            </li>
                            <li>
                                <a href="#">Sản phẩm PM Procare diamond</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-header owl-carousel owl-theme">
        <div class="item">
            <img src="https://dinhduongbabau.net/wp-content/uploads/2020/06/banner-procare-diamond.jpg" alt="">
        </div>
        <div class="item">
            <img src="https://dinhduongbabau.net/wp-content/uploads/2019/11/canxi-cho-me.jpg" alt="">
        </div>
    </div>