<?php
/**
 * ink-blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ink-context-blog
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */


function ink_context_blog_remove_parent_function() {
	remove_action( 'after_setup_theme', 'context_blog_custom_header_setup' );

}
add_action( 'after_setup_theme', 'ink_context_blog_remove_parent_function', 2 );

// Below code is for changeing theme info

function ink_context_blog_config_modify( $config ) {
    $config['page_name'] = esc_html__( 'Ink Context Blog setup', 'ink-context-blog' );
	/* translators: theme version */
	$config['welcome_title'] = sprintf( esc_html__( 'Welcome to %s - ', 'ink-context-blog' ), 'Ink context blog' );
	/* translators: 1: theme name */
	$config['welcome_content']  = ('');
	$config['quick_links']  = array(
		'theme_url'         => array(
			'text' => esc_html__( 'Theme Details', 'ink-context-blog' ),
			'url'  => esc_url( 'https://www.postmagthemes.com/downloads/ink-context-blog-a-free-wordpress-theme/' ),
		),
		'demo_url'          => array(
			'text' => esc_html__( 'View Demo', 'ink-context-blog' ),
			'url'  => esc_url( 'https://contextblog.postmagthemes.com/inkcontextblog' ),
		),
		'demo_url_pro'          => array(
			'text' => esc_html__( 'View Demo Premium', 'ink-context-blog' ),
			'url'  => esc_url( 'https://contextblog.postmagthemes.com/contextblogpro' ),
		),
		'documentation_url' => array(
			'text' => esc_html__( 'View documentation', 'ink-context-blog' ),
			'url'  => esc_url( 'https://www.postmagthemes.com/docs/documentation-of-free-context-blog-wp-theme-and-pro/' ),
		),
		'pro_url'           => array(
			'text' => esc_html__( 'Buy Premium version', 'ink-context-blog' ),
			'url'  => esc_url( 'https://www.postmagthemes.com/downloads/context-blog-pro-wordpress-theme' ),

		),
	);
	$config['tabs']  = array( 
		'recommended_actions' => esc_html__( 'Recommended Actions', 'ink-context-blog' ),
		'support'             => esc_html__( 'Support', 'ink-context-blog' ), );
	$config['getting_started']  = ('');

    return $config;
}
add_filter( 'context_blog_about_filter', 'ink_context_blog_config_modify' );

function ink_context_blog_setup() {
	 /*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	* If you're building a theme based on ink-blog, use a find and replace
	* to change 'ink-blog' to the name of your theme in all the template files.
	*/
	load_theme_textdomain( 'ink-context-blog' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );


	add_theme_support(
		'custom-header',
		apply_filters(
			'ink_context_blog_custom_header_args',
			array(
				'default-image'      => get_theme_file_uri( '/images/default-header-image-ink.jpg' ),
				'default-text-color' => '#404040',
				'width'              => 1440,
				'height'             => 710,
				'flex-height'        => true,
				'video'              => true,
				'wp-head-callback'   => 'context_blog_header_style',
			)
		)
	);
	register_default_headers(
		array(
			'default-image' => array(
				'url'           => get_theme_file_uri( '/images/default-header-image-ink.jpg'),
				'thumbnail_url' => get_theme_file_uri( '/images/default-header-image-ink.jpg'),
				'description'   => __( 'Default header image', 'ink-context-blog' ),
			),
		)
	);


}
add_action( 'after_setup_theme', 'ink_context_blog_setup', 1 );


