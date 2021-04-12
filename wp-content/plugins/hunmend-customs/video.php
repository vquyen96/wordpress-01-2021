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

$query = "SELECT * FROM $wpdb->hunmend_questions ORDER BY id DESC";
$listQues =  $wpdb->get_results( $query);
?>

<div class="wrap">
    <div class="question-title d-flex">
        <h1><?php _e('Quản lý câu hỏi', 'hunmend-customs') ; ?></h1>
    </div>
    <div class="question-manages">
        <h3><?php _e('Danh sách câu hỏi', 'hunmend-customs'); ?></h3>
        <table class="widefat">
            <thead>
            <tr>
                <th><?php _e('ID', 'hunmend-customs'); ?></th>
                <th><?php _e('Người hỏi', 'hunmend-customs'); ?></th>
                <th><?php _e('Số điện thoại', 'hunmend-customs'); ?></th>
                <th><?php _e('Câu hỏi', 'hunmend-customs'); ?></th>
                <th colspan="3"><?php _e('Action', 'hunmend-customs'); ?></th>
            </tr>
            </thead>
            <tbody id="manage_polls">
            <?php foreach($listQues as $index => $ques) { ?>
            <tr>
                <td><?php echo $index+1?></td>
                <td><?php echo $ques->name?></td>
                <td><?php echo $ques->phone?></td>
                <td><?php echo $ques->question_title?></td>
                <td>
                    <a href="admin.php?page=hunmend-customs%2Fquestion-detail.php&amp;id=<?php echo $ques->id?>" class="edit"><?php _e('Chi tiết', 'hunmend-customs') ?></a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

