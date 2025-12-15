<?php

namespace ThyagoPacher\PixLink;

use chillerlan\QRCode\QRCode;
use Exception;
use ThyagoPacher\PixLink\PixPayload;

class PixQrcode
{

    public static function gerar(string $chavePix, string $nomeRecebedor, string $cidade, float $valor = 0.0, int $width = 360, int $height = 360): string 
    {
        try {
            $payload = PixPayload::gerar($chavePix, $nomeRecebedor, $cidade, $valor);

            $qrcode = (new QRCode)->render($payload);
            return '<img width="'.$width.'" height="'.$height.'" src="' . $qrcode . '" alt="QR Code PIX"/>';
        } catch (\Exception $e) {
            throw new Exception('Erro ao gerar QR Code: ' . $e->getMessage());
        }
    }

}
