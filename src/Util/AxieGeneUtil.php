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

use App\Value\AxieDefinition;
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

    private $partsClassMap = [];

    private $groups;
    /**
     * @var array
     */
    private $eyes;
    /**
     * @var string
     */
    private $region;
    /**
     * @var array
     */
    private $mouth;
    /**
     * @var array
     */
    private $ears;
    /**
     * @var array
     */
    private $horn;
    /**
     * @var array
     */
    private $back;
    /**
     * @var array
     */
    private $tail;
    /**
     * @var array
     */
    private $dominantGenes;
    /**
     * @var array
     */
    private $r1Genes;
    /**
     * @var array
     */
    private $r2Genes;
    private $allGenes;
    /**
     * @var int
     */
    private $pureness;
    /**
     * @var float|int
     */
    private $quality;

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

    /*
        function getClassFromGroup(group) {
            let bin = group.slice(0, 4);
            if (!(bin in classGeneMap)) {
                return "Unknown Class";
            }
            return classGeneMap[bin];
        }
     */
    private function getClass(): string
    {
        $bin = substr($this->getDecodedGeneGroups()[0], 0, 4);
        if (!(in_array($bin, array_keys(AxieDefinition::CLASS_GENE_MAP)))) {
            return 'Unknown Class';
        }
        return AxieDefinition::CLASS_GENE_MAP[$bin];
    }

    /*
        function getRegionFromGroup(group) {
            let regionBin = group.slice(8,13);
            if (regionBin in regionGeneMap) {
                return regionGeneMap[regionBin];
            }
            return "Unknown Region";
        }
     */
    private function _getRegionFromGroup($group) {
        $bin = substr($group, 8, 5);
        if (!(in_array($bin, array_keys(AxieDefinition::REGION_GENE_MAP)))) {
            return 'Unknown Class';
        }
        return AxieDefinition::REGION_GENE_MAP[$bin];
    }

    /*
        //hack. key: part name + " " + part type
        var partsClassMap = {};
        function getPartName(cls, part, region, binary, skinBinary="00") {
            let trait;
            if (binary in binarytraits[cls][part]) {
                if (skinBinary == "11") {
                    trait = binarytraits[cls][part][binary]["mystic"];
                } else if (skinBinary == "10") {
                    trait = binarytraits[cls][part][binary]["xmas"];
                } else if (region in binarytraits[cls][part][binary]) {
                    trait = binarytraits[cls][part][binary][region];
                } else if ("global" in binarytraits[cls][part][binary]) {
                    trait = binarytraits[cls][part][binary]["global"];
                } else {
                    trait = "UNKNOWN Regional " + cls + " " + part;
                }
            } else {
                trait = "UNKNOWN " + cls + " " + part;
            }
            //return part + "-" + trait.toLowerCase().replace(/\s/g, "-");
            partsClassMap[trait + " " + part] = cls;
            return trait;
        }
     */
    private function _getPartName($cls, $part, $region, $binary, $skinBinary = '00') {
        if ( ! in_array($binary, array_keys(AxieDefinition::BINARY_TRAITS[$cls][$part]))) {
            $trait = "UNKNOWN " . $cls . " " . $part;
        } else {
            if ( '11' === $skinBinary ) $trait = AxieDefinition::BINARY_TRAITS[ $cls ][$part][$binary]['mystic'];
            elseif( '10' === $skinBinary ) $trait = AxieDefinition::BINARY_TRAITS[ $cls ][$part][$binary]['xmas'];
            elseif( in_array($region, array_keys(AxieDefinition::BINARY_TRAITS[ $cls ][$part][$binary])) ) $trait = AxieDefinition::BINARY_TRAITS[ $cls ][$part][$binary][$region];
            elseif( in_array("global", array_keys(AxieDefinition::BINARY_TRAITS[ $cls ][$part][$binary])) ) $trait = AxieDefinition::BINARY_TRAITS[ $cls ][$part][$binary]["global"];
            else $trait = "UNKNOWN " . $cls . " " . $part;
        }
        $this->partsClassMap[ $trait . ' ' . $part ] = $cls;
        return $trait;
    }

    /*
        function getPartFromName(traitType, partName) {
            let traitId = traitType.toLowerCase() + "-" + partName.toLowerCase().replace(/\s/g, "-").replace(/[\?'\.]/g, "");
            return bodyPartsMap[traitId];
        }
     */
    private function _getPartFromName($traitType, $partName) {
        $traitId = strtolower($traitType) . '-' . str_replace( ['?', "'", '.'], '', str_replace(' ','-', strtolower($partName) ) );
        $key = array_search($traitId, array_column(AxieDefinition::BODY_PARTS, 'partId'));
        return AxieDefinition::BODY_PARTS[ $key ];
    }

    /*
        function getPatternsFromGroup(group) {
            //patterns could be 6 bits. use 4 for now
            return {d: group.slice(2, 8), r1: group.slice(8, 14), r2: group.slice(14, 20)};
        }
     */
    private function _getPatternsFromGroup($group) {
        return [
            'd' => substr($group, 2, 6),
            'r1' => substr($group, 8, 6),
            'r2' => substr($group, 14, 6),
        ];
    }

    /*
        function getColor(bin, cls) {
            let color;
            if (bin == "0000") {
                color = "ffffff";
            } else if (bin == "0001") {
                color = "7a6767";
            } else {
                color = geneColorMap[cls][bin];
            }
            return color;
        }
     */
    private function _getColor($bin, $cls) {
        if ('0000' === $bin) {
            return 'ffffff';
        }
        if ('0001' === $bin) {
            return '7a6767';
        }
        return AxieDefinition::GENE_COLOR_MAP[$cls][$bin];
    }

    /*
        function getColorsFromGroup(group, cls) {
            return {d: getColor(group.slice(20, 24), cls), r1: getColor(group.slice(24, 28), cls), r2: getColor(group.slice(28, 32), cls)};
        }
     */
    private function _getColorsFromGroup($group, $cls) {
        return [
            'd' => $this->_getColor(substr($group, 20, 4), $cls),
            'r1' => $this->_getColor(substr($group, 24, 4), $cls),
            'r2' => $this->_getColor(substr($group, 28, 4), $cls),
        ];
    }

    /*
        function getPartsFromGroup(part, group, region,) {
            let skinBinary = group.slice(0, 2);
            let mystic = skinBinary == "11";
            let dClass = classGeneMap[group.slice(2, 6)];
            let dBin = group.slice(6, 12);
            let dName = getPartName(dClass, part, region, dBin, skinBinary);

            let r1Class = classGeneMap[group.slice(12, 16)];
            let r1Bin = group.slice(16, 22);
            let r1Name = getPartName(r1Class, part, region, r1Bin);

            let r2Class = classGeneMap[group.slice(22, 26)];
            let r2Bin = group.slice(26, 32);
            let r2Name = getPartName(r2Class, part, region, r2Bin);

            return {d: getPartFromName(part, dName), r1: getPartFromName(part, r1Name), r2: getPartFromName(part, r2Name), mystic: mystic};
        }
     */
    private function _getPartsFromGroup($part, $group, $region) {
        $skinBinary = substr($group, 0, 2);
        $mystic = ($skinBinary === '11');
        $dClass = AxieDefinition::CLASS_GENE_MAP[ substr($group, 2, 4) ];
        $dBin = substr($group, 6, 6);
        $dName = $this->_getPartName($dClass, $part, $region, $dBin, $skinBinary);

        $r1Class = AxieDefinition::CLASS_GENE_MAP[ substr($group, 12, 4) ];
        $r1Bin = substr($group, 16, 6);
        $r1Name = $this->_getPartName($r1Class, $part, $region, $r1Bin);

        $r2Class = AxieDefinition::CLASS_GENE_MAP[ substr($group, 22, 4) ];
        $r2Bin = substr($group, 26, 6);
        $r2Name = $this->_getPartName($r2Class, $part, $region, $r2Bin);

        return [
            'd' => $this->_getPartFromName($part, $dName),
            'r1' => $this->_getPartFromName($part, $r1Name),
            'r2' => $this->_getPartFromName($part, $r2Name),
            'mystic' => $mystic
        ];
    }

    /*
        function getTraits(genes) {
            var groups = [
                genes.slice(0, 32),
                genes.slice(32, 64),
                genes.slice(64, 96),
                genes.slice(96, 128),
                genes.slice(128, 160),
                genes.slice(160, 192),
                genes.slice(192, 224),
                genes.slice(224, 256)
            ];
            let cls = getClassFromGroup(groups[0]);
            let region = getRegionFromGroup(groups[0]);
            let pattern = getPatternsFromGroup(groups[1]);
            let color = getColorsFromGroup(groups[1], groups[0].slice(0, 4));
            let eyes = getPartsFromGroup("eyes", groups[2], region);
            let mouth = getPartsFromGroup("mouth", groups[3], region);
            let ears = getPartsFromGroup("ears", groups[4], region);
            let horn = getPartsFromGroup("horn", groups[5], region);
            let back = getPartsFromGroup("back", groups[6], region);
            let tail = getPartsFromGroup("tail", groups[7], region);
            return {
                cls: cls,
                region: region,
                pattern: pattern,
                color: color,
                eyes: eyes,
                mouth: mouth,
                ears: ears,
                horn: horn,
                back: back,
                tail: tail
            };
        }
     */
    private function getDecodedGeneGroups() {
        if ( $this->groups ) {
            return $this->groups;
        }

        $this->groups = [
            substr($this->getDecodedGene(), 0, 32),
            substr($this->getDecodedGene(), 32, 32),
            substr($this->getDecodedGene(), 64, 32),
            substr($this->getDecodedGene(), 96, 32),
            substr($this->getDecodedGene(), 128, 32),
            substr($this->getDecodedGene(), 160, 32),
            substr($this->getDecodedGene(), 192, 32),
            substr($this->getDecodedGene(), 224, 32),
        ];
        return $this->groups;
    }

    public function getRegion() {
        if ($this->region) {
            return $this->region;
        }
        $this->region = $this->_getRegionFromGroup($this->getDecodedGeneGroups()[0]);
        return $this->region;
    }

    public function getEyes()
    {
        if ($this->eyes) {
            return $this->eyes;
        }
        $this->eyes = $this->_getPartsFromGroup('eyes', $this->getDecodedGeneGroups()[2], $this->getRegion());
        return $this->eyes;
    }

    public function getMouth()
    {
        if ($this->mouth) {
            return $this->mouth;
        }
        $this->mouth = $this->_getPartsFromGroup('mouth', $this->getDecodedGeneGroups()[3], $this->getRegion());
        return $this->mouth;
    }

    public function getEars()
    {
        if ($this->ears) {
            return $this->ears;
        }
        $this->ears = $this->_getPartsFromGroup('ears', $this->getDecodedGeneGroups()[4], $this->getRegion());
        return $this->ears;
    }

    public function getHorn()
    {
        if ($this->horn) {
            return $this->horn;
        }
        $this->horn = $this->_getPartsFromGroup('horn', $this->getDecodedGeneGroups()[5], $this->getRegion());
        return $this->horn;
    }

    public function getBack()
    {
        if ($this->back) {
            return $this->back;
        }
        $this->back = $this->_getPartsFromGroup('back', $this->getDecodedGeneGroups()[6], $this->getRegion());
        return $this->back;
    }

    public function getTail()
    {
        if ($this->tail) {
            return $this->tail;
        }
        $this->tail = $this->_getPartsFromGroup('tail', $this->getDecodedGeneGroups()[7], $this->getRegion());
        return $this->tail;
    }

    public function getTraits(): array
    {

        $cls = $this->getClass();
        $region = $this->getRegion();
        $pattern = $this->_getPatternsFromGroup($this->getDecodedGeneGroups()[1]);
        $color = $this->_getColorsFromGroup($this->getDecodedGeneGroups()[1], substr($this->getDecodedGeneGroups()[0], 0, 4));
        $eyes = $this->getEyes();
        $mouth = $this->getMouth();
        $ears = $this->getEars();
        $horn = $this->getHorn();
        $back = $this->getBack();
        $tail = $this->getTail();
        return [
            'cls' => $cls,
            'region' => $region,
            'pattern' => $pattern,
            'color' => $color,
            'eyes' => $eyes,
            'mouth' => $mouth,
            'ears' => $ears,
            'horn' => $horn,
            'back' => $back,
            'tail' => $tail,
        ];
    }

    public function getDominantGenes() {
        if ( $this->dominantGenes ) {
            return $this->dominantGenes;
        }
        $o = [];
        foreach ([$this->getEyes(), $this->getMouth(), $this->getEars(), $this->getHorn(), $this->getBack(), $this->getTail()] as $t) {
            if ( !empty($t['d']) ) {
                $o[] = $t['d'];
            }
        }
        $this->dominantGenes = $o;
        return $this->dominantGenes;
    }

    public function getR1Genes() {
        if ( $this->r1Genes ) {
            return $this->r1Genes;
        }
        $o = [];
        foreach ([$this->getEyes(), $this->getMouth(), $this->getEars(), $this->getHorn(), $this->getBack(), $this->getTail()] as $t) {
            if ( !empty($t['r1']) ) {
                $o[] = $t['r1'];
            }
        }
        $this->r1Genes = $o;
        return $this->r1Genes;
    }

    public function getR2Genes() {
        if ( $this->r2Genes ) {
            return $this->r2Genes;
        }
        $o = [];
        foreach ([$this->getEyes(), $this->getMouth(), $this->getEars(), $this->getHorn(), $this->getBack(), $this->getTail()] as $t) {
            if ( !empty($t['r2']) ) {
                $o[] = $t['r2'];
            }
        }
        $this->r2Genes = $o;
        return $this->r2Genes;
    }
    
    public function getAllGenes() {
        if ($this->allGenes) {
            return $this->allGenes;
        }
        $this->allGenes = [];
        foreach ([$this->getEyes(), $this->getMouth(), $this->getEars(), $this->getHorn(), $this->getBack(), $this->getTail()] as $t) {
            foreach(['d', 'r1', 'r2'] as $g) {
                if ( !empty($t[ $g ]) ) {
                    $this->allGenes[] = $t[$g];
                }
            }
        }
        return $this->allGenes;
    }

    public function getDominantClassPurity() {
        $tally = array_count_values(array_column($this->getDominantGenes(), 'class'));
        $classGeneCount = $tally[ $this->getClass() ] ?? 0;
        return ($classGeneCount / count($this->getDominantGenes())) * 100;
    }

    public function getR1ClassPurity() {
        $tally = array_count_values(array_column($this->getR1Genes(), 'class'));
        $classGeneCount = $tally[ $this->getClass() ] ?? 0;
        return ($classGeneCount / count($this->getR1Genes())) * 100;
    }

    public function getR2ClassPurity() {
        $tally = array_count_values(array_column($this->getR2Genes(), 'class'));
        $classGeneCount = $tally[ $this->getClass() ] ?? 0;
        return ($classGeneCount / count($this->getR2Genes())) * 100;
    }

    public function getOverallClassPurity() {
        return ( $this->getDominantClassPurity() + $this->getR1ClassPurity() + $this->getR2ClassPurity() ) / 3;
    }

    public function getDominantClasses() {
        return array_values(array_unique(array_column($this->getDominantGenes(), 'class')));
    }

    public function countDominantClasses() {
        return count($this->getDominantClasses());
    }

    public function getR1Classes() {
        return array_values(array_unique(array_column($this->getR1Genes(), 'class')));
    }

    public function countR1Classes() {
        return count($this->getR1Classes());
    }

    public function getR2Classes() {
        return array_values(array_unique(array_column($this->getR2Genes(), 'class')));
    }

    public function countR2Classes() {
        return count($this->getR2Classes());
    }

    /*
        function getQualityAndPureness(traits, cls) {
            let quality = 0;
            let dPureness = 0;
            for (let i in parts) {
                if (traits[parts[i]].d.class == cls) {
                    quality += PROBABILITIES.d;
                    dPureness++;
                }
                if (traits[parts[i]].r1.class == cls) {
                    quality += PROBABILITIES.r1;
                }
                if (traits[parts[i]].r2.class == cls) {
                    quality += PROBABILITIES.r2;
                }
            }
            return {quality: quality/MAX_QUALITY, pureness: dPureness};
        }
     */
    public function getPureness() {
        if ($this->pureness !== null) {
            return $this->pureness;
        }
        $pureness = 0;
        foreach($this->getDominantGenes() as $g) {
            if (isset($g['class']) && $this->getClass() === $g['class']) {
                $pureness++;
            }
        }
        $this->pureness = $pureness;
        return $this->pureness;
    }
    public function getQuality() {
        if ($this->quality !== null) {
            return $this->quality;
        }
        $quality = 0;
        foreach(AxieDefinition::AXIE_PARTS as $p) {
            if ( !empty($this->getTraits()[ $p ]['d']['class']) && $this->getTraits()[ $p ]['d']['class'] === $this->getClass() ) {
                $quality = $quality + AxieDefinition::GENE_PASSING_PROBABILITY['d'];
            }
            if ( !empty($this->getTraits()[ $p ]['r1']['class']) && $this->getTraits()[ $p ]['r1']['class'] === $this->getClass() ) {
                $quality = $quality + AxieDefinition::GENE_PASSING_PROBABILITY['r1'];
            }
            if ( !empty($this->getTraits()[ $p ]['r2']['class']) && $this->getTraits()[ $p ]['r2']['class'] === $this->getClass() ) {
                $quality = $quality + AxieDefinition::GENE_PASSING_PROBABILITY['r2'];
            }
        }
        $this->quality = ($quality / ( 6 * ( AxieDefinition::GENE_PASSING_PROBABILITY['d'] + AxieDefinition::GENE_PASSING_PROBABILITY['r1'] + AxieDefinition::GENE_PASSING_PROBABILITY['r2'] ) )) * 100;
        return $this->quality;
    }

    public function getGenePassingRates(): array
    {
        $parts = [];

        foreach([
            [ 'type' => 'd', 'method' => 'getDominantGenes' ],
            [ 'type' => 'r1', 'method' => 'getR1Genes' ],
            [ 'type' => 'r2', 'method' => 'getR2Genes' ],
        ] as $geneMethod) {
            foreach($this->{$geneMethod['method']}() as $gene) {
                $key = array_search($gene['partId'], array_column($parts, 'partId'));
                if (false === $key) {
                    $parts[] = [
                        'partId' => $gene['partId'],
                        'passingRate' => AxieDefinition::GENE_PASSING_PROBABILITY[$geneMethod['type']]
                    ];
                } else {
                    $parts[$key]['passingRate'] = $parts[$key]['passingRate'] + AxieDefinition::GENE_PASSING_PROBABILITY[$geneMethod['type']];
                }
            }
        }
        usort($parts, function($a, $b) {
            return $b['passingRate'] <=> $a['passingRate'];
        });

        return $parts;
    }

}
