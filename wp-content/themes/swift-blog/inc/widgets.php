<?php
/**
 * Theme widgets.
 *
 * @package Swift Blog
 */

// Load widget base.
require get_template_directory() . '/inc/widget-base.php';

if (!function_exists('swift_blog_load_widgets')) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function swift_blog_load_widgets()
    {
        // Recent Post widget.
        register_widget('TWP_sidebar_widget');

        // Author widget.
        register_widget('TWP_Author_Post_widget');

        // Social widget.
        register_widget('TWP_Social_widget');

    }
endif;
add_action('widgets_init', 'swift_blog_load_widgets');

/*Recent Post widget*/
if (!class_exists('TWP_sidebar_widget')) :

    /**
     * Popular widget Class.
     *
     * @since 1.0.0
     */
    class TWP_sidebar_widget extends Swift_Blog_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'swift_blog_popular_post_widget',
                'description' => __('Displays post form selected category specific for popular post in sidebars.', 'swift-blog'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'swift-blog'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => __('Select Category:', 'swift-blog'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'swift-blog'),
                ),
                'enable_counter' => array(
                    'label' => __('Enable Counter:', 'swift-blog'),
                    'type' => 'checkbox',
                    'default' => true,
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'swift-blog'),
                    'type' => 'number',
                    'default' => 5,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 6,
                ),
            );

            parent::__construct('swift-blog-popular-sidebar-layout', __('A SB:- Recent Post', 'swift-blog'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            ?>
            <?php global $post; 
            $count = 1;
            ?>
            <?php if (!empty($all_posts)) : ?>
            <div class="twp-recent-widget-section">                
                <ul class="twp-recent-widget-list">
                    <?php foreach ($all_posts as $key => $post) : ?>
                    <?php setup_postdata($post); ?>
                    <?php if (has_post_thumbnail()) {
                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'swift-blog-900-600' );
                        $url = $thumb['0'];
                        } else {
                            $url = '';
                    }
                    ?>
                    <li class="twp-recent-widget">
                        <div class="twp-image-section">
                            <a href="<?php the_permalink(); ?>" class="twp-overlay-image-section twp-overlay data-bg bg-image">
                                <img src="<?php echo esc_url($url); ?>" alt="<?php the_title_attribute(); ?>">
                                <span class="twp-post-format-icon-rounded twp-post-format-no-hover-effect"><?php echo esc_html(swift_blog_post_format(get_the_ID())); ?></span>
                                <span class="twp-post-format-icon-rounded twp-post-format-icon-hover-effect"><?php echo esc_html(swift_blog_post_format(get_the_ID())); ?></span>

                            </a>
                        </div>
                        <div class="twp-description twp-d-flex">
                            <?php if (true === $params['enable_counter']) { ?>
                                <h2 class="twp-unit"> <span><?php echo $count; ?></span></h2>
                            <?php } ?>
                            <div class="twp-caption">
                                <div class="twp-articles-title">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                </div>
                                <div class="twp-author-meta">
                                    <?php swift_blog_post_date(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php 
                        $count++;
                        endforeach;
                    ?>
                </ul>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*Author widget*/
if (!class_exists('TWP_Author_Post_widget')) :

    /**
     * Author widget Class.
     *
     * @since 1.0.0
     */
    class TWP_Author_Post_widget extends Swift_Blog_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'swift_blog_author_widget',
                'description' => __('Displays authors details in post.', 'swift-blog'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'swift-blog'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'author-name' => array(
                    'label' => __('Name:', 'swift-blog'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'description' => array(
                    'label' => __('Description:', 'swift-blog'),
                    'type'  => 'textarea',
                    'class' => 'widget-content widefat'
                ),
                'image_url' => array(
                    'label' => __('Author Image:', 'swift-blog'),
                    'type'  => 'image',
                ),
                'url-fb' => array(
                   'label' => __('Facebook URL:', 'swift-blog'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-tw' => array(
                   'label' => __('Twitter URL:', 'swift-blog'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-lt' => array(
                   'label' => __('Linkedin URL:', 'swift-blog'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
                'url-ig' => array(
                   'label' => __('Instagram URL:', 'swift-blog'),
                   'type' => 'url',
                   'class' => 'widefat',
                    ),
            );

            parent::__construct('swift-blog-author-layout', __('A SB:- Author Widget', 'swift-blog'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if ( ! empty( $params['title'] ) ) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            } ?>

            <!--cut from here-->
            <div class="twp-author-widget">
                <div class="twp-d-flex">
                    <?php if ( ! empty( $params['image_url'] ) ) { ?>
                        <div class="twp-image-section">
                            <div class="twp-wrapper  bg-image data-bg">
                                <img src="<?php echo esc_url( $params['image_url'] ); ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ( ! empty( $params['author-name'] ) ) { ?>
                        <h2 class="twp-inner-title twp-meta-font"><?php echo esc_html($params['author-name'] );?></h2>
                    <?php } ?>
                </div>

                <div class="twp-description">
                    <?php if ( ! empty( $params['description'] ) ) { ?>
                        <p><?php echo wp_kses_post( $params['description']); ?></p>
                    <?php } ?>
                </div>
                <div class="twp-social">
                    <?php if ( ! empty( $params['url-fb'] ) ) { ?>
                        <span class="twp-social-icon-rounded twp-secondary-border"><a href="<?php echo esc_url($params['url-fb']); ?>"><i class="fa fa-facebook"></i></a></span></span>
                    <?php } ?>
                    <?php if ( ! empty( $params['url-tw'] ) ) { ?>
                        <span class="twp-social-icon-rounded twp-secondary-border"><a href="<?php echo esc_url($params['url-tw']); ?>"><i class=" fa fa-twitter"></i></a></span>
                    <?php } ?>
                    <?php if ( ! empty( $params['url-lt'] ) ) { ?>
                        <span class="twp-social-icon-rounded twp-secondary-border"><a href="<?php echo esc_url($params['url-lt']); ?>"><i class=" fa fa-linkedin"></i></a></span>
                    <?php } ?>
                    <?php if ( ! empty( $params['url-ig'] ) ) { ?>
                        <span class="twp-social-icon-rounded twp-secondary-border"><a href="<?php echo esc_url($params['url-ig']); ?>"><i class=" fa fa-instagram"></i></a></span>
                    <?php } ?>
                </div>
            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*Social widget*/
if (!class_exists('TWP_Social_widget')) :

    /**
     * Social widget Class.
     *
     * @since 1.0.0
     */
    class TWP_Social_widget extends Swift_Blog_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'swift_blog_social_widget',
                'description' => __('Displays Social share.', 'swift-blog'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'swift-blog'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
            );

            parent::__construct('swift-blog-social-layout', __('A SB:- Social Widget', 'swift-blog'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if ( ! empty( $params['title'] ) ) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            } ?>

            <div class="twp-social-widget">
                <div class="social-widget-menu">
                <?php
                    wp_nav_menu(
                        array('theme_location' => 'social-nav',
                            'link_before' => '<span>',
                            'link_after' => '</span>',
                            'menu_id' => 'social-menu',
                            'fallback_cb' => false,
                            'menu_class' => 'twp-social-icons twp-social-icons-with-tooltip twp-widget-social-icons'
                        )); ?>
                </div>
                <?php if ( ! has_nav_menu( 'social-nav' ) ) : ?>
                    <p>
                        <?php esc_html_e( 'Social menu is not set. You need to create menu and assign it to Social Menu on Menu Settings.', 'swift-blog' ); ?>
                    </p>
                <?php endif; ?>
            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;