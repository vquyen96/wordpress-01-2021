<?php
include_once ('hunmend-enum.php');
### Check Whether User Can Manage Polls
if(!current_user_can('hunmend-customs')) {
    die('Access Denied');
}
global $wpdb;
$dataName = "TAG";


if ( ! empty($_POST) ) {
    $tagIndex = 0;
    $tagValue = [];
    $tagSort = [];
    while (isset($_POST['tag-'.$tagIndex])) {
        $tagValue[] = $_POST['tag-'.$tagIndex];
        $tagSort[$_POST['tag-'.$tagIndex]['title']] = $_POST['tag-'.$tagIndex]['sort'];
        $tagIndex++;
    }

    asort($tagSort);
    $tagIndexNew = 1;
    $tagValueSorted = [];
    $tagValueIndexAdded = [];
    foreach ($tagSort as $tagTitle => $tagItemSort){
        foreach($tagValue as $tagValueIndex => $tagValueItem) {
            if ($tagValueItem['title'] == $tagTitle && !in_array($tagValueIndex, $tagValueIndexAdded)) {
                $tagValueItem['sort'] = $tagIndexNew;
                $tagValueSorted[] = $tagValueItem;
                $tagValueIndexAdded[] = $tagValueIndex;
            }
        }
        $tagIndexNew++;
    }

    $tagValueSortedString = json_encode($tagValueSorted, true);

    $settingTag = $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s", $dataName));
    $updated_at = current_time( 'timestamp' );
    $dataUpdate = [
        'name'              => $dataName,
        'value'             => $tagValueSortedString,
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
            'id' => $settingTag->id
        ),
        $dataUpdateType,
        array(
            '%d'
        )
    );
}


$hunmendTags =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s LIMIT 1", "TAG"));

if ($hunmendTags == null || count($hunmendTags) == 0) {
    $valueTag = [
        [
            "title" => "example",
            "url" => "http://google.com",
            "sort" => 1
        ],
        [
            "title" => "example",
            "url" => "http://google.com",
            "sort" => 2
        ]
    ];
    $valueTagString = json_encode($valueTag);
    $wpdb->insert($wpdb->hunmend_customs, array('name' => __('TAG', 'hunmend-customs'), 'value' => $valueTagString, 'status' => 1), array('%s', '%s', '%d'));

    $hunmendTags =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s", "TAG"));
}


$valueTagString = $hunmendTags[0]->value;
$valueTags = json_decode($valueTagString, true);

?>


<form method="post"  enctype="multipart/form-data">
    <?php wp_nonce_field('wp-polls_add-poll'); ?>
    <div class="wrap">
        <h2><?php _e('Cài đặt Tag', 'hunmend-customs') ; ?></h2>
        <!-- Poll Question -->
        <table class="wp-list-table table-tag">
            <tr>
                <th width="20%" scope="row" valign="top">
                    <?php _e('Tiêu đề', 'hunmend-customs') ; ?>
                </th>
                <th width="50%">
                    <?php _e('URL', 'hunmend-customs') ; ?>
                </th>
                <th width="20%">
                    <?php _e('Thứ tự', 'hunmend-customs') ; ?>
                </th>
                <th width="10%">
                    <?php _e('Thứ tự', 'hunmend-customs') ; ?>
                </th>
            </tr>
            <?php $nextIndex = 1;?>
            <?php foreach ($valueTags as $index => $tag) { ?>
            <tr class="table-tag-item">
                <th width="20%" scope="row" valign="top">
                    <input type="text" name="tag-<?php echo $index ?>[title]" value="<?php echo $tag['title']?>" style="width: 100%" class='inputTagTitle'/>
                </th>
                <td width="50%">
                    <input type="text" width="100%" name="tag-<?php echo $index ?>[url]" value="<?php echo $tag['url']?>" style="width: 100%" class='inputTagUrl'/>
                </td>
                <td width="20%">
                    <input type="text" name="tag-<?php echo $index ?>[sort]" value="<?php echo $tag['sort']?>" style="width: 100%" class='inputTagSort'/>
                </td>
                <td width="10%">
                    <button class="button del-tag" >
                        <span class="dashicons dashicons-trash"></span>
                    </button>
                </td>
            </tr>
            <?php $nextIndex = $index+1; } ?>
        </table>

        <p style="text-align: center;">
            <input type="button" name="do" value="<?php _e('Thêm mới', 'hunmend-customs') ?>"  class="button button-success" id="add_new_tag"/>
            &nbsp;&nbsp;
            <input type="submit" name="do" value="<?php _e('Cập nhật', 'hunmend-customs') ?>"  class="button-primary" />
        </p>
    </div>
</form>

<script>
    jQuery(document).ready( function () {
        var nextIndex = <?php echo $nextIndex; ?>;
        jQuery(document).on("click", "#add_new_tag", function () {
            var newTag = "<tr class=\"table-tag-item\">\n" +
                "                <th width=\"20%\" scope=\"row\" valign=\"top\">\n" +
                "                    <input type=\"text\" name=\"tag-"+nextIndex+"[title]\" value=\"\" style=\"width: 100%\" class='inputTagTitle'/>\n" +
                "                </th>\n" +
                "                <td width=\"50%\">\n" +
                "                    <input type=\"text\" width=\"100%\" name=\"tag-"+nextIndex+"[url]\" value=\"\" style=\"width: 100%\"  class='inputTagUrl'/>\n" +
                "                </td>\n" +
                "                <td width=\"20%\">\n" +
                "                    <input type=\"text\" name=\"tag-"+nextIndex+"[sort]\" value=\"\" style=\"width: 100%\" class='inputTagSort' />\n" +
                "                </td>\n" +
                "                <td width=\"10%\">\n" +
                "                    <button class=\"button del-tag\" >\n" +
                "                        <span class=\"dashicons dashicons-trash\"></span>\n" +
                "                    </button>\n" +
                "                </td>" +
                "            </tr>";
            jQuery("table.table-tag").append(newTag);
            nextIndex+=1;
            var listTagTable = jQuery('.table-tag-item');
            for (var i = 0; i < listTagTable.length; i++) {
                listTagTable.eq(i).find('.inputTagTitle').attr("name", "tag-"+i+"[title]");
                listTagTable.eq(i).find('.inputTagUrl').attr("name", "tag-"+i+"[url]");
                listTagTable.eq(i).find('.inputTagSort').attr("name", "tag-"+i+"[sort]");
            }
        });

        jQuery(document).on("click", ".del-tag", function () {
            jQuery(this).parents("tr").remove();
            var listTagTable = jQuery('.table-tag-item');
            for (var i = 0; i < listTagTable.length; i++) {
                listTagTable.eq(i).find('.inputTagTitle').attr("name", "tag-"+i+"[title]");
                listTagTable.eq(i).find('.inputTagUrl').attr("name", "tag-"+i+"[url]");
                listTagTable.eq(i).find('.inputTagSort').attr("name", "tag-"+i+"[sort]");
            }
        })
    })

</script>
