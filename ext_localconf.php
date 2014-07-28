<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

// --- Get extension configuration ---
$extConf = array();
if ( strlen($_EXTCONF) ) {
	$extConf = unserialize($_EXTCONF);
}


// ------------------------------------
// Add Video Content Type
//
// Configure plugin as content element
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Simplicity.' . $_EXTKEY,
	'VideoContent',
	array('VideoContent' => 'show',),
	// non-cacheable actions
	array(),
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// ------------------------------------
// Default videoce page TSconfig
//
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:videoce/Configuration/TypoScript/tsconfig.ts">');
?>