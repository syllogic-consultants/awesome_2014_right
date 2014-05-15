<?php
//load our shortcodes
require_once(STYLESHEETPATH . '/includes/sy_shortcodes.php');
//load invoicing functions if this is the admin site:
if(isAdmin()){
	require_once(STYLESHEETPATH . '/includes/invoicing-functions.php');
}

/* Disable WordPress Admin Bar for all users but admins. */
add_filter('show_admin_bar', '__return_false');

/* function to quickly access the root domain and verify if localhosted*/

function sy_get_domain_name(){
	
	$domain_name =  preg_replace('/^www\./','',$_SERVER['SERVER_NAME']);
	
	return $domain_name; 

}
function isMainSite(){
	return is_maint_site();
}
function isWordpress(){
	if("wordpress.syllogic.in" == sy_get_domain_name()) return true;
	else return false;
}
function isMagento(){
	if("magento.syllogic.in" == sy_get_domain_name()) return true;
	else return false;
}
function isBi(){
	if("bi.syllogic.in" == sy_get_domain_name()) return true;
	else return false;
}
function isAdmin(){
	if("admin.syllogic.in" == sy_get_domain_name()) return true;
	else return false;
}
/*
Let's put a favicon to our dashboard page.
*/
function sy_admin_area_favicon() {
	$favicon_url = get_stylesheet_directory_uri() . '/images/logo_sq-32.ico';
	echo '<link rel="shortcut icon" href="' . $favicon_url . '"  type="image/vnd.microsoft.icon"/>';
	echo '<link rel="icon" href="' . $favicon_url . '" type="image/x-ico"/>';
}	 
add_action('admin_head', 'sy_admin_area_favicon');

/*add WP 3.8 dashicons for use in css*/
function syllogic_css_scripts() {
	// child theme css
	//wp_enqueue_style( '2014-right-style', get_stylesheet_uri(), array( 'dashicons' ), '1.0' );
	//screen styles for responsive layout
	wp_enqueue_style( 'screen-default-style', get_stylesheet_directory_uri().'/css/style-screen-default.css', array( 'twentyfourteen-style','dashicons' ), '1.0', 'screen' );
	wp_enqueue_style( 'comments-style', get_stylesheet_directory_uri().'/css/comments.css', array( 'twentyfourteen-style','screen-default-style' ), '1.0', 'screen' );
	wp_enqueue_style( 'quotes-style', get_stylesheet_directory_uri().'/css/quotes.css', array( 'twentyfourteen-style','screen-default-style' ), '1.0', 'screen' );
	wp_enqueue_style( 'screen-1100-style', get_stylesheet_directory_uri().'/css/style-screen-1100.css', array( 'twentyfourteen-style','screen-default-style' ), '1.0', 'screen and (max-width: 1100px)' );
	wp_enqueue_style( 'screen-995-style', get_stylesheet_directory_uri().'/css/style-screen-995.css', array( 'twentyfourteen-style','screen-default-style' ), '1.0', 'screen and (max-width: 995px)' );
	wp_enqueue_style( 'screen-670-style', get_stylesheet_directory_uri().'/css/style-screen-670.css', array( 'twentyfourteen-style','screen-default-style' ), '1.0', 'screen and (max-width: 670px)' );
	wp_enqueue_style( 'screen-435-style', get_stylesheet_directory_uri().'/css/style-screen-435.css', array( 'twentyfourteen-style','screen-default-style' ), '1.0', 'screen and (max-width: 435px)' );
     wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'syllogic_css_scripts' );
/*
    get the slug for a post to use in unique css id/class nameing
*/
function the_slug(){
  $slug = basename(get_permalink());
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  //if( $echo ) echo $slug;
  do_action('after_slug', $slug);
  return $slug;
}

if ( ! function_exists( 'awesome2014right_setup' ) ) :
function awesome2014right_setup() {

	// This theme allows users to set a custom background, let-s reset it.
	add_theme_support( 'custom-background', apply_filters( 'twentyfourteen_custom_background_args', array(
		'default-color' => '#878787',
	) ) );

}
endif; // twentyfourteen_setup
add_action( 'after_setup_theme', 'awesome2014right_setup' );

