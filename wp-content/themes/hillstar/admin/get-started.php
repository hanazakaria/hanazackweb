<?php

use ColibriWP\Theme\PluginsManager;
use ColibriWP\Theme\Translations;

$hillstar_is_builder_installed = apply_filters( 'hillstar_page_builder/installed', false );

wp_enqueue_script( 'updates' );

function hillstar_get_setting_link( $setting ) {
    return esc_attr( hillstar_theme()->getCustomizer()->getSettingQuickLink( $setting ) );
}

?>

<div class="hillstar-get-started__container hillstar-admin-panel">
    <div class="hillstar-get-started__section">
        <h2 class="col-title hillstar-get-started__section-title">
            <span class="hillstar-get-started__section-title__icon dashicons dashicons-admin-plugins"></span>
            <?php Translations::escHtmlE( 'get_started_section_1_title' ); ?>
        </h2>
        <div class="hillstar-get-started__content">


            <?php foreach ( hillstar_theme()->getPluginsManager()->getPluginData() as $hillstar_recommended_plugin_slug => $hillstar_recommended_plugin_data ): ?>
                <?php
                $hillstar_plugin_state = hillstar_theme()->getPluginsManager()->getPluginState( $hillstar_recommended_plugin_slug );
                $hillstar_notice_type  = $hillstar_plugin_state === PluginsManager::ACTIVE_PLUGIN ? 'blue' : '';
                if ( isset( $hillstar_recommended_plugin_data['internal'] ) && $hillstar_recommended_plugin_data['internal'] ) {
                    continue;
                }
                ?>
                <div 
				
					class="hillstar-notice <?php echo esc_attr( $hillstar_notice_type ); ?> plugin-card-<?php echo $hillstar_recommended_plugin_slug;?>">
                    <div class="hillstar-notice__header">
                        <h3 class="hillstar-notice__title"><?php echo esc_html( hillstar_theme()->getPluginsManager()->getPluginData( "{$hillstar_recommended_plugin_slug}.name" ) ); ?></h3>
                        <div class="hillstar-notice__action">
                            <?php if ( $hillstar_plugin_state === PluginsManager::ACTIVE_PLUGIN ): ?>
                                <p class="hillstar-notice__action__active"><?php Translations::escHtmlE( 'plugin_installed_and_active' ); ?> </p>
                            <?php else: ?>
                                <?php if ( $hillstar_plugin_state === PluginsManager::INSTALLED_PLUGIN ): ?>
                                    <a class="button button-large colibri-plugin activate-now" 
										data-slug="<?php echo $hillstar_recommended_plugin_slug;?>"
                                       href="<?php echo esc_url( hillstar_theme()->getPluginsManager()->getActivationLink( $hillstar_recommended_plugin_slug ) ); ?>">
                                        <?php Translations::escHtmlE( 'activate' ); ?>
                                    </a>
                                <?php else: ?>
                                    <a class="button button-large colibri-plugin install-now"
									   data-slug="<?php echo $hillstar_recommended_plugin_slug;?>"
                                       href="<?php echo esc_url( hillstar_theme()->getPluginsManager()->getInstallLink( $hillstar_recommended_plugin_slug ) ); ?>">
                                        <?php Translations::escHtmlE( 'install' ); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="hillstar-notice__description"><?php echo esc_html( hillstar_theme()->getPluginsManager()->getPluginData( "{$hillstar_recommended_plugin_slug}.description" ) ); ?></p>


                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="hillstar-get-started__section">
        <h2 class="hillstar-get-started__section-title">
            <span class="hillstar-get-started__section-title__icon dashicons dashicons-admin-appearance"></span>
            <?php Translations::escHtmlE( 'get_started_section_2_title' ); ?>
        </h2>
        <div class="hillstar-get-started__content">
            <div class="hillstar-customizer-option__container">
                <div class="hillstar-customizer-option">
                    <span class="hillstar-customizer-option__icon dashicons dashicons-format-image"></span>
                    <a class="hillstar-customizer-option__label"
                       target="_blank"
                       href="<?php echo esc_url( hillstar_get_setting_link( 'logo' ) ); ?>">
                        <?php Translations::escHtmlE( 'get_started_set_logo' ); ?>
                    </a>
                </div>
                <div class="hillstar-customizer-option">
                    <span class="hillstar-customizer-option__icon dashicons dashicons-format-image"></span>
                    <a class="hillstar-customizer-option__label"
                       target="_blank"
                       href="<?php echo esc_url( hillstar_get_setting_link( 'hero_background' ) ); ?>">
                        <?php Translations::escHtmlE( 'get_started_change_hero_image' ); ?>
                    </a>
                </div>
                <div class="hillstar-customizer-option">
                    <span class="hillstar-customizer-option__icon dashicons dashicons-menu-alt3"></span>
                    <a class="hillstar-customizer-option__label"
                       target="_blank"
                       href="<?php echo esc_url( hillstar_get_setting_link( 'navigation' ) ); ?>">
                        <?php Translations::escHtmlE( 'get_started_change_customize_navigation' ); ?>
                    </a>
                </div>
                <div class="hillstar-customizer-option">
                    <span class="hillstar-customizer-option__icon dashicons dashicons-layout"></span>
                    <a class="hillstar-customizer-option__label"
                       target="_blank"
                       href="<?php echo esc_url( hillstar_get_setting_link( 'hero_layout' ) ); ?>">
                        <?php Translations::escHtmlE( 'get_started_change_customize_hero' ); ?>
                    </a>
                </div>
                <div class="hillstar-customizer-option">
                    <span class="hillstar-customizer-option__icon dashicons dashicons-admin-appearance"></span>
                    <a class="hillstar-customizer-option__label"
                       target="_blank"
                       href="<?php echo esc_url( hillstar_get_setting_link( 'footer' ) ); ?>">
                        <?php Translations::escHtmlE( 'get_started_customize_footer' ); ?>
                    </a>
                </div>
                <?php if ( $hillstar_is_builder_installed ): ?>
                    <div class="hillstar-customizer-option">
                        <span class="hillstar-customizer-option__icon dashicons dashicons-art"></span>
                        <a class="hillstar-customizer-option__label"
                           target="_blank"
                           href="<?php echo esc_url( hillstar_get_setting_link( 'color_scheme' ) ); ?>">
                            <?php Translations::escHtmlE( 'get_started_change_color_settings' ); ?>
                        </a>
                    </div>
                    <div class="hillstar-customizer-option">
                        <span class="hillstar-customizer-option__icon dashicons dashicons-editor-textcolor"></span>
                        <a class="hillstar-customizer-option__label"
                           target="_blank"
                           href="<?php echo esc_url( hillstar_get_setting_link( 'general_typography' ) ); ?>">
                            <?php Translations::escHtmlE( 'get_started_customize_fonts' ); ?>
                        </a>
                    </div>

                <?php endif; ?>
                <div class="hillstar-customizer-option">
                    <span class="hillstar-customizer-option__icon dashicons dashicons-menu-alt3"></span>
                    <a class="hillstar-customizer-option__label"
                       target="_blank"
                       href="<?php echo esc_url( hillstar_get_setting_link( 'menu' ) ); ?>">
                        <?php Translations::escHtmlE( 'get_started_set_menu_links' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php



wp_print_request_filesystem_credentials_modal();
wp_print_admin_notice_templates();
