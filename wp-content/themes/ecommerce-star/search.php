<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ecommerce-star
 * @since 1.0
 */

get_header(); ?>
<div class="container search-background">
  <div class="row">
    <div id="primary" class="col-md-8 col-sm-8 content-area">
      <main id="main" class="site-main search" role="main">
        <?php
		if ( have_posts() ) :
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				if ( is_page() ) {
				
				  echo '<div class="multiple-content">';
					 get_template_part( 'template-parts/page/content', 'excerpt' );
				  echo '</div>';	
				} else {
				
				  echo '<div class="multiple-content">';				
					 get_template_part( 'template-parts/post/content', 'excerpt' );
				  echo '</div>';			
				}	

			endwhile; // End of the loop.

			the_posts_pagination(
				array(
					'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'ecommerce-star' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'ecommerce-star' ) . '</span> <span class="nav-title"><span>' . '<i class="fa fa-arrow-left" aria-hidden="true" ></i>' . '<span class="nav-title nav-margin-left" >'.__( 'View', 'ecommerce-star' ).'</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'ecommerce-star' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'ecommerce-star' ) . '</span> <span class="nav-title">'.__( 'View', 'ecommerce-star' ).'<span class="nav-margin-right"></span>' . '<i class="fa fa-arrow-right" aria-hidden="true"></i>'  . '</span>',
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'ecommerce-star' ) . ' </span>',
				)
			);

		else :
		?>
        <p>
          <?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ecommerce-star' ); ?>
        </p>
        <?php
				get_search_form();
		endif;
		?>
      </main>
      <!-- #main -->
    </div>
    <!-- #primary -->
    <div class="col-md-4 col-sm-4">
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
</div>
<!-- .container -->
<?php
get_footer();