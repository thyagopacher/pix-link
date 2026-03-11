## Gera Qrcode PIX via PHP

Sem dependências gerais para qualquer pacote a mais.

-Requisitos PHP 8.4

-Depende da lib chillerlan/php-qrcode é usado unicamente para converter o texto para QrCode.

## Instalação (rápido)
Entrar no bash com o comando, ele irá baixar tudo o necessário para usar em seu projeto
```bash
composer require thyago.pacher/pix-link
```

## Exemplo de geração do QrCode .
![Exemplo de QR Code Pix](docs/qrcode-pix-link.png)

Código usado para geração de QrCode PIX - no padrão Febrapan
```
$chave = 'xxxx'; // chave aleatória
$nome = 'THYAGO HENRIQUE PACHER';
$cidade = 'PONTA GROSSA';
$valor = 1.65;
$width = 360;
$height = 360;
echo (new PixQrcode)->chavePix($chave)
    ->nomeRecebedor($nome)
    ->cidade($cidade)
    ->valor($valor)
    ->gerar($width, $height);

```