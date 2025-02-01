<?php
/**
 * Template part for displaying posts	
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Swift Blog
 */
?>
<article id="post-<?php the_ID(); ?>" class="twp-single-page-post-section" >
	<div class="twp-single-page-author-section">
		<div class="twp-row">
            <?php
            if (1 == swift_blog_get_option('enable_author_detail_single_page')) {
                $author_id = $post->post_author;
                $author_posts_url = esc_url(get_author_posts_url($author_id));
                $avatar = get_avatar($author_id, 200);
                $display_name = esc_html(get_the_author_meta('display_name', $author_id));
                ?>

                <div class="twp-single-post-author">
                    <a class="d-block" href="<?php echo $author_posts_url; ?>">
                        <span class="twp-author-image">
                            <?php echo $avatar; ?>
                        </span>
                        <span class="twp-caption twp-meta-font"><?php echo $display_name; ?></span>
                    </a>
                </div>

            <?php } ?>

            <header class="entry-header">
				<?php swift_blog_post_categories(); ?>
				<h2 class="entry-title">
					<?php echo esc_attr(swift_blog_post_format(get_the_ID())); ?>
					<a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark">
					<?php the_title(); ?>
					</a>
				</h2>
					<div class="twp-author-meta">
						<?php swift_blog_post_date(); ?>
						<?php swift_blog_get_comments_count(get_the_ID()); ?>
					</div>

			</header><!-- .entry-header -->
			
		</div>
		<?php if (1 == swift_blog_get_option('enable_except_on_single_post')) {
				if (has_excerpt()){ ?>
					<div class="single-content-experpt">
						<?php the_excerpt(); ?>
					</div>
				<?php }
			}
			?>
	</div>

	<?php 
	$post_options = get_post_meta( $post->ID, 'swift-blog-meta-checkbox', true );
	if (!empty( $post_options ) ) {
	   swift_blog_post_thumbnail();
	} ?>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'swift-blog' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
