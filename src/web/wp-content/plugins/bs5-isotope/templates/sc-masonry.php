<?php

/*

 * Masonry template.
 *
 * This template can be overriden by copying this file to your-theme/bs5-isotope/sc-masonry.php
 *
 * @author 		Bastian Kreiter
 * @package 	bS5 Isotope
 * @version     1.0.0

Registers the Masonry Shortcode [bs-isotope-masonry type="post" tax="category" cat_parent="CATEGORY PARENT ID"] or [bs-isotope-masonry type="isotope" tax="isotope_category" cat_parent="CATEGORY PARENT ID"]
*/


// Isotope Grid Masonry Shortcode
add_shortcode( 'bs-isotope-masonry', 'isotope_masonry_shortcode' );
function isotope_masonry_shortcode( $atts ) {
	ob_start();
	extract( shortcode_atts( array (
        'cat_parent'    => '',
        'type' => '',
		'tax' => ''
	), $atts ) );

	$options = array(
		'posts_per_page' => -1,
		'post_type'      => 'post'
	);

	// Check if post type(s) was defined
	$type = trim( $type );
	if ( ! empty( $type ) ) {
		$options['post_type'] = $type;
	}

	// Check if taxonomy and terms were defined
	if ( $tax != '' && $cat_parent != '' ) {
		$terms = explode( ',', trim( $cat_parent ) );
		$terms = array_map( 'trim', $terms );
		$terms = array_unique( $terms );
		$terms = array_filter( $terms );
		$options['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => $tax,
				'field'    => 'term_id',
				'terms'    => $terms,
				'operator' => 'IN'
			)
		);
	}

	$query = new WP_Query( $options );
	if ( $query->have_posts() ) { ?>



<!-- Filters -->
<div class="d-block text-center mb-4">
    <div id="filters-masonry" class="filter-buttons btn-group">
        <a href="#" data-filter="*" class="active"><?php _e('All','bootscore'); ?></a>
        <?php 
		$terms = get_terms($tax, array('parent' => $cat_parent));
        $count = count($terms); //How many are they?
		if ( $count > 0 ){  //If there are more than 0 terms
			foreach ( $terms as $term ) {  //for each term:
				echo "<a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a>\n"; //create a list item with the current term slug for sorting, and name for label
			}
		} 
	?>
    </div>
</div>


<!-- Grid -->
<?php 
     $terms_ID_array = array();
     foreach ($terms as $term)
     {
         $terms_ID_array[] = $term->term_id; // Add each term's ID to an array
     }
     $terms_ID_string = implode(',', $terms_ID_array); // Create a string with all the IDs, separated by commas
     $the_query = new WP_Query( 'posts_per_page-1&cat='.$terms_ID_string ); // Display all posts that belong to the categories in the string                              
?>
<?php //if ( $the_query->have_posts() ) : ?>
<?php if ( $query->have_posts() ) : ?>
<div id="masonry" class="row">
    <?php //while ( $the_query->have_posts() ) : $the_query->the_post(); 
	while ( $query->have_posts() ) : $query->the_post(); 
	$termsArray = get_the_terms( $post->ID, $tax );  //Get the terms for this particular item
	$termsString = ""; //initialize the string that will contain the terms
		foreach ( $termsArray as $term ) { // for each term 
			$termsString .= $term->slug.' '; //create a string that has all the slugs 
		}
	?>
    <div class="<?php echo $termsString; ?> item col-md-6 col-lg-4 col-xxl-3"> <?php // 'item' is used as an identifier (see Setp 5, line 6) ?>

        <div class="card mb-4">

            <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
            <div class="card-body">

                <?php bootscore_category_badge(); ?>
                <?php isotope_category_badge(); ?>               
                
                <h2 class="blog-post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                
                <!-- Meta -->
                <?php if ( 'post' === get_post_type() ) : ?>
                <small class="text-muted mb-2">
                    <?php
				        bootscore_date();
				        bootscore_author();
				        bootscore_comments();
                        bootscore_edit();
				    ?>
                </small>
                <?php endif; ?>


                <?php the_excerpt(); ?>
                <div class="card-text">
                    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more »', 'bootscore'); ?></a>
                </div>
                <?php bootscore_tags(); ?>

            </div>
        </div>
    </div> <!-- end item -->
    <?php endwhile;  ?>
</div> <!-- end masonry -->
<?php endif; ?>
<!-- Grid End -->

<?php wp_reset_query(); // Reset query ?>



<?php $myvariable = ob_get_clean();
	return $myvariable;
	}	
}
// Isotope Post Grid Masonry Shortcode End