<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ecommerce-star
 * @since 1.0
 */
get_header();

//global $wpdb;
//$questions = $wpdb->get_results(
//    $wpdb->prepare(
//        "SELECT
//                    c.title as cate_title,
//                    c.parent_id,
//                    q.title,
//                    q.id,
//                    q.cate_id
//                FROM $wpdb->help_cate AS c
//                INNER JOIN $wpdb->help_question as q
//                ON c.id = q.cate_id
//                WHERE  c.parent_id = $cate_id
//                    OR q.cate_id = $cate_id
//                ORDER BY q.cate_id ASC"
//    )
//);


$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
$count = 10;
$postsPerPage = $count;
$postOffset = $paged * $postsPerPage;

$args = [
    'category'          => get_queried_object_id(),
    'offset'            => $postOffset,
    'posts_per_page'    => $postsPerPage,
];

$list_post = get_posts($args);
$postsInCat = get_term_by('id',get_queried_object_id(),'category');//Thay ID_CAT bằng ID mà bạn muốn đếm số bài viết
$total = $postsInCat->count; //
$lastPage = floor($total/$count);


$cate = get_category(get_queried_object_id());
global $ecommerce_star_option;
if ( class_exists( 'WP_Customize_Control' ) ) {
   $ecommerce_star_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings());  
}
?>

<div class="list-cate container">
    <div class="row">
        <div class="col-sm-8">
            <div class="list-cate-left">
                <h1 class="list-cate-left-title">
                    <?php echo $cate->name ?>
                </h1>
                <?php foreach ($list_post as $post) {?>
                <div class="list-cate-item">
                    <div class="list-cate-item-img">
                        <?php if( get_the_post_thumbnail_url($post->ID,'medium') != null ) { ?>
                            <div class="post-thumbnail" >
                                <a href="<?php echo get_permalink($post->ID);?>" style="background: url('<?php echo get_the_post_thumbnail_url($post->ID,'medium') ?>') no-repeat center /cover">

                                </a>
                            </div><!-- .post-thumbnail -->
                        <?php } else { ?>
                            <div class="post-thumbnail" style="background: #ccc">
                                <a href="<?php echo get_permalink($post->ID);?>">

                                </a>
                            </div><!-- .post-thumbnail -->
                        <?php } ?>
                    </div>

                    <div class="list-cate-item-content">
                        <h2 class="entry-title list-cate-item-title">
                            <a href="<?php echo get_permalink($post->ID);?>" class="home-cate-big-title">
                                <?php echo $post->post_title ?>
                            </a>
                        </h2>
                        <p class="list-cate-item-summary">
                            <?php echo cut_string(get_the_excerpt($post->ID), 300) ; ?>
                        </p>
                        <a href="<?php echo get_permalink($post->ID);?>" class="list-cate-item-seemore">Xem chi tiết >></a>
                    </div>
                </div>
                <?php } ?>
                <?php
                    paginate($lastPage, $paged, esc_url( home_url( '/' )).'?'.'cat='.get_queried_object_id())
                ?>

            </div>
        </div>
        <div class="col-sm-4">
            <?php include_once 'aside_tab.php'?>
        </div>
    </div>
</div>
<?php
get_footer();
?>
