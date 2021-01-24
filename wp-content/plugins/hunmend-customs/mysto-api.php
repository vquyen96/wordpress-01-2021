<?php
// url : http://localhost:6060/wp-json/api/v1/help/category
// url : http://localhost:6060/?rest_route=/api/v1/help/category
add_action( 'rest_api_init', function() {
    register_rest_route( 'api/v1/help', '/category', [
        'methods' => 'GET',
        'callback' => 'cate_list',
        'permission_callback' => '__return_true'
    ] );
} );


function cate_list($request) {
    global $wpdb;
    $parent_id = $request->get_param( 'parent_id' );
    $query = "SELECT * FROM $wpdb->help_cate ";
    if ($parent_id != null) {
        $query .="WHERE parent_id=$parent_id ";
    }
    $query .="ORDER BY id ASC";
    $categories = $wpdb->get_results( $wpdb->prepare($query) );

    return [
        'category' => $categories,
    ] ;
}