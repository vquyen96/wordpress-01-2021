<?php

/*
Plugin Name: Hunmend Customs
Plugin URI:
Description: Hunmend Customs created by vquyenaaa@gmail.com
Version: 1.0
Author: Hunmend developer team
Author URI:
Text Domain: hunmend-customs
*/

### Polls Table Name
global $wpdb;
$wpdb->hunmend_customs   = $wpdb->prefix.'hunmend_customs';
$wpdb->hunmend_banners   = $wpdb->prefix.'hunmend_banners';
$wpdb->hunmend_questions   = $wpdb->prefix.'hunmend_questions';
$wpdb->hunmend_videos   = $wpdb->prefix.'hunmend_videos';

add_action( 'admin_menu', 'hunmend_menu' );
function hunmend_menu() {
    add_menu_page( __( 'Hunmend Customs', 'hunmend-customs' ), __( 'Hunmend Setting', 'hunmend-customs' ), 'hunmend-customs', 'hunmend-customs/setting.php', '', 'dashicons-editor-alignleft' );

    add_submenu_page( 'hunmend-customs/setting.php', __( 'Setting', 'hunmend-customs'), __( 'Setting', 'hunmend-customs' ), 'hunmend-customs', 'hunmend-customs/setting.php' );
    add_submenu_page( 'hunmend-customs/setting.php', __( 'Banner', 'hunmend-customs'), __( 'Banner', 'hunmend-customs' ), 'hunmend-customs', 'hunmend-customs/banner.php' );
    add_submenu_page( 'hunmend-customs/setting.php', __( 'Question', 'hunmend-customs'), __( 'Question', 'hunmend-customs' ), 'hunmend-customs', 'hunmend-customs/question.php' );
    add_submenu_page( 'hunmend-customs/setting.php', __( 'Tag', 'hunmend-customs'), __( 'Tag', 'hunmend-customs' ), 'hunmend-customs', 'hunmend-customs/tag.php' );
    add_submenu_page( '', __( 'Question Detail', 'hunmend-customs' ), __( 'Question Detail', 'hunmend-customs' ), 'hunmend-customs', 'hunmend-customs/question-detail.php' );
}


### Function: Activate Plugin
register_activation_hook( __FILE__, 'hunmend_activation' );
function hunmend_activation( $network_wide ) {
    if ( is_multisite() && $network_wide ) {
        $ms_sites = wp_get_sites();

        if( 0 < count( $ms_sites ) ) {
            foreach ( $ms_sites as $ms_site ) {
                switch_to_blog( $ms_site['blog_id'] );
                hunmend_activate();
                restore_current_blog();
            }
        }
    } else {
        hunmend_activate();
    }
}

