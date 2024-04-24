<?php
defined('TYPO3') or die();

	// Configuration/TCA/Override/tx_mlstonelexicon_page.php


	// Anzeige der Tabs und Paletten im Lexikon
	$GLOBALS['TCA']['pages']['types'][169]['showitem'] = '
		--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.standard;standard,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;title,

		--div--;Lexikon,
			--palette--;Einstellungen für das Lexikon;lexicon,   
			--palette--;Bild für die Listenansicht;bild,
			--palette--;Innenbereich trocken;indoordryPalette,
			--palette--;Innenbereich nass;indoorwetPalette,
			--palette--;Außenbereich;outdoorPalette,

		--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
			--palette--;;backend_layout,
			--palette--;;replace,	

		--div--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.tabs.seo,
			--palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.seo;seo,
			--palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.social;social,
			--palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.opengraph;opengraph,
			--palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.twittercards;twittercards,
			--palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.robots;robots,
			--palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.canonical;canonical,
			--palette--;LLL:EXT:seo/Resources/Private/Language/locallang_tca.xlf:pages.palettes.sitemap;sitemap,

		--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;editorial,

        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,			        

		--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,

		--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
	';


	// Gruppe der Paletten für spezifische Bereiche wie Lexikon, Innenbereich trocken, nass und Außenbereich
	$GLOBALS['TCA']['pages']['palettes']['lexicon'] = [
		'showitem' => 'rocktype, subgroup, age, origin, color, structure'
	];

	$GLOBALS['TCA']['pages']['palettes']['indoordryPalette'] = [
		'showitem' => 'indoordry_1, indoordry_2, indoordry_3, indoordry_4, indoordry_5',
	];

	$GLOBALS['TCA']['pages']['palettes']['indoorwetPalette'] = [
		'showitem' => 'indoorwet_1, indoorwet_2, indoorwet_3',
	];

	$GLOBALS['TCA']['pages']['palettes']['outdoorPalette'] = [
		'showitem' => 'outdoor_1, outdoor_2, outdoor_3',
	];

// Spezifische TCA-Erweiterungen für das ml_stonelexicon
$stoneTca = [
    'rocktype' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/Backend.xlf:tx_mlstonelexicon_domain_model_stone.rocktype',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
            'required' => true,
        ],
    ],
	'subgroup' => [
		'exclude' => 0,
		'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/Backend.xlf:tx_mlstonelexicon_domain_model_stone.subgroup',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim',
   			'required' => true,
		],
	],
	'age' => [
		'exclude' => 0,
		'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/Backend.xlf:tx_mlstonelexicon_domain_model_stone.age',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim',
   			'required' => true,
		],
	],
	'origin' => [
		'exclude' => 0,
		'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/Backend.xlf:tx_mlstonelexicon_domain_model_stone.origin',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim',
   			'required' => true,
		],
	],
	'color' => [
		'exclude' => 0,
		'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/Backend.xlf:tx_mlstonelexicon_domain_model_stone.color',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => [
				['label' => 'Bitte auswählen','value' => '--div--'],
				['label' => 'Schwarz', 'value' => 1],
				['label' => 'Braun', 'value' => 2],
				['label' => 'Rot', 'value' => 3],
				['label' => 'Blau', 'value' => 4],
				['label' => 'Grün', 'value' => 5],
				['label' => 'Rosa', 'value' => 6],
				['label' => 'Beige', 'value' => 7],
				['label' => 'Gelb', 'value' => 8],
				['label' => 'Grau', 'value' => 9],
				['label' => 'Weiß', 'value' => 10],
			],
			'maxitems' => 1,
		],
	],
	'structure' => [
		'exclude' => 0,
		'label' => 'LLL:EXT:ml_stonelexicon/Resources/Private/Language/Backend.xlf:tx_mlstonelexicon_domain_model_stone.structure',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => [
				['label' => 'Bitte auswählen','value' => '--div--'],
				['label' => 'Pfeffer-Salz', 'value' => 1],
				['label' => 'unifarben', 'value' => 2],
				['label' => 'gewolkt', 'value' => 3],
				['label' => 'geadert', 'value' => 4],
				['label' => 'transluzent', 'value' => 5],
				['label' => 'körnig', 'value' => 6],
				['label' => 'nadelig', 'value' => 7],
				['label' => 'gebändert', 'value' => 8],
				['label' => 'glitzernd', 'value' => 9],
				['label' => 'marmoriert', 'value' => 10],
			],
			'maxitems' => 1,
		],
	],
	'indoordry_1' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Küchenarbeitsplatte',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'indoordry_2' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Wandverkleidung',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'indoordry_3' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Bodenbelag',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'indoordry_4' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Treppe',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'indoordry_5' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Wärmelampe geeignet',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'indoorwet_1' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Dusche',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'indoorwet_2' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Waschtisch',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'indoorwet_3' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Bodenbelag',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'outdoor_1' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Außenfassade',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'outdoor_2' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Terasse',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
	'outdoor_3' => [
		'exclude' => 1,
		'label' => '',
		'description' => '',
		'config' => [
			'type' => 'check',
			'renderType' => 'checkboxToggle',
			'items' => [
				[
					'label' => 'Außentreppe',
					'labelChecked' => 'Enabled',
					'labelUnchecked' => 'Disabled',
					'invertStateDisplay' => true,
				],
			],
			'cols' => 'inline',
		],
	],
];



// Anwendung der Konfiguration auf die 'pages' Tabelle
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $stoneTca);


// Sicherstellen, dass der globale TCA-Array verfügbar ist
global $TCA;

// Lokale Definition des Doktypes für die Konfiguration
$localCustomDoktype = 169;

// Registrieren des Doktype-Icons
if (isset($TCA['pages'])) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'pages', 'doktype', ['Naturstein', $localCustomDoktype, 'EXT:ml_stonelexicon/Resources/Public/Icons/BackendLayouts/diamant.svg'], '1', 'after'
    );

    \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
        $GLOBALS['TCA']['pages'],
        ['ctrl' => ['typeicon_classes' => [$localCustomDoktype => 'apps-pagetree-mlstonelexicon']]]
    );
}
