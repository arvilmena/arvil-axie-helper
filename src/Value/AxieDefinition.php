<?php
/**
 * AxieDefinition.php file summary.
 *
 * AxieDefinition.php file description.
 *
 * @link       https://project.com
 *
 * @package    Project
 *
 * @subpackage App\Value
 *
 * @author     Arvil Meña <arvil@arvilmena.com>
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace App\Value;

/**
 * Class AxieDefinition.
 *
 * Class AxieDefinition description.
 *
 * @since 1.0.0
 */
class AxieDefinition
{

    // const parts = ["eyes", "mouth" ,"ears", "horn", "back", "tail"];
    const AXIE_PARTS  = ["eyes", "mouth" ,"ears", "horn", "back", "tail"];

    // const PROBABILITIES = {d: 0.375, r1: 0.09375, r2: 0.03125}
    const GENE_PASSING_PROBABILITY = [ 'd' => 0.375, 'r1' => 0.09375, 'r2' => 0.03125];

    // const classGeneMap = {"0000": "beast", "0001": "bug", "0010": "bird", "0011": "plant", "0100": "aquatic", "0101": "reptile", "1000": "???", "1001": "???", "1010": "???"};
    const CLASS_GENE_MAP = [
        '0000' => 'beast',
        '0001' => 'bug',
        '0010' => 'bird',
        '0011' => 'plant',
        '0100' => 'aquatic',
        '0101' => 'reptile',
        '1000' => '???',
        '1001' => '???',
        '1010' => '???',
    ];
    const REGION_GENE_MAP = [
        '00000' => 'global',
        '00001' => 'japan'
    ];

