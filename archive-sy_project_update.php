<?php get_header();

$postid = (isset($_GET['ID']))?$_GET['ID']:'';

 ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content grid_view" role="main">

		<?php
			if ( have_posts()) :
				// Start the Loop.
				//while((!isset($post_id))?have_posts():$custom_query->have_posts()) : 
				while(have_posts()) : the_post();
				   $project_id = get_post_meta( get_the_ID(), 'project_update', true);
						if((empty($postid)) || (isset($postid) && $project_id == $postid)) :
							$content= get_the_content();
							$trimmed_content = wp_trim_words( $content, 05, '<a href="'. esc_url( get_permalink() ) .'"> ...Read More</a>' );
							$excerpt= get_the_excerpt();
		?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							// Page thumbnail and title.
							syllogic_post_thumbnail();
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
						
					</article>
					
		<?php
				      endif;
					
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