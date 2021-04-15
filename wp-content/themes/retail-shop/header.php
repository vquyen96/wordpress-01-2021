<?php
/**
 * The header
 * @package retail-shop
 * @since 1.0
 */

global $wpdb;

$hunmendCustoms =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE status = %d ORDER BY sort ASC", 1));
$hunmendData = [];
$listIsArray = ['NAV_HEADER', 'POST_TOP', 'CATE_HOME'];
if (count($hunmendCustoms) != 0) {
    foreach ($hunmendCustoms as $hunmend) {
        if (in_array($hunmend->name, $listIsArray)) {
            $hunmendData[$hunmend->name][] = $hunmend->value;
        } else {
            $hunmendData[$hunmend->name] = $hunmend->value;
        }
    }
}

$args = array(
    'taxonomy' => 'category',
    'orderby' => 'term_id',
    'order' => 'ASC',
    'show_count' => 1,
    'pad_counts' => 0,
    'hierarchical' => 0,
    'title_li' => '',
);
$cats = get_categories($args);

$args = array(
    'taxonomy' => 'product_cat',
    'orderby' => 'term_id',
    'order' => 'ASC',
    'show_count' => 1,
    'pad_counts' => 0,
    'hierarchical' => 0,
    'title_li' => '',
);
$catProduct = get_categories($args);

$listCateNav = [];
foreach ($hunmendData['NAV_HEADER'] as $cateId) {
    foreach ($cats as $cate) {
        if ($cate->cat_ID == $cateId) {
            $listCateNav[] = $cate;
        }
    }
}

//$listCateFeature = [];
//foreach ($hunmendData['FEATURE'] as $cateId) {
//    foreach ($cats as $cate) {
//        if ($cate->cat_ID == $cateId) {
//            $listCateFeature[] = $cate;
//        }
//    }
//}

// Get Smenu
$hunmendSmenus =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s LIMIT 1", "SUB_MENU"));
if ($hunmendSmenus != null && count($hunmendSmenus) != 0) {
    $valueSmenuString = $hunmendSmenus[0]->value;
    $valueSmenus = json_decode($valueSmenuString, true);
}


//print_r($cats);
//$moderation = $wpdb->get_col( $wpdb->prepare( "SELECT * FROM {$wpdb->ca} WHERE comment_approved = '0' LIMIT %d OFFSET %d", $limit, $start ) );

$bannerHead =  $wpdb->get_row( "SELECT * FROM $wpdb->hunmend_banners WHERE type=1");
$bannerHeadMobie =  $wpdb->get_row( "SELECT * FROM $wpdb->hunmend_banners WHERE type=4");
$bannerMain =  $wpdb->get_results( "SELECT * FROM $wpdb->hunmend_banners WHERE type=2");
$bannerMainMobie =  $wpdb->get_results( "SELECT * FROM $wpdb->hunmend_banners WHERE type=5");
$bannerIconHead =  $wpdb->get_row( "SELECT * FROM $wpdb->hunmend_banners WHERE type=6");

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link type="image/x-icon" href="<?php echo $bannerIconHead->value ?>" rel="shortcut icon" />
    <style>
        :root {
            --color-custom-1: <?php echo $hunmendData['COLOR_1']; ?>;
            --color-custom-2: <?php echo $hunmendData['COLOR_2']; ?>;
            --color-custom-3: <?php echo $hunmendData['COLOR_3']; ?>;
        }
    </style>
    <?php
        wp_head();
        /*
         * get default settings
         */
        global $retail_shop_option;
        if ( class_exists( 'WP_Customize_Control' ) ) {
           $retail_shop_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings());
        }

        $_post = get_post( $post );
        $og = [
            'title' => $_post->post_title,
            'description' => cut_string(get_the_excerpt($_post->ID), 300),
            'image' => get_the_post_thumbnail_url($_post->ID,'medium_large'),
        ];

    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TCFR748');</script>
    <!-- End Google Tag Manager -->
