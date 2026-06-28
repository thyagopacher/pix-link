# pix-link

Gera QR Code PIX (PIX Link) em PHP de forma simples e sem necessidade de conta bancária. Converte os dados no padrão EMV/FEBRABAN e gera a imagem do QR Code (data URI) pronta para uso em aplicações web.

Principais pontos:

- Zero configuração: gere o payload do PIX e converta em QR Code usando chillerlan/php-qrcode.
- Testes unitários com PHPUnit.
- Implementação compatível com PHP 8.x.

## Instalação

Instale via Composer:

```bash
composer require thyago.pacher/pix-link
```

## Uso rápido

```php
use ThyagoPacher\\PixLink\\PixQrcode;

$chave = 'suachave@banco.com';
$nome = 'NOME DO RECEBEDOR';
$cidade = 'CIDADE';
$valor = 10.50;

echo (new PixQrcode)->chavePix($chave)
    ->nomeRecebedor($nome)
    ->cidade($cidade)
    ->valor($valor)
    ->gerar(360, 360);
```

A função gera um `<img>` com atributo `src` contendo a imagem em data URI (image/png).

## Testes

Rode os testes com PHPUnit (já listado como require-dev no composer.json):

```bash
composer install --dev
vendor/bin/phpunit --testdox
```

## Principais melhorias nesta branch

- Correção no cálculo do CRC16 (o cálculo agora considera o placeholder '0000' durante a checagem, conforme especificação EMV).
- Novos testes unitários cobrindo CRC, casos de erro e validações.
- README com guia de uso, instalação e execução de testes.

## Licença

MIT
