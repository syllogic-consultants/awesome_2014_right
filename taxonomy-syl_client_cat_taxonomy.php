<?php get_header(); ?>


	<div id="main-content" class="main-content">

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
				<?php if ( have_posts() ) : ?>
					<?php
						// Start the Loop.
						$i=1;
						while ( have_posts() ) : the_post();
                            $content= get_the_content();
				        	$trimmed_content = wp_trim_words( $content, 15, '<a href="'. esc_url( get_permalink() ) .'"> ...Read More</a>' );
							?>
					<article class="col-1-2" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							if($i==1 or $i==2 or $i==5 or $i==6) :	
							// Page thumbnail and title.
							syllogic_post_thumbnail(true);
						    endif;
						    echo '<div class="grid_content">';
							the_title( '<header class="entry-header"><a href="' . esc_url( get_permalink() ) . '"><h1 class="entry-title">', '</h1></a></header><!-- .entry-header -->' );
						?>
						<div class="entry-content">
							<?php
								echo $trimmed_content;
								
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								) );

								edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' );
							?>
						</div><!-- .entry-content -->
						</div>
						<?php 
						    	if($i==3 or $i==4):	
							// Page thumbnail and title.
							syllogic_post_thumbnail(true);
					     	endif;
					     	$i++;
						?>
							
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
		<?php get_sidebar( 'content' ); ?>
	</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
?>