<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ays-pro.com/
 * @since             1.0.0
 * @package           Portfolio_Responsive_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       Portfolio Responsive Gallery
 * Plugin URI:        https://ays-pro.com/index.php/wordpress/portfolio-responsive-gallery/
 * Description:       Portfolio plugin for companies, designers, photographers, artists, freelancers.
 * Version:           1.4.6
 * Author:            Portfolio Team
 * Author URI:        https://ays-pro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       portfolio-responsive-gallery
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! defined( 'AYS_PRG_BASE_URL' ) ) {
    define( 'AYS_PRG_BASE_URL', plugin_dir_url(__FILE__ ) );
}

if( ! defined( 'AYS_PRG_ADMIN_URL' ) ) {
    define( 'AYS_PRG_ADMIN_URL', plugin_dir_url(__FILE__ ) . 'admin/' );
}


if( ! defined( 'AYS_PRG_PUBLIC_URL' ) ) {
    define( 'AYS_PRG_PUBLIC_URL', plugin_dir_url(__FILE__ ) . 'public/' );
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRG_NAME_VERSION', '1.4.6' );
define( 'PRG_NAME', 'portfolio-responsive-gallery' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-portfolio-responsive-gallery-activator.php
 */
function activate_portfolio_responsive_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-responsive-gallery-activator.php';
	Portfolio_Responsive_Gallery_Activator::ays_prg_db_check();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-portfolio-responsive-gallery-deactivator.php
 */
function deactivate_portfolio_responsive_gallery() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-responsive-gallery-deactivator.php';
	Portfolio_Responsive_Gallery_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_portfolio_responsive_gallery' );
register_deactivation_hook( __FILE__, 'deactivate_portfolio_responsive_gallery' );

add_action( 'plugins_loaded', 'activate_portfolio_responsive_gallery' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-responsive-gallery.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_portfolio_responsive_gallery() {

    add_action( 'admin_notices', 'general_prg_admin_notice' );
	$plugin = new Portfolio_Responsive_Gallery();
	$plugin->run();

}


function general_prg_admin_notice(){
    if ( isset($_GET['page']) && strpos($_GET['page'], PRG_NAME) !== false ) {
        ?>
            <div class="ays-notice-banner">
                <div class="navigation-bar">
                    <div id="navigation-container">
                        <div class="ays-portfolio-logo-container-upgrade">
                            <div class="logo-container">
                                <a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery" target="_blank" style="box-shadow: none;">
                                    <img  class="portfolio-logo" src="<?php echo esc_attr(AYS_PRG_ADMIN_URL) . '/images/portfolio_icon.png'; ?>" alt="<?php echo __( "Portfolio Responsive Gallery", AYS_PRG_ADMIN_URL ); ?>" title="<?php echo __( "Portfolio Responsive Gallery", AYS_PRG_ADMIN_URL ); ?>"/>
                                </a>
                            </div>
                            <div class="ays-portfolio-upgrade-container">
                                <a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery?utm_source=portfolio-free-dashboard&utm_medium=portfolio-top-banner&utm_campaign=portfolio-upgrade-button" target="_blank" class="portfolio-upgrade-to-pro">
                                    <img src="<?php echo AYS_PRG_ADMIN_URL . '/images/icons/lightning.svg' ?>" class="portfolio-upgrade-green-icon">
                                    <img src="<?php echo AYS_PRG_ADMIN_URL . '/images/icons/lightning-white.svg' ?>" class="portfolio-upgrade-white-icon">
                                    <span><?php echo __( "Upgrade", PRG_NAME ); ?></span>
                                </a>
                                <span class="ays-portfolio-logo-container-one-time-text"><?php echo __( "One-time payment", PRG_NAME ); ?></span>
                            </div>
                        </div>
                        <ul id="menu">
                            <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://plugins.ays-demo.com/portfolio-responsive-gallery-free-demo/" target="_blank">Demo</a></li>
                            <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank">Free Support</a></li>
                            <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank">Contact us</a></li>
                            <li class="modile-ddmenu-md">
                                <a class="toggle_ddmenu" href="javascript:void(0);"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                <ul class="ddmenu" data-expanded="false">
                                    <li><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/reviews/" target="_blank">Rate us</a></li>
                                    <li><a class="ays-btn" href="https://plugins.ays-demo.com/portfolio-responsive-gallery-free-demo/" target="_blank">Demo</a></li>
                                   <li><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank">Free Support</a></li>
                                    <li><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank">Contact us</a></li>
                                </ul>
                            </li>
                            <li class="modile-ddmenu-sm">
                            <a class="toggle_ddmenu" href="javascript:void(0);"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                <ul class="ddmenu" data-expanded="false">
                                    <li><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/reviews/" target="_blank">Rate us</a></li>
                                    <li><a class="ays-btn" href="https://plugins.ays-demo.com/portfolio-responsive-gallery-free-demo/" target="_blank">Demo</a></li>
                                   <li><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank">Free Support</a></li>
                                    <li><a class="ays-btn" href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" target="_blank">Contact us</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="ays_ask_question_content">
                <div class="ays_ask_question_content_inner">
                <a href="https://wordpress.org/support/plugin/portfolio-responsive-gallery/" class="ays_quiz_question_link" target="_blank">
                    <span class="ays-ask-question-content-inner-question-mark-text">?</span>
                    <span class="ays-ask-question-content-inner-hidden-text">Ask a question</span>
                </a>
                </div>
            </div>
        <?php
    }
}

run_portfolio_responsive_gallery();
