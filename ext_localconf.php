<?php
if (!defined('TYPO3_MODE')) { die('Access denied.'); }

call_user_func(
    function ($extKey) {

        // register icons
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'tx-videocontent-wizard',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/wizard_videocontent.png']
        );
        $iconRegistry->registerIcon(
            'tx-videocontent-plugin',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/plugin_videocontent.png']
        );

        // default videoce page TSconfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:videoce/Configuration/TypoScript/tsconfig.ts">');

    },$_EXTKEY
);
?>