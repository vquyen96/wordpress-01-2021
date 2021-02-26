<?php
include_once ('hunmend-enum.php');
### Check Whether User Can Manage Polls
if(!current_user_can('hunmend-customs')) {
    die('Access Denied');
}
global $wpdb;
$dataName = "SUB_MENU";


if ( ! empty($_POST) ) {
    $smenuIndex = 0;
    $smenuValue = [];
    $smenuSort = [];
    while (isset($_POST['smenu-'.$smenuIndex])) {
        $smenuValue[] = $_POST['smenu-'.$smenuIndex];
        $smenuSort[$_POST['smenu-'.$smenuIndex]['title']] = $_POST['smenu-'.$smenuIndex]['sort'];
        $smenuIndex++;
    }

    asort($smenuSort);
    $smenuIndexNew = 1;
    $smenuValueSorted = [];
    $smenuValueIndexAdded = [];
    foreach ($smenuSort as $smenuTitle => $smenuItemSort){
        foreach($smenuValue as $smenuValueIndex => $smenuValueItem) {
            if ($smenuValueItem['title'] == $smenuTitle && !in_array($smenuValueIndex, $smenuValueIndexAdded)) {
                $smenuValueItem['sort'] = $smenuIndexNew;
                $smenuValueSorted[] = $smenuValueItem;
                $smenuValueIndexAdded[] = $smenuValueIndex;
            }
        }
        $smenuIndexNew++;
    }

    $smenuValueSortedString = json_encode($smenuValueSorted, true);

    $settingSmenu = $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s", $dataName));
    $updated_at = current_time( 'timestamp' );
    $dataUpdate = [
        'name'              => $dataName,
        'value'             => $smenuValueSortedString,
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
            'id' => $settingSmenu->id
        ),
        $dataUpdateType,
        array(
            '%d'
        )
    );
}


$hunmendSmenus =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s LIMIT 1", $dataName));

if ($hunmendSmenus == null || count($hunmendSmenus) == 0) {
    $valueSmenu = [];
    for ($i = 1; $i < 10; $i++) {
        $valueSmenu[] = [
            "title" => "Tuần ".$i,
            "url" => "#",
            "sort" => $i
        ];
    }

    $valueSmenuString = json_encode($valueSmenu);
    $wpdb->insert($wpdb->hunmend_customs, array('name' => __($dataName, 'hunmend-customs'), 'value' => $valueSmenuString, 'status' => 1), array('%s', '%s', '%d'));

    $hunmendSmenus =  $wpdb->get_results(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_customs WHERE name = %s", $dataName));
}


$valueSmenuString = $hunmendSmenus[0]->value;
$valueSmenus = json_decode($valueSmenuString, true);

?>


<form method="post"  enctype="multipart/form-data">
    <?php wp_nonce_field('wp-polls_add-poll'); ?>
    <div class="wrap">
        <h2><?php _e('Cài đặt Smenu', 'hunmend-customs') ; ?></h2>
        <!-- Poll Question -->
        <table class="wp-list-table table-smenu">
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
            <?php foreach ($valueSmenus as $index => $smenu) { ?>
            <tr class="table-smenu-item">
                <th width="20%" scope="row" valign="top">
                    <input type="text" name="smenu-<?php echo $index ?>[title]" value="<?php echo $smenu['title']?>" style="width: 100%" class='inputSmenuTitle'/>
                </th>
                <td width="50%">
                    <input type="text" width="100%" name="smenu-<?php echo $index ?>[url]" value="<?php echo $smenu['url']?>" style="width: 100%" class='inputSmenuUrl'/>
                </td>
                <td width="20%">
                    <input type="text" name="smenu-<?php echo $index ?>[sort]" value="<?php echo $smenu['sort']?>" style="width: 100%" class='inputSmenuSort'/>
                </td>
                <td width="10%">
                    <button class="button del-smenu" >
                        <span class="dashicons dashicons-trash"></span>
                    </button>
                </td>
            </tr>
            <?php $nextIndex = $index+1; } ?>
        </table>

        <p style="text-align: center;">
            <input type="button" name="do" value="<?php _e('Thêm mới', 'hunmend-customs') ?>"  class="button button-success" id="add_new_smenu"/>
            &nbsp;&nbsp;
            <input type="submit" name="do" value="<?php _e('Cập nhật', 'hunmend-customs') ?>"  class="button-primary" />
        </p>
    </div>
</form>

<script>
    jQuery(document).ready( function () {
        var nextIndex = <?php echo $nextIndex; ?>;
        jQuery(document).on("click", "#add_new_smenu", function () {
            var newSmenu = "<tr class=\"table-smenu-item\">\n" +
                "                <th width=\"20%\" scope=\"row\" valign=\"top\">\n" +
                "                    <input type=\"text\" name=\"smenu-"+nextIndex+"[title]\" value=\"\" style=\"width: 100%\" class='inputSmenuTitle'/>\n" +
                "                </th>\n" +
                "                <td width=\"50%\">\n" +
                "                    <input type=\"text\" width=\"100%\" name=\"smenu-"+nextIndex+"[url]\" value=\"\" style=\"width: 100%\"  class='inputSmenuUrl'/>\n" +
                "                </td>\n" +
                "                <td width=\"20%\">\n" +
                "                    <input type=\"text\" name=\"smenu-"+nextIndex+"[sort]\" value=\"\" style=\"width: 100%\" class='inputSmenuSort' />\n" +
                "                </td>\n" +
                "                <td width=\"10%\">\n" +
                "                    <button class=\"button del-smenu\" >\n" +
                "                        <span class=\"dashicons dashicons-trash\"></span>\n" +
                "                    </button>\n" +
                "                </td>" +
                "            </tr>";
            jQuery("table.table-smenu").append(newSmenu);
            nextIndex+=1;
            var listSmenuTable = jQuery('.table-smenu-item');
            for (var i = 0; i < listSmenuTable.length; i++) {
                listSmenuTable.eq(i).find('.inputSmenuTitle').attr("name", "smenu-"+i+"[title]");
                listSmenuTable.eq(i).find('.inputSmenuUrl').attr("name", "smenu-"+i+"[url]");
                listSmenuTable.eq(i).find('.inputSmenuSort').attr("name", "smenu-"+i+"[sort]");
            }
        });

        jQuery(document).on("click", ".del-smenu", function () {
            jQuery(this).parents("tr").remove();
            var listSmenuTable = jQuery('.table-smenu-item');
            for (var i = 0; i < listSmenuTable.length; i++) {
                listSmenuTable.eq(i).find('.inputSmenuTitle').attr("name", "smenu-"+i+"[title]");
                listSmenuTable.eq(i).find('.inputSmenuUrl').attr("name", "smenu-"+i+"[url]");
                listSmenuTable.eq(i).find('.inputSmenuSort').attr("name", "smenu-"+i+"[sort]");
            }
        })
    })

</script>