function ink_context_blog_customizer( $wp_customize ) {
	 //Removed Section from the Parent theme 
	$wp_customize->remove_section('context_blog_home_full_screen_slider_section');
	$wp_customize->remove_section('context_blog_home_gallery_slider_section');
	$wp_customize->remove_section('context_blog_introduction_section');
	$wp_customize->remove_section('context_blog_home_main_blog_section');
	
	$wp_customize->add_section(
		'ink_context_blog_home_main_blog_section',
		array(
			'panel'    => 'context_blog_blog_post_settings_panel',
			'title'    => __( 'Blog post section', 'ink-context-blog' ),
			'priority' => 2,
		)
	);
	$wp_customize->add_setting(
		'context_blog_image_section6',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url',
		)
	);
	
	$wp_customize->add_control(
		'context_blog_image_section6',
		array(
			'type'        => 'Image',
			'section'     => 'ink_context_blog_home_main_blog_section',
			'input_attrs' => array(
				'src' => esc_url( get_theme_file_uri() . '/images/section6_ink.jpeg' ),
			),
		)
	);

	$wp_customize->add_setting(
		'context_blog_home_main_blog_enable',
		array(
			'default'           => 1,
			'sanitize_callback' => 'context_blog_sanitize_checkbox',
		)
	);
	
	$wp_customize->add_control(
		'context_blog_home_main_blog_enable',
		array(
			'section' => 'ink_context_blog_home_main_blog_section',
			'label'   => __( 'Enable this section', 'ink-context-blog' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'context_blog_home_main_blog_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control(
		'context_blog_home_main_blog_title',
		array(
			'section' => 'ink_context_blog_home_main_blog_section',
			'label'   => __( 'Title', 'ink-context-blog' ),
			'type'    => 'text',
		)
	);

	$ink_context_blog_post_taxonomy_arrays = array( __( 'category', 'ink-context-blog' ), __( 'meta', 'ink-context-blog' ), __( 'date', 'ink-context-blog' ), __( 'comment', 'ink-context-blog' ), __( 'excerpt', 'ink-context-blog' ) );
	foreach ( $ink_context_blog_post_taxonomy_arrays as  $ink_context_blog_post_taxonomy ) {

		$wp_customize->add_setting(
			'ink_context_blog_main_blog_' . $ink_context_blog_post_taxonomy,
			array(
				'default'           => 1,
				'sanitize_callback' => 'context_blog_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'ink_context_blog_main_blog_' . $ink_context_blog_post_taxonomy,
			array(
				/* translators: %s: Label */
				'label'   => sprintf( __( 'Show %s', 'ink-context-blog' ), $ink_context_blog_post_taxonomy ),
				'section' => 'ink_context_blog_home_main_blog_section',
				'type'    => 'checkbox',
			)
		);
	}
	$wp_customize->add_setting(
		'context_blog_main_blog_readmore',
		array(
			'default'           => 1,
			'sanitize_callback' => 'context_blog_sanitize_checkbox',
		)
	);
	
	$wp_customize->add_control(
		'context_blog_main_blog_readmore',
		array(
			'section' => 'ink_context_blog_home_main_blog_section',
			'label'   => __( 'Show read more', 'ink-context-blog' ),
			'type'    => 'checkbox',
		)
	);


	$wp_customize->add_setting(
		'context_blog_main_blog_excerpt_limit',
		array(
			'default'           => 22,
			'sanitize_callback' => 'absint',
		)
	);
	
	$wp_customize->add_control(
		'context_blog_main_blog_excerpt_limit',
		array(
			'label'       => esc_html__( 'Excerpt length', 'ink-context-blog' ),
			'description' => esc_html__( 'Excerpt Length determines the no of words in short description.', 'ink-context-blog' ),
			'section'     => 'ink_context_blog_home_main_blog_section',
			'type'        => 'number',
		)
	);


	$wp_customize->add_setting(
		'context_blog_mainblog_related_customize_heading',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control(
		new context_blog_Customizer_Title(
			$wp_customize,
			'context_blog_mainblog_related_customize_heading',
			array(
				'label'   => __( 'Related post settings', 'ink-context-blog' ),
				'section' => 'ink_context_blog_home_main_blog_section',
			)
		)
	);


	$wp_customize->add_setting(
		'context_blog_mainblog_related_post_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'context_blog_mainblog_related_post_text',
		array(
			'label'    => __( 'Title', 'ink-context-blog' ),
			'section'  => 'ink_context_blog_home_main_blog_section',
			'type'     => 'text',
		)
	);
	$wp_customize->add_section(
		new Context_blog_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell4',
			array(
				'title'    => esc_html__( 'Theme Details', 'ink-context-blog' ),
				'pro_text' => esc_html__( 'Ink Context Blog', 'ink-context-blog' ),
				'pro_url'  => esc_url( 'https://www.postmagthemes.com/downloads/ink-context-blog-a-free-wordpress-theme/' ),
				'priority' => 3,
				'panel'    => 'context_blog_document_panel',
			)
		)
	);

	}
add_action( 'customize_register', 'ink_context_blog_customizer', 9999 );

function ink_blog_dequeue_script1() {
	wp_dequeue_script( 'context-blog-customizer-hide' );
	wp_deregister_script('context-blog-customizer-hide');
}
add_action( 'customize_controls_enqueue_scripts', 'ink_blog_dequeue_script1',100);


function ink_blog_dequeue_script2() {
	wp_dequeue_script( 'context-blog-scripts' );
	wp_deregister_script('context-blog-scripts');
}
add_action( 'wp_print_scripts', 'ink_blog_dequeue_script2',100);

function ink_blog_editor_dequeue_script() {
	wp_dequeue_style( 'context-blog-editor-styles' );
}
add_action( 'enqueue_block_assets', 'ink_blog_editor_dequeue_script');


function ink_context_blog_customize_backend_scripts() {
	wp_enqueue_script( 'ink-context-blog-customizer-hide', get_stylesheet_directory_uri() . '/assets/customizer/ink-customizer-hide.js', array( 'jquery' ), '1.1.2', true );

   $ink_taxonomy_translate = array(
	   'ink_context_blog_meta_translate'     => __( 'meta', 'ink-context-blog' ),
	   'ink_context_blog_date_translate'     => __( 'date', 'ink-context-blog' ),
	   'ink_context_blog_comment_translate'  => __( 'comment', 'ink-context-blog' ),
	   'ink_context_blog_category_translate' => __( 'category', 'ink-context-blog' ),
	   'ink_context_blog_excerpt_translate'  => __( 'excerpt', 'ink-context-blog' ),

   );
   wp_localize_script( 'ink-context-blog-customizer-hide', 'ink_taxonomy_translate', $ink_taxonomy_translate );
   $phpInfo = array(
	'show_on_front_value' => get_option( 'show_on_front' ),

	);
	wp_localize_script( 'ink-context-blog-customizer-hide', 'phpInfo', $phpInfo );

}
add_action( 'customize_controls_enqueue_scripts', 'ink_context_blog_customize_backend_scripts', 10 );

function ink_context_blog_style() {

	wp_enqueue_style( 'slic-theme', get_template_directory_uri() . '/assets/css/slick-theme.css', array(), null );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '4.5.0' );
	wp_enqueue_style('ink-context-blog-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'ink-context-blog-style', get_stylesheet_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version') );

	wp_enqueue_style( 'ink-context-blog-google-fonts', 'https://fonts.googleapis.com/css?family=Josefin+Sans|Roboto|Courgette|Muli&display=swap', array(), null );

	if ( is_front_page() || is_home() ) {

		wp_enqueue_script( 'ink-context-blog-background-js', get_stylesheet_directory_uri() . '/assets/js/background-change.js', array(), '1.0.0', true );

	}
	wp_enqueue_script( 'ink-context-blog-js', get_stylesheet_directory_uri() . '/assets/js/script.js',  array( 'jquery' ), true );

	wp_localize_script(
		'ink-context-blog-js',
		'context_object',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		)
	);

}
add_action( 'wp_enqueue_scripts', 'ink_context_blog_style' );


