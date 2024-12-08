<?php
/*
Plugin Name: Portfolio Hinweis Slider
Description: Zeigt einen Hinweis-Slider an, dass das Portfolio noch im Aufbau ist. Hinweistext und Optionen sind anpassbar.
Version: 1.0
Author: Webdesigner Mario
AUTHOR URI: https://www.webdesigner-mario.de/
*/

// Sicherheit: Direktzugriff verhindern
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// CSS und JavaScript hinzufügen
function portfolio_slider_enqueue_assets() {
    // Prüfen, ob das Plugin aktiv ist
    if ( get_option( 'portfolio_slider_active', 'yes' ) === 'yes' ) {
        wp_enqueue_style(
            'portfolio-slider-css',
            plugin_dir_url( __FILE__ ) . 'css/portfolio-slider.css'
        );
        wp_enqueue_script(
            'portfolio-slider-js',
            plugin_dir_url( __FILE__ ) . 'js/portfolio-slider.js',
            array(),
            null,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'portfolio_slider_enqueue_assets' );

// HTML für den Slider ausgeben
function portfolio_slider_output() {
    // Prüfen, ob das Plugin aktiv ist
    if ( get_option( 'portfolio_slider_active', 'yes' ) !== 'yes' ) {
        return;
    }

    // Hinweistext und Button-Option abrufen
    $text = get_option( 'portfolio_slider_text', '⚠️ Dieses Portfolio ist noch im Aufbau. Bitte schauen Sie bald wieder vorbei! ⚠️' );
    $show_button = get_option( 'portfolio_slider_show_button', 'yes' );

    ?>
    <div id="notification-bar">
        <?php echo esc_html( $text ); ?>
        <?php if ( $show_button === 'yes' ) : ?>
            <button id="close-notification">Schließen</button>
        <?php endif; ?>
    </div>
    <?php
}
add_action( 'wp_footer', 'portfolio_slider_output' );

// Admin-Menü hinzufügen
function portfolio_slider_add_admin_menu() {
    add_options_page(
        'Portfolio Hinweis Slider',
        'Portfolio Hinweis Slider',
        'manage_options',
        'portfolio-slider-settings',
        'portfolio_slider_settings_page'
    );
}
add_action( 'admin_menu', 'portfolio_slider_add_admin_menu' );

// Einstellungen registrieren
function portfolio_slider_register_settings() {
    register_setting( 'portfolio_slider_settings_group', 'portfolio_slider_active' ); // Plugin aktivieren/deaktivieren
    register_setting( 'portfolio_slider_settings_group', 'portfolio_slider_text' ); // Hinweistext
    register_setting( 'portfolio_slider_settings_group', 'portfolio_slider_show_button' ); // Button anzeigen/verstecken
}
add_action( 'admin_init', 'portfolio_slider_register_settings' );

// Einstellungsseite ausgeben
function portfolio_slider_settings_page() {
    ?>
    <div class="wrap">
        <h1>Portfolio Hinweis Slider Einstellungen</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'portfolio_slider_settings_group' );
            do_settings_sections( 'portfolio_slider_settings_group' );
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Plugin aktivieren</th>
                    <td>
                        <input type="checkbox" name="portfolio_slider_active" value="yes" 
                        <?php checked( get_option( 'portfolio_slider_active', 'yes' ), 'yes' ); ?> />
                        Ja
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Hinweistext</th>
                    <td>
                        <textarea name="portfolio_slider_text" rows="4" cols="50"><?php echo esc_textarea( get_option( 'portfolio_slider_text', '' ) ); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Schließen-Button anzeigen</th>
                    <td>
                        <input type="checkbox" name="portfolio_slider_show_button" value="yes" 
                        <?php checked( get_option( 'portfolio_slider_show_button', 'yes' ), 'yes' ); ?> />
                        Ja
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}