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
$args = [
    'category' => get_queried_object_id()
];

$list_post = get_posts($args);

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
                <?php while ( have_posts() ) : the_post();?>
                <div class="list-cate-item">
                    <div class="list-cate-item-img">
                        <?php if( has_post_thumbnail() ) { ?>
                            <div class="post-thumbnail" >
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('full'); ?>
                                </a>
                            </div><!-- .post-thumbnail -->
                        <?php } else { ?>
                            <div class="post-thumbnail" style="background: #ccc">
                                <a href="<?php the_permalink(); ?>">

                                </a>
                            </div><!-- .post-thumbnail -->
                        <?php } ?>
                    </div>

                    <div class="list-cate-item-content">
                        <?php
                        the_title( sprintf( '<h2 class="entry-title list-cate-item-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                        ?>
                        <p class="list-cate-item-summary">
                            <?php echo cut_string(get_the_excerpt(get_the_id()), 300) ; ?>
                        </p>
                        <a href="<?php the_permalink(); ?>" class="list-cate-item-seemore">Xem chi tiết >></a>
                    </div>
                </div>
                <?php endwhile; ?>
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
