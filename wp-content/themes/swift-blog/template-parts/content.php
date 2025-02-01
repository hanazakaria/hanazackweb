<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Swift Blog
 */
$twp_archive_has_image = '';
?>
<?php if (has_post_thumbnail()) {
	$twp_archive_has_image = 'twp-archive-has-thumb';
} ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("twp-archive-post-list"); ?> data-aos="fade-up" data-aos-delay="250">
	<div class="twp-archive-post <?php echo esc_attr($twp_archive_has_image);?>">
		<?php if (has_post_thumbnail()) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium_large' );
			$url = $thumb['0'];
		 ?>
			<div class="twp-image-section">
				<a class="twp-overlay-image-section data-bg twp-overlay" href="<?php echo  esc_url( get_permalink() ); ?>"  data-background="<?php echo esc_url($url); ?>">
					<span class="twp-post-format-icon-rounded twp-post-format-no-hover-effect"><?php echo esc_html(swift_blog_post_format(get_the_ID())); ?></span>
					<div class="twp-post-format-icon-rounded twp-post-format-icon-hover-effect"><?php echo esc_html(swift_blog_post_format(get_the_ID())); ?></div>
				</a>
			</div>
            

		<?php } ?>
		<div class="twp-content">
			<div class="twp-wrapper">
				<header class="twp-archive-entry-header">
					<?php swift_blog_post_categories(); ?>
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
					<div class="twp-author-meta twp-meta-font">
						<?php swift_blog_post_author(); ?>
						<?php swift_blog_post_date(); ?>
						<?php swift_blog_get_comments_count(get_the_ID()); ?>
					</div>
				</header>
				<div class="twp-archive-entry-content">
					<?php the_excerpt(); ?>
					<div class="twp-btn-section">
						<a class="twp-read-more-btn twp-no-hover-effect" href="<?php the_permalink();?>"> <?php echo esc_html__( 'Continue Reading', 'swift-blog' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>	
</article><!-- #post-<?php the_ID(); ?> -->
