<?php
/**
 * AxieGeneUtilTest.php file summary.
 *
 * AxieGeneUtilTest.php file description.
 *
 * @link       https://project.com
 *
 * @package    Project
 *
 * @subpackage App\Tests\Util
 *
 * @author     Arvil Meña <arvil@arvilmena.com>
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace App\Tests\Util;

use App\Util\AxieGeneUtil;
use BCMathExtended\BC;
use PHPUnit\Framework\TestCase;

/**
 * Class AxieGeneUtilTest.
 *
 * Class AxieGeneUtilTest description.
 *
 * @since 1.0.0
 */
class AxieGeneUtilTest extends TestCase
{
    public function testMethods(): void
    {

        $gene = new AxieGeneUtil('0x810a43400a310c8004009080020214200a028c6002008020042314a');

        $this->assertEquals('849344215841909609199585950172954190544722304140846169088527053130', BC::hexdec('0x810a43400a310c8004009080020214200a028c6002008020042314a'));
        $this->assertEquals(
            '1000000100001010010000110100000000001010001100010000110010000000000001000000000010010000100000000000001000000010000101000010000000001010000000101000110001100000000000100000000010000000001000000000010000100011000101001010',
            $gene->getBinary()
        );
        $this->assertEquals(
            '000000000000000000000000000000000000',
            $gene->getStrMul()
        );
        $this->assertEquals(
            '0000000000000000000000000000000000001000000100001010010000110100000000001010001100010000110010000000000001000000000010010000100000000000001000000010000101000010000000001010000000101000110001100000000000100000000010000000001000000000010000100011000101001010',
            $gene->getDecodedGene()
        );

        var_dump($gene->getTraits());
        var_dump($gene->getDominantGenes());
    }
}