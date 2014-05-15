<?php get_header(); ?>


	<div id="main-content" class="main-content">

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
				<?php if ( have_posts() ) : ?>
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();
						$content= get_the_content();
						$trimmed_content = wp_trim_words( $content, 10, '<a href="'. esc_url( get_permalink() ) .'"> Read More...</a>' );
							?>
					<article  class="grid_fourth" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
								
							// Page thumbnail and title.
							syllogic_post_thumbnail(true);
						
							the_title( '<header class="entry-header" style="max-width: 76%;"><a href="' . esc_url( get_permalink() ) . '"><h1 class="entry-title">', '</h1></a></header><!-- .entry-header -->' );
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