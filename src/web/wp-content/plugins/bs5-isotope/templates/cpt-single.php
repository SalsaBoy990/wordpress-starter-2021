<?php
	/*
	 * Template Post Type: post
	 */
	  
	 get_header();  ?>

<div id="content" class="site-content container py-5 mt-5">
    <div id="primary" class="content-area">

        <div class="row">
            <div class="col">

                <main id="main" class="site-main">

                    <header class="entry-header">
                        <?php the_post(); ?>
                        
                        <?php isotope_category_badge(); ?>                        
                        <?php the_title('<h1>', '</h1>'); ?>
                        <?php bootscore_post_thumbnail(); ?>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <footer class="entry-footer">
                        <p><?php bootscore_tags(); ?></p>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <?php previous_post_link('%link'); ?>
                                </li>
                                <li class="page-item">
                                    <?php next_post_link('%link'); ?>
                                </li>
                            </ul>
                        </nav>
                    </footer>

                </main> <!-- #main -->

            </div><!-- col -->
            <?php get_sidebar(); ?>
        </div><!-- row -->

    </div><!-- #primary -->
</div><!-- #content -->

<?php get_footer(); ?>
