<?php

$bannerAside =  $wpdb->get_results( "SELECT * FROM $wpdb->hunmend_banners WHERE type=3");

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

$hunmendQuestions =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_questions WHERE status = %d AND answer != '' ORDER BY id DESC LIMIT 6 ", 1));
$hunmendVideo =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_videos WHERE status = %d ORDER BY id DESC LIMIT 6 ", 1));
$postNews = get_posts([
    'numberposts'       => 5,
    'orderby'           => 'post_date',
    'order'             => 'DESC',
    'post_type'         => 'post',
]);

$postVideos = get_posts([
    'numberposts'       => 4,
    'orderby'           => 'post_date',
    'order'             => 'DESC',
    'post_type'         => 'post',
    'category'          => 37
]);

$listVideos = '(';
foreach ($postVideos as $video) {
    $listVideos .= $video->ID.',';
}
$listVideos .= '0)';

$hunmendVideo =  $wpdb->get_results("SELECT * FROM $wpdb->hunmend_videos WHERE status = 1 AND post_id in ".$listVideos."  ORDER BY id DESC LIMIT 6 ");

?>
<div class="content-right">
    <?php foreach ($bannerAside as $banner) { ?>
    <a href="<?php echo $banner->links?>" class="home-banner-right">
        <img src="<?php echo $banner->value?>" alt="<?php echo $banner->title?>">
    </a>
    <?php } ?>
    <div class="content-right-search">
        <form class="content-right-form" action="<?php echo esc_url( home_url( '/' )) ?>" method="get">
            <label class="screen-reader-text">Tìm kiếmr</label>
            <input type="search" name="s" id="" value="" placeholder="Bạn tìm kiếm gì ...">
            <button type="submit"><span class="fa icon fa-search"></span></button>
        </form>
    </div>
    <div class="content-right-qa">
        <div class="content-right-qa-title">
            HỎI ĐÁP – TƯ VẤN TRỰC TUYẾN
        </div>
        <div class="content-right-qa-main">
            <ul>
                <?php foreach($hunmendQuestions as $question) { ?>
                <li>
                    <a href="<?php echo esc_url( home_url( '/' )) ?>?page=question&id=<?php echo $question->id?>" class="content-right-qa-item">
                        <?php echo $question->question_title?>
                    </a>
                </li>
                <?php } ?>

            </ul>
        </div>
        <a href="<?php echo esc_url( home_url( '/' )) ?>?page=contact" class="content-right-qa-seemore">Xem thêm</a>
    </div>
    <div class="content-right-news">
        <div class="content-right-news-title">
            BÀI VIẾT MỚI NHẤT
        </div>
        <div class="content-right-news-main">
            <ul>
                <?php foreach($postNews as $post) { ?>
                <li>
                    <a href="<?php echo get_permalink($post->ID);?>" class="content-right-news-item">
                        <?php echo cut_string($post->post_title, 100) ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="content-right-btn-qa">
        <a href="<?php echo esc_url( home_url( '/' )) ?>?page=contact" class="">Đặt câu hỏi cho chuyên gia</a>
    </div>
    <div class="content-right-vid">
        <div class="content-right-vid-title">
            Video clips
        </div>
        <div class="content-right-vid-main">
            <div class="content-right-vid-item">
                <?php foreach($hunmendVideo as $index => $video) { ?>
                    <?php if ($index == 0) { ?>
                        <iframe src="https://www.youtube.com/embed/<?php echo $video->youtube_id ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <a href="<?php echo get_permalink($video->post_id);?>" class="content-right-vid-item-name active">
                            <span class="dashicons dashicons-video-alt2"></span>
                            <?php echo cut_string($video->post_title, 60) ?>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo get_permalink($video->post_id);?>" class="content-right-vid-item-name">
                            <span class="dashicons dashicons-video-alt2"></span>
                            <?php echo cut_string($video->post_title, 60) ?>
                        </a>
                <?php } } ?>
            </div>
        </div>
    </div>
</div>
