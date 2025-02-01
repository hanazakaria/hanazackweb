<?php
/**
 * Swift Blog Theme Customizer
 *
 * @package Swift Blog
 */
//customizer core option
require get_template_directory() . '/inc/customizer/core/customizer-core.php';

//customizer 
require get_template_directory() . '/inc/customizer/core/default.php';
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function swift_blog_customize_register( $wp_customize ) {
	// Load custom controls.
	require get_template_directory() . '/inc/customizer/core/control.php';

	// Load customize sanitize.
	require get_template_directory() . '/inc/customizer/core/sanitize.php';

	// Load customize callback.
	require get_template_directory() . '/inc/customizer/core/callback.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'swift_blog_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'swift_blog_customize_partial_blogdescription',
		) );
	}
	/*slider and its property section*/
	require get_template_directory() . '/inc/customizer/slider.php';

	/*theme option panel details*/
	require get_template_directory() . '/inc/customizer/theme-option.php';	

	// Register custom section types.
	$wp_customize->register_section_type( 'Swift_Blog_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Swift_Blog_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Swift Blog Pro', 'swift-blog' ),
				'pro_text' => esc_html__( 'Upgrade To Pro', 'swift-blog' ),
				'pro_url'  => 'https://www.themeinwp.com/theme/swift-blog-pro/',
				'priority'  => 1,
			)
		)
	);
}
add_action( 'customize_register', 'swift_blog_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function swift_blog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function swift_blog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function swift_blog_customize_preview_js() {
	wp_enqueue_script( 'swift-blog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );

}
add_action( 'customize_preview_init', 'swift_blog_customize_preview_js' );


function swift_blog_customizer_css() {
	wp_enqueue_script('swift_blog_customize_admin_js', get_template_directory_uri().'/assets/twp/js/customizer-admin.js', array('customize-controls'));

	wp_enqueue_style( 'swift_blog_customize_controls', get_template_directory_uri() . '/assets/twp/css/customizer-controll.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'swift_blog_customizer_css',0 );
