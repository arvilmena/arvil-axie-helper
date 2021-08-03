<?php
/**
 * AxieGeneUtil.php file summary.
 *
 * AxieGeneUtil.php file description.
 *
 * @link       https://project.com
 *
 * @package    Project
 *
 * @subpackage App\Util
 *
 * @author     Arvil Meña <arvil@arvilmena.com>
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace App\Util;

use BCMathExtended\BC;

/**
 * Class AxieGeneUtil.
 *
 * Class AxieGeneUtil description.
 *
 * @since 1.0.0
 */
class AxieGeneUtil
{

    /**
     * @var string
     */
    private $geneHex;

    private $bigInt;

    private $binary;

    private $strMul;

    private $decodedGene;

    public function __construct(string $geneHex) {

        $this->geneHex = $geneHex;
    }

    public function getBigInt() : string {
        if ($this->bigInt) {
            return $this->bigInt;
        }
        $this->bigInt = BC::hexdec(trim($this->geneHex));
        return $this->bigInt;
    }

    private function _base_convert_arbitrary($number, $fromBase, $toBase) {
        $digits = '0123456789abcdefghijklmnopqrstuvwxyz';
        $length = strlen($number);
        $result = '';

        $nibbles = array();
        for ($i = 0; $i < $length; ++$i) {
            $nibbles[$i] = strpos($digits, str_split($number)[$i]);
        }

        do {
            $value = 0;
            $newlen = 0;
            for ($i = 0; $i < $length; ++$i) {
                $value = $value * $fromBase + $nibbles[$i];
                if ($value >= $toBase) {
                    $nibbles[$newlen++] = (int)($value / $toBase);
                    $value %= $toBase;
                }
                else if ($newlen > 0) {
                    $nibbles[$newlen++] = 0;
                }
            }
            $length = $newlen;
            $result = $digits[$value].$result;
        }
        while ($newlen != 0);
        return $result;
    }

    public function getBinary() : string {
        if ($this->binary) {
            return $this->binary;
        }
        $this->binary = $this->_base_convert_arbitrary($this->getBigInt(), 10, 2);
        return $this->binary;
    }

    public function getStrMul() : string {
        if ($this->strMul) {
            return $this->strMul;
        }
        $this->strMul = str_repeat("0", (256 - strlen($this->getBinary())));
        return $this->strMul;
    }

    public function getDecodedGene() : string {
        if ($this->decodedGene) {
            return $this->decodedGene;
        }
        $this->decodedGene = $this->getStrMul() . $this->getBinary();
        return $this->decodedGene;
    }

}
