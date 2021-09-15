<?php

/*

 * Equal height overlay template.
 *
 * This template can be overriden by copying this file to your-theme/bs5-isotope/sc-equal-height-overlay.php
 *
 * @author 		Bastian Kreiter
 * @package 	bS5 Isotope
 * @version     1.0.0

Registers the Masonry Shortcode [bs-isotope-equal-height-overlay type="post" tax="category" cat_parent="CATEGORY PARENT ID"] or [bs-isotope-equal-height-overlay type="isotope" tax="isotope_category" cat_parent="CATEGORY PARENT ID"]
*/


// Isotope Grid Masonry Overlay Shortcode
add_shortcode( 'bs-isotope-equal-height-overlay', 'isotope_equal_height_overlay_shortcode' );
function isotope_equal_height_overlay_shortcode( $atts ) {
	ob_start();
	extract( shortcode_atts( array (
        'cat_parent'    => '',
        'type' => '',
		'tax' => '',
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
    <div id="filters-equal-height-overlay" class="filter-buttons btn-group">
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
<div id="equal-height-overlay" class="row">
    <?php //while ( $the_query->have_posts() ) : $the_query->the_post(); 
	while ( $query->have_posts() ) : $query->the_post(); 
	$termsArray = get_the_terms( $post->ID, $tax );  //Get the terms for this particular item
	$termsString = ""; //initialize the string that will contain the terms
		foreach ( $termsArray as $term ) { // for each term 
			$termsString .= $term->slug.' '; //create a string that has all the slugs 
		}
	?>
    <div class="<?php echo $termsString; ?> item col-md-6 col-lg-4 col-xxl-3"> <?php // 'item' is used as an identifier (see Setp 5, line 6) ?>

        <div class="card mb-4 bg-dark text-white border-0">

            <!-- Featured Image-->            
            <?php the_post_thumbnail('medium', array('class' => 'rounded')); ?>

            <div class="card-img-overlay d-flex align-items-center justify-content-center text-center">
                <div class="overlay-content">
                    <!-- Title -->
                    <h2 class="blog-post-title card-title">
                        <!--<a href="<?php the_permalink(); ?>">-->
                        <?php the_title(); ?>
                        <!--</a>-->
                    </h2>
                    
                    <?php the_excerpt(); ?>

                    <!-- Read more -->
                    <div class="readmore">
                        <a class="btn btn-outline-light d-inline" href="<?php the_permalink(); ?>"><?php _e('Read more »', 'bootscore'); ?></a>
                    </div>
                </div>

            </div>

        </div>
        
    </div> <!-- end item -->
    <?php endwhile;  ?>
</div> <!-- end masonry overlay -->
<?php endif; ?>
<!-- Grid End -->

<?php wp_reset_query(); // Reset query ?>



<?php $myvariable = ob_get_clean();
	return $myvariable;
	}	
}
// Isotope Post Grid Masonry Overlay Shortcode End