function hunmend_activate()
{
    global $wpdb;

    if (@is_file(ABSPATH . '/wp-admin/includes/upgrade.php')) {
        include_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    } elseif (@is_file(ABSPATH . '/wp-admin/upgrade-functions.php')) {
        include_once(ABSPATH . '/wp-admin/upgrade-functions.php');
    } else {
        die('We have problem finding your \'/wp-admin/upgrade-functions.php\' and \'/wp-admin/includes/upgrade.php\'');
    }

    // Create Help Tables (2 Tables)
    $charset_collate = $wpdb->get_charset_collate();

    $create_table = array();
    $create_table['hunmend_customs'] = "CREATE TABLE $wpdb->hunmend_customs (" .
        "id int(10) NOT NULL auto_increment," .
        "name varchar(200) character set utf8 NOT NULL default ''," .
        "value text character set utf8 NOT NULL default ''," .
        "sort int(10) NOT NULL default 1," .
        "status tinyint(3) NOT NULL default 1," .
        "created_at int(10) NOT NULL default '0'," .
        "updated_at int(10) NOT NULL default '0'," .
        "creator_id int(10) default NULL," .
        "PRIMARY KEY  (id)" .
        ") $charset_collate;";

    $create_table['hunmend_banners'] = "CREATE TABLE $wpdb->hunmend_banners (" .
        "id int(10) NOT NULL auto_increment," .
        "title varchar(200) character set utf8 NOT NULL default ''," .
        "value varchar(200) character set utf8 NOT NULL default ''," .
        "links varchar(200) character set utf8 NOT NULL default ''," .
        "sort int(10) NOT NULL default 1," .
        "type int(10) NOT NULL default 1," .
        "status tinyint(3) NOT NULL default 1," .
        "created_at int(10) NOT NULL default '0'," .
        "updated_at int(10) NOT NULL default '0'," .
        "creator_id int(10) default NULL," .
        "PRIMARY KEY  (id)" .
        ") $charset_collate;";

    $create_table['hunmend_questions'] = "CREATE TABLE $wpdb->hunmend_questions (" .
        "id int(10) NOT NULL auto_increment," .
        "name varchar(200) character set utf8 NOT NULL default ''," .
        "email varchar(200) character set utf8 default ''," .
        "phone varchar(200) character set utf8 default ''," .
        "age varchar(200) character set utf8 default ''," .
        "question_title text character set utf8 NOT NULL default ''," .
        "question_content text character set utf8 NOT NULL default ''," .
        "answer text character set utf8 NOT NULL default ''," .
        "sort int(10) NOT NULL default 1," .
        "view_count int(10) NOT NULL default 1," .
        "status tinyint(3) NOT NULL default 1," .
        "created_at int(10) NOT NULL default '0'," .
        "updated_at int(10) NOT NULL default '0'," .
        "creator_id int(10) default NULL," .
        "PRIMARY KEY  (id)" .
        ") $charset_collate;";

    $create_table['hunmend_videos'] = "CREATE TABLE $wpdb->hunmend_videos (" .
        "id int(10) NOT NULL auto_increment," .
        "post_id int(10) NOT NULL," .
        "youtube_id varchar(200) character set utf8 default ''," .
        "post_title varchar(200) character set utf8 default ''," .
        "sort int(10) NOT NULL default 1," .
        "view_count int(10) NOT NULL default 1," .
        "status tinyint(3) NOT NULL default 1," .
        "created_at int(10) NOT NULL default '0'," .
        "updated_at int(10) NOT NULL default '0'," .
        "creator_id int(10) default NULL," .
        "PRIMARY KEY  (id)" .
        ") $charset_collate;";

    dbDelta($create_table['hunmend_customs']);
    dbDelta($create_table['hunmend_banners']);
    dbDelta($create_table['hunmend_questions']);
    dbDelta($create_table['hunmend_videos']);
    // Check Whether It is Install Or Upgrade
    $first_hunmend = $wpdb->get_var("SELECT id FROM $wpdb->hunmend_customs LIMIT 1");
    // If Install, Insert 1st Poll Question With 5 Poll Answers
    if (empty($first_hunmend)) {

        // Insert Hunmend  (5 Records)
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('PHONE', 'hunmend-customs'), 'value' => __('0388044009', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('FB_PAGE', 'hunmend-customs'), 'value' => __('https://www.facebook.com/nhungcaunoibathu/', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('CONTACT_CONTENT', 'hunmend-customs'), 'value' => __('Đặt câu hỏi', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('NAV_HEADER', 'hunmend-customs'), 'value' => __('1', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('NAV_HEADER', 'hunmend-customs'), 'value' => __('19', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('NAV_HEADER', 'hunmend-customs'), 'value' => __('22', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('NAV_HEADER', 'hunmend-customs'), 'value' => __('24', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('FEATURE', 'hunmend-customs'), 'value' => __('16', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('FEATURE', 'hunmend-customs'), 'value' => __('23', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('POST_TOP', 'hunmend-customs'), 'value' => __('56', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('POST_TOP', 'hunmend-customs'), 'value' => __('122', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('POST_TOP', 'hunmend-customs'), 'value' => __('113', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('POST_TOP', 'hunmend-customs'), 'value' => __('92', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('POST_TOP', 'hunmend-customs'), 'value' => __('74', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('POST_TOP', 'hunmend-customs'), 'value' => __('87', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('CATE_HOME', 'hunmend-customs'), 'value' => __('1', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('CATE_HOME', 'hunmend-customs'), 'value' => __('16', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('CATE_HOME', 'hunmend-customs'), 'value' => __('17', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('CATE_HOME', 'hunmend-customs'), 'value' => __('18', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('CATE_HOME', 'hunmend-customs'), 'value' => __('19', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));
        $wpdb->insert($wpdb->hunmend_customs, array('name' => __('CATE_HOME', 'hunmend-customs'), 'value' => __('20', 'hunmend-customs'), 'status' => 1), array('%s', '%s', '%d'));


        $permalink = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name = 'permalink_structure'"));

        if ($permalink != null) {
            $wpdb->update(
                $wpdb->options,
                [
                    'option_value' => '/%year%/%monthnum%/%day%/%postname%/'
                ],
                array(
                    'id' => $permalink->option_id
                ),
                [
                    '%s'
                ],
                array(
                    '%d'
                )
            );
        } else {
            $wpdb->insert(
                $wpdb->options,
                [
                    'option_name' => 'permalink_structure',
                    'option_value' => '/%year%/%monthnum%/%day%/%postname%/',
                    'autoload' => 'yes'
                ],
                array(
                    '%s',
                    '%s',
                    '%s'
                )
            );
        }


        // Set 'mysto_help' Capabilities To Administrator
        $role = get_role('administrator');
        if (!$role->has_cap('hunmend-customs')) {
            $role->add_cap('hunmend-customs');
        }
    }
}

function str_slug($string) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
}
