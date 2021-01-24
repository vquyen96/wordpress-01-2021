<?php
global $wpdb;
$bannerId    = ( isset( $_GET['id'] ) ? (int) sanitize_key( $_GET['id'] ) : 0 );
$bannerTypes = [
    1 => 'Đầu trang',
    2 => 'Trung tâm',
    3 => 'Bên phải',
    4 => 'Đầu trang mobie',
    5 => 'Trung tâm mobie'
];


$bannerUrl = null;
if (isset($_FILES['file_banner']) && $_FILES['file_banner']['size'] != 0) {
    $wordpress_upload_dir = wp_upload_dir();
    $i = 1; // number of tries when the file with the same name is already exists

    $bannerImg = $_FILES['file_banner'];
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $bannerImg['name'];
    $new_file_mime = mime_content_type( $bannerImg['tmp_name'] );

    if( empty( $bannerImg ) )
        die( 'File is not selected.' );

    if( $bannerImg['error'] )
        die( $bannerImg['error'] );

    if( $bannerImg['size'] > wp_max_upload_size() )
        die( 'It is too large than expected.' );

    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
        die( 'WordPress doesn\'t allow this type of uploads.' );

    while( file_exists( $new_file_path ) ) {
        $i++;
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $bannerImg['name'];
    }

// looks like everything is OK
    if( move_uploaded_file( $bannerImg['tmp_name'], $new_file_path ) ) {
        $upload_id = wp_insert_attachment( array(
            'guid'           => $new_file_path,
            'post_mime_type' => $new_file_mime,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', $bannerImg['name'] ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ), $new_file_path );

        // wp_generate_attachment_metadata() won't work if you do not include this file
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Generate and save the attachment metas into the database
        wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
        $bannerUrl = $wordpress_upload_dir['url'] . '/' . basename( $new_file_path );
    }

}
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

$query = "SELECT * FROM $wpdb->hunmend_banners ORDER BY id DESC";
$listBanner =  $wpdb->get_results( $query);

$bannerCurrent = $wpdb->get_row(  $wpdb->prepare("SELECT * FROM $wpdb->hunmend_banners WHERE id = %d", $bannerId));

?>
<style>
    img.banner-img {
        max-height: 96px;
        border: 1px solid #ccc;
    }
</style>
<div class="wrap">
    <div class="banner-title d-flex">
        <h1><?php _e('Quản lý banner', 'hunmend-customs') ; ?></h1>
        <a href="admin.php?page=hunmend-customs%2Fbanner.php" class="btn button-primary">Thêm mới</a>
    </div>
    <div class="banner-add-new">
        <form action="" method="post" enctype="multipart/form-data">
            <h3><?php $bannerId == 0 ? _e('Thêm mới banner', 'hunmend-customs') : _e('Chỉnh sửa banner', 'hunmend-customs'); ?></h3>
            <table class="form-table">
                <tr>
                    <th width="20%" scope="row" valign="top"><?php _e('Tên', 'hunmend-customs') ?></th>
                    <td width="80%">
                        <input type="text" size="70" name="title" value="<?php echo $bannerId == 0 ? '' : $bannerCurrent->title?>" />
                    </td>
                </tr>
                <tr>
                    <th width="20%" scope="row" valign="top"><?php _e('Hình ảnh', 'hunmend-customs') ?></th>
                    <td width="80%">
                        <input type="file" size="70" name="file_banner" value="" />
                    </td>
                </tr>
                <tr>
                    <th width="20%" scope="row" valign="top"><?php _e('Link', 'hunmend-customs') ?></th>
                    <td width="80%">
                        <input type="text" size="70" name="links" value="<?php echo $bannerId == 0 ? '' : $bannerCurrent->links?>" />
                    </td>
                </tr>
                <tr>
                    <th width="20%" scope="row" valign="top"><?php _e('Loại banner', 'hunmend-customs') ?></th>
                    <td width="80%">
                        <select name="type" id="">
                            <?php foreach ($bannerTypes as $banner_id => $bannerName) { ?>
                            <option value="<?php echo $banner_id?>" <?php echo $bannerId != 0 && $bannerCurrent->type == $banner_id ? 'selected' : '' ?>><?php echo $bannerName?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
            <p style="text-align: center;">
                <input type="submit" name="do" value="<?php $bannerId == 0 ? _e('Thêm mới', 'hunmend-customs') : _e('Cập Nhật', 'hunmend-customs') ; ?>"  class="button-primary" />
            </p>
        </form>
    </div>
    <div class="banner-manages">
        <h3><?php _e('Danh sách Banner', 'hunmend-customs'); ?></h3>
        <table class="widefat">
            <thead>
            <tr>
                <th><?php _e('ID', 'hunmend-customs'); ?></th>
                <th><?php _e('Title', 'hunmend-customs'); ?></th>
                <th><?php _e('Image', 'hunmend-customs'); ?></th>
                <th><?php _e('Vị trí', 'hunmend-customs'); ?></th>
                <th colspan="3"><?php _e('Action', 'hunmend-customs'); ?></th>
            </tr>
            </thead>
            <tbody id="manage_polls">
            <?php foreach($listBanner as $index => $banner) { ?>
            <tr>
                <td><?php echo $index+1?></td>
                <td><?php echo $banner->title?></td>
                <td>
                    <img src="<?php echo $banner->value?>" alt="<?php echo $banner->title?>" class="banner-img">
                </td>
                <td><?php echo $bannerTypes[$banner->type] ?></td>
                <td>
                    <a href="admin.php?page=hunmend-customs%2Fbanner.php&amp;id=<?php echo $banner->id?>" class="edit"><?php _e('Edit', 'hunmend-customs') ?></a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

