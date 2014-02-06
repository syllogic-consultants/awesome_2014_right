<?php
/* Disable WordPress Admin Bar for all users but admins. */
add_filter('show_admin_bar', '__return_false');

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
    $
    $args = array(
		'post_type' => array( 'post', '[custom post type]'),
		'tag' => $tag_name,
		'posts_per_page' => $max_posts,
		'order_by' => 'name',
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
            	} );
            	
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
            wp_enqueue_script( 'awesome_2014-slider', get_stylesheet_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery', 'awesome_2014-script' ), '' , true );
            wp_localize_script( 'awesome_2014-slider', 'featuredSliderDefaults', array(
                'prevText' => __( 'Previous', 'awesome_2014' ),
                'nextText' => __( 'Next', 'awesome_2014' )
            ) );
        }
}
add_action( 'wp_enqueue_scripts' , 'awesome_2014_featured_content_scripts' , 999 );

