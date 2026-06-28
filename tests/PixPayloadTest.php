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

    public function testGerarPayloadCrcIsValid()
    {
        $chavePix = '12345678901';
        $nomeRecebedor = 'THYAGO HENRIQUE PACHER';
        $cidade = 'PONTA GROSSA';
        $valor = 1.65;      
        $txid = 'TX12345';

        $payload = PixPayload::gerar($chavePix, $nomeRecebedor, $cidade, $valor, $txid);

        // CRC está nos últimos 4 caracteres
        $crcExtracted = substr($payload, -4);
        $this->assertMatchesRegularExpression('/^[0-9A-F]{4}$/', $crcExtracted, 'CRC deve ser 4 caracteres hexadecimais maiúsculos');

        // Recalcula CRC localmente e compara
        $payloadWithoutCrc = substr($payload, 0, -4);
        $payloadForCrc = $payloadWithoutCrc . '0000';
        $crcRecalc = strtoupper($this->crc16($payloadForCrc));

        $this->assertEquals($crcRecalc, $crcExtracted, 'CRC calculado deve bater com o CRC presente no payload');
    }

    public function testGerarPayloadValorZeroThrows()
    {
        $this->expectException(\InvalidArgumentException::class);
        $chavePix = 'XXXX';
        $nomeRecebedor = 'AAA';
        $cidade = 'BBB';
        $valor = 0.0;

        PixPayload::gerar($chavePix, $nomeRecebedor, $cidade, $valor);
    }

    // local crc16 para validação nos testes (mesma implementação usada na classe)
    private function crc16($str) {
        $crc = 0xFFFF;
        $len = strlen($str);

        for ($c = 0; $c < $len; $c++) {
            $crc ^= ord($str[$c]) << 8;
            for ($i = 0; $i < 8; $i++) {
                $crc = ($crc & 0x8000) ? ($crc << 1) ^ 0x1021 : $crc << 1;
            }
        }

        return substr(sprintf('%04X', $crc & 0xFFFF), -4);
    }
}
