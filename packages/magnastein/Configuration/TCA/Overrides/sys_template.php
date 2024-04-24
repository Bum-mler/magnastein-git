<?php
defined('TYPO3') or die('Access denied.');

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function()
{
    /**
     * Temporary variables
     */
    $extensionKey = 'magnastein';

    /**
     * Default TypoScript for Magnastein
     */
    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'magnastein'
    );
});
