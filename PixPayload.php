<?php

class PixPayload
{
    public static function gerar(
        string $pixKey,
        string $nome,
        string $cidade,
        ?float $valor = null,
        string $descricao = ''
    ): string {
        $payload = [];

        $payload['00'] = '01';
        $payload['26'] = self::campo([
            '00' => 'BR.GOV.BCB.PIX',
            '01' => $pixKey
        ]);

        $payload['52'] = '0000';
        $payload['53'] = '986';

        if ($valor !== null) {
            $payload['54'] = number_format($valor, 2, '.', '');
        }

        $payload['58'] = 'BR';
        $payload['59'] = substr($nome, 0, 25);
        $payload['60'] = substr($cidade, 0, 15);

        if ($descricao) {
            $payload['62'] = self::campo([
                '05' => $descricao
            ]);
        }

        $payload['63'] = '04';

        $brCode = '';
        foreach ($payload as $id => $value) {
            $brCode .= $id . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
        }

        return $brCode . '63' . '04' . self::crc16($brCode . '6304');
    }

    private static function campo(array $dados): string
    {
        $out = '';
        foreach ($dados as $id => $valor) {
            $out .= $id . str_pad(strlen($valor), 2, '0', STR_PAD_LEFT) . $valor;
        }
        return $out;
    }

    private static function crc16(string $payload): string
    {
        $polinomio = 0x1021;
        $resultado = 0xFFFF;

        for ($i = 0; $i < strlen($payload); $i++) {
            $resultado ^= (ord($payload[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                $resultado = ($resultado & 0x8000)
                    ? (($resultado << 1) ^ $polinomio)
                    : ($resultado << 1);
                $resultado &= 0xFFFF;
            }
        }

        return strtoupper(str_pad(dechex($resultado), 4, '0', STR_PAD_LEFT));
    }
}
