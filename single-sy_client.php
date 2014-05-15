<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php
			if ( have_posts() ) :
				 the_post();
					$content= get_the_content();
					
		?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							// Page thumbnail and title.
							syllogic_post_thumbnail();
							the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
						?>
						<div class="entry-content">
							<?php
								//echo $content."<br>";
								the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) );								
								//echo "<p><b>Contact Name</b> : ".get_post_meta( get_the_ID(), "contact_person", true )."</p>";
								
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