/* B2 Video Player — inicialização do Plyr (vanilla JS, sem jQuery) */

document.addEventListener('DOMContentLoaded', () => {
    const config = window.b2vpConfig || {};
    const showSpeed = config.showSpeed !== false;

    const controls = [
        'play-large',
        'play',
        'progress',
        'current-time',
        'duration',
        'mute',
        'volume',
        'captions',
        'settings',
        'fullscreen',
    ];

    const settings = ['captions'];
    if (showSpeed) {
        settings.push('speed');
    }

    const plyrOptions = {
        controls,
        settings,
        ratio: '16:9',
        speed: {
            selected: 1,
            options: [0.75, 1, 1.25, 1.5, 2],
        },
        captions: {
            active: false,
            language: 'pt-BR',
            update: true,
        },
        i18n: {
            restart: 'Reiniciar',
            rewind: 'Retroceder {seektime}s',
            play: 'Reproduzir',
            pause: 'Pausar',
            fastForward: 'Avançar {seektime}s',
            seek: 'Buscar',
            seekLabel: '{currentTime} de {duration}',
            played: 'Reproduzido',
            buffered: 'Carregado',
            currentTime: 'Tempo atual',
            duration: 'Duração',
            volume: 'Volume',
            mute: 'Silenciar',
            unmute: 'Ativar som',
            enableCaptions: 'Ativar legendas',
            disableCaptions: 'Desativar legendas',
            download: 'Baixar',
            enterFullscreen: 'Tela cheia',
            exitFullscreen: 'Sair da tela cheia',
            frameTitle: 'Player para {title}',
            captions: 'Legendas',
            settings: 'Configurações',
            pip: 'PIP',
            menuBack: 'Voltar ao menu anterior',
            speed: 'Velocidade',
            normal: 'Normal',
            quality: 'Qualidade',
            loop: 'Loop',
            start: 'Início',
            end: 'Fim',
            all: 'Tudo',
            reset: 'Redefinir',
            disabled: 'Desativado',
            enabled: 'Ativado',
            advertisement: 'Publicidade',
            qualityBadge: {
                2160: '4K',
                1440: 'HD',
                1080: 'HD',
                720: 'HD',
                576: 'SD',
                480: 'SD',
            },
        },
    };

    // Inicializar uma instância por vídeo na página (suporte a múltiplos shortcodes).
    document.querySelectorAll('.b2vp-player').forEach((videoEl) => {
        new Plyr(videoEl, plyrOptions);
    });
});
