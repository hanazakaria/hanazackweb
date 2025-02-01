<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Portfolio_Responsive_Gallery
 * @subpackage Portfolio_Responsive_Gallery/admin/partials
 */
?>

<?php
    $plus_icon_svg = "<span class=''><img src='". AYS_PRG_ADMIN_URL ."/images/icons/plus=icon.svg'></span>";
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap ays-prg-list-table">
    <h1 class="wp-heading-inline">
        <?php
        echo esc_html(get_admin_page_title());        
        echo sprintf( '<a href="?page=%s&action=%s" class="portfolio_add_new_button page-title-action button-primary ays-prg-add-new-button-new-design"> %s '  . __('Add New', $this->plugin_name) . '</a>', esc_attr( $_REQUEST['page'] ), 'add', $plus_icon_svg);
        ?>
    </h1>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                        $this->portfolio_obj->prepare_items();
                        $search = __("Search" , $this->plugin_name);
                        $this->portfolio_obj->search_box($search, $this->plugin_name);
                        $this->portfolio_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>