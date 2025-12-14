<?php

require 'PixPayload.php';
require 'PixQrCode.php';

$payload = PixPayload::gerar(
    '05820810929',
    'THYAGO HENRIQUE PACHER',
    'SAO PAULO',
    50.00,
    'Pedido 123'
);

PixQrCode::gerarImagem($payload);
