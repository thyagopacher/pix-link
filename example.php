<?php

require 'PixPayload.php';
require './vendor/autoload.php';

use chillerlan\QRCode\QRCode;

$chave = '05820810929'; // chave aleatória
$nome = 'THYAGO HENRIQUE PACHER';
$cidade = 'PONTA GROSSA';
$valor = 1.65;
$payload = PixPayload::gerar($chave, $nome, $cidade, $valor);

$qrcode = (new QRCode)->render($payload);
echo '<img width="360" height="360" src="' . $qrcode . '" alt="QR Code PIX"/>';
