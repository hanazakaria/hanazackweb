<?php
	$ink_context_blog_tags           = get_the_category( $post->ID );
	if ( $ink_context_blog_tags ) {
		$ink_context_blog_tag_ids = array();
		foreach ( $ink_context_blog_tags as $ink_context_blog_individual_tag ) {
		$ink_context_blog_tag_ids[] = $ink_context_blog_individual_tag->term_id;
		}
		$ink_context_blog_args     = array(
		'category__in'        => $ink_context_blog_tag_ids,
		'orderby'             => 'date',
		'post__not_in'        => array( $post->ID ),
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => 1,
	);
	$ink_context_blog_my_query = new wp_query( $ink_context_blog_args );
	if ( $ink_context_blog_my_query->have_posts() ) { ?> 
		<div class="related-post-block">
				<h4 class="other-title"><?php echo esc_html( get_theme_mod( 'context_blog_mainblog_related_post_text','' ) ); ?></h4> 
				<div class="related-post-mainblog">
                    <div class="row">
                        <?php
                        while ( $ink_context_blog_my_query->have_posts() ) :
                            $ink_context_blog_my_query->the_post(); ?>
                            <div class="col-lg-3 col-md-6 col-6">
								<div class=" hover-trigger blog-snippet" >
									<a href="<?php the_permalink(); ?>" class="img-holder" aria-label='<?php the_title_attribute(); ?>'>
										<?php the_post_thumbnail( 'context-blog-main-blog-2-538X382' ); ?>                    
									</a>
									<?php if ( has_post_thumbnail() ): ?>
										<div class="blog-content yes_image">
									<?php else : ?>
										<div class="blog-content no_image">
									<?php endif; ?>
										<h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
										</div>								</div>
                            </div> <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
				</div>                   
			</div> 
		<?php
	}
}