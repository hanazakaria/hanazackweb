<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package context-blog
 */

get_header();


if ( ! ( is_home() || is_front_page() ) ) :
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( ! is_home() && ( ! is_front_page() ) ) : ?>
			<header class="header">
			<?php context_blog_simple_breadcrumb(); ?>
			</header>    

		<?php
		endif;

		get_template_part( 'template-parts/content', 'page' );
		?>

	</article>
	<?php

else :
	?>
	<main id="main" class = "site-main 
	<?php
	if ( get_option( 'show_on_front' ) == 'page' and is_front_page() ) :
			echo 'its-static-page';
	elseif ( ! ( is_front_page() || is_home() ) ) :
		echo 'its-detail-page';
	else :
		echo 'its-blog-page';
	endif;
	?>
	"> 
	<?php

	if ( get_theme_mod( 'context_blog_card_slider_enable_homepage', 1 ) == 1 ) :
		get_template_part( 'main-body/card-slider', 'section' );
	endif;
    
	dynamic_sidebar( 'frontpage-body' );

	get_template_part( 'template-parts/content', 'page' );
	?>

	</div>
	</main> 
	<?php
endif;
get_footer();