    const BINARY_TRAITS = [
        'beast' => [
            'eyes' => [
                '001000' => [
                    'global' => 'Puppy',
                ],
                '000010' => [
                    'global' => 'Zeal',
                    'mystic' => 'Calico Zeal',
                ],
                '000100' => [
                    'global' => 'Little Peas',
                    'xmas' => 'Snowflakes',
                ],
                '001010' => [
                    'global' => 'Chubby',
                ],
            ],
            'ears' => [
                '001010' => [
                    'global' => 'Puppy',
                ],
                '000100' => [
                    'global' => 'Nut Cracker',
                ],
                '000010' => [
                    'global' => 'Nyan',
                    'mystic' => 'Pointy Nyan',
                ],
                '000110' => [
                    'global' => 'Innocent Lamb',
                    'xmas' => 'Merry Lamb',
                ],
                '001000' => [
                    'global' => 'Zen',
                ],
                '001100' => [
                    'global' => 'Belieber',
                ],
            ],
            'back' => [
                '001000' => [
                    'japan' => 'Hamaya',
                    'global' => 'Risky Beast',
                ],
                '000100' => [
                    'global' => 'Hero',
                ],
                '000110' => [
                    'global' => 'Jaguar',
                ],
                '000010' => [
                    'mystic' => 'Hasagi',
                    'global' => 'Ronin',
                ],
                '001010' => [
                    'global' => 'Timber',
                ],
                '001100' => [
                    'global' => 'Furball',
                ],
            ],
            'horn' => [
                '001000' => [
                    'japan' => 'Umaibo',
                    'global' => 'Pocky',
                ],
                '000100' => [
                    'global' => 'Imp',
                    'japan' => 'Kendama',
                ],
                '000110' => [
                    'global' => 'Merry',
                ],
                '000010' => [
                    'mystic' => 'Winter Branch',
                    'global' => 'Little Branch',
                ],
                '001010' => [
                    'global' => 'Dual Blade',
                ],
                '001100' => [
                    'global' => 'Arco',
                ],
            ],
            'tail' => [
                '000100' => [
                    'global' => 'Rice',
                ],
                '000010' => [
                    'global' => 'Cottontail',
                    'mystic' => 'Sakura Cottontail',
                ],
                '000110' => [
                    'global' => 'Shiba',
                ],
                '001000' => [
                    'global' => 'Hare',
                ],
                '001010' => [
                    'global' => 'Nut Cracker',
                ],
                '001100' => [
                    'global' => 'Gerbil',
                ],
            ],
            'mouth' => [
                '000100' => [
                    'global' => 'Goda',
                ],
                '000010' => [
                    'global' => 'Nut Cracker',
                    'mystic' => 'Skull Cracker',
                ],
                '001000' => [
                    'global' => 'Axie Kiss',
                ],
                '001010' => [
                    'global' => 'Confident',
                ],
            ],
        ],
        'bug' => [
            'mouth' => [
                '001000' => [
                    'japan' => 'Kawaii',
                    'global' => 'Cute Bunny',
                ],
                '000010' => [
                    'global' => 'Mosquito',
                    'mystic' => 'Feasting Mosquito',
                ],
                '000100' => [
                    'global' => 'Pincer',
                ],
                '001010' => [
                    'global' => 'Square Teeth',
                ],
            ],
            'horn' => [
                '001010' => [
                    'global' => 'Parasite',
                ],
                '000010' => [
                    'global' => 'Lagging',
                    'mystic' => 'Laggingggggg',
                ],
                '000110' => [
                    'global' => 'Caterpillars',
                ],
                '000100' => [
                    'global' => 'Antenna',
                ],
                '001000' => [
                    'global' => 'Pliers',
                ],
                '001100' => [
                    'global' => 'Leaf Bug',
                ],
            ],
            'tail' => [
                '001000' => [
                    'global' => 'Gravel Ant',
                ],
                '000010' => [
                    'mystic' => 'Fire Ant',
                    'global' => 'Ant',
                ],
                '000100' => [
                    'global' => 'Twin Tail',
                ],
                '000110' => [
                    'global' => 'Fish Snack',
                    'japan' => 'Maki',
                ],
                '001010' => [
                    'global' => 'Pupae',
                ],
                '001100' => [
                    'global' => 'Thorny Caterpillar',
                ],
            ],
            'back' => [
                '001000' => [
                    'global' => 'Sandal',
                ],
                '000010' => [
                    'global' => 'Snail Shell',
                    'mystic' => 'Starry Shell',
                ],
                '000100' => [
                    'global' => 'Garish Worm',
                    'xmas' => 'Candy Canes',
                ],
                '000110' => [
                    'global' => 'Buzz Buzz',
                ],
                '001010' => [
                    'global' => 'Scarab',
                ],
                '001100' => [
                    'global' => 'Spiky Wing',
                ],
            ],
            'ears' => [
                '000010' => [
                    'global' => 'Larva',
                    'mystic' => 'Vector',
                ],
                '000110' => [
                    'global' => 'Ear Breathing',
                ],
                '000100' => [
                    'global' => 'Beetle Spike',
                ],
                '001000' => [
                    'global' => 'Leaf Bug',
                ],
                '001010' => [
                    'global' => 'Tassels',
                ],
                '001100' => [
                    'japan' => 'Mon',
                    'global' => 'Earwing',
                ],
            ],
            'eyes' => [
                '000010' => [
                    'global' => 'Bookworm',
                    'mystic' => 'Broken Bookworm',
                ],
                '000100' => [
                    'global' => 'Neo',
                ],
                '001010' => [
                    'global' => 'Kotaro?',
                ],
                '001000' => [
                    'global' => 'Nerdy',
                ],
            ],
        ],
        'aquatic' => [
            'eyes' => [
                '001000' => [
                    'global' => 'Gero',
                ],
                '000010' => [
                    'global' => 'Sleepless',
                    'mystic' => 'Insomnia',
                    'japan' => 'Yen',
                ],
                '000100' => [
                    'global' => 'Clear',
                ],
                '001010' => [
                    'global' => 'Telescope',
                ],
            ],
            'mouth' => [
                '001000' => [
                    'global' => 'Risky Fish',
                ],
                '000100' => [
                    'global' => 'Catfish',
                ],
                '000010' => [
                    'global' => 'Lam',
                    'mystic' => 'Lam Handsome',
                ],
                '001010' => [
                    'global' => 'Piranha',
                    'japan' => 'Geisha',
                ],
            ],
            'horn' => [
                '001100' => [
                    'global' => 'Shoal Star',
                ],
                '000110' => [
                    'global' => 'Clamshell',
                ],
                '000010' => [
                    'global' => 'Babylonia',
                    'mystic' => 'Candy Babylonia',
                ],
                '000100' => [
                    'global' => 'Teal Shell',
                ],
                '001000' => [
                    'global' => 'Anemone',
                ],
                '001010' => [
                    'global' => 'Oranda',
                ],
            ],
            'ears' => [
                '000010' => [
                    'global' => 'Nimo',
                    'mystic' => 'Red Nimo',
                ],
                '000110' => [
                    'global' => 'Bubblemaker',
                ],
                '000100' => [
                    'global' => 'Tiny Fan',
                ],
                '001000' => [
                    'global' => 'Inkling',
                ],
                '001010' => [
                    'global' => 'Gill',
                ],
                '001100' => [
                    'global' => 'Seaslug',
                ],
            ],
            'tail' => [
                '000010' => [
                    'global' => 'Koi',
                    'mystic' => 'Kuro Koi',
                    'japan' => 'Koinobori',
                ],
                '000110' => [
                    'global' => 'Tadpole',
                ],
                '000100' => [
                    'global' => 'Nimo',
                ],
                '001010' => [
                    'global' => 'Navaga',
                ],
                '001000' => [
                    'global' => 'Ranchu',
                ],
                '001100' => [
                    'global' => 'Shrimp',
                ],
            ],
            'back' => [
                '000010' => [
                    'global' => 'Hermit',
                    'mystic' => 'Crystal Hermit',
                ],
                '000100' => [
                    'global' => 'Blue Moon',
                ],
                '000110' => [
                    'global' => 'Goldfish',
                ],
                '001010' => [
                    'global' => 'Anemone',
                ],
                '001000' => [
                    'global' => 'Sponge',
                ],
                '001100' => [
                    'global' => 'Perch',
                ],
            ],
        ],
        'bird' => [
            'ears' => [
                '001100' => [
                    'japan' => 'Karimata',
                    'global' => 'Risky Bird',
                ],
                '000010' => [
                    'global' => 'Pink Cheek',
                    'mystic' => 'Heart Cheek',
                ],
                '000100' => [
                    'global' => 'Early Bird',
                ],
                '000110' => [
                    'global' => 'Owl',
                ],
                '001010' => [
                    'global' => 'Curly',
                ],
                '001000' => [
                    'global' => 'Peace Maker',
                ],
            ],
            'tail' => [
                '001010' => [
                    'japan' => 'Omatsuri',
                    'global' => 'Granma\'s Fan',
                ],
                '000010' => [
                    'global' => 'Swallow',
                    'mystic' => 'Snowy Swallow',
                ],
                '000100' => [
                    'global' => 'Feather Fan',
                ],
                '000110' => [
                    'global' => 'The Last One',
                ],
                '001000' => [
                    'global' => 'Cloud',
                ],
                '001100' => [
                    'global' => 'Post Fight',
                ],
            ],
            'back' => [
                '000010' => [
                    'global' => 'Balloon',
                    'mystic' => 'Starry Balloon',
                ],
                '000110' => [
                    'global' => 'Raven',
                ],
                '000100' => [
                    'global' => 'Cupid',
                    'japan' => 'Origami',
                ],
                '001000' => [
                    'global' => 'Pigeon Post',
                ],
                '001010' => [
                    'global' => 'Kingfisher',
                ],
                '001100' => [
                    'global' => 'Tri Feather',
                ],
            ],
            'horn' => [
                '000110' => [
                    'global' => 'Trump',
                ],
                '000010' => [
                    'global' => 'Eggshell',
                    'mystic' => 'Golden Shell',
                ],
                '000100' => [
                    'global' => 'Cuckoo',
                ],
                '001000' => [
                    'global' => 'Kestrel',
                ],
                '001010' => [
                    'global' => 'Wing Horn',
                ],
                '001100' => [
                    'global' => 'Feather Spear',
                    'xmas' => 'Spruce Spear',
                ],
            ],
            'mouth' => [
                '000010' => [
                    'global' => 'Doubletalk',
                    'mystic' => 'Mr. Doubletalk',
                ],
                '000100' => [
                    'global' => 'Peace Maker',
                ],
                '001000' => [
                    'global' => 'Hungry Bird',
                ],
                '001010' => [
                    'global' => 'Little Owl',
                ],
            ],
            'eyes' => [
                '000010' => [
                    'global' => 'Mavis',
                    'mystic' => 'Sky Mavis',
                ],
                '000100' => [
                    'global' => 'Lucas',
                ],
                '001010' => [
                    'global' => 'Robin',
                ],
                '001000' => [
                    'global' => 'Little Owl',
                ],
            ],
        ],
        'reptile' => [
            'eyes' => [
                '001010' => [
                    'japan' => 'Kabuki',
                    'global' => 'Topaz',
                ],
                '000100' => [
                    'global' => 'Tricky',
                ],
                '000010' => [
                    'global' => 'Gecko',
                    'mystic' => 'Crimson Gecko',
                ],
                '001000' => [
                    'global' => 'Scar',
                    'japan' => 'Dokuganryu',
                ],
            ],
            'mouth' => [
                '001000' => [
                    'global' => 'Razor Bite',
                ],
                '000100' => [
                    'global' => 'Kotaro',
                ],
                '000010' => [
                    'global' => 'Toothless Bite',
                    'mystic' => 'Venom Bite',
                ],
                '001010' => [
                    'global' => 'Tiny Turtle',
                    'japan' => 'Dango',
                ],
            ],
            'ears' => [
                '001000' => [
                    'global' => 'Small Frill',
                ],
                '000110' => [
                    'global' => 'Curved Spine',
                ],
                '000100' => [
                    'global' => 'Friezard',
                ],
                '000010' => [
                    'global' => 'Pogona',
                    'mystic' => 'Deadly Pogona',
                ],
                '001010' => [
                    'global' => 'Swirl',
                ],
                '001100' => [
                    'global' => 'Sidebarb',
                ],
            ],
            'back' => [
                '001000' => [
                    'global' => 'Indian Star',
                ],
                '000010' => [
                    'global' => 'Bone Sail',
                    'mystic' => 'Rugged Sail',
                ],
                '000100' => [
                    'global' => 'Tri Spikes',
                ],
                '000110' => [
                    'global' => 'Green Thorns',
                ],
                '001010' => [
                    'global' => 'Red Ear',
                ],
                '001100' => [
                    'global' => 'Croc',
                ],
            ],
            'tail' => [
                '000100' => [
                    'global' => 'Iguana',
                ],
                '000010' => [
                    'global' => 'Wall Gecko',
                    'mystic' => 'Escaped Gecko',
                ],
                '000110' => [
                    'global' => 'Tiny Dino',
                ],
                '001000' => [
                    'global' => 'Snake Jar',
                    'xmas' => 'December Surprise',
                ],
                '001010' => [
                    'global' => 'Gila',
                ],
                '001100' => [
                    'global' => 'Grass Snake',
                ],
            ],
            'horn' => [
                '000010' => [
                    'global' => 'Unko',
                    'mystic' => 'Pinku Unko',
                ],
                '000110' => [
                    'global' => 'Cerastes',
                ],
                '000100' => [
                    'global' => 'Scaly Spear',
                ],
                '001010' => [
                    'global' => 'Incisor',
                ],
                '001000' => [
                    'global' => 'Scaly Spoon',
                ],
                '001100' => [
                    'global' => 'Bumpy',
                ],
            ],
        ],
        'plant' => [
            'tail' => [
                '001000' => [
                    'global' => 'Yam',
                ],
                '000010' => [
                    'global' => 'Carrot',
                    'mystic' => 'Namek Carrot',
                ],
                '000100' => [
                    'global' => 'Cattail',
                ],
                '000110' => [
                    'global' => 'Hatsune',
                ],
                '001010' => [
                    'global' => 'Potato Leaf',
                ],
                '001100' => [
                    'global' => 'Hot Butt',
                ],
            ],
            'mouth' => [
                '000100' => [
                    'global' => 'Zigzag',
                    'xmas' => 'Rudolph',
                ],
                '000010' => [
                    'global' => 'Serious',
                    'mystic' => 'Humorless',
                ],
                '001000' => [
                    'global' => 'Herbivore',
                ],
                '001010' => [
                    'global' => 'Silence Whisper',
                ],
            ],
            'eyes' => [
                '000010' => [
                    'global' => 'Papi',
                    'mystic' => 'Dreamy Papi',
                ],
                '000100' => [
                    'global' => 'Confused',
                ],
                '001010' => [
                    'global' => 'Blossom',
                ],
                '001000' => [
                    'global' => 'Cucumber Slice',
                ],
            ],
            'ears' => [
                '000010' => [
                    'global' => 'Leafy',
                    'mystic' => 'The Last Leaf',
                ],
                '000110' => [
                    'global' => 'Rosa',
                ],
                '000100' => [
                    'global' => 'Clover',
                ],
                '001000' => [
                    'global' => 'Sakura',
                    'japan' => 'Maiko',
                ],
                '001010' => [
                    'global' => 'Hollow',
                ],
                '001100' => [
                    'global' => 'Lotus',
                ],
            ],
            'back' => [
                '000110' => [
                    'global' => 'Bidens',
                ],
                '000100' => [
                    'global' => 'Shiitake',
                    'japan' => 'Yakitori',
                ],
                '000010' => [
                    'global' => 'Turnip',
                    'mystic' => 'Pink Turnip',
                ],
                '001010' => [
                    'global' => 'Mint',
                ],
                '001000' => [
                    'global' => 'Watering Can',
                ],
                '001100' => [
                    'global' => 'Pumpkin',
                ],
            ],
            'horn' => [
                '000100' => [
                    'global' => 'Beech',
                    'japan' => 'Yorishiro',
                ],
                '000110' => [
                    'global' => 'Rose Bud',
                ],
                '000010' => [
                    'global' => 'Bamboo Shoot',
                    'mystic' => 'Golden Bamboo Shoot',
                ],
                '001010' => [
                    'global' => 'Cactus',
                ],
                '001000' => [
                    'global' => 'Strawberry Shortcake',
                ],
                '001100' => [
                    'global' => 'Watermelon',
                ],
            ],
        ],
    ];

