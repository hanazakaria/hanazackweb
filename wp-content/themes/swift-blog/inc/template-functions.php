<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Swift Blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function swift_blog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
    global $post;
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    $global_layout = swift_blog_get_option( 'global_layout' );

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
      if ( $post && is_singular() ) {
          $post_options = get_post_meta( $post->ID, 'swift-blog-meta-select-layout', true );

          if (empty( $post_options ) ) {
              $global_layout = esc_attr( swift_blog_get_option('global_layout') );
          } else{
              $global_layout = esc_attr($post_options);
          }
      }

    if ($global_layout == 'left-sidebar') {
        $classes[]= 'left-sidebar';
    }
    elseif ($global_layout == 'no-sidebar') {
        $classes[]= 'no-sidebar';
    }
    else{
        $classes[]= 'right-sidebar';

    }

	return $classes;
}
add_filter( 'body_class', 'swift_blog_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function swift_blog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'swift_blog_pingback_header' );


if ( ! function_exists( 'swift_blog_archive_title' ) ) :
    function swift_blog_archive_title( $title ) {
        if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        } elseif ( is_post_type_archive() ) {
            $title = post_type_archive_title( '', false );
        } elseif ( is_tax() ) {
            $title = single_term_title( '', false );
        }

        return $title;
    }
endif;
add_filter( 'get_the_archive_title', 'swift_blog_archive_title' );


/**
 * Returns word count of the sentences.
 *
 * @since swift_blog 1.0.0
 */
if (!function_exists('swift_blog_words_count')):
function swift_blog_words_count($length = 25, $swift_blog_content = null) {
    $length          = absint($length);
    $source_content  = preg_replace('`\[[^\]]*\]`', '', $swift_blog_content);
    $trimmed_content = wp_trim_words($source_content, $length, '');
    return $trimmed_content;
}
endif;


if( ! function_exists( 'swift_blog_excerpt_length' ) ) :

    /**
     * Excerpt length
     *
     * @since  swift-blog 1.0.0
     *
     * @param null
     * @return int
     */
    function swift_blog_excerpt_length( $length ){
        if ( is_admin() ) {
                return $length;
        }
        $excerpt_length = swift_blog_get_option('excerpt_length_global');
        if ( empty( $excerpt_length) ) {
            $excerpt_length = $length;
        }
        return absint( $excerpt_length );

    }

endif;
add_filter( 'excerpt_length', 'swift_blog_excerpt_length', 999 );

if (!function_exists('swift_blog_get_localized_variables')) :
    /**
     * Returns localized variable.
     *
     * @since 1.0.0
     *
     * return array localized variables
     */
    function swift_blog_get_localized_variables(){
        /*For Ajax Load Posts*/
        $args['nonce'] = wp_create_nonce( 'sb-load-more-nonce' );
        $args['ajaxurl'] = admin_url( 'admin-ajax.php' );


        if( is_front_page() ){
            $args['post_type'] = 'post';
        }

        /*Support for custom post types*/
        if( is_post_type_archive() ){
            $args['post_type'] = get_queried_object()->name;
        }
        /**/

        /*Support for categories and taxonomies*/
        if( is_category() || is_tag() || is_tax() ){
            $args['cat'] = get_queried_object()->slug;
            $args['taxonomy'] = get_queried_object()->taxonomy;
            /*Get the associated post type for custom taxonomy*/
            if( is_tax() ){
                global $wp_taxonomies;
                $tax_object = isset( $wp_taxonomies[$args['taxonomy']] ) ? $wp_taxonomies[$args['taxonomy']]->object_type : array();
                $args['post_type'] = array_pop($tax_object);
            }
            /**/
        }
        /**/

        /*Support for search*/
        if( is_search() ){
            $args['search'] = get_search_query();
        }
        /**/

        /*Support for author*/
        if( is_author() ){
            $args['author'] = get_the_author_meta( 'user_nicename' ) ;
        }
        /**/

        /*Support for date archive*/
        if( is_date() ){
            $args['year'] = get_query_var('year');
            $args['month'] = get_query_var('monthnum');
            $args['day'] = get_query_var('day');
        }
        /**/

        return $args;
    }
endif;

if( ! function_exists( 'swift_blog_recommended_plugins' ) ) :

  /**
   * Recommended plugins
   *
   */
  function swift_blog_recommended_plugins(){
      $swift_blog_plugins = array(
        array(
            'name'     => __('Social Share With Floating Bar', 'swift-blog'),
            'slug'     => 'social-share-with-floating-bar',
            'required' => false,
        ),
        array(
            'name'     => __( 'MailChimp for WordPress', 'swift-blog' ),
            'slug'     => 'mailchimp-for-wp',
            'required' => false,
        ),
        array(
            'name'      => esc_html__('Demo Import Kit','swift-blog'),
            'slug'      => 'demo-import-kit',
            'required'  => false,
        ),
        array(
            'name'      => esc_html__('Themeinwp Import Companion','swift-blog'),
            'slug'      => 'themeinwp-import-companion',
            'required'  => false,
        ),
      );
      $swift_blog_plugins_config = array(
          'dismissable' => true,
      );
      
      tgmpa( $swift_blog_plugins, $swift_blog_plugins_config );
  }
endif;
add_action( 'tgmpa_register', 'swift_blog_recommended_plugins' );


