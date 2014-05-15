<?php get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				
					$content= get_the_content();
					
					$project_memembers_array=get_post_meta( get_the_ID(), "projects_team", false );
					
					$project_memembers=$project_memembers_array[0];
				//  $unser = maybe_unserialize( $project_memembers);
				//	echo "<pre>",print_r ( $project_memembers ),"</pre>";

		?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							// Page thumbnail and title.
							syllogic_post_thumbnail();
							the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
						?>
						<div class="entry-content">
							<div class="entry-content1">
									<?php
										$id= get_post_meta(get_the_ID(), "project_update", true );
										$query = new WP_Query(array(  'post_type' => 'sy_project',  'post__in' => array($id)));
										if ( $query->have_posts() ){
												$query->the_post();	?>
														<h4>Project : <a href="<?php echo get_permalink(); ?>"><?php echo  the_title(); ?></a> </h4>
											
									<?php	} ?>
									<h3><b>Project team memembers</b><h3>
									<?php
									//echo sizeof($project_memembers);
								if (sizeof($project_memembers) > 0 && is_array($project_memembers) ){
									foreach($project_memembers as $key => $team){
										echo 'Member Name : <b>'.$team['teammembername'].'</b><br>';
										echo 'Member Email : '.$team['teammemberemail'].'<br>';										
										echo 'Member Effort : '.$team['teammembereffort'].'<br>';
									}
									}
									else{
									 echo "No project memembers";
									}
									?>
								</div>
							<?php
								//echo $content."<br>";
							
								
								the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) );
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