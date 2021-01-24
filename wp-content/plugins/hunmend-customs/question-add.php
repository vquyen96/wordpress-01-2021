<?php
### Check Whether User Can Manage Polls
if(!current_user_can('mysto_help')) {
    die('Access Denied');
}
global $wpdb;

$question_id    = ( isset( $_GET['id'] ) ? (int) sanitize_key( $_GET['id'] ) : 0 );
$current_question =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->help_question WHERE id = %d", $question_id));
if ($current_question == null) {
    $current_question = [
        'title'     => '',
        'content'       => '',
        'cate_id' => 0
    ];
} else {
    $current_question = json_decode(json_encode($current_question), true);
}

$query = "SELECT * FROM $wpdb->help_cate ORDER BY created_at ASC";
$cates = $wpdb->get_results( $query);

$list_cate = [];
$cate_parent_id = null;
foreach ($cates as $cate) {
    if ($cate->parent_id == 0) {
        $list_cate[] = $cate;
        foreach ($cates as $index => $cate_child) {
            if ($cate_child->parent_id == $cate->id) {
                $cate_child->title = ' -- '.$cate_child->title;
                $list_cate[] = $cate_child;
                unset($cates[$index]);
            }
        }
    }
}

### Form Processing
if ( ! empty($_POST['do'] ) ) {
    // Decide What To Do
    switch ( $_POST['do'] ) {
        // Add Question
        case __( 'Add Question', 'mysto-help' ):
            $text = '';
            $title = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
            if ( ! empty( $title ) ) {
                $created_at = current_time( 'timestamp' );

                // Insert Question
                $add_question = $wpdb->insert(
                    $wpdb->help_question,
                    array(
                        'title'             => $title,
                        'slug'              => str_slug($title),
                        'content'           => isset( $_POST['content'] ) ? trim( $_POST['content'] ) : '',
                        'cate_id'           => isset( $_POST['cate_id'] ) ? trim( $_POST['cate_id'] ) : 0,
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
                if ( ! $add_question ) {
                    $text .= '<p style="color: red;">' . sprintf(__('Error In Adding Question \'%s\'.', 'mysto-help'), htmlspecialchars($title, ENT_QUOTES, 'UTF-8')) . '</p>';
                }
            } else {
                $text .= '<p style="color: red;">' . __( 'Question Title is empty.', 'mysto-help' ) . '</p>';
            }
            break;
        // Update Question
        case __( 'Edit Question', 'mysto-help' ):
            $text = '';
            $title = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
            $question_id = isset( $_POST['id'] ) ? trim( $_POST['id'] ) : '';
            if ( ! empty( $title ) && ! empty( $question_id ) ) {
                $updated_at = current_time( 'timestamp' );

                // Update Question
                $add_question = $wpdb->update(
                    $wpdb->help_question,
                    array(
                        'title'             => $title,
                        'slug'              => str_slug($title),
                        'content'           => isset( $_POST['content'] ) ? trim( $_POST['content'] ) : '',
                        'cate_id'           => isset( $_POST['cate_id'] ) ? trim( $_POST['cate_id'] ) : 0,
                        'updated_at'        => $updated_at,
                    ),
                    array(
                        'id' => $question_id
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%d'
                    ),
                    array(
                        '%d'
                    )
                );

                $current_question =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->help_question WHERE id = %d", $question_id));
                $current_question = json_decode(json_encode($current_question), true);

                if ( ! $add_question ) {
                    $text .= '<p style="color: red;">' . sprintf(__('Error In Update Question \'%s\'.', 'mysto-help'), htmlspecialchars($title, ENT_QUOTES, 'UTF-8')) . '</p>';
                }
            } else {
                $text .= '<p style="color: red;">' . __( 'Question Title is empty.', 'mysto-help' ) . '</p>';
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
<form method="post">
    <?php wp_nonce_field('wp-polls_add-poll'); ?>
    <div class="wrap">
        <h2><?php $question_id == 0 ? _e('Add Question', 'mysto-help') : _e('Edit Question', 'mysto-help'); ?></h2>
        <!-- Poll Question -->
        <h3><?php _e('Question Detail', 'mysto-help'); ?></h3>
        <table class="form-table">
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Title', 'mysto-help') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="id" class="d-none" value="<?php echo $current_question['id']?>" />
                    <input type="text" size="70" name="title" value="<?php echo $current_question['title']?>" />
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Content', 'mysto-help') ?></th>
                <td width="80%">
                    <?php
                    wp_editor(
                        $current_question['content'],
                        'content',
                        array(
                            '_content_editor_dfw' => true,
                            'drag_drop_upload'    => true,
                            'tabfocus_elements'   => 'content-html,save-post',
                            'editor_height'       => 300,
                            'tinymce'             => array(
                                'resize'                  => false,
                                'wp_autoresize_on'        => true,
                                'add_unload_trigger'      => false,
                                'wp_keep_scroll_position' => ! true,
                            ),
                        )
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top"><?php _e('Category', 'mysto-help') ?></th>
                <td width="80%">
                    <select name="cate_id" id="">
                        <?php foreach($list_cate as $cate) {
                            ?>
                            <option value="<?php echo $cate->id ?>" <?php echo $current_question['cate_id'] == $cate->id ? 'selected' : '' ?> ><?php echo $cate->title ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

        </table>
        <p style="text-align: center;">
            <input type="submit" name="do" value="<?php $question_id == 0 ? _e('Add Question', 'mysto-help') : _e('Edit Question', 'mysto-help') ; ?>"  class="button-primary" />
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
