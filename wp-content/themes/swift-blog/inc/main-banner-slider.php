<?php
if (!function_exists('swift_blog_banner_slider')) :
    /**
     * Banner Slider
     *
     * @since swift-blog 1.0.0
     *
     */
    function swift_blog_banner_slider()
    {
        if (1 != swift_blog_get_option('show_main_banner_section')) {
            return null;
        }
        $swift_blog_slider_excerpt_number = absint(swift_blog_get_option('number_of_content_home_slider'));
        $swift_blog_banner_slider_category = absint(swift_blog_get_option('select_category_for_slider_section'));
        $swift_blog_banner_slider_number = absint(swift_blog_get_option('number_of_home_slider'));

        $qargs = array(
            'posts_per_page' => absint($swift_blog_banner_slider_number),
            'post_type' => 'post',
            'cat' => absint($swift_blog_banner_slider_category),
        );
        $slider_pagenav = '';
        $swift_blog_banner_slider_args = $qargs;
        $swift_blog_banner_slider_query = new WP_Query($swift_blog_banner_slider_args); ?>
        <?php $i = 1; ?>
        <?php $rtl_class_c = 'false';
        if(is_rtl()){ 
            $rtl_class_c = 'true';
        }?>
        <section class="twp-banner-slider-section">
            <div class="container-fluid">
                <div class="twp-banner-wrapper clearfix">
                    <div class="twp-banner-slider" data-slick='{"rtl": <?php echo($rtl_class_c); ?>}'>
                        <?php
                        if ($swift_blog_banner_slider_query->have_posts()) :
                            while ($swift_blog_banner_slider_query->have_posts()) : $swift_blog_banner_slider_query->the_post();
                                if (has_excerpt()) {
                                    $swift_blog_slider_content = get_the_excerpt();
                                } else {
                                    $swift_blog_slider_content = swift_blog_words_count($swift_blog_slider_excerpt_number, get_the_content());
                                }
                                ?>
                                <div class="twp-slider-items" title="<?php the_title(); ?>">
                                    <?php if (has_post_thumbnail()) {
                                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
                                        $url = $thumb['0'];
                                    } else {
                                        $url ='';
                                    } ?>
                                        <div class="twp-image-section data-bg" data-background="<?php echo esc_url($url); ?>"></div>
                                    <div class="twp-desc">
                                        <div class="twp-author-meta twp-meta-font">
                                            <?php swift_blog_post_author(); ?>
                                            <?php swift_blog_post_date(); ?>
                                            <?php swift_blog_get_comments_count(get_the_ID()); ?>
                                        </div>
                                        <h3 class="twp-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php if ($swift_blog_slider_excerpt_number != 0) { ?>
                                            <p class="visible hidden-xs hidden-sm"><?php echo wp_kses_post($swift_blog_slider_content); ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                                $slider_pagenav .= '<div class="slider-nav-item"><figure class="slider-article">';
                                $slider_pagenav .= '<figcaption class="navtitle-wrapper">';
                                $slider_pagenav .= '<h3 class="twp-post-title"><span>'.'0'.esc_html($i++).'</span>'.esc_html(wp_trim_words( get_the_title() )).'</h3>';
                                $slider_pagenav .= '</figcaption>';
                                $slider_pagenav .= '</figure></div>';
                            endwhile;
                            wp_reset_postdata();
                        endif; ?>
                    </div>
                    <div class="twp-banner-pagination-section">
                        <?php if (!empty (swift_blog_get_option('swift_blog_banner_slider_section'))) { ?>
                            <h2 class="twp-section-title"><span class="twp-tag-line twp-tag-line-white"><?php echo esc_html(swift_blog_get_option('swift_blog_banner_slider_section')); ?></span></h2>
                        <?php } ?>
                        <div class="twp-banner-pagination">
                            <?php echo $slider_pagenav;?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end slider-section -->
        <?php
    }
endif;
add_action('swift_blog_action_slider_post', 'swift_blog_banner_slider', 10);