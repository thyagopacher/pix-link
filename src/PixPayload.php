<?php

namespace ThyagoPacher\PixLink;

class PixPayload
{

    public static function gerar($chavePix, $nomeRecebedor, $cidade, $valor = null, $txid = 'TX12345') {
        $valorFormatado = $valor ? number_format($valor, 2, '.', '') : null;

        $payload = [
            '00' => '01', // Payload Format Indicator
            '26' => '0014br.gov.bcb.pix01' . str_pad(strlen($chavePix), 2, '0', STR_PAD_LEFT) . $chavePix, // Chave PIX
            '52' => '0000', // Merchant Category Code
            '53' => '986',  // Transaction Currency (BRL = 986)
            '54' => $valorFormatado ? str_pad(strlen($valorFormatado), 2, '0', STR_PAD_LEFT) . $valorFormatado : '', // Amount
            '58' => 'BR', // Country Code
            '59' => str_pad(strlen($nomeRecebedor), 2, '0', STR_PAD_LEFT) . $nomeRecebedor,
            '60' => str_pad(strlen($cidade), 2, '0', STR_PAD_LEFT) . $cidade,
            '62' => '05' . str_pad(strlen($txid), 2, '0', STR_PAD_LEFT) . $txid,
        ];

        $emv = '';
        foreach ($payload as $id => $valor) {
            if ($valor !== '') {
                if (in_array($id, ['54', '59', '60'])) {
                    $emv .= $id . $valor;
                } else {
                    $emv .= $id . str_pad(strlen($valor), 2, '0', STR_PAD_LEFT) . $valor;
                }
            }
        }

        // Adiciona CRC16
        $emv .= '6304';
        $emv .= strtoupper(self::crc16($emv));

        return $emv;
    }

    private static function crc16($str) {
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
