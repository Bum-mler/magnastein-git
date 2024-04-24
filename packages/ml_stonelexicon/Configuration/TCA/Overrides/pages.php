<?php

declare(strict_types=1);

defined('TYPO3') or die();

// Configuration/TCA/Overrides/pages.php


call_user_func(function () {
    $localCustomDoktype = 169;  // Lokale Definition
    $iconIdentifier = 'apps-pagetree-mlstonelexicon';

    // Registrierung des Icons für den neuen Doktype
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$localCustomDoktype] = $iconIdentifier;

    // PageTS-Konfiguration für den neuen Doktype
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        "mod {
            web_layout {
                doktypeIcon {
                    {$localCustomDoktype} = '{$iconIdentifier}'
                }
            }
        }"
    );

    // Benutzerdefinierte Drag Area im Page Tree für den neuen Doktype
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
        'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $localCustomDoktype . ')'
    );
});
