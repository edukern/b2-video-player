<?php
// Executa somente via desinstalação do WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Remove as opções do banco de dados ao desinstalar.
delete_option( 'b2vp_primary_color' );
delete_option( 'b2vp_cdn_base_url' );
delete_option( 'b2vp_show_speed' );
