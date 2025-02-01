<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Portfolio_Responsive_Gallery
 * @subpackage Portfolio_Responsive_Gallery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Portfolio_Responsive_Gallery
 * @subpackage Portfolio_Responsive_Gallery/admin
 * @author     Portfolio Team <info@ays-pro.com>
 */
class Portfolio_Responsive_Gallery_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    private $portfolio_obj;
    private $portfolio_attributes_obj;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_filter('set-screen-option', array(__CLASS__, 'set_screen'), 10, 3);
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook_suffix) {

        wp_enqueue_style($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->version, 'all');

        if (false === strpos($hook_suffix, $this->plugin_name)) {
            return;
        }

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Portfolio_Responsive_Gallery_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Portfolio_Responsive_Gallery_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('ays_prg_animate.css', plugin_dir_url(__FILE__) . 'css/animate.min.css', array(), '3.7.2', 'all');
        wp_enqueue_style($this->plugin_name.'-ays_prg_font_awesome', plugin_dir_url(__FILE__) . 'css/font_awesome_all.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name.'-ays_prg_fa_v4_shims', plugin_dir_url(__FILE__) . 'css/font_awesome_v4-shims.min.css', array(), $this->version, 'all');
        wp_enqueue_style('ays_prg_bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), '4.3.1', 'all');
        wp_enqueue_style('ays-prg-select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), '4.0.7', 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/portfolio-responsive-gallery-admin.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . "-banner", plugin_dir_url( __FILE__ ) . 'css/portfolio-responsive-gallery-banner.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook_suffix) {

        if (false !== strpos($hook_suffix, "plugins.php")){
          wp_enqueue_script('sweetalert-js-prg', plugin_dir_url(__FILE__) . 'js/sweetalert2.all.min.js', array('jquery'), '7.26.29', true);
          wp_enqueue_script('admin-js-prg', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->plugin_name, true);
          wp_localize_script('admin-js-prg',  'apm_admin_ajax_obj', array('ajaxUrl' => admin_url('admin-ajax.php')));
        }


        if (false === strpos($hook_suffix, $this->plugin_name)) {
            return;
        }

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Portfolio_Responsive_Gallery_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Portfolio_Responsive_Gallery_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('jquery-effects-core');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_media();
        wp_enqueue_editor();
        wp_enqueue_script('ays_prg_popper', plugin_dir_url(__FILE__) . 'js/popper.min.js', array('jquery'), '1.14.7', true);
        wp_enqueue_script('ays_prg_bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), '4.3.1', true);
        wp_enqueue_script('ays_prg_select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), '4.0.7', true);
        wp_enqueue_script('sweetalert-js-prg', plugin_dir_url(__FILE__) . 'js/sweetalert2.all.min.js', array('jquery'), '7.26.29', true);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/portfolio-responsive-gallery-admin.js', array('jquery'), $this->version, true);

        wp_enqueue_script( $this->plugin_name . "banner", plugin_dir_url( __FILE__ ) . 'js/portfolio-responsive-gallery-banner.js', array( 'jquery' ), $this->version, true );
        $prg_banner_date = $this->ays_prg_update_banner_time();
        wp_localize_script( $this->plugin_name, 'portfolioLangObj', array(
            'copied'        => __( 'Copied!', $this->plugin_name),
            'clickForCopy'  => __( 'Click for copy.', $this->plugin_name),
            'prgBannerDate' => $prg_banner_date,
        ) );

    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {

        add_options_page(__('Portfolio Responsive Gallery', $this->plugin_name), __('Portfolio Responsive Gallery', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));

        $hook_gallery = add_menu_page(__('Portfolio Responsive Gallery', $this->plugin_name), __('Portfolio Responsive Gallery', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), AYS_PRG_ADMIN_URL . 'images/icons/icon-prg-128x128.svg', 6);

        add_action("load-$hook_gallery", [$this, 'screen_option_portfolio']);

        $hook_portfolio = add_submenu_page(
            $this->plugin_name,
            __('Portfolios', $this->plugin_name),
            __('Portfolios', $this->plugin_name),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );

        add_action("load-$hook_portfolio", [$this, 'screen_option_portfolio']);

        $hook_portfolio_attributes = add_submenu_page(
            $this->plugin_name,
            __('Attributes', $this->plugin_name),
            __('Attributes', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-portfolio-attributes',
            array($this, 'display_plugin_portfolio_attributes_page')
        );

        add_action("load-$hook_portfolio_attributes", [$this, 'screen_option_portfolio_attributes']);

        $hook_portfolio_how_to_use = add_submenu_page(
            $this->plugin_name,
            __('How to use', $this->plugin_name),
            __('How to use', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-portfolio-how_to_use',
            array($this, 'display_plugin_portfolio_how_to_use_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links($links) {
        /*
         *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
         */
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
            '<a href="https://plugins.ays-demo.com/portfolio-responsive-gallery-free-demo/" target="_blank">' . __('Demo', $this->plugin_name) . '</a>',
            '<a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery" target="_blank" style="color: red;font-weight: bold;">' . __('Upgrade', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
        case 'add':
            include_once 'partials/actions/portfolio-responsive-gallery-admin-actions.php';
            break;
        case 'edit':
            include_once 'partials/actions/portfolio-responsive-gallery-admin-actions.php';
            break;
        default:
            include_once 'partials/portfolio-responsive-gallery-admin-display.php';
        }
    }

    public function display_plugin_portfolio_attributes_page() {
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
        case 'add':
            include_once 'partials/attributes/actions/portfolio-responsive-gallery-attributes-actions.php';
            break;
        case 'edit':
            include_once 'partials/attributes/actions/portfolio-responsive-gallery-attributes-actions.php';
            break;
        default:
            include_once 'partials/attributes/portfolio-responsive-gallery-attributes-display.php';
        }
    }
    public function display_plugin_portfolio_how_to_use_page() {

        include_once('partials/how-to-use/portfolio-responsive-gallery-how-to-use.php');
    }

    public static function set_screen($status, $option, $value) {
        return $value;
    }

    public function screen_option_portfolio() {
        $option = 'per_page';
        $args = [
            'label' => __('Portfolios', $this->plugin_name),
            'default' => 20,
            'option' => 'portfolios_per_page',
        ];

        add_screen_option($option, $args);
        $this->portfolio_obj = new Portfolio_Responsive_Gallery_List_Table($this->plugin_name);
    }

    public function screen_option_portfolio_attributes() {
        $option = 'per_page';
        $args = [
            'label' => __('Attributes', $this->plugin_name),
            'default' => 20,
            'option' => 'attributes_per_page',
        ];

        add_screen_option($option, $args);
        $this->portfolio_attributes_obj = new Portfolio_Responsive_Gallery_Attributes_List_Table($this->plugin_name);
    }

    public function ays_get_attr_for_project() {
        if (isset($_REQUEST["action"]) && $_REQUEST["action"] == 'ays_get_attr_for_project') {
            global $wpdb;
            $sql = "SELECT * FROM {$wpdb->prefix}ays_portfolio_attributes WHERE `published`='1'";
            $results = $wpdb->get_results($sql, 'ARRAY_A');
            echo json_encode($results);
            wp_die();
        }
    }

    public static function ays_get_rpg_options() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ays_portfolio';
        $res = $wpdb->get_results("SELECT id, name, width, height FROM " . $table_name . "");
        $aysGlobal_array = array();

        foreach ($res as $ays_res_options) {
            $aysStatic_array = array();
            $aysStatic_array[] = $ays_res_options->id;
            $aysStatic_array[] = $ays_res_options->name;
            $aysStatic_array[] = $ays_res_options->width;
            $aysStatic_array[] = $ays_res_options->height;
            $aysGlobal_array[] = $aysStatic_array;
        }
        return $aysGlobal_array;
    }

    function ays_rpg_register_tinymce_plugin($plugin_array) {
        $plugin_array['ays_rpg_button_mce'] = AYS_rpg_BASE_URL . '/ays_rpg_shortcode.js';
        return $plugin_array;
    }

    public function prg_deactivate_plugin_option() {
		$request_value  = $_REQUEST['upgrade_plugin'];

		$upgrade_option = get_option('ays_prg_upgrade_plugin','');
		if ($upgrade_option === '') {
			add_option('ays_prg_upgrade_plugin', $request_value);
		} else {
			update_option('ays_prg_upgrade_plugin', $request_value);
		}
		echo json_encode(array('option' => get_option('ays_prg_upgrade_plugin','')));
		wp_die();
	}

    function ays_rpg_add_tinymce_button($buttons) {
        $buttons[] = "ays_rpg_button_mce";
        return $buttons;
    }

    function gen_ays_rpg_shortcode_callback() {
        $shortcode_data = $this->ays_get_rpg_options();

        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title><?php echo __('Gallery Photo Gallery', $this->plugin_name); ?></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>

                <?php
            wp_print_scripts('jquery');
        ?>
                <base target="_self">
            </head>
            <body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" dir="ltr" class="forceColors">
                <div class="select-sb">

              <table align="center">
                  <tr>
                    <td><label for="ays_rpg">Gallery</label></td>
                    <td>
                      <span>
                                <select id="ays_rpg" style="padding: 2px; height: 25px; font-size: 16px;width:100%;">
                            <option>--Select Gallery--</option>
                                <?php foreach ($shortcode_data as $index => $data) {
            echo '<option id="' . $data[0] . '" value="' . $data[0] . '" mw="' . $data[2] . '" mh="' . $data[3] . '" class="ays_rpg_options">' . $data[1] . '</option>';
        }

        ?>
                                </select>
                            </span>
                    </td>
                  </tr>
                  <tr>
                    <td><label for="ays_rpg_nk_width_get">Gallery width</label></td>
                    <td><input type="number" name="ays_sl_nk_width_get" id="ays_rpg_nk_width_get" style="padding: 2px; height: 25px; font-size: 16px;"></td>
                  </tr>
                  <tr>
                    <td><label for="ays_rpg_nk_height_get">Gallery height</label></td>
                    <td><input type="number" name="ays_rpg_nk_height_get" id="ays_rpg_nk_height_get" style="padding: 2px; height: 25px; font-size: 16px;"></td>
                  </tr>
              </table>
                </div>
                <div class="mceActionPanel">
                    <input type="submit" id="insert" name="insert" value="Insert" onClick="rpg_insert_shortcode();"/>
                </div>
            <script>
                jQuery("#ays_rpg").change(function(event){
                        var ays_rpg_mw = jQuery( "#ays_rpg option:selected").attr("mw");
                        var ays_rpg_mh = jQuery( "#ays_rpg option:selected").attr("mh");
                        jQuery("#ays_rpg_nk_width_get").val(ays_rpg_mw);
                        jQuery("#ays_rpg_nk_height_get").val(ays_rpg_mh);
                    });
            </script>
            <script type="text/javascript">
                function rpg_insert_shortcode() {
                    var mw = document.getElementById('ays_rpg_nk_width_get').value;
                    var mh = document.getElementById('ays_rpg_nk_height_get').value;
                    var tagtext = '[gallery_p_gallery id="' + document.getElementById('ays_rpg')[document.getElementById('ays_rpg').selectedIndex].id + '" w="'+ mw +'" h="'+ mh +'"]';
                    window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
                    tinyMCEPopup.close();
                }
              </script>

            </body>
          </html>
          <?php
        die();
    }

    public function ays_get_all_image_sizes() {
        $image_sizes = array();
        global $_wp_additional_image_sizes;
        $default_image_sizes = array('thumbnail', 'medium', 'medium_large', 'large');

        foreach ($default_image_sizes as $size) {
            $image_sizes[$size]['width'] = intval(get_option("{$size}_size_w"));
            $image_sizes[$size]['height'] = intval(get_option("{$size}_size_h"));
            $image_sizes[$size]['crop'] = get_option("{$size}_crop") ? get_option("{$size}_crop") : false;
        }

        if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) {
            $image_sizes = array_merge($image_sizes, $_wp_additional_image_sizes);
        }

        return $image_sizes;
    }

    //Sale Banner Start
    // public function ays_prg_sale_baner()
    // {
    //     if(isset($_POST['ays_prg_sale_btn_winter'])){
    //         update_option('ays_prg_sale_notification_w', 1);
    //         update_option('ays_prg_sale_date_w', current_time( 'mysql' ));
    //     }

    //     if(isset($_POST['ays_prg_sale_btn_winter_for_two_months'])){
    //         update_option('ays_prg_sale_dismiss_for_two_month_w', 1);
    //         update_option('ays_prg_sale_date_w', current_time( 'mysql' ));
    //     }
    
    //     $ays_prg_sale_date = get_option('ays_prg_sale_date_w');
    //     $ays_prg_sale_two_months = get_option('ays_prg_sale_dismiss_for_two_month_w');

    //     $val = 60*60*24*5;
    //     if($ays_prg_sale_two_months == 1){
    //         $val = 60*60*24*61;
    //     }

    //     $current_date = current_time( 'mysql' );
    //     $date_diff = strtotime($current_date) - intval(strtotime($ays_prg_sale_date)) ;
        
    //     $days_diff = $date_diff / $val;
    
    //     if(intval($days_diff) > 0 ){
    //         update_option('ays_prg_sale_notification_w', 0);
    //         update_option('ays_prg_sale_dismiss_for_two_month_w', 0);
    //     }
    
    //     $ays_prg_flag = intval(get_option('ays_prg_sale_notification_w'));
    //     $ays_prg_flag += intval(get_option('ays_prg_sale_dismiss_for_two_month_w'));
    //     if( $ays_prg_flag == 0 ){
    //         if (isset($_GET['page'])){
    //             if($_GET['page'] == 'portfolio-responsive-gallery' || $_GET['page'] == 'portfolio-responsive-gallery-portfolio-attributes' || $_GET['page'] == 'portfolio-responsive-gallery-portfolio-how_to_use') {
    //                 // $this->ays_prg_sale_message($ays_prg_flag);
    //                 $this->ays_prg_winter_bundle_message($ays_prg_flag);
    //             }
    //         }
    //     }
    // }

    public function ays_prg_sale_baner(){
        if(isset($_POST['ays_prg_sale_btn'])){
            update_option('ays_prg_sale_btn', 1); 
            update_option('ays_prg_sale_date', current_time( 'mysql' ));
        }

        if(isset($_POST['ays_prg_sale_btn_for_two_months'])){
            update_option('ays_prg_sale_btn_for_two_months', 1);
            update_option('ays_prg_sale_date', current_time( 'mysql' ));
        }

        $ays_prg_sale_date = get_option('ays_prg_sale_date');
        $ays_prg_sale_two_months = get_option('ays_prg_sale_btn_for_two_months');

        $val = 60*60*24*5;
        if($ays_prg_sale_two_months == 1){
            $val = 60*60*24*61;
        }

        $current_date = current_time( 'mysql' );
        $date_diff = strtotime($current_date) -  intval(strtotime($ays_prg_sale_date));

        $days_diff = $date_diff / $val;

        if(intval($days_diff) > 0 ){
            update_option('ays_prg_sale_btn', 0); 
            update_option('ays_prg_sale_btn_for_two_months', 0);
        }

        $ays_prg_ishmar = intval(get_option('ays_prg_sale_btn'));
        $ays_prg_ishmar += intval(get_option('ays_prg_sale_btn_for_two_months'));
        if($ays_prg_ishmar == 0 ){
            if (isset($_GET['page']) && strpos($_GET['page'], PRG_NAME) !== false) {
                // $this->ays_prg_christmas_message($ays_prg_ishmar);
                // $this->ays_prg_black_friday_message($ays_prg_ishmar);
                // $this->ays_prg_new_sale_message($ays_prg_ishmar);
                $this->ays_prg_new_prg_pro_message_2024($ays_prg_ishmar);
            }
        }
    }

    /*
    ==========================================
       Sale Banner | Start
    ==========================================
    */
    public function ays_prg_new_sale_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-prg-new-sale-dicount-month-main" class="notice notice-success is-dismissible ays_prg_dicount_info">';
                $content[] = '<div id="ays-prg-dicount-month" class="ays_prg_dicount_month">';
                    // $content[] = '<a href="https://ays-pro.com/mega-bundle" target="_blank" class="ays-prg-sale-banner-link"><img src="' . AYS_PRG_ADMIN_URL . '/images/mega_bundle_logo_box.png"></a>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-prg-dicount-wrap-text-box">';
                        $content[] = '<div>';

                            $content[] = '<span class="ays-prg-new-sale-title">';
                                $content[] = __( "<span><a href='https://ays-pro.com/wordpress/portfolio-responsive-gallery?utm_source=dashboard&utm_medium=prg-free&utm_campaign=sale-banner' target='_blank' style='color:#ffffff; text-decoration: underline;'>Portfolio Responsive Gallery</a></span>", PRG_NAME );
                            $content[] = '</span>';
                            $content[] = '<div style="display: inline-block;">';
                                $content[] = '<img src="' . AYS_PRG_ADMIN_URL . '/images/ays-prg-banner-sale-30.svg" class="ays-prg-new-sale-mobile-image-display-none" style="width: 70px;">';
                            $content[] = '</div>';
                            $content[] = '</br>';
                            $content[] = '<div class="ays-prg-new-sale-mobile-image-display-block display_none">';
                                $content[] = '<img src="' . AYS_PRG_ADMIN_URL . '/images/ays-prg-banner-sale-30.svg" style="width: 70px;">';
                            $content[] = '</div>';

                            $content[] = '<span class="ays-prg-new-sale-desc">';
                                $content[] = '<img class="ays-prg-new-sale-guaranteeicon" src="' . AYS_PRG_ADMIN_URL . '/images/prg-guaranteeicon.svg" style="width: 30px;">';
                                $content[] = __( "30 Day Money Back Guarantee", PRG_NAME );
                            $content[] = '</span>';
                        $content[] = '</div>';

                        // $content[] = '<br>';

                        // $content[] = '<strong>';
                        //         $content[] = __( "Hurry up! <a href='https://ays-pro.com/mega-bundle' target='_blank'>Check it out!</a>", PRG_NAME );
                        // $content[] = '</strong>';

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-prg-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-prg-dismiss-buttons-content">';
                                if( current_user_can( 'manage_options' ) ){
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_prg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad</button>';
                                    $content[] = wp_nonce_field( PRG_NAME . '-sale-banner' ,  PRG_NAME . '-sale-banner' );
                                }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-prg-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-prg-countdown-main-container">';
                            $content[] = '<div class="ays-prg-countdown-container">';

                                $content[] = '<div id="ays-prg-countdown">';

                                    $content[] = '<div>';
                                        $content[] = __( "Offer ends in:", PRG_NAME );
                                    $content[] = '</div>';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-prg-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-prg-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-prg-dicount-wrap-button-box">';
                        $content[] = '<a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery?utm_source=dashboard&utm_medium=prg-free&utm_campaign=sale-banner" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now', PRG_NAME ) . '</a>';
                        $content[] = '<span class="ays-prg-dicount-one-time-text">';
                            $content[] = __( "One-time payment", PRG_NAME );
                        $content[] = '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }
    /*
    ==========================================
       Sale Banner | End
    ==========================================
    */

    public function ays_prg_sale_message($ishmar){
        if($ishmar == 0 ){
            $content[] = '<div id="ays-prg-dicount-month-main" class="notice notice-success is-dismissible ays_prg_dicount_info">';
                $content[] = '<div id="ays-prg-dicount-month" class="ays_prg_dicount_month">';
                    $content[] = '<a href="https://ays-pro.com/business-bundle" target="_blank" class="ays-prg-sale-banner-link" style="display:none;"><img src="' . AYS_PRG_ADMIN_URL . 'images/black-friday-great-bundle.png"></a>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box">';

                        $content[] = '<strong style="font-weight: bold;">';
                            $content[] = __( "Limited Time <span class='ays-prg-dicount-wrap-color'>50%</span> SALE on <br><span><a href='https://ays-pro.com/business-bundle' target='_blank' class='ays-prg-dicount-wrap-color ays-prg-dicount-wrap-text-decoration' style='display:block;'>Business Bundle</a></span> (All 13 Plugins)!", PRG_NAME );
                        $content[] = '</strong>';

                        $content[] = '<br>';

                        $content[] = '<strong>';
                                $content[] = __( "Hurry up! Ends on November 26. <a href='https://ays-pro.com/business-bundle' target='_blank'>Check it out!</a>", PRG_NAME );
                        $content[] = '</strong>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box">';

                        $content[] = '<div id="ays-prg-countdown-main-container">';
                            $content[] = '<div class="ays-prg-countdown-container">';

                                $content[] = '<div id="ays-prg-countdown">';
                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-prg-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-prg-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-prg-dismiss-buttons-content">';
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_portfolio_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad</button>';
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_prg_sale_btn_for_two_months" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad for 2 months</button>';
                                $content[] = '</div>';
                            $content[] = '</form>';

                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-buy-now-button-box">';
                        $content[] = '<a href="https://ays-pro.com/business-bundle" class="button button-primary ays-buy-now-button" id="ays-button-top-buy-now" target="_blank" style="" >' . __( 'Buy Now !', PRG_NAME ) . '</a>';
                    $content[] = '</div>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-prg-dicount-wrap-opacity-box">';
                        $content[] = '<a href="https://ays-pro.com/business-bundle" class="ays-buy-now-opacity-button" target="_blank">' . __( 'link', PRG_NAME ) . '</a>';
                    $content[] = '</div>';

                $content[] = '</div>';
            $content[] = '</div>';
            
            $content = implode( '', $content );
            echo $content;

        }
    }

    // public function ays_prg_winter_bundle_message($flag){
    //     if($flag == 0 ){
    //         $content = array();

    //         $content[] = '<div id="ays-prg-dicount-month-main" class="notice notice-success is-dismissible ays_prg_dicount_info">';
    //             $content[] = '<div id="ays-prg-dicount-month" class="ays_prg_dicount_month">';
    //                 $content[] = '<a href="https://ays-pro.com/winter-bundle" target="_blank" class="ays-prg-sale-banner-link"><img src="' . AYS_PRG_ADMIN_URL . '/images/winter_bundle_logo.png"></a>';

    //                 $content[] = '<div class="ays-prg-dicount-wrap-box">';

    //                     $content[] = '<strong>';
    //                         $content[] = __( "Limited Time <span class='ays-prg-dicount-wrap-color'>50%</span> SALE on <br><span><a href='https://ays-pro.com/winter-bundle' target='_blank' class='ays-prg-dicount-wrap-color ays-prg-dicount-wrap-text-decoration' style='display:block;'>Winter Bundle</a></span> (Copy + Popup + Survey)!", PRG_NAME );
    //                     $content[] = '</strong>';

    //                     $content[] = '<br>';

    //                     $content[] = '<strong>';
    //                             $content[] = __( "Hurry up! Ends on January 1. <a href='https://ays-pro.com/winter-bundle' target='_blank'>Check it out!</a>", PRG_NAME );
    //                     $content[] = '</strong>';
                            
    //                 $content[] = '</div>';

    //                 $content[] = '<div class="ays-prg-dicount-wrap-box">';

    //                     $content[] = '<div id="ays-prg-countdown-main-container">';
    //                         $content[] = '<div class="ays-prg-countdown-container">';

    //                             $content[] = '<div id="ays-prg-countdown">';
    //                                 $content[] = '<ul>';
    //                                     $content[] = '<li><span id="ays-prg-countdown-days"></span>days</li>';
    //                                     $content[] = '<li><span id="ays-prg-countdown-hours"></span>Hours</li>';
    //                                     $content[] = '<li><span id="ays-prg-countdown-minutes"></span>Minutes</li>';
    //                                     $content[] = '<li><span id="ays-prg-countdown-seconds"></span>Seconds</li>';
    //                                 $content[] = '</ul>';
    //                             $content[] = '</div>';

    //                             $content[] = '<div id="ays-prg-countdown-content" class="emoji">';
    //                                 $content[] = '<span>🚀</span>';
    //                                 $content[] = '<span>⌛</span>';
    //                                 $content[] = '<span>🔥</span>';
    //                                 $content[] = '<span>💣</span>';
    //                             $content[] = '</div>';

    //                         $content[] = '</div>';

    //                         $content[] = '<form action="" method="POST">';
	// 							$content[] ='<div id="ays-prg-dismiss-buttons-content" style="margin: auto;">';
	// 								$content[] = '<button class="btn btn-link ays-button" name="ays_prg_sale_btn_winter" style="height: 32px; margin-left: 0;padding-left: 0;cursor:pointer;">Dismiss ad</button>';
	// 								$content[] = '<button class="btn btn-link ays-button" name="ays_prg_sale_btn_winter_for_two_months" style="height: 32px; padding-left: 0;margin-left:5px; cursor:pointer;">Dismiss ad for 2 months</button>';
	// 							$content[] ='</div>';
    //                         $content[] = '</form>';

    //                     $content[] = '</div>';
                            
    //                 $content[] = '</div>';

    //                 $content[] = '<a href="https://ays-pro.com/winter-bundle" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now !', PRG_NAME ) . '</a>';
    //             $content[] = '</div>';
    //         $content[] = '</div>';

    //         $content = implode( '', $content );
    //         echo $content;
    //     }
    // }

    // Christmas banner
    public static function ays_prg_christmas_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-prg-dicount-christmas-month-main" class="notice notice-success is-dismissible ays_prg_dicount_info">';
                $content[] = '<div id="ays-prg-dicount-christmas-month" class="ays_prg_dicount_month">';
                    $content[] = '<div class="ays-prg-dicount-christmas-box">';
                        $content[] = '<div class="ays-prg-dicount-christmas-wrap-box ays-prg-dicount-christmas-wrap-box-80">';
                            $content[] = '<div class="ays-prg-dicount-christmas-title-row">' . __( 'Limited Time', PRG_NAME ) .' '. '<a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery" class="ays-prg-dicount-christmas-button-sale" target="_blank">' . __( '20%', PRG_NAME ) . '</a>' . ' SALE</div>';
                            $content[] = '<div class="ays-prg-dicount-christmas-title-row">' . __( 'prg Maker Plugin', PRG_NAME ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-prg-dicount-christmas-wrap-box" style="width: 25%;">';
                            $content[] = '<div id="ays-prg-countdown-main-container">';
                                $content[] = '<div class="ays-prg-countdown-container">';
                                    $content[] = '<div id="ays-prg-countdown" style="display: block;">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><span id="ays-prg-countdown-days"></span>' . __( 'Days', PRG_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-prg-countdown-hours"></span>' . __( 'Hours', PRG_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-prg-countdown-minutes"></span>' . __( 'Minutes', PRG_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-prg-countdown-seconds"></span>' . __( 'Seconds', PRG_NAME ) . '</li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';
                                    $content[] = '<div id="ays-prg-countdown-content" class="emoji" style="display: none;">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-prg-dicount-christmas-wrap-box" style="width: 25%;">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery" class="ays-prg-dicount-christmas-button-buy-now" target="_blank">' . __( 'BUY NOW!', PRG_NAME ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-prg-dismiss-buttons-container-for-form-christmas">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-prg-dismiss-buttons-content-christmas">';
                            $content[] = '<button class="btn btn-link ays-button-christmas" name="ays_prg_sale_btn" style="">' . __( 'Dismiss ad', PRG_NAME ) . '</button>';
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    /*
    ==========================================
        Black Friday Banner | Start
    ==========================================
    */

    public static function ays_prg_black_friday_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-prg-dicount-black-friday-month-main" class="notice notice-success is-dismissible ays_prg_dicount_info">';
                $content[] = '<div id="ays-prg-dicount-black-friday-month" class="ays_prg_dicount_month">';
                    $content[] = '<div class="ays-prg-dicount-black-friday-box">';
                        $content[] = '<div class="ays-prg-dicount-black-friday-wrap-box ays-prg-dicount-black-friday-wrap-box-80" style="width: 70%;">';
                            $content[] = '<div class="ays-prg-dicount-black-friday-title-row">' . __( 'Limited Time', PRG_NAME ) .' '. '<a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery?utm_source=dashboard&utm_medium=portfolio-responsive-gallery-free&utm_campaign=black-friday-sale-banner" class="ays-prg-dicount-black-friday-button-sale" target="_blank">' . __( 'Sale', PRG_NAME ) . '</a>' . '</div>';
                            $content[] = '<div class="ays-prg-dicount-black-friday-title-row ays-prg-dicount-black-friday-title-row-product"><span>' . __( 'Portfolio Responsive Gallery', PRG_NAME ) . '</span></div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-prg-dicount-black-friday-wrap-box ays-prg-dicount-black-friday-wrap-text-box">';
                            $content[] = '<div class="ays-prg-dicount-black-friday-text-row">' . __( '30% off', PRG_NAME ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-prg-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<div id="ays-prg-countdown-main-container">';
                                $content[] = '<div class="ays-prg-countdown-container">';
                                    $content[] = '<div id="ays-prg-countdown" style="display: block;">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><span id="ays-prg-countdown-days">0</span>' . __( 'Days', PRG_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-prg-countdown-hours">0</span>' . __( 'Hours', PRG_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-prg-countdown-minutes">0</span>' . __( 'Minutes', PRG_NAME ) . '</li>';
                                            $content[] = '<li><span id="ays-prg-countdown-seconds">0</span>' . __( 'Seconds', PRG_NAME ) . '</li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';
                                    $content[] = '<div id="ays-prg-countdown-content" class="emoji" style="display: none;">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-prg-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery?utm_source=dashboard&utm_medium=portfolio-responsive-gallery-free&utm_campaign=black-friday-sale-banner" class="ays-prg-dicount-black-friday-button-buy-now" target="_blank">' . __( 'Get Your Deal', PRG_NAME ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-prg-dismiss-buttons-container-for-form-black-friday">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-prg-dismiss-buttons-content-black-friday">';
                            if( current_user_can( 'manage_options' ) ){
                                $content[] = '<button class="btn btn-link ays-button-black-friday" name="ays_prg_sale_btn" style="">' . __( 'Dismiss ad', PRG_NAME ) . '</button>';
                                $content[] = wp_nonce_field( PRG_NAME . '-sale-banner' ,  PRG_NAME . '-sale-banner' );
                            }
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    /*
    ==========================================
        Black Friday Banner | End
    ==========================================
    */

    public function ays_prg_new_prg_pro_message_2024($ishmar){
        if($ishmar == 0 ){
            $content = array();
            $content[] = '<div id="ays-prg-new-mega-bundle-dicount-month-main-2024" class="notice notice-success is-dismissible ays_prg_dicount_info">';
                $content[] = '<div id="ays-prg-dicount-month" class="ays_prg_dicount_month">';

                    $content[] = '<div class="ays-prg-discount-box-sale-image"></div>';
                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-prg-dicount-wrap-text-box">';

                        $content[] = '<div class="ays-prg-dicount-wrap-text-box-texts">';
                            $content[] = '<div>
                                            <a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery?utm_source=dashboard&utm_medium=prg-free&utm_campaign=sale-banner" target="_blank" style="color:#30499B;">
                                            <span class="ays-prg-new-mega-bundle-limited-text">Limited</span> Offer for Portfolio Responsive Gallery </a> <br> 
                                          </div>';
                        $content[] = '</div>';

                        $content[] = '<div style="font-size: 17px;">';
                            $content[] = '<img style="width: 24px;height: 24px;" src="' . esc_attr(AYS_PRG_ADMIN_URL) . '/images/icons/guarantee-new.png">';
                            $content[] = '<span style="padding-left: 4px; font-size: 14px; font-weight: 600;"> 30 Day Money Back Guarantee</span>';
                            
                        $content[] = '</div>';

                       

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-prg-dismiss-buttons-container-for-prg">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-prg-dismiss-buttons-content">';
                                    if( current_user_can( 'manage_options' ) ){
                                        $content[] = '<button class="btn btn-link ays-button" name="ays_prg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0; color: #30499B;
                                        ">Dismiss ad</button>';
                                        $content[] = wp_nonce_field( $this->plugin_name . '-sale-banner' ,  $this->plugin_name . '-sale-banner' );
                                    }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-prg-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-prg-countdown-main-container">';
                            $content[] = '<div class="ays-prg-countdown-container">';

                                $content[] = '<div id="ays-prg-countdown">';

                                    $content[] = '<div style="font-weight: 500;">';
                                        $content[] = __( "Offer ends in:", "portfolio-responsive-gallery" );
                                    $content[] = '</div>';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-prg-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-prg-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-prg-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-prg-dicount-wrap-box ays-prg-dicount-wrap-button-box">';
                        $content[] = '<a href="https://ays-pro.com/wordpress/portfolio-responsive-gallery?utm_source=dashboard&utm_medium=prg-free&utm_campaign=sale-banner" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now !', "portfolio-responsive-gallery" ) . '</a>';
                        $content[] = '<span >One-time payment</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo html_entity_decode(esc_html( $content ));
        }        
    }

    public function ays_prg_update_banner_time(){

        $date = time() + ( 3 * 24 * 60 * 60 ) + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
        // $date = time() + ( 60 ) + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS); // for testing | 1 min
        $next_3_days = date('M d, Y H:i:s', $date);

        $ays_prg_banner_time = get_option('ays_prg_banner_time');

        if ( !$ays_prg_banner_time || is_null( $ays_prg_banner_time ) ) {
            update_option('ays_prg_banner_time', $next_3_days ); 
        }

        $get_ays_prg_banner_time = get_option('ays_prg_banner_time');

        $val = 60*60*24*0.5; // half day
        // $val = 60; // for testing | 1 min

        $current_date = current_time( 'mysql' );
        $date_diff = strtotime($current_date) - intval(strtotime($get_ays_prg_banner_time));

        $days_diff = $date_diff / $val;
        if(intval($days_diff) > 0 ){
            update_option('ays_prg_banner_time', $next_3_days);
        }

        return $get_ays_prg_banner_time;
    }

    public function portfolio_admin_footer($a){
        wp_enqueue_style( $this->plugin_name . '-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
        if(isset($_REQUEST['page'])){
            if(false !== strpos( sanitize_text_field( $_REQUEST['page'] ), $this->plugin_name)){
                ?>
                <p style="font-size:13px;text-align:center;font-style:italic;">
                    <span style="margin-left:0px;margin-right:10px;" class="ays_heart_beat"><img src="<?php echo AYS_PRG_ADMIN_URL . 'images/heart.png'; ?>" class="animated" /></span>
                    <span><?php echo __( "If you love our plugin, please do big favor and rate us on", $this->plugin_name); ?></span> 
                    <a target="_blank" href='https://wordpress.org/support/plugin/portfolio-responsive-gallery/reviews/'>WordPress.org</a>
                    <span class="ays_heart_beat"><img src="<?php echo AYS_PRG_ADMIN_URL . 'images/heart.png'; ?>" class="animated" /></span>
                </p>
            <?php
            }
        }
    }
}
