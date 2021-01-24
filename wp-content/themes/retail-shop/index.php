<?php get_header();

$list_exclude = [];

$args = [
    'numberposts'      => 6,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'post',
];
$list_post_top = get_posts($args);
//print_r(get_permalink($list_post_top[0]->ID));
foreach ($list_post_top as $postItem) {
    $list_exclude[] = $postItem->ID;
}

$args = array(
    'taxonomy' => 'category',
    'orderby' => 'term_id',
    'order' => 'ASC',
    'show_count' => 1,
    'pad_counts' => 0,
    'hierarchical' => 0,
    'title_li' => '',
    'number' => 6,
);
$cats = get_categories($args);

$list_post_cate = [];
for ($i = 0; $i < 6; $i++) {
    $list_post = [];
    $list_post['cate_title'] = $cats[$i]->name;
    $list_post['cate_id'] = $cats[$i]->cat_ID;

    $list_post['posts'] = get_posts([
        "category"          => $cats[$i]->cat_ID,
        'numberposts'       => 4,
        'orderby'           => 'post_date',
        'order'             => 'DESC',
        'post_type'         => 'post',
        'exclude'           => $list_exclude
    ]);
    $list_post_cate[] = $list_post;
    foreach ($list_post['posts'] as $postItem) {
        $list_exclude[] = $postItem->ID;
    }
}

$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);

$product_categories = get_terms( 'product_cat', $cat_args );

print_r($product_categories);
?>

<div class="container home-content">
    <div class="row">
        <div class="col-sm-8 home-content-left">
            <div class="home-top">
                <div class="home-top-big owl-carousel owl-theme">
                    <?php for ($i = 0; $i < 3; $i++) {?>
                    <div class="home-top-big-item">
                        <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-big-img"
                             style="background: url('<?php echo get_the_post_thumbnail_url($list_post_top[$i]->ID,'medium_large') ?>') no-repeat center /cover">
                        </a>
                        <div class="home-top-big-left">
                            <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-big-title">
                                <?php echo $list_post_top[$i]->post_title?>
                            </a>
                            <div class="home-top-big-summary">
                                <?php echo cut_string(get_the_excerpt($list_post_top[$i]->ID), 300)?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="home-top-small">
                    <?php for ($i = 3; $i < 6; $i++) {?>
                    <div class="home-top-small-item">
                        <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-small-img" style="background: url('<?php echo get_the_post_thumbnail_url($list_post_top[$i]->ID,'thumbnail') ?>') no-repeat center /cover"></a>
                        <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-small-title"><?php echo $list_post_top[$i]->post_title?></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php for ($i = 0; $i < 6; $i++) {?>
            <div class="home-cate">
                <a href="<?php echo get_category_link($list_post_cate[$i]['cate_id']); ?>" class="home-cate-title">
                    <?php print_r($list_post_cate[$i]['cate_title']) ; ?>
                </a>
                <?php if (isset($list_post_cate[$i]['posts'][0])) {?>
                <div class="home-cate-main">
                    <div class="home-cate-big">
                        <div class="home-cate-big-left">
                            <a href="<?php echo get_permalink($list_post_cate[$i]['posts'][0]->ID);?>" class="home-cate-big-img" style="background: url('<?php echo get_the_post_thumbnail_url($list_post_cate[$i]['posts'][0]->ID,'medium') ?>') no-repeat center /cover"></a>
                        </div>
                        <div class="home-cate-big-right">
                            <a href="<?php echo get_permalink($list_post_cate[$i]['posts'][0]->ID);?>" class="home-cate-big-title">
                                <?php echo $list_post_cate[$i]['posts'][0]->post_title ?>
                            </a>
                            <div class="home-cate-big-summary">
                                <?php echo cut_string(get_the_excerpt($list_post_cate[$i]['posts'][0]->ID), 250)?>
                            </div>
                        </div>
                    </div>
                    <div class="home-cate-small">
                        <ul>
                            <?php for ($j = 1; $j < count($list_post_cate[$i]['posts']) ; $j++) {?>
                            <li>
                                <a href="<?php echo get_permalink($list_post_cate[$i]['posts'][$j]->ID);?>" class="home-cate-small-title">
                                    <?php echo $list_post_cate[$i]['posts'][$j]->post_title ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
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
<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
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
