<?php 

namespace tests;

use PHPUnit\Framework\TestCase;
use ThyagoPacher\PixLink\PixPayload;

class PixPayloadTest extends TestCase
{
    public function testGerarPayload()
    {
        $chavePix = 'XXXX';
        $nomeRecebedor = 'THYAGO HENRIQUE PACHER';
        $cidade = 'PONTA GROSSA';
        $valor = 1.65;      
        $width = 360;
        $height = 360;
        $payloadTxt = PixPayload::gerar($chavePix, $nomeRecebedor, $cidade, $valor, $width, $height);
        $this->assertIsString($payloadTxt, 'Payload deve ser uma string');
        $this->assertNotEmpty($payloadTxt, 'Payload não deve ser vazio');
        $this->assertStringContainsString('000201', $payloadTxt, 'Payload deve conter o identificador do Pix');
    }
}