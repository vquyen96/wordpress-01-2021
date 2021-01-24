<?php get_header();

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


$list_exclude = [];

$args = [
    'numberposts'      => 50,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'post',
];
$list_post_new = get_posts($args);
$list_post_top = [];
foreach ($hunmendData['POST_TOP'] as $postIds) {
    foreach ($list_post_new as $postItem) {
        if ($postItem->ID == $postIds) {
            $list_post_top[] = $postItem;
        }
    }
}

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
);
$cats = get_categories($args);
$listCateHome = [];
foreach ($hunmendData['CATE_HOME'] as $cateId) {
    foreach ($cats as $cate) {
        if ($cate->cat_ID == $cateId) {
            $listCateHome[] = $cate;
        }
    }
}

$list_post_cate = [];
for ($i = 0; $i < count($listCateHome); $i++) {
    $list_post = [];
    $list_post['cate_title'] = $listCateHome[$i]->name;
    $list_post['cate_id'] = $listCateHome[$i]->cat_ID;

    $list_post['posts'] = get_posts([
        "category"          => $listCateHome[$i]->cat_ID,
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
            <?php include_once 'aside_tab.php'?>
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
