<?php
defined( 'ABSPATH' ) || exit;

class B2VP_Shortcode {

    private bool $enqueue_assets = false;

    public function __construct() {
        add_shortcode( 'b2video', [ $this, 'render' ] );
        add_action( 'wp_footer', [ $this, 'maybe_enqueue_assets' ] );
    }

    /**
     * Renderiza o shortcode [b2video].
     *
     * @param array<string, string>|string $atts Atributos do shortcode.
     * @return string HTML do player.
     */
    public function render( array|string $atts ): string {
        if ( is_admin() ) {
            return '';
        }

        $atts = shortcode_atts(
            [
                'url'      => '',
                'title'    => 'Vídeo',
                'poster'   => '',
                'captions' => '',
                'autoplay' => 'false',
                'width'    => '',
                'minimal'  => 'false',
            ],
            (array) $atts,
            'b2video'
        );

        $url = esc_url( trim( $atts['url'] ) );
        if ( empty( $url ) ) {
            return '<!-- b2video: parâmetro "url" é obrigatório -->';
        }

        $this->enqueue_assets = true;

        $title    = esc_attr( $atts['title'] );
        $poster   = esc_url( $atts['poster'] );
        $captions = esc_url( $atts['captions'] );
        $autoplay = 'true' === strtolower( $atts['autoplay'] );
        $minimal  = 'true' === strtolower( $atts['minimal'] );
        $width    = ! empty( $atts['width'] ) ? 'max-width:' . (int) $atts['width'] . 'px;' : '';

        $wrapper_class = 'b2vp-wrapper' . ( $minimal ? ' b2vp-minimal' : '' );
        $style_attr    = $width  ? ' style="' . esc_attr( $width ) . '"' : '';
        $poster_attr   = $poster ? ' poster="' . $poster . '"' : '';
        $autoplay_attr = $autoplay ? ' autoplay playsinline' : '';

        $captions_track = '';
        if ( $captions ) {
            $captions_track = sprintf(
                '<track kind="captions" label="Português" srclang="pt-BR" src="%s" default>',
                $captions
            );
        }

        return sprintf(
            '<div class="%s"%s>
    <video class="b2vp-player"
        playsinline
        controls
        data-plyr-provider="html5"%s%s
        title="%s">
        <source src="%s" type="video/mp4">
        %s
    </video>
</div>',
            $wrapper_class,
            $style_attr,
            $poster_attr,
            $autoplay_attr,
            $title,
            $url,
            $captions_track
        );
    }

    /**
     * Enfileira os assets do Plyr e do plugin apenas se o shortcode foi usado na página.
     */
    public function maybe_enqueue_assets(): void {
        if ( ! $this->enqueue_assets ) {
            return;
        }

        $plyr_version = '3.7.8';
        $plyr_cdn     = 'https://cdn.plyr.io/' . $plyr_version;

        wp_enqueue_style(
            'plyr',
            $plyr_cdn . '/plyr.css',
            [],
            $plyr_version
        );

        wp_enqueue_style(
            'b2vp-player',
            B2VP_URL . 'assets/css/player.css',
            [ 'plyr' ],
            B2VP_VERSION
        );

        $primary_color = get_option( 'b2vp_primary_color', '#E63012' );
        $inline_css    = ':root { --plyr-color-main: ' . sanitize_hex_color( $primary_color ) . '; }';
        wp_add_inline_style( 'b2vp-player', $inline_css );

        wp_enqueue_script(
            'plyr',
            $plyr_cdn . '/plyr.polyfilled.js',
            [],
            $plyr_version,
            true
        );

        wp_enqueue_script(
            'b2vp-player',
            B2VP_URL . 'assets/js/player.js',
            [ 'plyr' ],
            B2VP_VERSION,
            true
        );

        $show_speed = get_option( 'b2vp_show_speed', '1' );
        wp_localize_script(
            'b2vp-player',
            'b2vpConfig',
            [
                'showSpeed' => (bool) $show_speed,
            ]
        );
    }
}
