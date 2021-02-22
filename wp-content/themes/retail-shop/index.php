<?php get_header();

global $wpdb;
$count = 10;


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


// Get Tag
$hunmendTags =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s LIMIT 1", "TAG"));
if ($hunmendTags != null && count($hunmendTags) != 0) {
    $valueTagString = $hunmendTags[0]->value;
    $valueTags = json_decode($valueTagString, true);
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

$videoCount =  $wpdb->get_results("SELECT COUNT(*) FROM $wpdb->hunmend_videos");
$total = json_decode(json_encode($videoCount[0]), true)['COUNT(*)'];
$lastPage = floor($total/$count);
$paged = (isset($_GET['paged'])) ? $_GET['paged'] : 1;
$pageName = (isset($_GET['page'])) ? $_GET['page'] : '';
$offset = ($paged-1) * $count;

$questions =  $wpdb->get_results("SELECT * FROM $wpdb->hunmend_questions WHERE answer != '' ORDER BY id DESC LIMIT $count OFFSET $offset");
$videoList =  $wpdb->get_results("SELECT * FROM $wpdb->hunmend_videos ORDER BY id DESC LIMIT $count OFFSET $offset ");
$videoIds = [];



foreach ($videoList as $video) {
    $videoIds[] = $video->post_id;
}

$postVideos = get_posts([
    'numberposts'       => 4,
    'orderby'           => 'post_date',
    'order'             => 'DESC',
    'post_type'         => 'post',
    'include'           => $videoIds
]);

// Contact
if (isset($_POST['do'])) {
    $dataQues = [
            'name' => $_POST['fullname'],
            'phone' => $_POST['phone'],
            'age' => $_POST['age'],
            'question_title' => $_POST['question_title'],
            'question_content' => $_POST['question_content'],
    ];
    $questionResult = $wpdb->insert(
            $wpdb->hunmend_questions,
            $dataQues,
            ['%s','%s','%d','%s','%s']
        );

}

if ($pageName == 'question') {
    $questionId = (isset($_GET['id'])) ? $_GET['id'] : 0;
    if ($questionId == 0) {}

    $question =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_questions WHERE id = %d", $questionId));


}


?>

<div class="container home-content">
    <div class="row">
        <div class="col-sm-8 home-content-left">
            <?php if ($pageName == 'contact') { ?>
                <?php echo $hunmendData['CONTACT_CONTENT']?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-2">
                        <label for="" class="form-question-title"><?php _e('Họ tên', 'hunmend-customs') ?> <span></span></label>
                        <input type="text" name="fullname" value="" class="form-question-input" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-question-title"><?php _e('Số điện thoại', 'hunmend-customs') ?></label>
                        <input type="text" name="phone" value="" class="form-question-input"/>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-question-title"><?php _e('Tuổi thai nhi', 'hunmend-customs') ?></label>
                        <input type="text"  name="age" value="" class="form-question-input"/>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-question-title"><?php _e('Miêu tả ngắn gọn câu hỏi', 'hunmend-customs') ?></label>
                        <input type="text" name="question_title" value="" class="form-question-input"/>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-question-title"><?php _e('Chi tiết câu hỏi', 'hunmend-customs') ?></label>
                        <?php wp_editor('', 'question_content', ['editor_height' => 300]) ?>
                    </div>
                    <div class="form-group mb-2">
                        <input type="submit" name="do" value="<?php _e('Gửi câu hỏi', 'hunmend-customs') ; ?>"  class="form-question-btn" />
                    </div>
                </form>

                <h3>Những câu hỏi thường gặp</h3>
                <div class="question-list">
                    <?php foreach ($questions as $question) { ?>
                    <div class="question-item">
                        <div class="question-title">Câu hỏi: <?php echo $question->question_title ?></div>
                        <div class="question-info">Hỏi bởi <?php echo $question->name ?> lúc 30-06-2020 09:40</div>
                        <div class="question-main">
                            <img src="https://img.icons8.com/cotton/2x/doctor-skin-type-1.png" alt="" class="question-main-img">
                            <div class="question-main-answer">
                                <?php echo cut_string($question->answer, 250) ?>
                                <a href="<?php echo esc_url( home_url( '/' )) ?>?page=question&id=<?php echo $question->id?>">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            <?php } else if ($pageName == 'question') {?>
                <div class="question-detail">
                    <div class="question-detail-main">
                        <h1 class="question-detail-title">
                            <?php echo $question->question_title?>
                        </h1>
                        <div class="question-detail-content">
                            <?php echo $question->question_content?>
                        </div>
                        <div class="answer-detail-title">
                            Trả lời
                        </div>
                        <div class="answer-detail-content">
                            <?php echo $question->answer ?>
                        </div>
                    </div>
                    <div class="post-content-relate">
                        <div class="post-content-relate-title">
                            Bài viết liên quan
                        </div>
                        <div class="post-content-relate-main">
                            <ul>
                                <li>
                                    <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                                </li>
                                <li>
                                    <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                                </li>
                                <li>
                                    <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                                </li>
                                <li>
                                    <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                                </li>
                                <li>
                                    <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                                </li>
                            </ul>
                        </div>
                    </div>
<!--                    <div class="post-content-line"></div>-->
<!--                        <div class="post-content-share">-->
<!--                            <div class="post-content-share-title">-->
<!--                                Chia sẻ của mẹ bầu-->
<!--                            </div>-->
<!--                            <div class="post-content-share-main">-->
<!--                                <ul>-->
<!--                                    <li>-->
<!--                                        <a href="#" class="post-content-share-item">Dành cho những bà mẹ đang chuẩn bị mang thai và mang thai</a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#" class="post-content-share-item">Nhật ký viết cho bé Miu và bé Heo con của mẹ</a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#" class="post-content-share-item">Dành cho những bà mẹ đang chuẩn bị mang thai và mang thai</a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#" class="post-content-share-item">Nhật ký viết cho bé Miu và bé Heo con của mẹ</a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#" class="post-content-share-item">Dành cho những bà mẹ đang chuẩn bị mang thai và mang thai</a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>

            <?php } else if ($pageName == 'video') {?>
                <div class="">
                    <h1 class="list-cate-left-title">
                        Video tư vấn
                    </h1>
                    <?php foreach ($postVideos as $postVid) { ?>
                        <div class="list-cate-item">
                            <div class="list-cate-item-img">
                                <?php if( has_post_thumbnail($postVid->ID) ) { ?>
                                    <div class="post-thumbnail" >
                                        <a href="<?php echo get_permalink($postVid->ID);?>" style="background: url('<?php echo get_the_post_thumbnail_url($postVid->ID,'medium_large') ?>') no-repeat center /cover">
<!--                                            --><?php //the_post_thumbnail('full'); ?>
                                        </a>
                                    </div><!-- .post-thumbnail -->
                                <?php } else { ?>
                                    <div class="post-thumbnail" style="background: #ccc">
                                        <a href="<?php echo get_permalink($postVid->ID);?>">

                                        </a>
                                    </div><!-- .post-thumbnail -->
                                <?php } ?>
                            </div>

                            <div class="list-cate-item-content">
                                <h2 class="entry-title list-cate-item-title">
                                    <a href="<?php echo get_permalink($postVid->ID);?>" rel="bookmark">
                                        <?php echo $postVid->post_title?>
                                    </a>
                                </h2>
                                <p class="list-cate-item-summary">
                                    <?php echo cut_string(get_the_excerpt($postVid->ID), 300) ; ?>
                                </p>
                                <a href="<?php echo get_permalink($postVid->ID);?>" class="list-cate-item-seemore">Xem chi tiết >></a>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                        paginate($lastPage, $paged, esc_url( home_url( '/' )).'?'.'page=video')
                    ?>
                </div>

            <?php } else {?>
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
                <div class="home-top-small home-top-tag ">
                    <div class="tag-image">
                        <img src="https://omnghen.vn/html/destop/images/ic-mbth.jpg" alt="">
                    </div>
                    <div class="tag-main">
                        <? foreach ($valueTags as $tag) { ?>
                            <a href="<?php echo $tag['url'] ?>" class="tag-item">
                                <?php echo $tag['title'] ?>
                            </a>
                        <?php } ?>
                    </div>
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
