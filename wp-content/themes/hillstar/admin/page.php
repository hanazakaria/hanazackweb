<?php


use ColibriWP\Theme\Core\Hooks;
use ColibriWP\Theme\Translations;
use ColibriWP\Theme\View;

$hillstar_tabs            = View::getData( 'tabs', array() );
$hillstar_current_tab     = View::getData( 'current_tab', null );
$hillstar_url             = View::getData( 'page_url', null );
$hillstar_welcome_message = View::getData( 'welcome_message', null );
$hillstar_tab_partial     = View::getData( "tabs.{$hillstar_current_tab}.tab_partial", null );
Hooks::prefixed_do_action( "before_info_page_tab_{$hillstar_current_tab}" );
$hillstar_slug        = "colibri-wp-page-info";
$colibri_get_started = array(
    'plugin_installed_and_active' => Translations::escHtml( 'plugin_installed_and_active' ),
    'activate'                    => Translations::escHtml( 'activate' ),
    'activating'                  => __( 'Activating', 'hillstar' ),
    'install_recommended'         => isset( $_GET['install_recommended'] ) ? $_GET['install_recommended'] : ''
);

wp_localize_script( $hillstar_slug, 'colibri_get_started', $colibri_get_started );
?>
<div class="hillstar-admin-page wrap about-wrap full-width-layout mesmerize-page">

    <div class="hillstar-admin-page--hero">
        <div class="hillstar-admin-page--hero-intro hillstar-admin-page-spacing ">
            <div class="hillstar-admin-page--hero-logo">
                <img src="<?php echo esc_url( hillstar_theme()->getAssetsManager()->getBaseURL() . "/images/hillstar-logo.png" ) ?>"
                     alt="logo"/>
            </div>
            <div class="hillstar-admin-page--hero-text ">
                <?php if ( $hillstar_welcome_message ): ?>
                    <h1><?php echo esc_html( $hillstar_welcome_message ); ?></h1>
                <?php endif; ?>
            </div>
        </div>
        <?php if ( count( $hillstar_tabs ) ): ?>
            <nav class="nav-tab-wrapper wp-clearfix">
                <?php foreach ( $hillstar_tabs as $hillstar_tab_id => $hillstar_tab ) : ?>
                    <a class="nav-tab <?php echo ( $hillstar_current_tab === $hillstar_tab_id ) ? 'nav-tab-active' : '' ?>"
                       href="<?php echo esc_url( add_query_arg( array( 'current_tab' => $hillstar_tab_id ),
                           $hillstar_url ) ); ?>">
                        <?php echo esc_html( $hillstar_tab['title'] ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>
    </div>
    <?php if ( $hillstar_tab_partial ): ?>
        <div class="hillstar-admin-page--body hillstar-admin-page-spacing">
            <div class="hillstar-admin-page--content">
                <div class="hillstar-admin-page--tab">
                    <div class="hillstar-admin-page--tab-<?php echo esc_attr( $hillstar_current_tab ); ?>">
                        <?php View::make( $hillstar_tab_partial,
                            Hooks::prefixed_apply_filters( "info_page_data_tab_{$hillstar_current_tab}",
                                array() ) ); ?>
                    </div>
                </div>

            </div>
            <div class="hillstar-admin-page--sidebar">
                <?php View::make( 'admin/sidebar' ) ?>
            </div>
        </div>
    <?php endif; ?>
</div>


