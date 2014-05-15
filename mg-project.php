<?php
/*
Template Name: wp projects 
*/
get_header();
$project_visibility_value=array(1=>"Syllogic",2=>"Client",	3=>"Public");
?>
<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		 <?php 
			global $switched;
			get_current_blog_id();
			switch_to_blog(1);
			
		 ?> 
		<?php
			$type = 'sy_project';
			
			
			$args=array(
			  'post_type' => $type,
			  'post_status' => 'publish',
			  'posts_per_page' => -1
			
			  );

			$my_query = null;
			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ) :
			  while ($my_query->have_posts()) : $my_query->the_post(); 
				$content= get_the_content();
				$trimmed_content = wp_trim_words( $content, 15, '<a href="'. esc_url( get_permalink() ) .'"> ...Read More</a>' );
				$terms = get_the_terms(get_the_ID(), 'syl_proj_cat_taxonomy');
				$visible_ID = get_post_meta(get_the_ID(), "project_visibility", true );
				$visible_name = $project_visibility_value[$visible_ID];
				 if ($terms && ! is_wp_error($terms)) :
	                $term_name_arr = array();
                    	foreach ($terms as $term) {
                    	   $term_name_arr[] = '<a href="'.get_term_link( $term->slug, 'syl_proj_cat_taxonomy' ) .'">'
							                    .$term->name.'</a>'; 
							$term_name[] 	=	$term->name;			
                    	}
                    	$terms_name_str = join( " | ", $term_name_arr);
                    endif;
					if( in_array("Magento", $term_name) && $visible_name == "Public"){	
				?>
				 
				<article class="grid_fourth" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
						syllogic_post_thumbnail(true);
						the_title( '<header class="entry-header"><a href="' . esc_url( get_permalink() ) . '"><h1 class="entry-title">', '</h1></a></header><!-- .entry-header -->' );
						$id= get_post_meta(get_the_ID(), "client_post", true );
							$query = new WP_Query(array(  'post_type' => 'sy_client',  'post__in' => array($id)));
							if ( $query->have_posts() ){
									$query->the_post();	?>
							<span class="client_cat">(Project category : <?php echo  $terms_name_str; ?>)</span>	
							<h4>Client : <?php echo the_title(); ?></h4>
						<?php	} ?>
				<div class="entry-content">
					<?php
						echo $trimmed_content;
						
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
			}					
			unset($term_name_arr);
			unset($term_name);
			endwhile;
				// Previous/next post navigation.
				twentyfourteen_paging_nav();
								

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif; 
			
			
			?>
			<?php	wp_reset_query();  // Restore global post data stomped by the_post(). ?>
		</div>
	</div>
</div><!-- #main-content -->
 <?php restore_current_blog() ?> 

<?php 
get_sidebar();
get_footer(); ?>