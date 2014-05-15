<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script type="text/javascript" charset="utf-8"></script>
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" href="http://wordpress.syllogic.in/wp-content/themes/awesome_2014_right/images/logo_sq-32.ico" type="image/vnd.microsoft.icon"/>
	<link rel="icon" href="http://wordpress.syllogic.in/wp-content/themes/awesome_2014_right/images/logo_sq-32.ico" type="image/x-ico"/>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<!--[if (gte IE 6)&(lte IE 8)]>
  		<script type="text/javascript" src="js/selectivizr.js"></script>
  	<![endif]--> 
</head>

<body <?php body_class(); ?>>
<?php if ( wp_is_mobile() ) : ?>

        <header id="masthead" class="site-header" role="banner">
           <div id="big-top-mobile">
            <?php if ( get_header_image() ) : ?>
				<div id="site-header-mobile">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="280"  alt="">
					</a>
				</div>
			<?php endif; ?>
            </div>
		   
            <a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
            <a id="menu-toggle"  class="second" title="<?php _e( 'Click To Show Sidebar', 'awesome_2014' ); ?>" href="#slideout"><span class="genericon genericon-menu"></span></a>
        </header><!-- #masthead -->

	<?php else:  ?>

        <header id="masthead" class="site-header" role="banner">
            <div id="big-top">
            <?php if ( get_header_image() ) { ?>
				<div id="site-header">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
					</a>
				</div>
			<?php }else{ ?>
                <div class="header-main">
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                </div>
                    <?php $description = get_bloginfo( 'description', 'display' );
                    if ( ! empty ( $description ) ) :?>
                        <h2 class="topbar-description"><?php echo esc_html( $description ); ?></h2>
                    <?php endif; 
                } ?>
            </div>

            <nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
                <div class="search-toggle">
                    <a href="#search-container" class="screen-reader-text"><?php _e( 'Search', 'twentyfourteen' ); ?></a>
                </div>
                <div id="search-container" class="search-box-wrapper hide">
                    <div class="search-box">
                        <?php get_search_form(); ?>
                    </div>
                </div>
                <h1 class="menu-toggle"><?php _e( 'Primary Menu', 'twentyfourteen' ); ?></h1>
                <a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'container_class' => 'topbar-menu', ) ); ?>

            </nav>

        </header><!-- #masthead -->

	<?php endif; ?>
<div id="page" class="hfeed site">
	    
	
	<?php
	if ( is_user_logged_in() ) {
	$user_ID = get_current_user_id();
	$user_Role = get_cimyFieldValue($user_ID, 'USER_VISIBILITY');	
			//echo $role;
			if ( $user_Role == "Client" ) {
				?>
				<style>
					/* .sub-menu .menu-item-336,
					.sub-menu .menu-item-335,
					.sub-menu .menu-item-334,
					.sub-menu .menu-item-333,
					.sub-menu .menu-item-274,
					.sub-menu .menu-item-328,
					.sub-menu .menu-item-329,
					.sub-menu .menu-item-331,
					.sub-menu .menu-item-332,
					.sub-menu .menu-item-330,
					.sub-menu .menu-item-400,
					.sub-menu .menu-item-337{
						display: none;
					}*/
					#menu-left-hand-menu #menu-item-272 ul.sub-menu, 
					#menu-left-hand-menu #menu-item-274 ul.sub-menu {
						display: none;
					}
					#menu-left-hand-menu #menu-item-272 a:before, 
					#menu-left-hand-menu #menu-item-274 a:before {
						 content: "";
					}
				</style>
				
				<?php
				

			}
	}
?>	

	<div id="main" class="site-main">
