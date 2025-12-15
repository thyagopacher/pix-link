<?php

namespace ThyagoPacher\PixLink;

use chillerlan\QRCode\QRCode;
use Exception;
use ThyagoPacher\PixLink\PixPayload;

class PixQrcode
{

    // Class properties for PIX details
    private string $chavePix;
    private string $nomeRecebedor;
    private string $cidade;
    private float $valor;

    // Setters with method chaining
    public function chavePix(string $chavePix): PixQrcode
    {
        $this->chavePix = $chavePix;
        return $this;
    }

    public function nomeRecebedor(string $nomeRecebedor): PixQrcode
    {
        $this->nomeRecebedor = $nomeRecebedor;
        return $this;
    }

    public function cidade(string $cidade): PixQrcode
    {
        $this->cidade = $cidade;
        return $this;
    }

    public function valor(float $valor): PixQrcode
    {
        $this->valor = $valor;
        return $this;
    }

    private function validaCampos (string $chavePix, string $nomeRecebedor, string $cidade, float $valor) :bool
    {
        if (empty($chavePix)) {
            throw new Exception('Chave PIX é obrigatório.');
        }
        if (empty($nomeRecebedor)) {
            throw new Exception('Nome recebedor é obrigatório.');
        }
        if (empty($cidade)) {
            throw new Exception('Cidade é obrigatório.');
        }
        if (empty($valor) || $valor <= 0) {
            throw new Exception('Valor deve ser maior que zero.');
        }

        return true;
    }

    /**
     * Gerar function
     *
     * @param integer $width
     * @param integer $height
     * 
     * @return string
     * 
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function gerar (int $width = 360, int $height = 360): string 
    {
        try {

            self::validaCampos($this->chavePix, $this->nomeRecebedor, $this->cidade, $this->valor);

            $payload = PixPayload::gerar($this->chavePix, $this->nomeRecebedor, $this->cidade, $this->valor);
            $qrcode = (new QRCode)->render($payload);

            return '<img width="'.$width.'" height="'.$height.'" src="' . $qrcode . '" alt="QR Code PIX"/>';
        } catch (\Exception $e) {
            throw new Exception('Erro ao gerar QR Code: ' . $e->getMessage());
        }
    }

}
