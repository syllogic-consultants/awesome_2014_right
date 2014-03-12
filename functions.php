<?php
/* Disable WordPress Admin Bar for all users but admins. */
add_filter('show_admin_bar', '__return_false');

/*add WP 3.8 dashicons for use in css*/
function themename_scripts() {
wp_enqueue_style( 'themename-style', get_stylesheet_uri(), array( 'dashicons' ), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'themename_scripts' );
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
wp_enqueue_style( 'slideout', get_stylesheet_directory_uri().'/js/sidr/stylesheets/jquery.sidr.dark.css');
}

// add only if is mobile
if ( wp_is_mobile() ) {
add_action( 'wp_enqueue_scripts', 'awesome_2014_add_slideout', 10 );
}

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
            		var minH = _window.height() - $('#masthead').outerHeight(true);
            		$('#secondary').css('min-height',minH);
            	} );
            	_window.resize( function() {
                    var minH = _window.height() - $('#masthead').outerHeight(true);
            		$('#secondary').css('min-height',minH)   
                });
            } )( jQuery );
        </script>
    <?php 
    }
} 

add_action('wp_footer', 'awesome_2014_initialise_slider');

//dequeue/enqueue scripts
function awesome_2014_featured_content_scripts() {
    wp_dequeue_script( 'twentyfourteen-script' );
    wp_dequeue_script( 'twentyfourteen-slider' );
    
    wp_enqueue_script( 'awesome_2014-script', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery' ), '' , true );
    if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
            wp_enqueue_style( 'custom-slider', get_stylesheet_directory_uri() . '/css/slider.css' );
            wp_enqueue_script( 'awesome_2014-slider', get_stylesheet_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery', 'awesome_2014-script' ), '' , true );
            wp_localize_script( 'awesome_2014-slider', 'featuredSliderDefaults', array(
                'prevText' => __( 'Previous', 'awesome_2014' ),
                'nextText' => __( 'Next', 'awesome_2014' )
            ) );
        }
}
add_action( 'wp_enqueue_scripts' , 'awesome_2014_featured_content_scripts' , 999 );

function syllogic_post_thumbnail() {
	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}
    $quoted = get_post_meta(get_the_ID(),"quoted_text");
	if ( is_singular() ) :
	?>
	
	<div class="post-thumbnail">
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
	</div>

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>">
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
                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
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

?>