<?php
declare(strict_types=1);

defined('TYPO3') or die();

// ext_localconf.php

call_user_func(function() {
    // Definition der Namespace der Controller für klarere Referenzierung
    $StoneController = \Simplesigns\MlStonelexicon\Controller\StoneController::class;
    $JsonController = \Simplesigns\MlStonelexicon\Controller\JsonController::class;
    
    /**
     * Konfiguration des Lexikon Frontend Plugins
     * 'MlStonelexicon' ist der Extension-Key und 'Lexicon' der eindeutige Name für das Plugin.
     * Die Arrays definieren die erlaubten Controller-Aktionen für das öffentliche Plugin
     * und die Aktionen, die gecacht werden können.
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MlStonelexicon',
        'Lexicon',
        [$StoneController => 'list, search'], // Controller und deren erlaubte Aktionen
        [$StoneController => 'list, search']  // Controller und deren cache-fähige Aktionen
    );

    /**
     * Konfiguration des Json Frontend Plugins
     * Analog zum Lexikon Plugin, jedoch für den JsonController.
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MlStonelexicon',
        'Json',
        [$JsonController => 'list'], // Erlaubte Aktionen
        [$JsonController => 'list']  // Cache-fähige Aktionen
    );
    
    /**
     * Hinzufügen von PageTS für BackendLayouts
     * Inkludiert eine TypoScript-Konfigurationsdatei für Backend Layouts.
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import \'EXT:ml_stonelexicon/Configuration/TsConfig/Page/Mod/WebLayout/BackendLayouts.tsconfig\''
    );
});

    /**
     * Einbindung des Haupt-Setup-TypoScripts für die Extension.
     * 
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '@import \'EXT:ml_stonelexicon/Configuration/TypoScript/setup.typoscript\''
    );

    // Icons.php oder in Ihrer ext_localconf.php
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'apps-pagetree-mlstonelexicon', // Der eindeutige Identifier des Icons
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:ml_stonelexicon/Resources/Public/Icons/BackendLayouts/diamant.svg']
    );    