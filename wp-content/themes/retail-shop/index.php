<?php get_header();

global $wpdb;


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


$list_exclude = [];

$args = [
    'numberposts'      => 50,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'post',
];
$list_post_new = get_posts($args);
$list_post_top = [];
foreach ($hunmendData['POST_TOP'] as $postIds) {
    foreach ($list_post_new as $postItem) {
        if ($postItem->ID == $postIds) {
            $list_post_top[] = $postItem;
        }
    }
}

foreach ($list_post_top as $postItem) {
    $list_exclude[] = $postItem->ID;
}

$args = array(
    'taxonomy' => 'category',
    'orderby' => 'term_id',
    'order' => 'ASC',
    'show_count' => 1,
    'pad_counts' => 0,
    'hierarchical' => 0,
    'title_li' => '',
);
$cats = get_categories($args);
$listCateHome = [];
foreach ($hunmendData['CATE_HOME'] as $cateId) {
    foreach ($cats as $cate) {
        if ($cate->cat_ID == $cateId) {
            $listCateHome[] = $cate;
        }
    }
}

$list_post_cate = [];
for ($i = 0; $i < count($listCateHome); $i++) {
    $list_post = [];
    $list_post['cate_title'] = $listCateHome[$i]->name;
    $list_post['cate_id'] = $listCateHome[$i]->cat_ID;

    $list_post['posts'] = get_posts([
        "category"          => $listCateHome[$i]->cat_ID,
        'numberposts'       => 4,
        'orderby'           => 'post_date',
        'order'             => 'DESC',
        'post_type'         => 'post',
        'exclude'           => $list_exclude
    ]);
    $list_post_cate[] = $list_post;
    foreach ($list_post['posts'] as $postItem) {
        $list_exclude[] = $postItem->ID;
    }
}

$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);

$product_categories = get_terms( 'product_cat', $cat_args );
?>

