<?php
### Check Whether User Can Manage Polls
if(!current_user_can('hunmend-customs')) {
    die('Access Denied');
}
global $wpdb;

if ( ! empty($_POST) ) {
    $dataQues = [
        'answer' => $_POST['answer'],
        'question_title' => $_POST['question_title'],
        'question_content' => $_POST['question_content'],
    ];

    $questionResult = $wpdb->update(
        $wpdb->hunmend_questions,
        $dataQues,
        ['id' => $_GET['id']],
        ['%s', '%s', '%s'],
        ['%d']
    );
}


$question =  $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_questions WHERE id = %d ORDER BY id DESC", $_GET['id']));

?>


<form method="post"  enctype="multipart/form-data" class="form-question">
    <div class="wrap">
        <h2><?php _e('Chi tiết câu hỏi', 'hunmend-customs') ; ?></h2>
        <table class="form-table">
            <tr>
                <th width="20%" scope="row" valign="top" class="form-question-title"><?php _e('Họ tên', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="fullname" value="<?php echo $question->name?>" disabled/>
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top" class="form-question-title"><?php _e('Số điện thoại', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="phone" value="<?php echo $question->phone?>" disabled/>
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top" class="form-question-title"><?php _e('Tuổi thai nhi', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="age" value="<?php echo $question->age?>" disabled/>
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top" class="form-question-title"><?php _e('Miêu tả ngắn gọn câu hỏi', 'hunmend-customs') ?></th>
                <td width="80%">
                    <input type="text" size="70" name="question_title" value="<?php echo $question->question_title?>"/>
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top" class="form-question-title"><?php _e('Chi tiết câu hỏi', 'hunmend-customs') ?></th>
                <td width="80%">
                    <?php wp_editor($question->question_content, 'question_content', ['editor_height' => 300, 'media_buttons' => FALSE, 'quicktags' => false, 'readonly' => true]) ?>
                </td>
            </tr>
            <tr>
                <th width="20%" scope="row" valign="top" class="form-question-title"><?php _e('Trả lời', 'hunmend-customs') ?></th>
                <td width="80%">
                    <?php wp_editor($question->answer, 'answer', ['editor_height' => 300, 'media_buttons' => FALSE,]) ?>
                </td>
            </tr>
        </table>

        <p style="text-align: center;">
            <input type="submit" name="do" value="<?php _e('Update', 'hunmend-customs') ?>"  class="button-primary" />
            &nbsp;&nbsp;
            <input type="button" name="cancel" value="<?php _e('Cancel', 'hunmend-customs'); ?>" class="button" onclick="javascript:history.go(-1)" />
        </p>
    </div>
</form>
