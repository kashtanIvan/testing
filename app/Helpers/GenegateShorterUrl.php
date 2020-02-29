<?php

namespace App\Helpers;

class GenegateShorterUrl
{
    private $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * @param int $length
     * @return string
     */
    public function generate(int $length = 1): string
    {
        $characters = str_shuffle(str_repeat($this->string, rand(6, 12)));
        $firstPiece = substr($characters, 0, $length);
        $secondPiece = substr($characters, 0, $length + 4);
        return $firstPiece . '/' . $secondPiece;
    }
}
