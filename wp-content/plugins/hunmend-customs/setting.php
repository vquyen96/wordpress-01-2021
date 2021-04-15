<?php
include_once ('hunmend-enum.php');
### Check Whether User Can Manage Polls
if(!current_user_can('hunmend-customs')) {
    die('Access Denied');
}
global $wpdb;


$dataType = [
    'COLOR_1'         => 'single',
    'COLOR_2'         => 'single',
    'COLOR_3'         => 'single',
    'PHONE'         => 'single',
    'FB_PAGE'       => 'single',
    'CONTACT_CONTENT' => 'single',
    'FEATURE_TITLE' => 'single',
    'NAV_HEADER'    => 'list',
//    'FEATURE'       => 'list',
    'POST_TOP'      => 'list',
    'CATE_HOME'     => 'list',
];
if ( ! empty($_POST) ) {
    foreach ($dataType as $dataName => $dataType) {
        if ($dataType == 'single') {
            if (isset($_POST[$dataName])) {
                $setting = $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s", $dataName));
                if ($setting != null) {
                    $updated_at = current_time( 'timestamp' );
                    $dataUpdate = [
                        'name'              => $dataName,
                        'value'             => $_POST[$dataName],
                        'updated_at'        => $updated_at,
                    ];
                    $dataUpdateType = [
                        '%s',
                        '%s',
                        '%d'
                    ];

                    $update_setting = $wpdb->update(
                        $wpdb->hunmend_customs,
                        $dataUpdate,
                        array(
                            'id' => $setting->id
                        ),
                        $dataUpdateType,
                        array(
                            '%d'
                        )
                    );
                }
            }
        }

        if ($dataType == 'list') {
            $settings = $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s", $dataName));
            for($i = 0; $i < count($settings); $i++) {
                $updated_at = current_time( 'timestamp' );
                $dataUpdate = [
                    'name'              => $dataName,
                    'value'             => $_POST[$dataName][$i],
                    'sort'              => ($i+1),
                    'updated_at'        => $updated_at,
                ];
                $dataUpdateType = [
                    '%s',
                    '%s',
                    '%d',
                    '%d',
                ];

                $update_setting = $wpdb->update(
                    $wpdb->hunmend_customs,
                    $dataUpdate,
                    array(
                        'id' => $settings[$i]->id
                    ),
                    $dataUpdateType,
                    array(
                        '%d'
                    )
                );
            }
        }

    }
}


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

$catHeaders = get_categories([
    'taxonomy' => 'category',
    'orderby' => 'term_id',
    'order' => 'ASC',
    'parent' => 0
]);
$catFeatures = get_categories([
    'taxonomy' => 'category',
    'orderby' => 'term_id',
    'order' => 'ASC',
]);


$args = [
    'numberposts'      => 50,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'post',
];
$list_post_top = get_posts($args);



?>


<form method="post"  enctype="multipart/form-data">
    <?php wp_nonce_field('wp-polls_add-poll'); ?>
    <div class="wrap">
        <h2><?php _e('Cài đặt hệ thống', 'hunmend-customs') ; ?></h2>
        <!-- Poll Question -->
        <h3><?php _e('Cài đặt chung', 'hunmend-customs'); ?></h3>
        <table class="form-table">
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Màu sắc 1', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="color" size="70" name="COLOR_1" value="<?php echo $hunmendData['COLOR_1']?>" />
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Màu sắc 2', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="color" size="70" name="COLOR_2" value="<?php echo $hunmendData['COLOR_2']?>" />
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Màu sắc 3', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="color" size="70" name="COLOR_3" value="<?php echo $hunmendData['COLOR_3']?>" />
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Số điện thoại', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="PHONE" value="<?php echo $hunmendData['PHONE']?>" />
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Link page Facebook', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="FB_PAGE" value="<?php echo $hunmendData['FB_PAGE']?>" />
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Đặt câu hỏi', 'hunmend-customs') ?></th>
                <td width="80%">
                    <?php wp_editor($hunmendData['CONTACT_CONTENT'], 'CONTACT_CONTENT', ['editor_height' => 300, 'media_buttons' => FALSE, 'quicktags' => false, 'readonly' => true]) ?>
                </td>
            </tr>
        </table>

        <h3><?php _e('Sắp xếp menu đầu trang', 'hunmend-customs'); ?></h3>
        <table class="form-table">
            <?php for ($i = 0; $i < count($hunmendData['NAV_HEADER']); $i++) { ?>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Menu thứ '.($i+1), 'hunmend-customs') ?></th>
                <td width="80%">
                    <select name="NAV_HEADER[]" id="">
                        <?php foreach ($catHeaders as $cat) { ?>
                        <option value="<?php echo $cat->term_id ?>" <?php echo $cat->term_id == $hunmendData['NAV_HEADER'][$i] ? 'selected' : '' ?>><?php echo $cat->name ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>

        </table>

        <h3><?php _e('Tiêu điểm', 'hunmend-customs'); ?></h3>
        <table class="form-table">
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Tiêu đề', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="FEATURE_TITLE" value="<?php echo $hunmendData['FEATURE_TITLE']?>" />
                </td>
            </tr>
        </table>


        <?php if (isset($hunmendData['POST_TOP'])) { ?>
            <h3><?php _e('Sắp xếp bài viết hot', 'hunmend-customs'); ?></h3>
            <table class="form-table">
                <?php for ($i = 0; $i < count($hunmendData['POST_TOP']); $i++) { ?>
                    <tr>
                        <th width="20%" scope="row" valign="top"><?php _e('Tiêu đề thứ '.($i+1), 'hunmend-customs') ?></th>
                        <td width="80%">
                            <select name="POST_TOP[]" id="">
                                <?php foreach ($list_post_top as $post) { ?>
                                    <option value="<?php echo $post->ID ?>" <?php echo $post->ID == $hunmendData['POST_TOP'][$i] ? 'selected' : '' ?>><?php echo $post->post_title ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>


        <?php if (isset($hunmendData['CATE_HOME'])) { ?>
            <h3><?php _e('Sắp xếp danh mục nổi bật', 'hunmend-customs'); ?></h3>
            <table class="form-table">
                <?php for ($i = 0; $i < count($hunmendData['CATE_HOME']); $i++) { ?>
                    <tr>
                        <th width="20%" scope="row" valign="top"><?php _e('Danh mục thứ '.($i+1), 'hunmend-customs') ?></th>
                        <td width="80%">
                            <select name="CATE_HOME[]" id="">
                                <?php foreach ($catFeatures as $cat) { ?>
                                    <option value="<?php echo $cat->term_id ?>" <?php echo $cat->term_id == $hunmendData['CATE_HOME'][$i] ? 'selected' : '' ?>><?php echo $cat->name ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <p style="text-align: center;">
            <input type="submit" name="do" value="<?php _e('Update', 'hunmend-customs') ?>"  class="button-primary" />
            &nbsp;&nbsp;
            <input type="button" name="cancel" value="<?php _e('Cancel', 'hunmend-customs'); ?>" class="button" onclick="javascript:history.go(-1)" />
        </p>
    </div>
</form>
