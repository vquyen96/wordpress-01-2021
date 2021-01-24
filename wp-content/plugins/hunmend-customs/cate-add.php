<?php
### Check Whether User Can Manage Polls
if(!current_user_can('mysto_help')) {
    die('Access Denied');
}
global $wpdb;
global $wp;

$cate_id    = ( isset( $_GET['id'] ) ? (int) sanitize_key( $_GET['id'] ) : 0 );
$current_cate =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->help_cate WHERE id = %d", $cate_id));
if ($current_cate == null) {
    $current_cate = [
        'title'     => '',
        'img'       => '',
        'parent_id' => 0
    ];
} else {
    $current_cate = json_decode(json_encode($current_cate), true);
}

$query = "SELECT * FROM $wpdb->help_cate WHERE parent_id = 0 ORDER BY created_at ASC";
$cates = $wpdb->get_results( $query);

### Form Processing
if ( ! empty($_POST['do'] ) ) {
    // Decide What To Do
    switch ( $_POST['do'] ) {
        // Add Poll
        case __( 'Add Category', 'mysto-help' ):
            $text = '';
            $title = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
            if ( ! empty( $title ) ) {
                $created_at = current_time( 'timestamp' );
                if (isset($_FILES['img']) && $_FILES['img']['size'] != 0) {
                    $value = upload_image($_FILES['img']);
                }
                // Insert Category
                $add_category = $wpdb->insert(
                    $wpdb->help_cate,
                    array(
                        'title'             => $title,
                        'img'               => isset($value) ? $value : '',
                        'slug'              => str_slug($title),
                        'parent_id'         => isset( $_POST['parent_id'] ) ? trim( $_POST['parent_id'] ) : 0,
                        'created_at'        => $created_at,
                        'creator_id'        => get_current_user_id(),
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%d',
                        '%d'
                    )
                );
                if ( ! $add_category ) {
                    $text .= '<p style="color: red;">' . sprintf(__('Error In Adding Category \'%s\'.', 'mysto-help'), htmlspecialchars($title, ENT_QUOTES, 'UTF-8')) . '</p>';
                }
            } else {
                $text .= '<p style="color: red;">' . __( 'Category Title is empty.', 'mysto-help' ) . '</p>';
            }
            break;
        // Edit Category
        case __( 'Edit Category', 'mysto-help' ):
            $text = '';
            $title = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
            $cate_id = isset( $_POST['id'] ) ? trim( $_POST['id'] ) : '';
            if ( ! empty( $title ) && ! empty( $cate_id ) ) {
                $updated_at = current_time( 'timestamp' );
                $dataUpdate = [
                    'title'             => $title,
                    'slug'              => str_slug($title),
                    'parent_id'         => isset( $_POST['parent_id'] ) ? trim( $_POST['parent_id'] ) : 0,
                    'updated_at'        => $updated_at,
                ];
                $dataUpdateType = [
                    '%s',
                    '%s',
                    '%d',
                    '%d'
                ];

                if (isset($_FILES['img']) && $_FILES['img']['size'] != 0) {
                    $dataUpdate['img'] = upload_image($_FILES['img']);
                    $dataUpdateType[] = '%s';
                }
                // Update Category
                $add_category = $wpdb->update(
                    $wpdb->help_cate,
                    $dataUpdate,
                    array(
                        'id' => $cate_id
                    ),
                    $dataUpdateType,
                    array(
                        '%d'
                    )
                );

                $current_cate =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->help_cate WHERE id = %d", $cate_id));
                $current_cate = json_decode(json_encode($current_cate), true);

                if ( ! $add_category ) {
                    $text .= '<p style="color: red;">' . sprintf(__('Error In Adding Category \'%s\'.', 'mysto-help'), htmlspecialchars($title, ENT_QUOTES, 'UTF-8')) . '</p>';
                }
            } else {
                $text .= '<p style="color: red;">' . __( 'Category Title is empty.', 'mysto-help' ) . '</p>';
            }
            break;
    }
}

### Add Poll Form
$poll_noquestion = 2;
$count = 0;
?>
<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade">'.($text).'</div>'; } ?>
<style>
    .d-none {
        display: none;
    }
    .w-200 {
        width: 200px;
    }
</style>
<form method="post"  enctype="multipart/form-data">
    <?php wp_nonce_field('wp-polls_add-poll'); ?>
    <div class="wrap">
        <h2><?php $cate_id == 0 ? _e('Add Category', 'mysto-help') : _e('Edit Category', 'mysto-help') ; ?></h2>
        <!-- Poll Question -->
        <h3><?php _e('Category Detail', 'mysto-help'); ?></h3>
        <table class="form-table">
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Title', 'mysto-help') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="id" class="d-none" value="<?php echo $current_cate['id']?>" />
                    <input type="text" size="70" name="title" value="<?php echo $current_cate['title']?>" />
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Image', 'mysto-help') ?></th>
                <td width="80%">
                    <input type="file" class="d-none" name="img" onchange="changeImg(this)">
                    <img src="<?php echo $current_cate['img'] == '' ? home_url( $wp->request ).'/wp-content/plugins/mysto-help/img/default-image.png' : $current_cate['img']?>" alt="" class="w-200 changeImg cursor-pointer">
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Parent Category', 'mysto-help') ?></th>
                <td width="80%">
                    <select name="parent_id" id="">
                        <option value="0">Root</option>
                        <?php foreach($cates as $cate) {
                        ?>
                            <option value="<?php echo $cate->id ?>" <?php echo $current_cate['parent_id'] == $cate->id ? 'selected' : '' ?> ><?php echo $cate->title ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
        </table>
        <p style="text-align: center;">
            <input type="submit" name="do" value="<?php $cate_id == 0 ? _e('Add Category', 'mysto-help') : _e('Edit Category', 'mysto-help') ; ?>"  class="button-primary" />
            &nbsp;&nbsp;
            <input type="button" name="cancel" value="<?php _e('Cancel', 'mysto-help'); ?>" class="button" onclick="javascript:history.go(-1)" />
        </p>
    </div>
</form>
<script>
    jQuery('.changeImg').click(function () {
        jQuery(this).prev().click();
    });
    function changeImg(input)
    {
        console.log(input);
        var inputFile = jQuery(this);
        //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            //Sự kiện file đã được load vào website
            reader.onload = function(e) {
                //Thay đổi đường dẫn ảnh
                // $('#avatar').attr('src',e.target.result);
                jQuery(input).next().attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
