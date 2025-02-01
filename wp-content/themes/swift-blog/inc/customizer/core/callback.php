<?php
/**
 * Customizer callback functions for header-add.
 *
 * @package Swift Blog
 */

/*select page for slider*/
if ( ! function_exists( 'swift_blog_mailchimp_section_callback' ) ) :

	/**
	 * Check if slider section page/post is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function swift_blog_mailchimp_section_callback( $control ) {

		if ( 1 == $control->manager->get_setting( 'enable_mailchimp_suscription' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;
