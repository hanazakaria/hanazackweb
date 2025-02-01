<?php
if ( !class_exists('Swift_Blog_Dashboard_Notice') ):

    class Swift_Blog_Dashboard_Notice
    {
        function __construct()
        {	
            global $pagenow;

        	if( $this->swift_blog_show_hide_notice() ){

	            if( is_multisite() ){

                  add_action( 'network_admin_notices',array( $this,'swift_blog_admin_notice' ) );

                } else {

                  add_action( 'admin_notices',array( $this,'swift_blog_admin_notice' ) );
                }
	        }
	        add_action( 'wp_ajax_swift_blog_notice_dismiss', array( $this, 'swift_blog_notice_dismiss' ) );
			add_action( 'switch_theme', array( $this, 'swift_blog_notice_clear_cache' ) );
            add_action('admin_init', array( $this, 'swift_blog_notice_remove' ),100);

        }
        
        function swift_blog_notice_remove(){
            if( isset( $_GET['page'] ) && $_GET['page'] == get_template().'-about' ){

                remove_all_actions('admin_notices');
                remove_all_actions('all_admin_notices');
            }
        }
        
        public static function swift_blog_show_hide_notice( $status = false ){

            if( $status ){

                if( (class_exists( 'Demo_Import_Kit_Class' ) ) || get_option('swift_blog_admin_notice') ){

                    return false;

                }else{

                    return true;

                }

            }

            // Check If current Page 
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'swift-blog-about'  ) {
                return false;
            }

        	// Hide if dismiss notice
        	if( get_option('swift_blog_admin_notice') ){
				return false;
			}
            // Hide if all plugin active
            if (class_exists( 'Demo_Import_Kit_Class' ) && class_exists( 'Themeinwp_Import_Companion' ) ) {
                return false;
            }
			// Hide On TGMPA pages
			if ( ! empty( $_GET['tgmpa-nonce'] ) ) {
				return false;
			}
			// Hide if user can't access
        	if ( current_user_can( 'manage_options' ) ) {
				return true;
			}
			
        }

        // Define Global Value
        public static function swift_blog_admin_notice(){ ?>

            <div class="updated notice is-dismissible twp-swift-blog-notice">

                <h3><?php esc_html_e('Quick Setup','swift-blog'); ?></h3>

                <p><strong><?php esc_html_e('Swift Blog is now installed and ready to use. Are you looking for a better experience to set up your site?','swift-blog'); ?></strong></p>

                <small><?php esc_html_e("We've prepared a unique onboarding process through our",'swift-blog'); ?> <a href="<?php echo esc_url( admin_url().'themes.php?page='.get_template().'-about') ?>"><?php esc_html_e('Getting started','swift-blog'); ?></a> <?php esc_html_e("page. It helps you get started and configure your upcoming website with ease. Let's make it shine!",'swift-blog'); ?></small>

                <p>
                    <a target="_blank" class="button button-primary button-primary-upgrade" href="<?php echo esc_url( 'https://www.themeinwp.com/theme/swift-blog-pro/' ); ?>">
                        <span class="dashicons dashicons-thumbs-up"></span>
                        <span><?php esc_html_e('Upgrade to Pro','swift-blog'); ?></span>
                    </a>

                    <a class="button button-primary twp-install-active" href="javascript:void(0)">
                        <span class="dashicons dashicons-admin-plugins"></span>
                        <span><?php esc_html_e('Install and activate recommended plugins','swift-blog'); ?></span>
                    </a>

                    <span class="quick-loader-wrapper"><span class="quick-loader"></span></span>

                    <a target="_blank" class="button button-secondary" href="<?php echo esc_url( 'https://demo.themeinwp.com/swift-blog/' ); ?>">
                        <span class="dashicons dashicons-welcome-view-site"></span>
                        <span><?php esc_html_e('View Demo','swift-blog'); ?></span>
                    </a>

                    <a target="_blank" class="button button-primary" href="<?php echo esc_url('https://wordpress.org/support/theme/swift-blog/reviews/?filter=5'); ?>">
                        <span class="dashicons dashicons-star-filled"></span>
                        <span class="dashicons dashicons-star-filled"></span>
                        <span class="dashicons dashicons-star-filled"></span>
                        <span class="dashicons dashicons-star-filled"></span>
                        <span class="dashicons dashicons-star-filled"></span>
                        <span><?php esc_html_e('Leave a review', 'swift-blog'); ?></span>
                    </a>

                    <a class="btn-dismiss twp-custom-setup" href="javascript:void(0)"><?php esc_html_e('Dismiss this notice.','swift-blog'); ?></a>

                </p>

            </div>

        <?php
        }

        public function swift_blog_notice_dismiss(){

            check_ajax_referer( 'swift_blog_ajax_nonce', 'security' );
            update_option('swift_blog_admin_notice','hide');

            die();

        }

        public function swift_blog_notice_clear_cache(){

        	update_option('swift_blog_admin_notice','');

        }

    }
    new Swift_Blog_Dashboard_Notice();
endif;