<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ecommerce-star
 * @since 1.0
 */
get_header();
$_post = get_post( $post );

global $ecommerce_star_option;
$class = 'col-md-8 col-sm-8';
if($ecommerce_star_option['layout_section_post_one_column']==true){   
   $class = 'col-md-12 col-sm-12';
}

$categories = get_the_terms( $post->id, 'category' );
?>

<div class="container post-content">
    <div class="row">
        <div class="col-sm-8">
            <div class="post-content-left">
                <div class="post-content-main">
                    <h1 class="post-content-title">
                        <?php echo $_post->post_title?>
                    </h1>
                    <div ></div>
                    <div class="post-content-content">
                        <?php echo $_post->post_content ?>
                    </div>
                    <div class="share-item">
                        <div class="fb-like" data-href="https://mangthaikhoe.vn/" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>

                    </div>
                    <div class="fb-comments" data-href="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" data-width="" data-numposts=""></div>
                </div>
                <div class="post-content-relate">
                    <div class="post-content-relate-title">
                        Bài viết liên quan
                    </div>
                    <div class="post-content-relate-main">
                        <ul>
                            <li>
                                <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-relate-item">Chuẩn bị mang thai – Những điều cần biết!</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="post-content-line"></div>
                <div class="post-content-share">
                    <div class="post-content-share-title">
                        Chia sẻ của mẹ bầu
                    </div>
                    <div class="post-content-share-main">
                        <ul>
                            <li>
                                <a href="#" class="post-content-share-item">Dành cho những bà mẹ đang chuẩn bị mang thai và mang thai</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-share-item">Nhật ký viết cho bé Miu và bé Heo con của mẹ</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-share-item">Dành cho những bà mẹ đang chuẩn bị mang thai và mang thai</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-share-item">Nhật ký viết cho bé Miu và bé Heo con của mẹ</a>
                            </li>
                            <li>
                                <a href="#" class="post-content-share-item">Dành cho những bà mẹ đang chuẩn bị mang thai và mang thai</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <?php include_once 'aside_tab.php'?>
        </div>
    </div>
</div>

<?php 
get_footer();