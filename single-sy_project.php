
<?php get_header(); 
 $projectID=get_the_ID();

if ( have_posts() ) {
	$project_lat = get_post_meta( $projectID, '_et_listing_lat', true );
	$project_lng = get_post_meta( $projectID, '_et_listing_lng', true );
	if ( '' == $project_lat && '' == $project_lng ){
		$project_lat=12.980418292307993;
		$project_lng=80.25978098281712;
	}
	$marker_id = $projectID;
}?>
<script type="text/javascript">
 (function($){
    var map;
	var centre = new google.maps.LatLng(21.204847387161795, 79.1172028578171);
	var MY_MAPTYPE_ID = 'Outline';

	function initialise() {
	  var featureOpts = [
		{stylers: [
			{ hue: '#00278A' },
			{ visibility: 'simplified' },
			{ gamma: 0.5 },
			{ weight: 0.9 }
		  ]
		},
		{elementType: 'labels',
		  stylers: [
			{ visibility: 'off' }
		  ]
		},
		{featureType: 'water',
		  stylers: [
			{ color: '#00278A' }
		  ]
		}
	  ];

	  var mapOptions = {
		zoom: 4,
		center: centre,
		mapTypeControlOptions: {
		  mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
		},
		mapTypeId: MY_MAPTYPE_ID,
    	disableDefaultUI: true
	  };
	  
	  map = new google.maps.Map(document.getElementById('mapLocation'),
		  mapOptions);

	  var styledMapOptions = {
		name: 'Outline'
	  };

	  var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

	  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
	  sy_add_marker(map, <?php printf( ' %1$d, %2$s, %3$s',$marker_id, $project_lat, $project_lng); ?>);
	}

	function sy_add_marker( map,marker_order, marker_lat, marker_lng){
		var marker_id = 'sy_marker_' + marker_order;
		var image = {
			url: "<?php echo get_stylesheet_directory_uri(); ?>/images/plant-white.png",
			// This marker is 20 pixels wide by 32 pixels tall.
			size: new google.maps.Size(30,34),
			// The origin for this image is 0,0.
			origin: new google.maps.Point(0,0),
			// The anchor for this image is the base of the flagpole at 0,32.
			//anchor: new google.maps.Point(0, 32)
		  };
		var myLatLng = new google.maps.LatLng(marker_lat, marker_lng);
		var marker = new google.maps.Marker({
			id : marker_id,
			position: myLatLng,
			map: map,
			icon: image
		});

	}
	google.maps.event.addDomListener(window, 'load', initialise);
})(jQuery)
	</script>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

	<?php
		if ( have_posts() ) {
			the_post();
			if(is_project_visible(203)){
				// Start the Loop.
					//$content= get_the_content();
					
					$livesite = get_post_meta($projectID, "project_livesite_url", true );
					$input = trim($livesite, '/');
					if (!preg_match('#^http(s)?://#', $input)) {
                       $input = 'http://' . $input;
                    }
                    $urlParts = parse_url($input);
                    $domain = preg_replace('/^www\./', '', $urlParts['host']);
				//	echo "<pre>",print_r($project_visibility_value),"</pre>";
				//	echo $project_visibility;
				
				 ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							// Page thumbnail and title.
							echo '<div class="col-1-3">';
							
							syllogic_post_thumbnail();
								echo '<div id="mapLocation" class="gmap3"></div>';
								echo '</div>';
							the_title( '<header class="entry-header"><a href="' . esc_url( get_permalink() ) . '"><h1 class="entry-title">', '</h1></a></header><!-- .entry-header -->' );
						?>
						<div class="entry-content">
							
								<?php
									$clientID= get_post_meta($projectID, "client_post", true );
									$query = new WP_Query(array(  'post_type' => 'sy_client',  'post__in' => array($clientID)));
									if ( $query->have_posts() ){
										$query->the_post();
										$siteDomain = '';
										if($livesite != '' && $domain != '')
											$siteDomain = ' (<a href="'.$livesite.'" target="_blank">'.$domain.'</a>)';
										echo '<h4>'. get_the_title().$siteDomain.'</h4>';
								  
									 	//echo $content;
									 	the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) );
									 }?>
							
							<div class="pupdate_grid">
							<h4>Project Updates</h4>
							<?php
			                        $query = new WP_Query(array(  'post_type' => 'sy_project_update',  
			                                                        'meta_key' => 'project_update',
			                                                        'meta_value' => $projectID));
									  	if ( $query->have_posts() ){ 
									  	 	while ( $query->have_posts() ) : $query->the_post();
									  	 	$date = get_the_date();
									  	   // $query->the_post();
									  	    ?>
									  	    
											 <div class="col-4-12">
												<div id="post-<?php  the_ID(); ?>"  <?php post_class(); ?>>
                            						<?php
                            							// Page thumbnail and title.
                            							syllogic_post_thumbnail(true);
                            							the_title( '<header class="entry-header"><a href="' . esc_url( get_permalink() ) . '"><h1 class="entry-title">', '</h1></a></header><!-- .entry-header -->' );
                            						?>
                            						<h6>Date posted: <?php echo $date ?></h6>
                            					</div>
										      </div>
        								  	  <?php
        								      endwhile;
    									 } 
    									 else{
    									      echo "There are currently no updates for this project";
    									 }
    							?>
    				        	</div><!-- .pupdate_grid -->
							<?php
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
			} else{ ?>
				<div class="login">
					<p> Please login to see this project details (<a href="http://office.shost.in/wp-login.php/">Login</a>) <a href="http://office.shost.in/blog/sy_project/">Back</a></p>
				</div>
		<?php }
		}else{
			// If no content, include the "No posts found" template.
			get_template_part( 'content', 'none' );
		} ?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
?>