<?php
/**
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after.
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package retail-shop
 */

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

global $retail_shop_option;	
if ( class_exists( 'WP_Customize_Control' ) ) {
   $retail_shop_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings());  
}

$retail_shop_class = '';

if($retail_shop_option['footer_section_image']!=''){
	$retail_shop_class = 'footeroverlay';
}
$retail_shop_class = $retail_shop_class. ' footer-foreground';



if($retail_shop_option['after_shop'] !=''  && class_exists( 'WooCommerce' ) && is_shop()){
	get_template_part( 'sections/after', 'shop');  
}

global $wpdb;

$hunmendCustoms =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE status = %d ORDER BY sort ASC", 1));
$hunmendData = [];
$listIsArray = ['NAV_HEADER', 'POST_TOP', 'FEATURE', 'CATE_HOME'];
if (count($hunmendCustoms) != 0) {
    foreach ($hunmendCustoms as $hunmend) {
        if (in_array($hunmend->name, $listIsArray)) {
            $hunmendData[$hunmend->name][] = $hunmend->value;
        } else {
            $hunmendData[$hunmend->name] = $hunmend->value;
        }
    }
}

?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="footer-main">
                    <?php
                    $content = "";
                    foreach ($cats as $cat) {
                        if ($cat->category_parent == 0 && $cat != null) {
                            $content .= "<div class='footer-item'><div class='footer-item-title'>$cat->name</div>";
                            $hasCateChild = false;
                            foreach ($cats as $catChild) {
                                if ($catChild->category_parent == $cat->term_id) {
                                    if (!$hasCateChild) {
                                        $content .= "<div class='footer-item-main'>";
                                        $hasCateChild = true;
                                    }
                                    $content .= "<a href='" . esc_url( home_url( '/' )."?cat=".$catChild->term_id ) . "'>$catChild->name</a>";
                                }
                            }
                            if ($hasCateChild) {
                                $content .= "</div>";
                            }
                            $content .= "</div>";
                        }

                    }
                    echo $content;
                    ?>
                    <div class="footer-item">
                        <div class="fb-page" data-href="https://www.facebook.com/nhungcaunoibathu/" data-tabs="" data-width="" data-height="200px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/nhungcaunoibathu/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/nhungcaunoibathu/">Những Câu Nói Bất Hủ</a></blockquote></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- #colophon -->
<?php 
global $retail_shop_option;	
if ( class_exists( 'WP_Customize_Control' ) ) {
   $retail_shop_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings());  
}
if($retail_shop_option['box_layout']){
	// end of wrapper div
	echo '</div>';
}

wp_footer(); ?>
<a href="tel:<?php echo $hunmendData['PHONE']?>" class="call-now" rel="nofollow">
    <div class="kenit-alo-phone">
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <div class="animated infinite tada kenit-alo-img-circle"></div>
        <span><?php echo $hunmendData['PHONE']?></span>
    </div>
</a>


<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v9.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="111184877432358"
     theme_color="#003d70">
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $(document).on('click', '.btn-menu-mobie , .btn-menu-mobie-hide', function () {
        $('nav.nav-menu').toggle();
    });
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:1
            }
        }
    })
</script>
</body>
</html>