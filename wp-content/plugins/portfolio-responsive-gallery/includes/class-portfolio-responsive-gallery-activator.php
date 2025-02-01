<?php
global $ays_prg_db_version;
$ays_prg_db_version = '1.0.7';
/**
 * Fired during plugin activation
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Portfolio_Responsive_Gallery
 * @subpackage Portfolio_Responsive_Gallery/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Portfolio_Responsive_Gallery
 * @subpackage Portfolio_Responsive_Gallery/includes
 * @author     Portfolio Team <info@ays-pro.com>
 */
class Portfolio_Responsive_Gallery_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        global $ays_prg_db_version;
        $installed_ver = get_option("ays_prg_db_version");

        $table_portfolio = $wpdb->prefix . 'ays_portfolio';
        $table_portfolio_items = $wpdb->prefix . 'ays_portfolio_items';
        $table_attributes = $wpdb->prefix . 'ays_portfolio_attributes';
        $charset_collate = $wpdb->get_charset_collate();
        if ($installed_ver != $ays_prg_db_version) {

            $sql = "CREATE TABLE $table_portfolio (
                      	id INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                      	name VARCHAR(255) NOT NULL,
                      	description TEXT NOT NULL,
                      	options TEXT NOT NULL,
                      	PRIMARY KEY (id)
                    )$charset_collate;
                    CREATE TABLE $table_portfolio_items (
                      	id INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                      	portfolio_id INT(16) NOT NULL,
                      	name VARCHAR(255) NOT NULL,
                      	description TEXT NOT NULL,
                      	project_url TEXT NOT NULL,
                      	main_image TEXT NOT NULL,
                      	images TEXT NOT NULL,
                      	options TEXT NOT NULL,
                      	attributes TEXT NOT NULL,
                      	PRIMARY KEY (id)
                    )$charset_collate;
                    CREATE TABLE $table_attributes (
                        id INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                        name VARCHAR(255) NOT NULL,
                        slug VARCHAR(255) NOT NULL,
                        type VARCHAR(255) NOT NULL,
                        published TINYINT UNSIGNED NOT NULL,
                        PRIMARY KEY (`id`)
                    )$charset_collate;";
            dbDelta($sql);

            update_option('ays_prg_db_version', $ays_prg_db_version);
        }
    }

    public static function ays_prg_db_check() {
        global $ays_prg_db_version;
        if (get_site_option('ays_prg_db_version') != $ays_prg_db_version) {
            self::activate();
        }
    }
}
