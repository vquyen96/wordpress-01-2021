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
global $ecommerce_star_option;
$class = 'col-md-8 col-sm-8';
if($ecommerce_star_option['layout_section_post_one_column']==true){   
   $class = 'col-md-12 col-sm-12';
}

$_post = get_post( $post );
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
                    <span class="share-item">
                        <img src="http://bscedu.vn/public/assets/client/images/fb-logo.png"

                             alt="Share on Facebook"
                             onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo get_permalink($_post->ID);?>//'),
                                     'facebook-share-dialog','width=626,height=436');
                                     return false;"
                        >
                    </span>
                    <iframe src="https://www.facebook.com/plugins/comment_embed.php?href=https%3A%2F%2Fidfnwvjv.nethost-1511.000nethost.com%2F%3Fp%3D56&width=560&include_parent=false&appId=196414931235563&height=0" width="560" height="0" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>

                    <!-- Load Facebook SDK for JavaScript -->
                    <div id="fb-root"></div>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=196414931235563&autoLogAppEvents=1" nonce="Z28QZBbj"></script>
                    <!-- Your embedded comments code -->
                    <div class="fb-comment-embed" data-href="https://idfnwvjv.nethost-1511.000nethost.com/?p=56" data-width="560" data-include-parent="false"></div>

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