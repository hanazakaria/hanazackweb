<?php
if (!function_exists('swift_blog_single_related_post')) :
    /**
     * Main Banner Section
     *
     * @since swift-blog 1.0.0
     *
     */
    function swift_blog_single_related_post()
    {
        if (1 != swift_blog_get_option('enable_related_post_on_single_page')) {
            return;
        }
        ?>
        <div class="twp-single-related-post-section">
            <div class="container">
                    <?php
                    global $post;
                    $categories = get_the_category(get_the_ID());
                    $related_section_title = esc_html(swift_blog_get_option('single_related_post_title'));
                    $number_of_related_posts = absint(swift_blog_get_option('number_of_single_related_post'));

                    if ($categories) {
                        $cat_ids = array();
                        foreach ($categories as $category) $cat_ids[] = $category->term_id;
                        $swift_blog_related_post_args = array(
                            'posts_per_page' => absint($number_of_related_posts),
                            'category__in' => $cat_ids,
                            'post__not_in' => array(get_the_ID()),
                            'order' => 'ASC',
                            'orderby' => 'rand'
                        ); ?>
                        <h2 class="twp-title twp-primary-title"><?php echo esc_html($related_section_title); ?></h2>
                        <ul class="twp-related-post-list">
                            <?php 
                            $swift_blog_related_post_post_query = new WP_Query($swift_blog_related_post_args);
                            if ($swift_blog_related_post_post_query->have_posts()) :
                                while ($swift_blog_related_post_post_query->have_posts()) : $swift_blog_related_post_post_query->the_post();
                                        if(has_post_thumbnail()){
                                            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium_large' );
                                            $url = $thumb['0'];
                                        }
                                        else{
                                            $url = '';
                                        }?>
                                        <li class="twp-related-post">
                                            <div class="twp-image-section">
                                                <a href="<?php the_permalink(); ?>" class="twp-overlay-image-section twp-overlay data-bg d-block" data-background="<?php echo esc_url($url); ?>">
                                                    <span class="twp-post-format-icon-rounded twp-post-format-no-hover-effect">
                                                        <?php echo esc_attr(swift_blog_post_format(get_the_ID())); ?>
                                                    </span>
                                                    <span class="twp-post-format-icon-rounded twp-post-format-icon-hover-effect">
                                                        <?php echo esc_attr(swift_blog_post_format(get_the_ID())); ?>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="twp-author-meta">
                                                <?php swift_blog_post_date(); ?>
                                            </div>
                                            
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        </li>
                                    <?php endwhile;
                            endif; 
                            wp_reset_postdata(); 
                            ?>
                        </ul>
                    <?php } ?> 
            </div><!--/container-->
        </div><!--/twp-news-main-section-->
        <?php
}  
endif;
add_action('swift_blog_action_related_post', 'swift_blog_single_related_post', 10);
