<?php
/**
 * Plugin Name: B2 Video Player
 * Plugin URI:  https://github.com/
 * Description: Player de vídeo profissional para vídeos hospedados no Backblaze B2 com entrega via Cloudflare CDN. Usa Plyr.js, suporta legendas VTT e é compatível com Elementor.
 * Version:     1.0.0
 * Author:      Keenfisher
 * Text Domain: b2-video-player
 * License:     GPL-2.0+
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/lib/github-updater.php';
new SPP_GitHub_Updater( __FILE__, 'edukern/b2-video-player', '1.0.0' );

define( 'B2VP_VERSION', '1.0.0' );
define( 'B2VP_PATH', plugin_dir_path( __FILE__ ) );
define( 'B2VP_URL', plugin_dir_url( __FILE__ ) );

require_once B2VP_PATH . 'includes/class-shortcode.php';
require_once B2VP_PATH . 'includes/class-admin.php';

register_activation_hook( __FILE__, 'b2vp_activate' );
function b2vp_activate(): void {
    add_option( 'b2vp_primary_color', '#E63012' );
    add_option( 'b2vp_cdn_base_url', '' );
    add_option( 'b2vp_show_speed', '1' );
}

register_deactivation_hook( __FILE__, 'b2vp_deactivate' );
function b2vp_deactivate(): void {
    // Nenhuma limpeza necessária na desativação.
}

new B2VP_Shortcode();

if ( is_admin() ) {
    new B2VP_Admin();
}
