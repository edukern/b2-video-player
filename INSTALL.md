# B2 Video Player — Guia de Instalação e Uso

## 1. Instalando o plugin no WordPress

1. No painel do WordPress, acesse **Plugins > Adicionar Novo**.
2. Clique em **Enviar Plugin** (botão no topo da página).
3. Clique em **Escolher arquivo**, selecione `b2-video-player.zip` e clique em **Instalar Agora**.
4. Após a instalação, clique em **Ativar Plugin**.
5. Acesse **Configurações > B2 Video Player** para personalizar a cor do player e outras opções.

---

## 2. Criando um bucket público no Backblaze B2

1. Acesse [backblaze.com](https://www.backblaze.com) e faça login na sua conta.
2. No painel, vá em **B2 Cloud Storage > Buckets** e clique em **Create a Bucket**.
3. Dê um nome ao bucket (ex: `treinamento-videos`).
4. Em **Files in Bucket are**, selecione **Public**.
5. Clique em **Create a Bucket**.
6. Anote o **Endpoint** do bucket (ex: `s3.us-west-004.backblazeb2.com`) — você precisará dele para configurar o Cloudflare.

---

## 3. Configurando o CNAME no Cloudflare

Esse passo cria uma URL amigável como `cdn.suaempresa.com.br` apontando para o bucket B2.

1. Acesse o painel do [Cloudflare](https://dash.cloudflare.com) e selecione seu domínio.
2. Vá em **DNS > Records** e clique em **Add Record**.
3. Configure:
   - **Type:** CNAME
   - **Name:** `cdn` (isso criará `cdn.suaempresa.com.br`)
   - **Target:** `f004.backblazeb2.com` *(substitua pelo endpoint do seu bucket)*
   - **Proxy status:** Proxied (laranja) — recomendado para cache e HTTPS automático
4. Salve o registro.
5. Aguarde alguns minutos para a propagação do DNS.

> **Dica:** Com o Cloudflare ativo, os vídeos são servidos com cache global, reduzindo latência e custo de transferência do B2.

---

## 4. Fazendo upload de um vídeo e obtendo a URL

1. No painel do Backblaze B2, acesse seu bucket.
2. Clique em **Upload** e selecione o arquivo `.mp4`.
3. Após o upload, clique no arquivo para ver os detalhes.
4. A URL pública terá o formato:
   ```
   https://f004.backblazeb2.com/file/nome-do-bucket/nome-do-video.mp4
   ```
5. Substitua o domínio pelo seu CNAME do Cloudflare:
   ```
   https://cdn.suaempresa.com.br/file/nome-do-bucket/nome-do-video.mp4
   ```
   
   Ou, se configurou o bucket como raiz:
   ```
   https://cdn.suaempresa.com.br/videos/aula-01.mp4
   ```

---

## 5. Usando o shortcode no Elementor

### Shortcode completo (com todos os parâmetros):

```
[b2video 
  url="https://cdn.suaempresa.com.br/videos/modulo-01.mp4" 
  title="Módulo 01 — Introdução" 
  poster="https://cdn.suaempresa.com.br/thumbs/modulo-01.jpg" 
  captions="https://cdn.suaempresa.com.br/subs/modulo-01.vtt" 
  autoplay="false" 
  width="900"
]
```

### Shortcode mínimo (só o vídeo):

```
[b2video url="https://cdn.suaempresa.com.br/videos/modulo-01.mp4"]
```

### Como inserir no Elementor:

1. Edite a página com o Elementor.
2. Arraste o widget **HTML** (ou **Shortcode**) para a área desejada.
3. Cole o shortcode no campo de conteúdo.
4. Clique em **Atualizar** para salvar.
5. Visualize a página no frontend para ver o player funcionando.

### Parâmetros disponíveis:

| Parâmetro  | Obrigatório | Descrição                                    |
|------------|-------------|----------------------------------------------|
| `url`      | Sim         | URL completa do arquivo `.mp4`               |
| `title`    | Não         | Título do vídeo (acessibilidade)             |
| `poster`   | Não         | URL da imagem de capa (JPG, PNG ou WebP)     |
| `captions` | Não         | URL do arquivo de legendas `.vtt`            |
| `autoplay` | Não         | `true` ou `false` (padrão: `false`)          |
| `width`    | Não         | Largura máxima em pixels (padrão: 100%)      |

---

## 6. Gerando legendas (.vtt) gratuitamente

Os arquivos de legenda devem estar no formato **WebVTT** (extensão `.vtt`). Ferramentas gratuitas para gerar:

### Opção 1 — VEED.IO (recomendado para iniciantes)
1. Acesse [veed.io](https://www.veed.io)
2. Faça upload do seu vídeo
3. Vá em **Subtitles** e clique em **Auto Subtitle** para gerar automaticamente com IA
4. Edite as legendas conforme necessário
5. Clique em **Export** e selecione o formato **VTT**
6. Faça upload do arquivo `.vtt` no seu bucket B2 junto com o vídeo

### Opção 2 — Happy Scribe
1. Acesse [happyscribe.com](https://www.happyscribe.com)
2. Faça upload do vídeo ou cole a URL
3. Selecione o idioma (Português Brasileiro)
4. Faça o download no formato **VTT**

### Opção 3 — Subtitle Edit (offline, gratuito)
- Software desktop para Windows: [nikse.dk/subtitleedit](https://www.nikse.dk/subtitleedit)
- Permite criar, editar e exportar legendas em VTT

### Hospedando o arquivo VTT no B2:
1. Faça upload do `.vtt` para o mesmo bucket dos vídeos
2. A URL será algo como: `https://cdn.suaempresa.com.br/subs/modulo-01.vtt`
3. Use essa URL no parâmetro `captions` do shortcode

> **Importante:** Para que as legendas funcionem em navegadores, o servidor do arquivo `.vtt` deve ter CORS configurado corretamente. No Cloudflare, isso é tratado automaticamente quando o proxy está ativo.

---

## Suporte

Em caso de dúvidas, entre em contato com a equipe responsável pelo plugin.
