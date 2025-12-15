<?php

require './vendor/autoload.php';

use ThyagoPacher\PixLink\PixQrcode;

$chave = '05820810929'; // chave aleatória
$nome = 'THYAGO HENRIQUE PACHER';
$cidade = 'PONTA GROSSA';
$valor = 1.65;
$width = 360;
$height = 360;
echo PixQrcode::gerar($chave, $nome, $cidade, $valor, $width, $height);
