=== B2 Video Player ===
Contributors: equipetreinamento
Tags: video, player, plyr, backblaze, b2, cloudflare, cdn, elementor, treinamento
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Player de vídeo profissional para vídeos hospedados no Backblaze B2 com entrega via Cloudflare CDN. Usa Plyr.js, suporta legendas e é compatível com Elementor.

== Description ==

O **B2 Video Player** permite reproduzir vídeos MP4 hospedados no Backblaze B2 (entregues via Cloudflare CDN) diretamente no WordPress, usando o player open-source **Plyr.js**.

**Recursos:**

* Player responsivo 16:9 com design profissional
* Suporte a legendas (.vtt)
* Controle de velocidade de reprodução (0.75× a 2×)
* Totalmente em português (pt-BR)
* Compatível com Elementor (widgets HTML e Shortcode)
* Sem marca d'água, sem YouTube, sem Vimeo
* Página de configurações com cor primária personalizável
* Suporte a múltiplos players na mesma página

**Shortcode:**

    [b2video url="https://cdn.suaempresa.com.br/videos/aula-01.mp4" title="Aula 01" poster="https://cdn.suaempresa.com.br/thumbs/aula-01.jpg" captions="https://cdn.suaempresa.com.br/subs/aula-01.vtt"]

== Installation ==

1. Acesse **Plugins > Adicionar Novo > Enviar Plugin** no painel do WordPress.
2. Selecione o arquivo `b2-video-player.zip` e clique em **Instalar Agora**.
3. Ative o plugin.
4. Configure em **Configurações > B2 Video Player**.

== Frequently Asked Questions ==

= Preciso ter uma conta no Backblaze B2? =

Sim. Os vídeos devem estar em um bucket público do Backblaze B2, idealmente entregue via Cloudflare CDN (CNAME).

= Funciona com o Elementor? =

Sim. Use o widget **HTML** ou **Shortcode** do Elementor e cole o shortcode `[b2video ...]`.

= Posso ter mais de um vídeo na mesma página? =

Sim. Cada shortcode gera um player independente.

== Screenshots ==

1. Player em funcionamento com controles completos
2. Página de configurações no painel WordPress

== Changelog ==

= 1.0.0 =
* Versão inicial

== Upgrade Notice ==

= 1.0.0 =
Primeira versão estável.
