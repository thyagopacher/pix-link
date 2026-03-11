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

        $payloadTxt = PixPayload::gerar($chavePix, $nomeRecebedor, $cidade, $valor);
        $this->assertIsString($payloadTxt, 'Payload deve ser uma string');
        $this->assertNotEmpty($payloadTxt, 'Payload não deve ser vazio');
        $this->assertStringContainsString('000201', $payloadTxt, 'Payload deve conter o identificador do Pix');
    }
}