    const GENE_COLOR_MAP = [
        '0000' => [
            '0010' => 'ffec51',
            '0011' => 'ffa12a',
            '0100' => 'f0c66e',
            '0110' => '60afce',
        ],
        '0001' => [
            '0010' => 'ff7183',
            '0011' => 'ff6d61',
            '0100' => 'f74e4e',
        ],
        '0010' => [
            '0010' => 'ff9ab8',
            '0011' => 'ffb4bb',
            '0100' => 'ff778e',
        ],
        '0011' => [
            '0010' => 'ccef5e',
            '0011' => 'efd636',
            '0100' => 'c5ffd9',
        ],
        '0100' => [
            '0010' => '4cffdf',
            '0011' => '2de8f2',
            '0100' => '759edb',
            '0110' => 'ff5a71',
        ],
        '0101' => [
            '0010' => 'fdbcff',
            '0011' => 'ef93ff',
            '0100' => 'f5e1ff',
            '0110' => '43e27d',
        ],
        '1000' => [
            '0010' => 'D9D9D9',
            '0011' => 'D9D9D9',
            '0100' => 'D9D9D9',
            '0110' => 'D9D9D9',
        ],
        '1001' => [
            '0010' => 'D9D9D9',
            '0011' => 'D9D9D9',
            '0100' => 'D9D9D9',
            '0110' => 'D9D9D9',
        ],
        '1010' => [
            '0010' => 'D9D9D9',
            '0011' => 'D9D9D9',
            '0100' => 'D9D9D9',
            '0110' => 'D9D9D9',
        ],
    ];

