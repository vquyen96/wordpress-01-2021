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
           <div class="content-right">
               <a href="#" class="home-banner-right">
                   <img src="https://dinhduongbabau.net/wp-content/uploads/2020/02/tang-suc-de-khang-ba-bau-mua-dich-covid19.jpg" alt="">
               </a>
               <a href="#" class="home-banner-right">
                   <img src="https://dinhduongbabau.net/wp-content/uploads/2019/01/y-dinh-duong-ba-bau.jpg" alt="">
               </a>
               <a href="#" class="home-banner-right">
                   <img src="https://dinhduongbabau.net/wp-content/uploads/2018/08/widget-ddbb-e1533622168600.jpg" alt="">
               </a>
               <div class="content-right-search">
                   <form class="content-right-form" action="http://localhost:6060/" method="get">
                       <select class="d-none" name="product_cat">
                           <option value="0" selected>All Categories</option>
                       </select>

                       <label class="screen-reader-text">Tìm kiếmr</label>
                       <input type="search" name="s" id="" value="" placeholder="Bạn tìm kiếm gì ...">
                       <button type="submit"><span class="fa icon fa-search"></span></button>
                       <input type="hidden" name="post_type" value="product">
                   </form>
               </div>
               <div class="content-right-qa">
                   <div class="content-right-qa-title">
                       HỎI ĐÁP – TƯ VẤN TRỰC TUYẾN
                   </div>
                   <div class="content-right-qa-main">
                       <ul>
                           <li>
                               <a href="#" class="content-right-qa-item">
                                   E be nhe can hon so voi tuoi thai
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-qa-item">
                                   Bà bầu khó thở, làm gì để giảm bớt?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-qa-item">
                                   Bí quyết nhận biết Omega 3 loại nào tốt nhất?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-qa-item">
                                   Thuốc procare cho bà bầu của nước nào?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-qa-item">
                                   Bà bầu khó thở, làm gì để giảm bớt?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-qa-item">
                                   Bí quyết nhận biết Omega 3 loại nào tốt nhất?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-qa-item">
                                   Thuốc procare cho bà bầu của nước nào?
                               </a>
                           </li>
                       </ul>
                   </div>
                   <a href="#" class="content-right-qa-seemore">Xem thêm</a>
               </div>
               <div class="content-right-news">
                   <div class="content-right-news-title">
                       BÀI VIẾT MỚI NHẤT
                   </div>
                   <div class="content-right-news-main">
                       <ul>
                           <li>
                               <a href="#" class="content-right-news-item">
                                   Chế độ dinh dưỡng thế nào để phòng chống thiếu máu khi mang thai?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-news-item">
                                   Bà bầu khó thở, làm gì để giảm bớt?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-news-item">
                                   Bí quyết nhận biết Omega 3 loại nào tốt nhất?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-news-item">
                                   Thuốc procare cho bà bầu của nước nào?
                               </a>
                           </li>
                           <li>
                               <a href="#" class="content-right-news-item">
                                   Bà bầu khó thở, làm gì để giảm bớt?
                               </a>
                           </li>
                       </ul>
                   </div>
               </div>
               <div class="content-right-btn-qa">
                   <a href="#" class="">Đặt câu hỏi cho chuyên gia</a>
               </div>
               <div class="content-right-vid">
                   <div class="content-right-vid-title">
                       Video clips
                   </div>
                   <div class="content-right-vid-main">
                       <div CLASS="content-right-vid-item">
                           <iframe src="https://www.youtube.com/embed/3SJ-9414U1o" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                           <div class="content-right-vid-item-name">
                               <span class="dashicons dashicons-video-alt2"></span>
                               Tự tin đảm bảo dinh dưỡng “ĐỦ-ĐÚNG” tốt nhất cho con khi mang thai
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
  </div>
</div><!-- .container -->

<?php
get_footer();
