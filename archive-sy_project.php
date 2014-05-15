<?php get_header(); ?>
<div id="main-content " class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();
					$content= get_the_content();
					$trimmed_content = wp_trim_words( $content, 15, '<a href="'. esc_url( get_permalink() ) .'"> ...Read More</a>' );
					$excerpt= get_the_excerpt();
			    	$terms = get_the_terms($post->ID, 'syl_proj_cat_taxonomy' );
					//echo "<pre>",print_r($terms),"</pre>";
					$visible_ID = get_post_meta(get_the_ID(), "project_visibility", true );
					//$visible_name = $project_visibility_value[$visible_ID];
                    if ($terms && ! is_wp_error($terms)) :
	                $term_name_arr = array();
                    	foreach ($terms as $term) {
                    	    $term_name_arr[] = '<a href="'.get_term_link( $term->slug, 'syl_proj_cat_taxonomy' ) .'">'
							                    .$term->name.'</a>';
                    	}
						
                    	$terms_name_str = join( " | ", $term_name_arr);
                    endif;
		
		
				
		?>
				
					<article class="grid_fourth" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					 
						<?php
					
							//echo "The Visibility: ".$visible_ID;
							// Page thumbnail and title.
							//echo 1, 2, 3;
					    	syllogic_post_thumbnail(true);
							the_title( '<header class="entry-header"><a href="' . esc_url( get_permalink() ) . '"><h1 class="entry-title">', '</h1></a></header><!-- .entry-header -->' );
							$id= get_post_meta(get_the_ID(), "client_post", true );
							$query = new WP_Query(array(  'post_type' => 'sy_client',  'post__in' => array($id)));
							if ( $query->have_posts() ){
									$query->the_post();
						?>
							<span class="client_cat">(Project category : <?php echo  $terms_name_str; ?>)</span>
							<h4>Client : <?php echo the_title(); ?></h4>
						<?php	} ?>
						<div class="entry-content">
							<?php
								echo $trimmed_content;
								echo $categories;
								//echo $term.'here';
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								) );

								edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' );
							?>
						</div><!-- .entry-content -->
					</article>
					
		<?php
				endwhile;
				// Previous/next post navigation.
				twentyfourteen_paging_nav();
								

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
			
		?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); 
	    
	?>
</div><!-- #main-content -->

<?php

get_sidebar();
get_footer();
?>