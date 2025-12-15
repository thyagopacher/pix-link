<?php

namespace ThyagoPacher\PixLink;

use chillerlan\QRCode\QRCode;
use ThyagoPacher\PixLink\PixPayload;

class PixQrcode
{

    public static function gerar(string $chavePix, string $nomeRecebedor, string $cidade, float $valor = 0.0, int $width = 360, int $height = 360): string {

        $chave = '05820810929'; // chave aleatória
        $nome = 'THYAGO HENRIQUE PACHER';
        $cidade = 'PONTA GROSSA';
        $valor = 1.65;
        $payload = PixPayload::gerar($chave, $nome, $cidade, $valor);

        $qrcode = (new QRCode)->render($payload);
        return '<img width="360" height="360" src="' . $qrcode . '" alt="QR Code PIX"/>';
    }

}
