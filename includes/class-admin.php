<?php
defined( 'ABSPATH' ) || exit;

class B2VP_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function add_menu(): void {
        add_options_page(
            __( 'B2 Video Player', 'b2-video-player' ),
            __( 'B2 Video Player', 'b2-video-player' ),
            'manage_options',
            'b2-video-player',
            [ $this, 'render_page' ]
        );
    }

    public function register_settings(): void {
        register_setting(
            'b2vp_settings_group',
            'b2vp_primary_color',
            [
                'sanitize_callback' => 'sanitize_hex_color',
                'default'           => '#E63012',
            ]
        );

        register_setting(
            'b2vp_settings_group',
            'b2vp_cdn_base_url',
            [
                'sanitize_callback' => 'esc_url_raw',
                'default'           => '',
            ]
        );

        register_setting(
            'b2vp_settings_group',
            'b2vp_show_speed',
            [
                'sanitize_callback' => [ $this, 'sanitize_checkbox' ],
                'default'           => '1',
            ]
        );

        add_settings_section(
            'b2vp_main_section',
            __( 'Configurações do Player', 'b2-video-player' ),
            null,
            'b2-video-player'
        );

        add_settings_field(
            'b2vp_primary_color',
            __( 'Cor primária do player', 'b2-video-player' ),
            [ $this, 'field_primary_color' ],
            'b2-video-player',
            'b2vp_main_section'
        );

        add_settings_field(
            'b2vp_cdn_base_url',
            __( 'CDN Base URL', 'b2-video-player' ),
            [ $this, 'field_cdn_base_url' ],
            'b2-video-player',
            'b2vp_main_section'
        );

        add_settings_field(
            'b2vp_show_speed',
            __( 'Controle de velocidade', 'b2-video-player' ),
            [ $this, 'field_show_speed' ],
            'b2-video-player',
            'b2vp_main_section'
        );
    }

    public function sanitize_checkbox( mixed $value ): string {
        return $value ? '1' : '0';
    }

    public function field_primary_color(): void {
        $value = get_option( 'b2vp_primary_color', '#E63012' );
        printf(
            '<input type="color" name="b2vp_primary_color" value="%s">
            <p class="description">%s</p>',
            esc_attr( $value ),
            esc_html__( 'Cor de destaque usada nos controles do player (botões, barra de progresso).', 'b2-video-player' )
        );
    }

    public function field_cdn_base_url(): void {
        $value = get_option( 'b2vp_cdn_base_url', '' );
        printf(
            '<input type="url" name="b2vp_cdn_base_url" value="%s" class="regular-text" placeholder="https://cdn.suaempresa.com.br">
            <p class="description">%s</p>',
            esc_attr( $value ),
            esc_html__( 'URL base do seu CDN (apenas referência — use a URL completa no shortcode).', 'b2-video-player' )
        );
    }

    public function field_show_speed(): void {
        $value = get_option( 'b2vp_show_speed', '1' );
        printf(
            '<label><input type="checkbox" name="b2vp_show_speed" value="1" %s> %s</label>
            <p class="description">%s</p>',
            checked( '1', $value, false ),
            esc_html__( 'Exibir controle de velocidade de reprodução', 'b2-video-player' ),
            esc_html__( 'Permite ao aluno ajustar a velocidade do vídeo (0.75×, 1×, 1.25×, 1.5×, 2×).', 'b2-video-player' )
        );
    }

    public function render_page(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

            <?php settings_errors( 'b2vp_settings_group' ); ?>

            <form method="post" action="options.php">
                <?php
                settings_fields( 'b2vp_settings_group' );
                do_settings_sections( 'b2-video-player' );
                submit_button( __( 'Salvar configurações', 'b2-video-player' ) );
                ?>
            </form>

            <hr>
            <h2><?php esc_html_e( 'Exemplo de uso', 'b2-video-player' ); ?></h2>
            <p><?php esc_html_e( 'Copie o shortcode abaixo e cole em qualquer página, post ou widget HTML do Elementor:', 'b2-video-player' ); ?></p>
            <pre style="background:#f0f0f0;padding:12px;border-radius:4px;">[b2video url="https://cdn.suaempresa.com.br/videos/aula-01.mp4" title="Aula 01" poster="https://cdn.suaempresa.com.br/thumbs/aula-01.jpg" captions="https://cdn.suaempresa.com.br/subs/aula-01.vtt"]</pre>
        </div>
        <?php
    }
}