</head>
<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TCFR748"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0&appId=196414931235563&autoLogAppEvents=1" nonce="5gl5IZ0n"></script>
    <header class="custom-header">
        <div class="header-content" style="background: url('<?php echo $bannerHead->value ?>') no-repeat center /cover">
            <div class="header-top">
                <div class="header-top-search">
                    <form class="top-search" action="<?php echo esc_url( home_url( '/' )) ?>" method="get">

                        <label class="screen-reader-text" for="woocommerce-product-search-field">Search for</label>
                        <input type="search" name="s" id="" value="" placeholder="Bạn tìm kiếm gì ...">
                        <button type="submit"><span class="fa icon fa-search"></span></button>
                    </form>
                </div>
                <div class="header-top-nav">
                    <a href="<?php echo esc_url( home_url( '/' )) ?>">Trang chủ</a>
                        <a href="tel:<?php echo $hunmendData['PHONE'] ?>">Liên hệ <?php echo $hunmendData['PHONE'] ?></a>
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
        <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="header-content-mobie responsive-768" style="background: url('<?php echo $bannerHeadMobie->value ?>') no-repeat center /cover">

        </a>
    </header>
    <nav class="nav-menu">
        <ul>
            <?php
            $content = "";
            foreach ($listCateNav as $cat) {
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
            echo $content;
            ?>
            <li><a href="<?php echo esc_url( home_url( '/' )) ?>?page=contact">Tư vấn hỏi đáp</a></li>
            <li><a href="<?php echo esc_url( home_url( '/' )).'?product_cat='.$catProduct[0]->slug ?>">Sản phẩm</a></li>
            <li><a href="<?php echo esc_url( home_url( '/' )) ?>?page=video">Video tư vấn</a></li>
        </ul>
        <div class="btn-menu-mobie-hide">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
    <div class="container focal-bg">
        <div class="row">
            <div class="col-12">
                <div class="focal">
                    <div class="focal-title">
                        <?php echo $hunmendData['FEATURE_TITLE'] ?>
                    </div>
                    <div class="focal-content">
                        <ul>
                            <li class="responsive-768">
                                <a href="<?php echo esc_url( home_url( '/' )."?cat=".$catChild->term_id ) ?>">Trang chủ</a>
                            </li>
                            <? foreach ($valueSmenus as $smenu) { ?>
                            <li>
                                <a href="<?php echo $smenu['url'] ?>"><?php echo $smenu['title'] ?></a>
                            </li>
                            <?php } ?>
                        </ul>
                        <span aria-label="Next" class="btnNextSubMenu">></span>
                        <span aria-label="Prevout" class="btnPrevSubMenu"><</span>
                    </div>
                    <div class="btn-menu-mobie">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-search-mobie">
        <div class="content-right-search">
            <form class="content-right-form" action="<?php echo esc_url( home_url( '/' )) ?>" method="get">
                <label class="screen-reader-text">Tìm kiếmr</label>
                <input type="search" name="s" id="" value="" placeholder="Bạn tìm kiếm gì ...">
                <button type="submit"><span class="fa icon fa-search"></span></button>
            </form>
        </div>
    </div>
    <div class="banner-header-bg">
        <div class="banner-header owl-carousel owl-theme header-slide">
            <?php foreach ($bannerMain as $banner) { ?>
                <div class="item">
                    <a href="<?php echo $banner->links?>" target="_blank">
                        <img src="<?php echo $banner->value?>" alt="<?php echo $banner->title?>">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="banner-header-bg-mobie">
        <div class="banner-header owl-carousel owl-theme">
            <?php foreach ($bannerMainMobie as $banner) { ?>
                <div class="item">
                    <a href="<?php echo $banner->links?>" target="_blank">
                        <img src="<?php echo $banner->value?>" alt="<?php echo $banner->title?>">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function () {
            var countSubMenu = <?php echo count($valueSmenus); ?>;
            var smenuMl = 0;
            var smenuPadding = 40;
            var smenuPlus = 200;
            if (jQuery(window).width() < 768) {
                var smenuItem = 64;
                smenuPadding = 150;
                smenuPlus = 100;
            } else {
                var smenuItem = 52+43;
            }
            jQuery(document).on('click', '.btnNextSubMenu', function() {
                var smenuBgWidth = jQuery('.focal-content').width();

                var smenuWidth = smenuItem * countSubMenu;
                var smenuMoveWidth = smenuWidth - smenuBgWidth - smenuMl +  smenuPadding;
                console.log(smenuMoveWidth);
                if (smenuMoveWidth > 0) {
                    smenuMl += smenuPlus;
                    jQuery('.focal-content>ul').css('margin-left', '-' + smenuMl + 'px');
                    jQuery('.focal-content>span.btnPrevSubMenu').css('display', 'block');
                }
            });

            jQuery(document).on('click', '.btnPrevSubMenu', function() {
                if (smenuMl > 0) {
                    smenuMl -= smenuPlus;
                    jQuery('.focal-content>ul').css('margin-left', '-' + smenuMl + 'px');
                }

                if (smenuMl <= 0) {
                    jQuery('.focal-content>span.btnPrevSubMenu').css('display', 'none');
                }

            });
        });
    </script>