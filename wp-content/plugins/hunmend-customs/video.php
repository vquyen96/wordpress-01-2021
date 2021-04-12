<?php
global $wpdb;

if (isset($_POST['do']) && $bannerId == 0) {
    if ($bannerUrl == null) {
        $alertError = "Hình ảnh không được để trống";
    }
    $dataBanner = [
        'title' => $_POST['title'],
        'value' => $bannerUrl,
        'links' => $_POST['links'],
        'sort'  => 1,
        'type'  => $_POST['type'],
        'status'=> 1
    ];
    $bannerResult = $wpdb->insert(
        $wpdb->hunmend_banners,
        $dataBanner,
        [
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
        ]
    );
} else if (isset($_POST['do']) && $bannerId != 0) {
    $dataBanner = [
        'title' => $_POST['title'],
        'links' => $_POST['links'],
        'sort'  => 1,
        'type'  => $_POST['type'],
        'status'=> 1
    ];
    $dataType = [
        '%s',
        '%s',
        '%d',
        '%d',
        '%d',
    ];
    if ($bannerUrl != null) {
        $dataBanner['value'] = $bannerUrl;
        $dataType[] = '%s';
    }

    $bannerResult = $wpdb->update(
        $wpdb->hunmend_banners,
        $dataBanner,
        ['id' => $bannerId],
        $dataType,
        ['%d']
    );
}

$postVideos = get_posts([
    'orderby'           => 'post_date',
    'order'             => 'DESC',
    'post_type'         => 'post',
    'category'          => 37
]);

$query = "SELECT * FROM $wpdb->hunmend_videos ORDER BY id DESC";
$listVid =  $wpdb->get_results( $query);


?>

<div class="wrap">
    <div class="question-title d-flex">
        <h1><?php _e('Quản lý video', 'hunmend-customs') ; ?></h1>
    </div>
    <div class="question-manages">
        <h3><?php _e('Danh sách video', 'hunmend-customs'); ?></h3>
        <table class="widefat">
            <thead>
            <tr>
                <th><?php _e('ID', 'hunmend-customs'); ?></th>
                <th><?php _e('Bài viết', 'hunmend-customs'); ?></th>
                <th><?php _e('Video', 'hunmend-customs'); ?></th>
                <th colspan="3"><?php _e('Tùy chọn', 'hunmend-customs'); ?></th>
            </tr>
            </thead>
            <tbody id="manage_polls">
            <?php foreach($postVideos as $index => $postVid) { ?>
            <tr>
                <td><?php echo $index+1?></td>
                <td><?php echo $postVid->post_title?></td>
                <td><?php echo $postVid->post_title?></td>
                <td>
                    <button class="edit-vid"><?php _e('Sửa vid', 'hunmend-customs') ?></button>
                    <button class="detail-post"><?php _e('Chi tiết', 'hunmend-customs') ?></button>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
