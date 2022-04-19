<?php defined( 'ABSPATH' ) || die( 'Direct file access is prohibited.' ); ?>


<?php get_header(); 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<main id="site-main" class="site-main">
    <div class="wp-block-group" id="blog-list">
        <div class="wp-block-group__inner-container blog__wrap">
            <?php if ( have_posts() ): ?>
                <ul class="blog__list">
                    <?php
                        while ( have_posts() ) :
                            the_post(); 
                    ?>
                        <li class="blog__listing content">
                            <article class="blog__teaser">
                                <a href="<?php echo get_permalink(); ?>">
                                    <div class="blog__teaser__image-wrap">
                                        <?php echo get_the_post_thumbnail( $post, 'large' ); ?>
                                    </div>
                                    <div class="blog__teaser__content-wrap">
                                        <h2>
                                            <sup><?php echo get_the_date('M d, Y'); ?></sup>
                                            <?php echo the_title(); ?>
                                        </h2>
                                        <span>Read more</span>
                                    </div>
                                </a>
                            </article>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div class="next-page-link-wrapper wp-block-button" data-page-current="<?php echo $paged; ?>" data-per-page="<?php echo get_option('posts_per_page'); ?>"><?php print get_next_posts_link(); ?></div>
            <?php else: ?>
                <p>Sorry, there are no blog posts to show.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
