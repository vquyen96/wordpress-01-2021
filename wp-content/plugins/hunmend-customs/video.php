<?php
global $wpdb;
$videoId = ( isset( $_GET['id'] ) ? (int) sanitize_key( $_GET['id'] ) : 0 );

if ($videoId != 0) {
    $postVideo = get_post( $videoId );
}

if (isset($_POST['do']) && $videoId != 0) {
    $hunmendVideo =  $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->hunmend_videos WHERE status = 1 AND post_id = %s",$_POST['post_id']));

    if ($hunmendVideo == null) {
        $videoResult = $wpdb->insert(
            $wpdb->hunmend_videos,
            [
                'post_id' => $_POST['post_id'],
                'youtube_id' => $_POST['links'],
                'post_title' => $postVideo->post_title,
                'sort' => 1,
                'view_count' => 0,
                'status' => 1
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
            ]
        );
    } else {
        $videoResult = $wpdb->update(
            $wpdb->hunmend_videos,
            [
                'post_id' => $_POST['post_id'],
                'youtube_id' => $_POST['links'],
                'post_title' => $postVideo->post_title,
                'sort' => 1,
                'view_count' => 0,
                'status' => 1
            ],
            ['id' => $hunmendVideo->id],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
            ],
            ['%d']
        );
    }
}

$postVideos = get_posts([
    'orderby'           => 'post_date',
    'order'             => 'DESC',
    'post_type'         => 'post',
    'category'          => 37
]);

$query = "SELECT * FROM $wpdb->hunmend_videos ORDER BY id DESC";
$listVid =  $wpdb->get_results( $query);

$listVideos = '(';
foreach ($postVideos as $video) {
    $listVideos .= $video->ID.',';
}
$listVideos .= '0)';

$hunmendVideos =  $wpdb->get_results("SELECT * FROM $wpdb->hunmend_videos WHERE status = 1 AND post_id in ".$listVideos."  ORDER BY id DESC");
$listVideoIds = [];
foreach ($hunmendVideos as $hmVideo) {
    $listVideoIds[$hmVideo->post_id] = $hmVideo->youtube_id;
}

?>

<div class="wrap">
    <div class="question-title d-flex">
        <h1><?php _e('Quản lý video', 'hunmend-customs') ; ?></h1>
    </div>
    <?php if ($videoId != 0) { ?>
    <div class="banner-add-new">
        <form action="" method="post" enctype="multipart/form-data">
            <h3><?php _e('Chỉnh sửa video', 'hunmend-customs'); ?></h3>
            <table class="form-table">
                <tr>
                    <th width="20%" scope="row" valign="top"><?php _e('Tên bài viết', 'hunmend-customs') ?></th>
                    <td width="80%">
                        <input type="text" size="70" name="title" value="<?php echo $postVideo->post_title?>" disabled/>
                        <input type="hidden" size="70" name="post_id" value="<?php echo $postVideo->ID?>"/>
                    </td>
                </tr>
                <tr>
                    <th width="20%" scope="row" valign="top"><?php _e('Youtube ID', 'hunmend-customs') ?></th>
                    <td width="80%">
                        <input type="text" size="70" name="links" value="<?php echo isset($listVideoIds[$postVideo->ID]) ? $listVideoIds[$postVideo->ID] : ''; ?>" />
                    </td>
                </tr>
                <tr>
                    <th width="20%" scope="row" valign="top"></th>
                    <td width="80%">
                        <input type="submit" name="do" value="<?php _e('Cập Nhật', 'hunmend-customs') ; ?>"  class="button-primary" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php }?>
    <div class="question-manages">
        <h3><?php _e('Danh sách video', 'hunmend-customs'); ?></h3>
        <table class="widefat">
            <thead>
            <tr>
                <th><?php _e('ID', 'hunmend-customs'); ?></th>
                <th><?php _e('Bài viết', 'hunmend-customs'); ?></th>
                <th><?php _e('Youtube ID', 'hunmend-customs'); ?></th>
                <th colspan="3"><?php _e('Tùy chọn', 'hunmend-customs'); ?></th>
            </tr>
            </thead>
            <tbody id="manage_polls">
            <?php foreach($postVideos as $index => $hunmendVid) { ?>
            <tr>
                <td><?php echo $index+1?></td>
                <td><?php echo $hunmendVid->post_title?></td>
                <td><?php echo isset($listVideoIds[$hunmendVid->ID]) ? $listVideoIds[$hunmendVid->ID] : ''; ?></td>
                <td>
                    <a href="admin.php?page=hunmend-customs%2Fvideo.php&amp;id=<?php echo $hunmendVid->ID?>" class="edit-vid button-primary"><?php _e('Sửa vid', 'hunmend-customs') ?></a>
                    <a href="post.php?post=<?php echo $hunmendVid->ID?>&action=edit" class="edit-vid buttons"><?php _e('Chi tiết', 'hunmend-customs') ?></a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