<div class="container home-content">
    <div class="row">
        <div class="col-sm-8 home-content-left">
            <?php if ($_GET['page'] == 'contact') { ?>
                <div class="page-original-content"><h1>Hỏi đáp</h1>
                    <p><img class="aligncenter size-full wp-image-3268 lazyloaded" data-src="https://dinhduongbabau.net/wp-content/uploads/2018/09/hoi-dap.jpg" alt="" width="600" height="400" src="https://dinhduongbabau.net/wp-content/uploads/2018/09/hoi-dap.jpg"></p>
                    <p style="text-align: center;"><strong>Chào mừng bạn đến với chuyên mục&nbsp;<span style="color: #800000;">TƯ VẤN SỨC KHỎE VÀ DINH DƯỠNG CHO BÀ BẦU</span>&nbsp;của chúng tôi! </strong></p>
                    <p>&nbsp;</p>
                    <p style="text-align: justify;"><strong>Để được chuyên gia tư vấn trực tiếp bạn vui lòng gọi đến số&nbsp;<span style="color: #ff0000;"><span style="font-size: 20px;">0964.666.152</span></span>&nbsp;hoặc gửi câu hỏi vào <span style="color: #ff0000;">Form&nbsp;Hỏi Đáp</span> dưới đây, các chuyên gia sẽ tư vấn sớm nhất cho bạn.</strong></p>
                    <p>&nbsp;</p>
                    <p style="text-align: justify;"><strong>Kinh nghiệm nhỏ: Việc <span style="color: #800000;">TÌM CÂU HỎI&nbsp;</span>và đọc trước&nbsp;<span style="color: #800000;">NHỮNG CÂU HỎI THƯỜNG GẶP&nbsp;</span>&nbsp;(phía bên dưới)&nbsp;có thể sẽ tiết kiệm được thời gian cho&nbsp;bạn!</strong></p>
                </div>
                <div class="s-ques" id="s-ques"> <form role="search" method="get" id="searchform" action=""> <div class="search-list-category"> <input type="text" value="" name="ques" id="s" placeholder="Nhập câu hỏi cần tìm"><input type="submit" id="searchsubmit" value="Tìm câu hỏi"> </div> </form> </div>
                <div class="questions-search"> <input type="text" class="fitqa-questions-suggest ui-autocomplete-input" id="questions-suggest" autocomplete="off" placeholder="Tìm câu hỏi"> <input type="button" class="fitqa-suggest-submit fitqa-button" id="suggest-submit" value="Tìm câu hỏi"> hoặc <a href="#ask-new-question" class="ask-question fitqa-button">Đặt câu hỏi của bạn</a> </div>
                <div id="ask-new-question" class="ask-new-question"> <form action="" method="post" class="fitqa-ask-form"><p class="field-user_name"><label for="user_name">Họ tên <span class="reqired">*</span></label><input type="text" name="user_name" id="user_name" class="fitqa-input-text user_name fitqa-require"></p><p class="field-user_email"><label for="user_email">Email <span class="reqired">*</span></label><input type="text" name="user_email" id="user_email" class="fitqa-input-text user_email fitqa-require"></p><p class="field-user_phone"><label for="user_phone">Số điện thoại </label><input type="text" onkeypress="return ValidNumber(event);" name="user_phone" id="user_phone" class="fitqa-input-number user_phone "></p><p class="field-user_age"><label for="user_age">Tuổi thai nhi</label><select name="user_age" id="user_age" class="fitqa-input-text user_age user_age"> <option value="Chuẩn bị mang thai">Chuẩn bị mang thai</option> <option value="Tuần thứ 1">Tuần thứ 1</option> <option value="Tuần thứ 2">Tuần thứ 2</option> <option value="Tuần thứ 3">Tuần thứ 3</option> <option value="Tuần thứ 4">Tuần thứ 4</option> <option value="Tuần thứ 5">Tuần thứ 5</option> <option value="Tuần thứ 6">Tuần thứ 6</option> <option value="Tuần thứ 7">Tuần thứ 7</option> <option value="Tuần thứ 8">Tuần thứ 8</option> <option value="Tuần thứ 9">Tuần thứ 9</option> <option value="Tuần thứ 10">Tuần thứ 10</option> <option value="Tuần thứ 11">Tuần thứ 11</option> <option value="Tuần thứ 12">Tuần thứ 12</option> <option value="Tuần thứ 13">Tuần thứ 13</option> <option value="Tuần thứ 14">Tuần thứ 14</option> <option value="Tuần thứ 15">Tuần thứ 15</option> <option value="Tuần thứ 16">Tuần thứ 16</option> <option value="Tuần thứ 17">Tuần thứ 17</option> <option value="Tuần thứ 18">Tuần thứ 18</option> <option value="Tuần thứ 19">Tuần thứ 19</option> <option value="Tuần thứ 20">Tuần thứ 20</option> <option value="Tuần thứ 21">Tuần thứ 21</option> <option value="Tuần thứ 22">Tuần thứ 22</option> <option value="Tuần thứ 23">Tuần thứ 23</option> <option value="Tuần thứ 24">Tuần thứ 24</option> <option value="Tuần thứ 25">Tuần thứ 25</option> <option value="Tuần thứ 26">Tuần thứ 26</option> <option value="Tuần thứ 27">Tuần thứ 27</option> <option value="Tuần thứ 28">Tuần thứ 28</option> <option value="Tuần thứ 29">Tuần thứ 29</option> <option value="Tuần thứ 30">Tuần thứ 30</option> <option value="Tuần thứ 31">Tuần thứ 31</option> <option value="Tuần thứ 32">Tuần thứ 32</option> <option value="Tuần thứ 33">Tuần thứ 33</option> <option value="Tuần thứ 34">Tuần thứ 34</option> <option value="Tuần thứ 35">Tuần thứ 35</option> <option value="Tuần thứ 36">Tuần thứ 36</option> <option value="Tuần thứ 37">Tuần thứ 37</option> <option value="Tuần thứ 38">Tuần thứ 38</option> <option value="Tuần thứ 39">Tuần thứ 39</option> <option value="Tuần thứ 40">Tuần thứ 40</option> <option value="Đang cho con bú">Đang cho con bú</option> </select></p><p class="field-question_brief"><label for="question_brief">Miêu tả ngắn gọn câu hỏi <span class="reqired">*</span></label><input type="text" name="question_brief" id="question_brief" class="fitqa-input-text question_brief fitqa-require"></p><label>Chi tiết câu hỏi <span class="reqired">*</span></label><br><div id="wp-question_detail-wrap" class="wp-core-ui wp-editor-wrap tmce-active"> <div id="wp-question_detail-editor-container" class="wp-editor-container"><div id="mceu_31" class="mce-tinymce mce-container mce-panel" hidefocus="1" tabindex="-1" role="application" style="visibility: hidden; border-width: 1px; width: 100%;"><div id="mceu_31-body" class="mce-container-body mce-stack-layout"><div id="mceu_32" class="mce-top-part mce-container mce-stack-layout-item mce-first"><div id="mceu_32-body" class="mce-container-body"><div id="mceu_33" class="mce-toolbar-grp mce-container mce-panel mce-first mce-last" hidefocus="1" tabindex="-1" role="group"><div id="mceu_33-body" class="mce-container-body mce-stack-layout"><div id="mceu_34" class="mce-container mce-toolbar mce-stack-layout-item mce-first" role="toolbar"><div id="mceu_34-body" class="mce-container-body mce-flow-layout"><div id="mceu_35" class="mce-container mce-flow-layout-item mce-first mce-last mce-btn-group" role="group"><div id="mceu_35-body"><div id="mceu_0" class="mce-widget mce-btn mce-menubtn mce-fixed-width mce-listbox mce-first mce-btn-has-text" tabindex="-1" aria-labelledby="mceu_0" role="button" aria-haspopup="true"><button id="mceu_0-open" role="presentation" type="button" tabindex="-1"><span class="mce-txt">Đoạn</span> <i class="mce-caret"></i></button></div><div id="mceu_1" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Bold"><button id="mceu_1-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-bold"></i></button></div><div id="mceu_2" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Italic"><button id="mceu_2-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-italic"></i></button></div><div id="mceu_3" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Danh sách liệt kê được đánh số"><button id="mceu_3-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-bullist"></i></button></div><div id="mceu_4" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Danh sách được đánh số"><button id="mceu_4-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-numlist"></i></button></div><div id="mceu_5" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Blockquote"><button id="mceu_5-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-blockquote"></i></button></div><div id="mceu_6" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Align left"><button id="mceu_6-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-alignleft"></i></button></div><div id="mceu_7" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Align center"><button id="mceu_7-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-aligncenter"></i></button></div><div id="mceu_8" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Align right"><button id="mceu_8-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-alignright"></i></button></div><div id="mceu_9" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Insert/edit link"><button id="mceu_9-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-link"></i></button></div><div id="mceu_10" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Insert Read More tag"><button id="mceu_10-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-wp_more"></i></button></div><div id="mceu_11" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Fullscreen"><button id="mceu_11-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-fullscreen"></i></button></div><div id="mceu_12" class="mce-widget mce-btn mce-last" tabindex="-1" role="button" aria-label="Toolbar Toggle"><button id="mceu_12-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-wp_adv"></i></button></div></div></div></div></div><div id="mceu_36" class="mce-container mce-toolbar mce-stack-layout-item mce-last" role="toolbar" style="display: none;"><div id="mceu_36-body" class="mce-container-body mce-flow-layout"><div id="mceu_37" class="mce-container mce-flow-layout-item mce-first mce-last mce-btn-group" role="group"><div id="mceu_37-body"><div id="mceu_13" class="mce-widget mce-btn mce-first" tabindex="-1" aria-pressed="false" role="button" aria-label="Strikethrough"><button id="mceu_13-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-strikethrough"></i></button></div><div id="mceu_14" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Horizontal line"><button id="mceu_14-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-hr"></i></button></div><div id="mceu_15" class="mce-widget mce-btn mce-splitbtn mce-colorbutton" role="button" tabindex="-1" aria-haspopup="true" aria-label="Text color"><button role="presentation" hidefocus="1" type="button" tabindex="-1"><i class="mce-ico mce-i-forecolor"></i><span id="mceu_15-preview" class="mce-preview"></span></button><button type="button" class="mce-open" hidefocus="1" tabindex="-1"> <i class="mce-caret"></i></button></div><div id="mceu_16" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Paste as text"><button id="mceu_16-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-pastetext"></i></button></div><div id="mceu_17" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Clear formatting"><button id="mceu_17-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-removeformat"></i></button></div><div id="mceu_18" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Special character"><button id="mceu_18-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-charmap"></i></button></div><div id="mceu_19" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Decrease indent"><button id="mceu_19-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-outdent"></i></button></div><div id="mceu_20" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Tăng khoảng cách thụt đầu dòng"><button id="mceu_20-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-indent"></i></button></div><div id="mceu_21" class="mce-widget mce-btn mce-disabled" tabindex="-1" role="button" aria-label="Undo" aria-disabled="true"><button id="mceu_21-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-undo"></i></button></div><div id="mceu_22" class="mce-widget mce-btn mce-disabled" tabindex="-1" role="button" aria-label="Redo" aria-disabled="true"><button id="mceu_22-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-redo"></i></button></div><div id="mceu_23" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Keyboard Shortcuts"><button id="mceu_23-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-wp_help"></i></button></div><div id="mceu_24" class="mce-widget mce-btn" tabindex="-1" role="button" aria-label="Remove link"><button id="mceu_24-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-unlink"></i></button></div><div id="mceu_25" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Subscript"><button id="mceu_25-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-subscript"></i></button></div><div id="mceu_26" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Superscript"><button id="mceu_26-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-superscript"></i></button></div><div id="mceu_27" class="mce-widget mce-btn mce-splitbtn mce-colorbutton" role="button" tabindex="-1" aria-haspopup="true" aria-label="Background color"><button role="presentation" hidefocus="1" type="button" tabindex="-1"><i class="mce-ico mce-i-backcolor"></i><span id="mceu_27-preview" class="mce-preview"></span></button><button type="button" class="mce-open" hidefocus="1" tabindex="-1"> <i class="mce-caret"></i></button></div><div id="mceu_28" class="mce-widget mce-btn mce-menubtn mce-fixed-width mce-listbox mce-btn-has-text" tabindex="-1" aria-labelledby="mceu_28" role="button" aria-label="Font Sizes" aria-haspopup="true"><button id="mceu_28-open" role="presentation" type="button" tabindex="-1"><span class="mce-txt">16px</span> <i class="mce-caret"></i></button></div><div id="mceu_29" class="mce-widget mce-btn" tabindex="-1" aria-pressed="false" role="button" aria-label="Justify"><button id="mceu_29-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-alignjustify"></i></button></div><div id="mceu_30" class="mce-widget mce-btn mce-last" tabindex="-1" aria-pressed="false" role="button" aria-label="Insert/edit media"><button id="mceu_30-button" role="presentation" type="button" tabindex="-1"><i class="mce-ico mce-i-media"></i></button></div></div></div></div></div></div></div></div></div><div id="mceu_38" class="mce-edit-area mce-container mce-panel mce-stack-layout-item" hidefocus="1" tabindex="-1" role="group" style="border-width: 1px 0px 0px;"><iframe id="question_detail_ifr" frameborder="0" allowtransparency="true" title="Khó khăn khi sử dụng? Hãy nhấn Alt-Shift-H để giúp đỡ" style="width: 100%; height: 149px; display: block;"></iframe></div><div id="mceu_39" class="mce-statusbar mce-container mce-panel mce-stack-layout-item mce-last" hidefocus="1" tabindex="-1" role="group" style="border-width: 1px 0px 0px;"><div id="mceu_39-body" class="mce-container-body mce-flow-layout"><div id="mceu_40" class="mce-path mce-flow-layout-item mce-first"><div class="mce-path-item">&nbsp;</div></div><div id="mceu_41" class="mce-flow-layout-item mce-last mce-resizehandle"><i class="mce-ico mce-i-resize"></i></div></div></div></div></div><textarea class="wp-editor-area" rows="7" autocomplete="off" cols="40" name="question_detail" id="question_detail" style="display: none;" aria-hidden="true"></textarea></div>
                        </div> <input type="submit" name="submit_question" value="Gửi câu hỏi" class="fitqa-submit-question"></form> </div>
            <?php } else {?>
            <div class="home-top">
                <div class="home-top-big owl-carousel owl-theme">
                    <?php for ($i = 0; $i < 3; $i++) {?>
                    <div class="home-top-big-item">
                        <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-big-img"
                             style="background: url('<?php echo get_the_post_thumbnail_url($list_post_top[$i]->ID,'medium_large') ?>') no-repeat center /cover">
                        </a>
                        <div class="home-top-big-left">
                            <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-big-title">
                                <?php echo $list_post_top[$i]->post_title?>
                            </a>
                            <div class="home-top-big-summary">
                                <?php echo cut_string(get_the_excerpt($list_post_top[$i]->ID), 300)?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="home-top-small">
                    <?php for ($i = 3; $i < 6; $i++) {?>
                    <div class="home-top-small-item">
                        <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-small-img" style="background: url('<?php echo get_the_post_thumbnail_url($list_post_top[$i]->ID,'thumbnail') ?>') no-repeat center /cover"></a>
                        <a href="<?php echo get_permalink($list_post_top[$i]->ID);?>" class="home-top-small-title"><?php echo $list_post_top[$i]->post_title?></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php for ($i = 0; $i < 6; $i++) {?>
            <div class="home-cate">
                <a href="<?php echo get_category_link($list_post_cate[$i]['cate_id']); ?>" class="home-cate-title">
                    <?php print_r($list_post_cate[$i]['cate_title']) ; ?>
                </a>
                <?php if (isset($list_post_cate[$i]['posts'][0])) {?>
                <div class="home-cate-main">
                    <div class="home-cate-big">
                        <div class="home-cate-big-left">
                            <a href="<?php echo get_permalink($list_post_cate[$i]['posts'][0]->ID);?>" class="home-cate-big-img" style="background: url('<?php echo get_the_post_thumbnail_url($list_post_cate[$i]['posts'][0]->ID,'medium') ?>') no-repeat center /cover"></a>
                        </div>
                        <div class="home-cate-big-right">
                            <a href="<?php echo get_permalink($list_post_cate[$i]['posts'][0]->ID);?>" class="home-cate-big-title">
                                <?php echo $list_post_cate[$i]['posts'][0]->post_title ?>
                            </a>
                            <div class="home-cate-big-summary">
                                <?php echo cut_string(get_the_excerpt($list_post_cate[$i]['posts'][0]->ID), 250)?>
                            </div>
                        </div>
                    </div>
                    <div class="home-cate-small">
                        <ul>
                            <?php for ($j = 1; $j < count($list_post_cate[$i]['posts']) ; $j++) {?>
                            <li>
                                <a href="<?php echo get_permalink($list_post_cate[$i]['posts'][$j]->ID);?>" class="home-cate-small-title">
                                    <?php echo $list_post_cate[$i]['posts'][$j]->post_title ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="col-sm-4">
            <?php include_once 'aside_tab.php'?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:false,
        responsive:{
            0:{
                items:1
            }
        }
    })
</script>