//Add mobile sidebar
function awesome_2014_mobile_widget_area() {
    register_sidebar( array(
        'name' => __( 'Mobile Sidebar', 'awesome_2014' ),
        'id' => 'sidebar-mobile',
        'description' => __( 'Slideout sidebar for mobile devices.', 'awesome_2014' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s mobile-widget">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'awesome_2014_mobile_widget_area' );

//add mobile menu
function awesome_2014_setup() {
    register_nav_menus( array(
        'mobile' => __( 'Mobile menu in left sidebar', 'awesome_2014' ),
    ) );
}
add_action( 'after_setup_theme', 'awesome_2014_setup' );

/**
* Add slideout Sidebar
*/
// Enqueue the css/js for slideout
function awesome_2014_add_slideout() {
    wp_enqueue_script( 'sidr', get_stylesheet_directory_uri().'/js/sidr/jquery.sidr.min.js', array('jquery'), null, true );
    wp_enqueue_script( 'slideout', get_stylesheet_directory_uri().'/js/slideout.js', array('sidr'), null, true );
    wp_enqueue_style( 'slideout-css', get_stylesheet_directory_uri().'/js/sidr/stylesheets/jquery.sidr.dark.css');
    wp_enqueue_style( 'sy-slideout-css', get_stylesheet_directory_uri().'/css/slideout-menu.css');
}
// add only if is mobile
if ( wp_is_mobile() ) {
    add_action( 'wp_enqueue_scripts', 'awesome_2014_add_slideout', 10 );
}

//dequeue/enqueue scripts
function awesome_2014_featured_content_scripts() {
	wp_dequeue_script( 'twentyfourteen-slider' );
	wp_dequeue_script( 'twentyfourteen-script' );
    wp_enqueue_script( 'awesome_2014-script', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery' ), '' , true );

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
        
		//if (! wp_is_mobile() ) {  //for the desktop flexslider
			wp_enqueue_style( 'custom-slider', get_stylesheet_directory_uri() . '/css/slider.css' );
			wp_enqueue_script( 'awesome_2014-slider', get_stylesheet_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery', 'awesome_2014-script' ), '' , true );
			wp_localize_script( 'awesome_2014-slider', 'featuredSliderDefaults', array(
				'prevText' => __( 'Previous', 'awesome_2014' ),
				'nextText' => __( 'Next', 'awesome_2014' )
			) );
		/*}else{ // for the mobile simple slider
			
			wp_enqueue_script( 'mobile-slider', get_stylesheet_directory_uri() . '/js/slider.js', array( 'jquery', 'awesome_2014-script' ), '', true );
			wp_localize_script( 'mobile-slider', 'featuredSliderDefaults', array(
				'prevText' => __( 'Previous', 'awesome_2014' ),
				'nextText' => __( 'Next', 'awesome_2014' )
			) );
		}*/
		
    }
    $queried_post_type = get_query_var('post_type');
    //we need Google Maps Api for the Project single template
    if ( is_single() && 'sy_project' ==  $queried_post_type ) {
        wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?sensor=false', array( 'jquery' ), '' , false );
        wp_enqueue_script( 'google-maps3', get_stylesheet_directory_uri() . '/js/gmap3.js', array( 'jquery','google-maps-api' ), '' , false );
    }
	
}
add_action( 'wp_enqueue_scripts' , 'awesome_2014_featured_content_scripts' , 999 );

//enqueue topbar js
function awesome_2014_add_topbarjs() {
wp_enqueue_script( 'topbarjs', get_stylesheet_directory_uri().'/js/topbar.js', array('jquery'), null, true );
}
//add if is not mobile
if ( !wp_is_mobile() ) {
add_action( 'wp_enqueue_scripts', 'awesome_2014_add_topbarjs' );
}

function awesome_2014_customize_register() {

    global $wp_customize;
    
    //add extended featured content section
    
    //add controls
    $wp_customize->add_setting( 'num_posts_grid', array( 'default' => '6' ) );
    $wp_customize->add_setting( 'num_posts_slider', array( 'default' => '6' ) );
    $wp_customize->add_setting( 'speed_posts_slider', array( 'default' => '5000' ) );
    $wp_customize->add_setting( 'delay_posts_slider', array( 'default' => '5000' ) );
    $wp_customize->add_setting( 'layout_mobile', array( 'default' => 'grid' ) );
    
    $wp_customize->add_control( 'num_posts_grid', array(
    'label' => __( 'Number of posts for grid', 'text-domain'),
    'section' => 'featured_content',
    'settings' => 'num_posts_grid',
    ) );
    
    $wp_customize->add_control( 'num_posts_slider', array(
    'label' => __( 'Number of posts for slider', 'text-domain'),
    'section' => 'featured_content',
    'settings' => 'num_posts_slider',
    ) );
    $wp_customize->add_control( 'speed_posts_slider', array(
    'label' => __( 'Speed of transition for slider (ms)', 'text-domain'),
    'section' => 'featured_content',
    'settings' => 'speed_posts_slider',
    ) );
    $wp_customize->add_control( 'delay_posts_slider', array(
    'label' => __( 'Initial delay for slider (ms)', 'text-domain'),
    'section' => 'featured_content',
    'settings' => 'delay_posts_slider',
    ) );
    
    $wp_customize->add_control( 'layout_mobile', array(
			'label' => __( 'Layout for mobile devices', 'text-domain'),
			'section' => 'featured_content',
			'settings' => 'layout_mobile',
			'type' => 'select',
			'choices' => array(
			'grid' => 'Grid',
			'slider' => 'Slider',
		),
    ) );
}

add_action( 'customize_register', 'awesome_2014_customize_register' );

function awesome_2014_theme_mod( $value ) {

    if ( wp_is_mobile() ){
        return get_theme_mod( 'layout_mobile', 'grid' );
    } else {
        return $value;
    }
}

add_filter( 'theme_mod_featured_content_layout', 'awesome_2014_theme_mod' );

function awesome_2014_get_featured_posts( $posts ){

    $fc_options = (array) get_option( 'featured-content' );

    if ( $fc_options ) {
    $tag_name = $fc_options['tag-name'];
    } else {
    $tag_name = 'featured';
    }
    
    $layout = get_theme_mod( 'featured_content_layout' );
    $max_posts = get_theme_mod( 'num_posts_' . $layout, 2 );
    
    $args = array(
		'post_type' => array( 'post', '[custom post type]'),
		'tag' => $tag_name,
		'posts_per_page' => $max_posts,
		'orderby' => 'name',
		'order' => 'ASC',
		'post_status' => 'publish',
    );
    //print_r($args);
    $new_post_array = get_posts( $args );
    
    if ( count($new_post_array) > 0 ) {
        return $new_post_array;
    } else {
        return $posts;
    }

}

add_filter( 'twentyfourteen_get_featured_posts', 'awesome_2014_get_featured_posts', 999, 1 );

//add slider initialisation to footer
function awesome_2014_initialise_slider(){ 
    $layout = get_theme_mod( 'featured_content_layout' );
    if($layout = "slider"){
        $speed = get_theme_mod( 'speed_posts_slider', 4500 );   
        $delay = get_theme_mod( 'speed_posts_slider', 0 );
    ?>
        <script type="text/javascript">
            ( function( $ ) {
				var body    = $( 'body' ),
					_window = $( window );
                // Initialize Featured Content slider.
            	_window.load( function() {
            		if ( body.is( '.slider' ) ) {
            			$( '.featured-content' ).flexslider( {
            				selector: '.featured-content-inner > article',
            				controlsContainer: '.featured-content',
            				slideshow: true,
            				slideshowSpeed: <?php echo $speed; ?>,
            				initDelay: <?php echo $delay; ?>,
            				namespace: 'slider-',
            			} );
            		}
					
            		var minH = _window.height() - $('#masthead').outerHeight();
            		$('#secondary').css('min-height',minH);
            	<?php if ( !wp_is_mobile() ) {?>
            		var leftSearch = _window.width() - $('#page').outerWidth();
            		$('.search-toggle').css('left',leftSearch);
            	<?php }?>
            	} );
            	_window.resize( function() {
                    var minH = _window.height() - $('#masthead').outerHeight();
            		$('#secondary').css('min-height',minH)  
            	<?php if ( !wp_is_mobile() ) {?>
            		var leftSearch = _window.width() - $('#page').outerWidth();
            		$('.search-toggle').css('left',leftSearch);
            	<?php }?>
                });
            } )( jQuery );
        </script>
    <?php 
    }
} 
add_action('wp_footer', 'awesome_2014_initialise_slider');

//add slider initialisation to footer
function mobile_wp_2014_initialise_slider(){ 
    $layout = get_theme_mod( 'featured_content_layout' );
    if($layout = "slider"){
    ?>
        <script type="text/javascript">
            ( function( $ ) {
				
				var body    = $( 'body' ),
					_window = $( window );
			// Initialize Featured Content slider.
				_window.load( function() {
					if ( body.is( '.slider' ) ) {
						$( '.featured-content' ).featuredslider( {
							selector: '.featured-content-inner > article',
							controlsContainer: '.featured-content'
						});
					}
			});
            } )( jQuery );
</script>
    <?php 
    }
} 


function syllogic_post_thumbnail($isGrid=false) {
//echo $isGrid;
	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}
     $quoted = get_post_meta(get_the_ID(),"quoted_text");
	if ( is_singular() && !$isGrid) :
	?>
	
	<div class="post-thumbnail">
	
	<?php
	    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
        echo '<a class="fancybox" style=" margin: 0 auto;" href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
    		if ( ( ! is_active_sidebar( 'sidebar-2' ) || is_page_template( 'page-templates/full-width.php' ) ) ) {
    			the_post_thumbnail( 'twentyfourteen-full-width' );
    		} else {
    			the_post_thumbnail();
    		}
		if($quoted[0] !=''){
	?>
	   <blockquote><?php echo $quoted[0]; ?> </blockquote>
	<?php }
	?>
	</a>
	</div>

	<?php else : ?>
<div class="block-thumbnail<?php if($isGrid) echo "_grid"; ?>">
	<a class="post-thumbnail<?php if($isGrid) echo "_grid"; ?>" href="<?php the_permalink(); ?>">
	<?php
		if ( ( ! is_active_sidebar( 'sidebar-2' ) || is_page_template( 'page-templates/full-width.php' ) ) ) {
			the_post_thumbnail( 'twentyfourteen-full-width' );
		} else {
			the_post_thumbnail();
		}
		if($quoted[0] !=''){
	?>
	    <blockquote><?php echo $quoted[0]; ?> </blockquote>
	<?php }
	?>
	</a>
    </div>
	<?php endif; // End is_singular()
}
add_filter('twentyfourteen_post_thumbnail','syllogic_post_thumbnail',1,0);


function syllogic_theme_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<article id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		    <footer class="comment-meta comment-meta-syllogic">
		        <div class="comment-author comment-author-syllogic vcard">
		        <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		            <?php printf(__('<cite class="fn syllogic-cite">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
		        </div>
                <?php if ($comment->comment_approved == '0') : ?>
		            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
		            <br />
                <?php endif; ?>

    		    <div class="comment-metadata syllogic-comment-metadata">
                    <a  href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
                        </time>
                    </a>
                    <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
                </div><!-- .comment-metadata -->

			<div class="comment-content syllogic-comment-content">
		        <?php comment_text() ?>
            </div> <!-- comment-content -->
		    <div class="reply syllogic-reply">
		    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		    </div>
		    <?php if ( 'div' != $args['style'] ) : ?>
		</article> <!-- div-comment-<?php comment_ID() ?>-->
		<?php endif; ?>
<?php
}

function office_manage_project_columns( $column, $post_id ) {
     global $post;
	 $ID = get_post_meta($post_id, "client_post" , true );
    if($column == 'client_post') :
     $client = get_the_title($ID);
     echo $client; 
     endif;
}
add_action( 'manage_sy_project_posts_custom_column', 'office_manage_project_columns', 10, 2 );

function office_edit_project_columns( $columns ) {
    $columns = array(
		 'cb' => '<input type="checkbox" />',
        'client_post' => __( 'Client' )
    );
    return $columns;
} 
add_filter( 'manage_edit-sy_project_columns', 'office_edit_project_columns' ) ;

function is_project_visible( $postID ) {
	$isVisible = false;
	$project_visibility_value=array(1=>"Syllogic",2=>"Client",3=>"Public");
	if( "sy_project" == get_post_type( $postID )){
		$projectVisibility = get_post_meta( $postID, 'project_visibility', true );
		if ( is_user_logged_in() ) {
			$user_ID = get_current_user_id();
			$user_Role = get_cimyFieldValue($user_ID, 'USER_VISIBILITY');	
			//echo $user_Role;
			//get client contact email
			$clientPostID =  get_cimyFieldValue($user_ID, 'CLIENT_POST_ID');	
			//echo $clientPostID;
			switch($project_visibility_value[$projectVisibility]){
				case "Syllogic": // only syllogic users can see
					if($user_Role == "Syllogic") $isVisible = true;
					break;
				case "Client": // client projects: check user role and client post ID
					if($user_Role == "Syllogic") $isVisible = true;
					else if($user_Role == "Client"){
						$clientPost = get_post_meta( $postID, 'client_post', true );
						if($clientPost == $clientPostID) $isVisible = true;
					}
					break;
				case "Public":
					$isVisible = true;
					break;
				default: //general case
			}
		}else{ //no one is logged in, public view
			//echo $project_visibility_value[$projectVisibility]."here2";
			if ( "Public" == $project_visibility_value[$projectVisibility]) $isVisible = true;
		}
	}
	return $isVisible;
}

function sy_get_posts( $query ) {
	$project_visibility_value=array(1=>"Syllogic",2=>"Client",	3=>"Public");
  
	if ( is_post_type_archive( 'sy_project' ) && $query->is_main_query() ){
		if ( is_user_logged_in() ) {
			$user_ID = get_current_user_id();
			$user_Role = get_cimyFieldValue($user_ID, 'USER_VISIBILITY');	
			//echo $user_Role;
			//get client contact email
			$clientPostID =  get_cimyFieldValue($user_ID, 'CLIENT_POST_ID');	
			//echo $clientPostID;
			switch($user_Role){
				case "Syllogic": // do not set any query, want all posts
					break;
				case "Client": // client projects: visibility & ID
					$query->set( 'meta_query', array('relation' => 'AND',array('key'=> 'client_post',
																			'value'=>$clientPostID,
																			'compare' => '=',
																			'type' => 'NUMERIC'),
																		array( 'key'=> 'project_visibility',
																			'value'=>'2',
																			'compare' => '=',
																			'type' => 'NUMERIC')
																				
														)					
								);
					break;
				default: //general case
					$query->set( 'meta_key', 'project_visibility' ); 
					$query->set( 'meta_value',  '3');  //public projects only
			}
		}else{ //no one is logged in, public view

			$query->set( 'meta_key', 'project_visibility' );
			$query->set( 'meta_value',  '3');  //public projects only
		}
	}
	return $query;
}
add_filter( 'pre_get_posts', 'sy_get_posts' );
/*
function twentyfourteen_menu_args( $args ) {
	$args['show_home'] = false;
	return $args;
}
add_filter( 'wp_nav_menu', 'twentyfourteen_menu_args', 40 ); */

?>