    const BODY_PARTS = [
        0 => [
            'partId' => 'eyes-gero',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Gero',
        ],
        1 => [
            'partId' => 'eyes-sleepless',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Sleepless',
        ],
        2 => [
            'partId' => 'eyes-yen',
            'class' => 'aquatic',
            'specialGenes' => 'japan',
            'type' => 'eyes',
            'name' => 'Yen',
        ],
        3 => [
            'partId' => 'eyes-clear',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Clear',
        ],
        4 => [
            'partId' => 'eyes-telescope',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Telescope',
        ],
        5 => [
            'partId' => 'ears-tiny-fan',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Tiny Fan',
        ],
        6 => [
            'partId' => 'ears-bubblemaker',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Bubblemaker',
        ],
        7 => [
            'partId' => 'ears-gill',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Gill',
        ],
        8 => [
            'partId' => 'ears-inkling',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Inkling',
        ],
        9 => [
            'partId' => 'ears-red-nimo',
            'class' => 'aquatic',
            'specialGenes' => 'mystic',
            'type' => 'ears',
            'name' => 'Red Nimo',
        ],
        10 => [
            'partId' => 'eyes-insomnia',
            'class' => 'aquatic',
            'specialGenes' => 'mystic',
            'type' => 'eyes',
            'name' => 'Insomnia',
        ],
        11 => [
            'partId' => 'ears-nimo',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Nimo',
        ],
        12 => [
            'partId' => 'mouth-lam-handsome',
            'class' => 'aquatic',
            'specialGenes' => 'mystic',
            'type' => 'mouth',
            'name' => 'Lam Handsome',
        ],
        13 => [
            'partId' => 'mouth-lam',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Lam',
        ],
        14 => [
            'partId' => 'mouth-risky-fish',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Risky Fish',
        ],
        15 => [
            'partId' => 'mouth-piranha',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Piranha',
        ],
        16 => [
            'partId' => 'horn-babylonia',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Babylonia',
        ],
        17 => [
            'partId' => 'mouth-geisha',
            'class' => 'aquatic',
            'specialGenes' => 'japan',
            'type' => 'mouth',
            'name' => 'Geisha',
        ],
        18 => [
            'partId' => 'horn-teal-shell',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Teal Shell',
        ],
        19 => [
            'partId' => 'mouth-catfish',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Catfish',
        ],
        20 => [
            'partId' => 'horn-anemone',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Anemone',
        ],
        21 => [
            'partId' => 'horn-clamshell',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Clamshell',
        ],
        22 => [
            'partId' => 'ears-seaslug',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Seaslug',
        ],
        23 => [
            'partId' => 'horn-shoal-star',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Shoal Star',
        ],
        24 => [
            'partId' => 'back-blue-moon',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Blue Moon',
        ],
        25 => [
            'partId' => 'back-sponge',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Sponge',
        ],
        26 => [
            'partId' => 'horn-5h04l-5t4r',
            'class' => 'aquatic',
            'specialGenes' => 'bionic',
            'type' => 'horn',
            'name' => '5H04L-5T4R',
        ],
        27 => [
            'partId' => 'horn-oranda',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Oranda',
        ],
        28 => [
            'partId' => 'back-hermit',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Hermit',
        ],
        29 => [
            'partId' => 'back-crystal-hermit',
            'class' => 'aquatic',
            'specialGenes' => 'mystic',
            'type' => 'back',
            'name' => 'Crystal Hermit',
        ],
        30 => [
            'partId' => 'horn-candy-babylonia',
            'class' => 'aquatic',
            'specialGenes' => 'mystic',
            'type' => 'horn',
            'name' => 'Candy Babylonia',
        ],
        31 => [
            'partId' => 'back-goldfish',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Goldfish',
        ],
        32 => [
            'partId' => 'tail-koi',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Koi',
        ],
        33 => [
            'partId' => 'back-anemone',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Anemone',
        ],
        34 => [
            'partId' => 'tail-koinobori',
            'class' => 'aquatic',
            'specialGenes' => 'japan',
            'type' => 'tail',
            'name' => 'Koinobori',
        ],
        35 => [
            'partId' => 'tail-nimo',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Nimo',
        ],
        36 => [
            'partId' => 'tail-navaga',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Navaga',
        ],
        37 => [
            'partId' => 'back-perch',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Perch',
        ],
        38 => [
            'partId' => 'tail-tadpole',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Tadpole',
        ],
        39 => [
            'partId' => 'tail-kuro-koi',
            'class' => 'aquatic',
            'specialGenes' => 'mystic',
            'type' => 'tail',
            'name' => 'Kuro Koi',
        ],
        40 => [
            'partId' => 'tail-ranchu',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Ranchu',
        ],
        41 => [
            'partId' => 'tail-shrimp',
            'class' => 'aquatic',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Shrimp',
        ],
        42 => [
            'partId' => 'eyes-zeal',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Zeal',
        ],
        43 => [
            'partId' => 'eyes-chubby',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Chubby',
        ],
        44 => [
            'partId' => 'ears-nut-cracker',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Nut Cracker',
        ],
        45 => [
            'partId' => 'eyes-snowflakes',
            'class' => 'beast',
            'specialGenes' => 'xmas',
            'type' => 'eyes',
            'name' => 'Snowflakes',
        ],
        46 => [
            'partId' => 'eyes-puppy',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Puppy',
        ],
        47 => [
            'partId' => 'ears-pointy-nyan',
            'class' => 'beast',
            'specialGenes' => 'mystic',
            'type' => 'ears',
            'name' => 'Pointy Nyan',
        ],
        48 => [
            'partId' => 'ears-innocent-lamb',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Innocent Lamb',
        ],
        49 => [
            'partId' => 'ears-nyan',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Nyan',
        ],
        50 => [
            'partId' => 'eyes-calico-zeal',
            'class' => 'beast',
            'specialGenes' => 'mystic',
            'type' => 'eyes',
            'name' => 'Calico Zeal',
        ],
        51 => [
            'partId' => 'eyes-little-peas',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Little Peas',
        ],
        52 => [
            'partId' => 'ears-belieber',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Belieber',
        ],
        53 => [
            'partId' => 'ears-puppy',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Puppy',
        ],
        54 => [
            'partId' => 'mouth-skull-cracker',
            'class' => 'beast',
            'specialGenes' => 'mystic',
            'type' => 'mouth',
            'name' => 'Skull Cracker',
        ],
        55 => [
            'partId' => 'ears-zen',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Zen',
        ],
        56 => [
            'partId' => 'mouth-goda',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Goda',
        ],
        57 => [
            'partId' => 'mouth-axie-kiss',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Axie Kiss',
        ],
        58 => [
            'partId' => 'mouth-confident',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Confident',
        ],
        59 => [
            'partId' => 'horn-winter-branch',
            'class' => 'beast',
            'specialGenes' => 'mystic',
            'type' => 'horn',
            'name' => 'Winter Branch',
        ],
        60 => [
            'partId' => 'horn-imp',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Imp',
        ],
        61 => [
            'partId' => 'horn-kendama',
            'class' => 'beast',
            'specialGenes' => 'japan',
            'type' => 'horn',
            'name' => 'Kendama',
        ],
        62 => [
            'partId' => 'mouth-nut-cracker',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Nut Cracker',
        ],
        63 => [
            'partId' => 'ears-merry-lamb',
            'class' => 'beast',
            'specialGenes' => 'xmas',
            'type' => 'ears',
            'name' => 'Merry Lamb',
        ],
        64 => [
            'partId' => 'horn-dual-blade',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Dual Blade',
        ],
        65 => [
            'partId' => 'horn-pocky',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Pocky',
        ],
        66 => [
            'partId' => 'horn-little-branch',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Little Branch',
        ],
        67 => [
            'partId' => 'back-ronin',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Ronin',
        ],
        68 => [
            'partId' => 'horn-arco',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Arco',
        ],
        69 => [
            'partId' => 'back-hasagi',
            'class' => 'beast',
            'specialGenes' => 'mystic',
            'type' => 'back',
            'name' => 'Hasagi',
        ],
        70 => [
            'partId' => 'horn-umaibo',
            'class' => 'beast',
            'specialGenes' => 'japan',
            'type' => 'horn',
            'name' => 'Umaibo',
        ],
        71 => [
            'partId' => 'horn-merry',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Merry',
        ],
        72 => [
            'partId' => 'back-hero',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Hero',
        ],
        73 => [
            'partId' => 'back-jaguar',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Jaguar',
        ],
        74 => [
            'partId' => 'back-timber',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Timber',
        ],
        75 => [
            'partId' => 'back-risky-beast',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Risky Beast',
        ],
        76 => [
            'partId' => 'back-furball',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Furball',
        ],
        77 => [
            'partId' => 'back-hamaya',
            'class' => 'beast',
            'specialGenes' => 'japan',
            'type' => 'back',
            'name' => 'Hamaya',
        ],
        78 => [
            'partId' => 'tail-sakura-cottontail',
            'class' => 'beast',
            'specialGenes' => 'mystic',
            'type' => 'tail',
            'name' => 'Sakura Cottontail',
        ],
        79 => [
            'partId' => 'tail-cottontail',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Cottontail',
        ],
        80 => [
            'partId' => 'tail-rice',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Rice',
        ],
        81 => [
            'partId' => 'tail-shiba',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Shiba',
        ],
        82 => [
            'partId' => 'tail-hare',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Hare',
        ],
        83 => [
            'partId' => 'tail-gerbil',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Gerbil',
        ],
        84 => [
            'partId' => 'eyes-sky-mavis',
            'class' => 'bird',
            'specialGenes' => 'mystic',
            'type' => 'eyes',
            'name' => 'Sky Mavis',
        ],
        85 => [
            'partId' => 'tail-nut-cracker',
            'class' => 'beast',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Nut Cracker',
        ],
        86 => [
            'partId' => 'eyes-little-owl',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Little Owl',
        ],
        87 => [
            'partId' => 'eyes-lucas',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Lucas',
        ],
        88 => [
            'partId' => 'eyes-mavis',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Mavis',
        ],
        89 => [
            'partId' => 'ears-pink-cheek',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Pink Cheek',
        ],
        90 => [
            'partId' => 'eyes-robin',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Robin',
        ],
        91 => [
            'partId' => 'ears-heart-cheek',
            'class' => 'bird',
            'specialGenes' => 'mystic',
            'type' => 'ears',
            'name' => 'Heart Cheek',
        ],
        92 => [
            'partId' => 'ears-early-bird',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Early Bird',
        ],
        93 => [
            'partId' => 'ears-owl',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Owl',
        ],
        94 => [
            'partId' => 'ears-risky-bird',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Risky Bird',
        ],
        95 => [
            'partId' => 'ears-curly',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Curly',
        ],
        96 => [
            'partId' => 'ears-peace-maker',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Peace Maker',
        ],
        97 => [
            'partId' => 'ears-karimata',
            'class' => 'bird',
            'specialGenes' => 'japan',
            'type' => 'ears',
            'name' => 'Karimata',
        ],
        98 => [
            'partId' => 'mouth-doubletalk',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Doubletalk',
        ],
        99 => [
            'partId' => 'mouth-mr-doubletalk',
            'class' => 'bird',
            'specialGenes' => 'mystic',
            'type' => 'mouth',
            'name' => 'Mr. Doubletalk',
        ],
        100 => [
            'partId' => 'mouth-peace-maker',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Peace Maker',
        ],
        101 => [
            'partId' => 'mouth-hungry-bird',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Hungry Bird',
        ],
        102 => [
            'partId' => 'mouth-little-owl',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Little Owl',
        ],
        103 => [
            'partId' => 'horn-eggshell',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Eggshell',
        ],
        104 => [
            'partId' => 'horn-golden-shell',
            'class' => 'bird',
            'specialGenes' => 'mystic',
            'type' => 'horn',
            'name' => 'Golden Shell',
        ],
        105 => [
            'partId' => 'horn-cuckoo',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Cuckoo',
        ],
        106 => [
            'partId' => 'horn-kestrel',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Kestrel',
        ],
        107 => [
            'partId' => 'horn-trump',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Trump',
        ],
        108 => [
            'partId' => 'horn-wing-horn',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Wing Horn',
        ],
        109 => [
            'partId' => 'horn-feather-spear',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Feather Spear',
        ],
        110 => [
            'partId' => 'back-balloon',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Balloon',
        ],
        111 => [
            'partId' => 'horn-spruce-spear',
            'class' => 'bird',
            'specialGenes' => 'xmas',
            'type' => 'horn',
            'name' => 'Spruce Spear',
        ],
        112 => [
            'partId' => 'back-cupid',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Cupid',
        ],
        113 => [
            'partId' => 'back-starry-balloon',
            'class' => 'bird',
            'specialGenes' => 'mystic',
            'type' => 'back',
            'name' => 'Starry Balloon',
        ],
        114 => [
            'partId' => 'back-origami',
            'class' => 'bird',
            'specialGenes' => 'japan',
            'type' => 'back',
            'name' => 'Origami',
        ],
        115 => [
            'partId' => 'back-raven',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Raven',
        ],
        116 => [
            'partId' => 'back-pigeon-post',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Pigeon Post',
        ],
        117 => [
            'partId' => 'back-kingfisher',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Kingfisher',
        ],
        118 => [
            'partId' => 'tail-swallow',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Swallow',
        ],
        119 => [
            'partId' => 'back-tri-feather',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Tri Feather',
        ],
        120 => [
            'partId' => 'tail-snowy-swallow',
            'class' => 'bird',
            'specialGenes' => 'mystic',
            'type' => 'tail',
            'name' => 'Snowy Swallow',
        ],
        121 => [
            'partId' => 'tail-feather-fan',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Feather Fan',
        ],
        122 => [
            'partId' => 'tail-the-last-one',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'The Last One',
        ],
        123 => [
            'partId' => 'tail-cloud',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Cloud',
        ],
        124 => [
            'partId' => 'tail-granmas-fan',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Granma\'s Fan',
        ],
        125 => [
            'partId' => 'tail-omatsuri',
            'class' => 'bird',
            'specialGenes' => 'japan',
            'type' => 'tail',
            'name' => 'Omatsuri',
        ],
        126 => [
            'partId' => 'eyes-bookworm',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Bookworm',
        ],
        127 => [
            'partId' => 'tail-post-fight',
            'class' => 'bird',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Post Fight',
        ],
        128 => [
            'partId' => 'eyes-neo',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Neo',
        ],
        129 => [
            'partId' => 'eyes-nerdy',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Nerdy',
        ],
        130 => [
            'partId' => 'eyes-kotaro',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Kotaro?',
        ],
        131 => [
            'partId' => 'eyes-broken-bookworm',
            'class' => 'bug',
            'specialGenes' => 'mystic',
            'type' => 'eyes',
            'name' => 'Broken Bookworm',
        ],
        132 => [
            'partId' => 'ears-larva',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Larva',
        ],
        133 => [
            'partId' => 'ears-beetle-spike',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Beetle Spike',
        ],
        134 => [
            'partId' => 'ears-vector',
            'class' => 'bug',
            'specialGenes' => 'mystic',
            'type' => 'ears',
            'name' => 'Vector',
        ],
        135 => [
            'partId' => 'ears-ear-breathing',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Ear Breathing',
        ],
        136 => [
            'partId' => 'ears-leaf-bug',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Leaf Bug',
        ],
        137 => [
            'partId' => 'ears-tassels',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Tassels',
        ],
        138 => [
            'partId' => 'ears-mon',
            'class' => 'bug',
            'specialGenes' => 'japan',
            'type' => 'ears',
            'name' => 'Mon',
        ],
        139 => [
            'partId' => 'ears-earwing',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Earwing',
        ],
        140 => [
            'partId' => 'mouth-mosquito',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Mosquito',
        ],
        141 => [
            'partId' => 'mouth-feasting-mosquito',
            'class' => 'bug',
            'specialGenes' => 'mystic',
            'type' => 'mouth',
            'name' => 'Feasting Mosquito',
        ],
        142 => [
            'partId' => 'mouth-pincer',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Pincer',
        ],
        143 => [
            'partId' => 'tail-ant',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Ant',
        ],
        144 => [
            'partId' => 'mouth-zigzag',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Zigzag',
        ],
        145 => [
            'partId' => 'tail-carrot',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Carrot',
        ],
        146 => [
            'partId' => 'ears-sidebarb',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Sidebarb',
        ],
        147 => [
            'partId' => 'tail-december-surprise',
            'class' => 'reptile',
            'specialGenes' => 'xmas',
            'type' => 'tail',
            'name' => 'December Surprise',
        ],
        148 => [
            'partId' => 'mouth-kawaii',
            'class' => 'bug',
            'specialGenes' => 'japan',
            'type' => 'mouth',
            'name' => 'Kawaii',
        ],
        149 => [
            'partId' => 'tail-pupae',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Pupae',
        ],
        150 => [
            'partId' => 'mouth-herbivore',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Herbivore',
        ],
        151 => [
            'partId' => 'tail-hatsune',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Hatsune',
        ],
        152 => [
            'partId' => 'ears-swirl',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Swirl',
        ],
        153 => [
            'partId' => 'tail-iguana',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Iguana',
        ],
        154 => [
            'partId' => 'horn-laggingggggg',
            'class' => 'bug',
            'specialGenes' => 'mystic',
            'type' => 'horn',
            'name' => 'Laggingggggg',
        ],
        155 => [
            'partId' => 'horn-caterpillars',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Caterpillars',
        ],
        156 => [
            'partId' => 'tail-fire-ant',
            'class' => 'bug',
            'specialGenes' => 'mystic',
            'type' => 'tail',
            'name' => 'Fire Ant',
        ],
        157 => [
            'partId' => 'tail-thorny-caterpillar',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Thorny Caterpillar',
        ],
        158 => [
            'partId' => 'mouth-serious',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Serious',
        ],
        159 => [
            'partId' => 'horn-golden-bamboo-shoot',
            'class' => 'plant',
            'specialGenes' => 'mystic',
            'type' => 'horn',
            'name' => 'Golden Bamboo Shoot',
        ],
        160 => [
            'partId' => 'back-bidens',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Bidens',
        ],
        161 => [
            'partId' => 'tail-yam',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Yam',
        ],
        162 => [
            'partId' => 'eyes-dokuganryu',
            'class' => 'reptile',
            'specialGenes' => 'japan',
            'type' => 'eyes',
            'name' => 'Dokuganryu',
        ],
        163 => [
            'partId' => 'mouth-kotaro',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Kotaro',
        ],
        164 => [
            'partId' => 'back-rugged-sail',
            'class' => 'reptile',
            'specialGenes' => 'mystic',
            'type' => 'back',
            'name' => 'Rugged Sail',
        ],
        165 => [
            'partId' => 'tail-tiny-dino',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Tiny Dino',
        ],
        166 => [
            'partId' => 'mouth-square-teeth',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Square Teeth',
        ],
        167 => [
            'partId' => 'horn-lagging',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Lagging',
        ],
        168 => [
            'partId' => 'tail-gravel-ant',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Gravel Ant',
        ],
        169 => [
            'partId' => 'eyes-papi',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Papi',
        ],
        170 => [
            'partId' => 'mouth-silence-whisper',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Silence Whisper',
        ],
        171 => [
            'partId' => 'horn-beech',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Beech',
        ],
        172 => [
            'partId' => 'tail-potato-leaf',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Potato Leaf',
        ],
        173 => [
            'partId' => 'tail-hot-butt',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Hot Butt',
        ],
        174 => [
            'partId' => 'mouth-dango',
            'class' => 'reptile',
            'specialGenes' => 'japan',
            'type' => 'mouth',
            'name' => 'Dango',
        ],
        175 => [
            'partId' => 'mouth-tiny-turtle',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Tiny Turtle',
        ],
        176 => [
            'partId' => 'back-1nd14n-5t4r',
            'class' => 'reptile',
            'specialGenes' => 'bionic',
            'type' => 'back',
            'name' => '1ND14N-5T4R',
        ],
        177 => [
            'partId' => 'tail-wall-gecko',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Wall Gecko',
        ],
        178 => [
            'partId' => 'horn-antenna',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Antenna',
        ],
        179 => [
            'partId' => 'horn-parasite',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Parasite',
        ],
        180 => [
            'partId' => 'tail-maki',
            'class' => 'bug',
            'specialGenes' => 'japan',
            'type' => 'tail',
            'name' => 'Maki',
        ],
        181 => [
            'partId' => 'eyes-dreamy-papi',
            'class' => 'plant',
            'specialGenes' => 'mystic',
            'type' => 'eyes',
            'name' => 'Dreamy Papi',
        ],
        182 => [
            'partId' => 'ears-lotus',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Lotus',
        ],
        183 => [
            'partId' => 'horn-bamboo-shoot',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Bamboo Shoot',
        ],
        184 => [
            'partId' => 'tail-namek-carrot',
            'class' => 'plant',
            'specialGenes' => 'mystic',
            'type' => 'tail',
            'name' => 'Namek Carrot',
        ],
        185 => [
            'partId' => 'tail-cattail',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Cattail',
        ],
        186 => [
            'partId' => 'mouth-venom-bite',
            'class' => 'reptile',
            'specialGenes' => 'mystic',
            'type' => 'mouth',
            'name' => 'Venom Bite',
        ],
        187 => [
            'partId' => 'horn-unko',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Unko',
        ],
        188 => [
            'partId' => 'back-croc',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Croc',
        ],
        189 => [
            'partId' => 'tail-snake-jar',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Snake Jar',
        ],
        190 => [
            'partId' => 'horn-pliers',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Pliers',
        ],
        191 => [
            'partId' => 'horn-p4r451t3',
            'class' => 'bug',
            'specialGenes' => 'bionic',
            'type' => 'horn',
            'name' => 'P4R451T3',
        ],
        192 => [
            'partId' => 'tail-fish-snack',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Fish Snack',
        ],
        193 => [
            'partId' => 'eyes-blossom',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Blossom',
        ],
        194 => [
            'partId' => 'mouth-humorless',
            'class' => 'plant',
            'specialGenes' => 'mystic',
            'type' => 'mouth',
            'name' => 'Humorless',
        ],
        195 => [
            'partId' => 'horn-strawberry-shortcake',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Strawberry Shortcake',
        ],
        196 => [
            'partId' => 'back-mint',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Mint',
        ],
        197 => [
            'partId' => 'eyes-tricky',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Tricky',
        ],
        198 => [
            'partId' => 'ears-small-frill',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Small Frill',
        ],
        199 => [
            'partId' => 'horn-pinku-unko',
            'class' => 'reptile',
            'specialGenes' => 'mystic',
            'type' => 'horn',
            'name' => 'Pinku Unko',
        ],
        200 => [
            'partId' => 'back-indian-star',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Indian Star',
        ],
        201 => [
            'partId' => 'horn-leaf-bug',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Leaf Bug',
        ],
        202 => [
            'partId' => 'ears-the-last-leaf',
            'class' => 'plant',
            'specialGenes' => 'mystic',
            'type' => 'ears',
            'name' => 'The Last Leaf',
        ],
        203 => [
            'partId' => 'horn-watermelon',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Watermelon',
        ],
        204 => [
            'partId' => 'eyes-scar',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Scar',
        ],
        205 => [
            'partId' => 'horn-cerastes',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Cerastes',
        ],
        206 => [
            'partId' => 'back-snail-shell',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Snail Shell',
        ],
        207 => [
            'partId' => 'eyes-cucumber-slice',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Cucumber Slice',
        ],
        208 => [
            'partId' => 'horn-rose-bud',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Rose Bud',
        ],
        209 => [
            'partId' => 'eyes-crimson-gecko',
            'class' => 'reptile',
            'specialGenes' => 'mystic',
            'type' => 'eyes',
            'name' => 'Crimson Gecko',
        ],
        210 => [
            'partId' => 'horn-scaly-spear',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Scaly Spear',
        ],
        211 => [
            'partId' => 'tail-gila',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Gila',
        ],
        212 => [
            'partId' => 'back-starry-shell',
            'class' => 'bug',
            'specialGenes' => 'mystic',
            'type' => 'back',
            'name' => 'Starry Shell',
        ],
        213 => [
            'partId' => 'eyes-confused',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Confused',
        ],
        214 => [
            'partId' => 'horn-yorishiro',
            'class' => 'plant',
            'specialGenes' => 'japan',
            'type' => 'horn',
            'name' => 'Yorishiro',
        ],
        215 => [
            'partId' => 'eyes-gecko',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Gecko',
        ],
        216 => [
            'partId' => 'mouth-razor-bite',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Razor Bite',
        ],
        217 => [
            'partId' => 'tail-escaped-gecko',
            'class' => 'reptile',
            'specialGenes' => 'mystic',
            'type' => 'tail',
            'name' => 'Escaped Gecko',
        ],
        218 => [
            'partId' => 'back-garish-worm',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Garish Worm',
        ],
        219 => [
            'partId' => 'ears-clover',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Clover',
        ],
        220 => [
            'partId' => 'back-shiitake',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Shiitake',
        ],
        221 => [
            'partId' => 'ears-deadly-pogona',
            'class' => 'reptile',
            'specialGenes' => 'mystic',
            'type' => 'ears',
            'name' => 'Deadly Pogona',
        ],
        222 => [
            'partId' => 'horn-incisor',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Incisor',
        ],
        223 => [
            'partId' => 'tail-grass-snake',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Grass Snake',
        ],
        224 => [
            'partId' => 'back-candy-canes',
            'class' => 'bug',
            'specialGenes' => 'xmas',
            'type' => 'back',
            'name' => 'Candy Canes',
        ],
        225 => [
            'partId' => 'ears-maiko',
            'class' => 'plant',
            'specialGenes' => 'japan',
            'type' => 'ears',
            'name' => 'Maiko',
        ],
        226 => [
            'partId' => 'horn-cactus',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Cactus',
        ],
        227 => [
            'partId' => 'ears-friezard',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Friezard',
        ],
        228 => [
            'partId' => 'back-bone-sail',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Bone Sail',
        ],
        229 => [
            'partId' => 'back-sandal',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Sandal',
        ],
        230 => [
            'partId' => 'ears-sakura',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Sakura',
        ],
        231 => [
            'partId' => 'back-turnip',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Turnip',
        ],
        232 => [
            'partId' => 'eyes-topaz',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'eyes',
            'name' => 'Topaz',
        ],
        233 => [
            'partId' => 'horn-scaly-spoon',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Scaly Spoon',
        ],
        234 => [
            'partId' => 'back-buzz-buzz',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Buzz Buzz',
        ],
        235 => [
            'partId' => 'ears-leafy',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Leafy',
        ],
        236 => [
            'partId' => 'back-pink-turnip',
            'class' => 'plant',
            'specialGenes' => 'mystic',
            'type' => 'back',
            'name' => 'Pink Turnip',
        ],
        237 => [
            'partId' => 'eyes-kabuki',
            'class' => 'reptile',
            'specialGenes' => 'japan',
            'type' => 'eyes',
            'name' => 'Kabuki',
        ],
        238 => [
            'partId' => 'back-tri-spikes',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Tri Spikes',
        ],
        239 => [
            'partId' => 'back-scarab',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Scarab',
        ],
        240 => [
            'partId' => 'ears-rosa',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Rosa',
        ],
        241 => [
            'partId' => 'back-watering-can',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Watering Can',
        ],
        242 => [
            'partId' => 'ears-pogona',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Pogona',
        ],
        243 => [
            'partId' => 'back-green-thorns',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Green Thorns',
        ],
        244 => [
            'partId' => 'back-spiky-wing',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Spiky Wing',
        ],
        245 => [
            'partId' => 'ears-hollow',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Hollow',
        ],
        246 => [
            'partId' => 'back-yakitori',
            'class' => 'plant',
            'specialGenes' => 'japan',
            'type' => 'back',
            'name' => 'Yakitori',
        ],
        247 => [
            'partId' => 'ears-curved-spine',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'ears',
            'name' => 'Curved Spine',
        ],
        248 => [
            'partId' => 'horn-bumpy',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'horn',
            'name' => 'Bumpy',
        ],
        249 => [
            'partId' => 'mouth-cute-bunny',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Cute Bunny',
        ],
        250 => [
            'partId' => 'tail-twin-tail',
            'class' => 'bug',
            'specialGenes' => NULL,
            'type' => 'tail',
            'name' => 'Twin Tail',
        ],
        251 => [
            'partId' => 'mouth-rudolph',
            'class' => 'plant',
            'specialGenes' => 'xmas',
            'type' => 'mouth',
            'name' => 'Rudolph',
        ],
        252 => [
            'partId' => 'back-pumpkin',
            'class' => 'plant',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Pumpkin',
        ],
        253 => [
            'partId' => 'mouth-toothless-bite',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'mouth',
            'name' => 'Toothless Bite',
        ],
        254 => [
            'partId' => 'back-red-ear',
            'class' => 'reptile',
            'specialGenes' => NULL,
            'type' => 'back',
            'name' => 'Red Ear',
        ],
    ];

}
