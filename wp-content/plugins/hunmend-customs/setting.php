<?php
include_once ('hunmend-enum.php');
### Check Whether User Can Manage Polls
if(!current_user_can('hunmend-customs')) {
    die('Access Denied');
}
global $wpdb;

$hunmendCustoms =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE status = %d ORDER BY sort ASC", 1));
$hunmendData = [];
$listIsArray = ['NAV_HEADER', 'POST_TOP', 'FEATURE'];
if (count($hunmendCustoms) != 0) {
    foreach ($hunmendCustoms as $hunmend) {
        if (in_array($hunmend->name, $listIsArray)) {
            $hunmendData[$hunmend->name][] = $hunmend->value;
        } else {
            $hunmendData[$hunmend->name] = $hunmend->value;
        }
    }
}

$args = array(
    'taxonomy' => 'category',
    'orderby' => 'term_id',
    'order' => 'ASC',
    'parent' => 0
);
$cats = get_categories($args);


$args = [
    'numberposts'      => 50,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'post',
];
$list_post_top = get_posts($args);
//print_r($list_post_top[0]);


if ( ! empty($_POST['do'] ) ) {
    print_r($_POST);

}
?>


<form method="post"  enctype="multipart/form-data">
    <?php wp_nonce_field('wp-polls_add-poll'); ?>
    <div class="wrap">
        <h2><?php _e('Cài đặt hệ thống', 'hunmend-customs') ; ?></h2>
        <!-- Poll Question -->
        <h3><?php _e('Cài đặt chung', 'hunmend-customs'); ?></h3>
        <table class="form-table">
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
        </table>

        <h3><?php _e('Sắp xếp menu đầu trang', 'hunmend-customs'); ?></h3>
        <table class="form-table">
            <?php for ($i = 0; $i < count($hunmendData['NAV_HEADER']); $i++) { ?>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Menu thứ '.($i+1), 'hunmend-customs') ?></th>
                <td width="80%">
                    <select name="NAV_HEADER[]" id="">
                        <?php foreach ($cats as $cat) { ?>
                        <option value="<?php echo $cat->term_id ?>" <?php echo $cat->term_id == $hunmendData['NAV_HEADER'][$i] ? 'selected' : '' ?>><?php echo $cat->name ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>

        </table>

        <h3><?php _e('Sắp xếp tiêu đề', 'hunmend-customs'); ?></h3>
        <table class="form-table">
            <?php for ($i = 0; $i < count($hunmendData['FEATURE']); $i++) { ?>
                <tr>
                    <th width="20%" scope="row" valign="top"><?php _e('Tiêu đề thứ '.($i+1), 'hunmend-customs') ?></th>
                    <td width="80%">
                        <select name="FEATURE[]" id="">
                            <?php foreach ($cats as $cat) { ?>
                                <option value="<?php echo $cat->term_id ?>" <?php echo $cat->term_id == $hunmendData['FEATURE'][$i] ? 'selected' : '' ?>><?php echo $cat->name ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            <?php } ?>

        </table>

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

        <p style="text-align: center;">
            <input type="submit" name="do" value="<?php _e('Update', 'hunmend-customs') ?>"  class="button-primary" />
            &nbsp;&nbsp;
            <input type="button" name="cancel" value="<?php _e('Cancel', 'hunmend-customs'); ?>" class="button" onclick="javascript:history.go(-1)" />
        </p>
    </div>
</form>
