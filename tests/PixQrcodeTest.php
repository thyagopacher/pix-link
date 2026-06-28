<?php 

namespace tests;

use PHPUnit\Framework\TestCase;
use ThyagoPacher\PixLink\PixQrcode;

class PixQrcodeTest extends TestCase
{
    public function testGerarQrcode()
    {
        $chavePix = 'XXXX';
        $nomeRecebedor = 'THYAGO HENRIQUE PACHER';
        $cidade = 'PONTA GROSSA';
        $valor = 1.65;      
        $width = 360;
        $height = 360;

        $qrcodeHtml = (new PixQrcode)->chavePix($chavePix)
            ->nomeRecebedor($nomeRecebedor)
            ->cidade($cidade)
            ->valor($valor)
            ->gerar($width, $height);

        $this->assertStringContainsString('<img', $qrcodeHtml);
        $this->assertStringContainsString('src="data:image/', $qrcodeHtml);
    }

    public function testGerarQrcodeMissingFieldsThrows()
    {
        $this->expectException(\Exception::class);

        // Missing valor (zero)
        $qrcode = new PixQrcode();
        $qrcode->chavePix('XXXX')
               ->nomeRecebedor('Nome')
               ->cidade('Cidade')
               ->valor(0.0)
               ->gerar();
    }
}
