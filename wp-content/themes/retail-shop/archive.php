<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ecommerce-star
 * @since 1.0
 */
get_header();

//global $wpdb;
//$questions = $wpdb->get_results(
//    $wpdb->prepare(
//        "SELECT
//                    c.title as cate_title,
//                    c.parent_id,
//                    q.title,
//                    q.id,
//                    q.cate_id
//                FROM $wpdb->help_cate AS c
//                INNER JOIN $wpdb->help_question as q
//                ON c.id = q.cate_id
//                WHERE  c.parent_id = $cate_id
//                    OR q.cate_id = $cate_id
//                ORDER BY q.cate_id ASC"
//    )
//);
$args = [
    'category' => 24
];

$list_post = get_posts($args);

$cate = get_category(24);
global $ecommerce_star_option;
if ( class_exists( 'WP_Customize_Control' ) ) {
   $ecommerce_star_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings());  
}
?>

<div class="list-cate container">
    <div class="row">
        <div class="col-sm-8">
            <div class="list-cate-left">
                <h1 class="list-cate-left-title">
                    <?php echo $cate->name ?>
                </h1>
                <?php foreach ($list_post as $post) { ?>
                <div class="list-cate-item">
                    <div class="list-cate-item-img">
                        <a href="#" class="list-cate-item-img-main"
                           style="background: url('https://dinhduongbabau.net/wp-content/uploads/2020/12/khi-chuan-bi-dinh-duong-mang-thai-ban-dung-quen-ru-chong-cung-tham-gia-nhe-240x180.jpg') no-repeat center /cover"></a>
                    </div>

                    <div class="list-cate-item-content">
                        <a href="#" class="list-cate-item-title">
                            Chế độ ăn uống ảnh hưởng thế nào tới khả năng sinh sản?
                        </a>
                        <p class="list-cate-item-summary">
                            Chắc hẳn bạn đã từng nghe rất nhiều lời khuyên về chế độ ăn uống,, bổ sung dưỡng chất khi chuẩn bị mang thai. Vậy cụ thể chế độ dinh dưỡng ảnh hưởng thế nào tới khả năng sinh sản? Cùng dinh dưỡng bà bầu tìm hiểu nhé! Các nhà nghiên cứu từ …
                        </p>
                        <a href="#" class="list-cate-item-seemore">Xem chi tiết >></a>
                    </div>
                </div>
                <?php } ?>
            </div>
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
</div>
<?php
get_footer();
?>
