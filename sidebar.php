<?php
/**
 * The Sidebar containing the main widget area
 *
 */
?>

<?php

	if ( wp_is_mobile() ) :

	// display mobile sidebar    ?>
        <div id="slideout" class="sidr">
           <div id="slideout-top">
               <?php
                   $description = get_bloginfo( 'description', 'display' );
                   if ( ! empty ( $description ) ) :
                       ?>
                       <h2 class="site-description"><?php echo esc_html( $description ); ?></h2>
                <?php endif; ?>
               <div class="search-toggle">
                   <a href="#search-container" class="screen-reader-text"><?php _e( 'Search', 'twentyfourteen' ); ?></a>
               </div>
               <div id="search-container" class="search-box-wrapper hide">
                   <div class="search-box">
                       <?php get_search_form(); ?>
                   </div>
               </div>
            </div>

            <?php if ( has_nav_menu( 'mobile' ) ) : ?>
                <nav role="navigation" class="navigation site-navigation">
                    <?php wp_nav_menu( array( 'theme_location' => 'mobile' ) ); ?>
                </nav>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'sidebar-mobile' ) ) : ?>
                <div id="mobile-sidebar" class="widget-area" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-mobile' ); ?>
                </div><!-- #mobile-sidebar -->
            <?php endif;?></div>

        </div> <!-- #seconday-mobile -->

<?php
	else:
	
	// display normal sidebar    ?>
	<div id="secondary">
		<?php if ( has_nav_menu( 'secondary' ) ) : ?>
		<nav role="navigation" class="navigation site-navigation secondary-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
		</nav>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #primary-sidebar -->
		<?php endif; ?>
	</div><!-- #secondary -->
		
<?php 
	endif;    ?>