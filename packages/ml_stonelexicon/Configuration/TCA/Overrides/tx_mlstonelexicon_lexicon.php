<?php
defined('TYPO3') or die();

// Configuration/TCA/Overrides/tx_mlstonelexicon_lexicon.php

// Registrierung der PageTSConfig-Datei für das Lexikon
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'MlStonelexicon',
    'Configuration/TsConfig/Page/All.tsconfig',
    'Lexikon'
);

// Registrierung des Lexikon-Plugins "Plugin Lexikon"
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MlStonelexicon',
    'Lexicon',
    'Steinlexikon',
    'EXT:ml_stonelexicon/Resources/Public/Icons/BackendLayouts/diamant.svg'
);
