<?php
/**
 * The template for displaying woocommerce pages
 *
 * @since 1.0

 */

get_header(); 

$retail_shop_content = 'col-sm-8 col-md-8 col-lg-9';
$retail_shop_sidebar = '';
if ( ! is_active_sidebar( 'sidebar-woocommerce' ) ) {
	$retail_shop_content = 'col-sm-12 col-md-12 col-lg-12';
	$retail_shop_sidebar = 'hide-content';	
}	
?>

<div class="container background">
   <div class="row">
       <div class="col-sm-8">
           <?php woocommerce_content(); ?>
       </div>
       <div class="col-sm-4">
           <?php include_once 'aside_tab.php'?>
       </div>
  </div>
</div><!-- .container -->

<?php
get_footer();
