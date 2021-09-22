<?php
    /**
     * Template Name: No Sidebar with Vue.js app container
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
     *
     * @package Bootscore
     */
    
    get_header();
    ?>
<div id="content" class="site-content container-fluid py-5 mt-5 site-padding">
    <div id="primary" class="content-area">

        <!-- Hook to add something nice -->
        <?php bs_after_primary(); ?>

        <main id="main" class="site-main">

            <header class="entry-header">
                <?php the_post(); ?>
                <!-- Title -->
                <?php the_title('<h1>', '</h1>'); ?>
                <!-- Featured Image-->
                <?php bootscore_post_thumbnail(); ?>
                <!-- .entry-header -->
            </header>
            <div class="entry-content">
                <!-- Content -->
                <?php the_content(); ?>
                <?php echo do_shortcode('[vuecommerce_filter_products]'); ?>
                <!-- .entry-content -->
                <?php wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bootscore' ),
					'after'  => '</div>',
					) );
					?>
            </div>
            <footer class="entry-footer">

            </footer>
            <!-- Comments -->
            <?php comments_template(); ?>

        </main><!-- #main -->

    </div><!-- #primary -->
</div><!-- #content -->
<?php
get_footer();