/* Display Breadcrumbs */
if (!function_exists('swift_blog_get_breadcrumb')) :

    /**
     * Simple breadcrumb.
     *
     * @since 1.0.0
     */
    function swift_blog_get_breadcrumb()
    {
        // Bail if Home Page.
        if (is_front_page() || is_home()) {
            return;
        }
        $breadcrumb_type = swift_blog_get_option( 'breadcrumb_type' );
        if ( 'disabled' === $breadcrumb_type ) {
            return;
        }

        if (!function_exists('breadcrumb_trail')) {

            /**
             * Load libraries.
             */

            require_once get_template_directory() . '/assets/libraries/breadcrumb-trail/breadcrumb-trail.php';
        }

        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false,
        ); ?>


        <div class="twp-breadcrumbs">
            <?php breadcrumb_trail($breadcrumb_args); ?>
        </div>


    <?php }

endif;
add_action('swift_blog_action_get_breadcrumb', 'swift_blog_get_breadcrumb');

if ( ! function_exists( 'swift_blog_display_posts_navigation' ) ) :

  /**
   * Display Pagination.
   *
   * @since 1.0.0
   */
  function swift_blog_display_posts_navigation() {

        $pagination_type = swift_blog_get_option( 'pagination_type', true );
        switch ( $pagination_type ) {

            case 'default':
                the_posts_navigation();
                break;

            case 'numeric':
                the_posts_pagination();
                break;
            default:
                break;
        }
    return;
  }

endif;

add_action( 'swift_blog_posts_navigation', 'swift_blog_display_posts_navigation' );


if ( !function_exists('swift_blog_sub_menu_toggle_button') ) :

    function swift_blog_sub_menu_toggle_button($args, $item, $depth) {

        // Add sub menu toggles to the main menu with toggles
        if ($args->theme_location == 'primary-nav' && isset($args->show_toggles)) {

            // Wrap the menu item link contents in a div, used for positioning
            $args->before = '<div class="submenu-wrapper">';
            $args->after = '';

            // Add a toggle to items with children
            if (in_array('menu-item-has-children', $item->classes)) {

                $toggle_target_string = '.menu-item.menu-item-' . $item->ID . ' > .sub-menu';

                // Add the sub menu toggle
                $args->after .= '<button type="button" class="submenu-toggle" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="250"><span class="screen-reader-text">' . __('Show sub menu', 'swift-blog') . '</span>' .'<i class="fa fa-chevron-down"></i>' . '</button>';

            }
            // Close the wrapper
            $args->after .= '</div><!-- .submenu-wrapper -->';
            // Add sub menu icons to the main menu without toggles (the fallback menu)

        } elseif ($args->theme_location == 'primary-nav') {

            if (in_array('menu-item-has-children', $item->classes)) {

                $args->before = '<div class="link-icon-wrapper">';
                $args->after = '<i class="fa fa-chevron-down"></i></div>';

            } else {

                $args->before = '';
                $args->after = '';

            }

        }

        return $args;
    }

endif;

add_filter('nav_menu_item_args', 'swift_blog_sub_menu_toggle_button', 10, 3);

/**
 * CSS related hooks.
 *
 * This file contains hook functions which are related to CSS.
 *
 * @package Swift Blog
 */

if (!function_exists('swift_blog_trigger_custom_css_action')) :

    /**
     * Do action theme custom CSS.
     *
     * @since 1.0.0
     */
function swift_blog_trigger_custom_css_action()
{
    $swift_blog_header_bg_color = swift_blog_get_option('header_bg_color');
    $swift_blog_header_text_color = swift_blog_get_option('header_text_color');
    $swift_blog_site_title_identity_color = swift_blog_get_option('site_title_identity_color');
    $background_color = get_background_color();
    ?>
        <style type="text/css">
            <?php
            if (!empty($swift_blog_site_title_identity_color) ){
                ?>
                body header.site-header .site-branding,
                body header.site-header .site-branding a,
                body header.site-header .site-branding a:hover{
                    color: <?php echo esc_html($swift_blog_site_title_identity_color); ?>;
                }
                
            <?php  } ?>  
            <?php
                if( !empty($swift_blog_header_text_color) ){
                ?>
                body .twp-nav-main-navigation i,
                body header.site-header ul.twp-social-icons.twp-social-icons-white a,
                body header.site-header ul.twp-social-icons.twp-social-icons-white a:hover,
                body .twp-nav-main-navigation .twp-nav-right-content .twp-search-section i{
                    color: <?php echo esc_html($swift_blog_header_text_color); ?>
                }
                body .twp-nav-main-navigation .twp-menu-icon.twp-white-menu-icon span:before,
                body .twp-nav-main-navigation .twp-menu-icon.twp-white-menu-icon span:after{
                    background-color:  <?php echo esc_html($swift_blog_header_text_color); ?>
                } 
                body .twp-nav-main-navigation.sticky i,
                body header.site-header .sticky ul.twp-social-icons.twp-social-icons-white a,
                body header.site-header .sticky ul.twp-social-icons.twp-social-icons-white a:hover,
                body .twp-nav-main-navigation.sticky .twp-nav-right-content .twp-search-section i{
                    color: #fff;
                }
                body .twp-nav-main-navigation.sticky .twp-menu-icon.twp-white-menu-icon span:before,
                body .twp-nav-main-navigation.sticky .twp-menu-icon.twp-white-menu-icon span:after{
                    background-color:  #fff;
                } 

            <?php } ?>
            <?php
                if( !empty(  $swift_blog_header_bg_color ) ){
                    ?>
                body header.site-header .wp-custom-header{
                    background-color: <?php echo esc_html( $swift_blog_header_bg_color ); ?>;
                }
            <?php  } ?>
            body .boxed-layout {
                background: <?php echo esc_html($background_color)?>;
            }
        </style>
<?php }
endif;