function ink_blog_editorscripts() {

	wp_enqueue_style( 'ink-context-blog-google-fonts', 'https://fonts.googleapis.com/css?family=Josefin+Sans|Roboto|Courgette|Muli&display=swap', array(), null );

	wp_register_style( 'ink-context-blog-editor-styles', false );

	wp_enqueue_style( 'ink-context-blog-editor-styles' );

	if ( ! is_singular() and ! is_home() and ! is_front_page() and ! is_archive() and ! is_search() and ! is_404() ) {

		wp_add_inline_style( 'ink-context-blog-editor-styles', ink_context_blog_color_font_css() );
	}

}
add_action( 'enqueue_block_assets', 'ink_blog_editorscripts', 11 );

function ink_context_blog_color_font_css() {

	$ink_context_blog_posttitle_font_family   = 'Courgette';
	$ink_context_blog_paragraph_font_family   = 'Muli';

		$theme_css = '

			.editor-styles-wrapper h1 {
				font-family : ' . esc_attr( $ink_context_blog_posttitle_font_family ) . '; 
			}
			.editor-styles-wrapper * { 
				font-family : ' . esc_attr( $ink_context_blog_paragraph_font_family ) . '; 
				line-height: 1.8;
			}
			.editor-styles-wrapper p { 
				font-size: 14px;
			}
			.category-tag li a {
				font-size: 24px;
			}
			.home-section h3.title, .archive h3.title, .search h3.title {
				font-size: 50px;
			}

		';
		
		return apply_filters( 'ink_context_blog_color_font_css', $theme_css );
}
