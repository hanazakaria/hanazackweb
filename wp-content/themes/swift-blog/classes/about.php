<?php

/**
 * Swift Blog About Page
 * @package Swift Blog
 *
 */

if (!class_exists('Swift_Blog_About_page')):

    class Swift_Blog_About_page
    {

        function __construct()
        {

            add_action('admin_menu', array($this, 'swift_blog_backend_menu'), 999);

        }

        // Add Backend Menu
        function swift_blog_backend_menu()
        {

            add_theme_page(esc_html__('Swift Blog', 'swift-blog'), esc_html__('Swift Blog', 'swift-blog'), 'activate_plugins', 'swift-blog-about', array($this, 'swift_blog_main_page'), 1);

        }

        // Settings Form
        function swift_blog_main_page()
        {

            require get_template_directory() . '/classes/about-render.php';

        }

    }

    new Swift_Blog_About_page();

endif;