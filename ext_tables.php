<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

// --- Get extension configuration ---
$extConf = array();
if ( strlen($_EXTCONF) ) {
	$extConf = unserialize($_EXTCONF);
}

// Add static typoscript configurations
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Video CE (Youtube, Vimeo)');

// --------------------------------------------------------------------
// Additional Video Content Type
//
// register plugin, with icon
$pluginIcon = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/plugin_videocontent.png';
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Simplicity.' . $_EXTKEY,
	'VideoContent',
	'Video (Youtube, Vimeo, Dailymotion)',
	$pluginIcon
);

// create plugin sig key
$pluginSignature = str_replace('_','',$_EXTKEY) . '_videocontent';

// show an icon in the page view
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('tt_content', $pluginSignature, $pluginIcon);

// define palettes
$TCA['tt_content']['palettes']['tx_videoce_size']['showitem'] = 'imagewidth;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.width,imageheight;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.height,image_zoom;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.clickenlarge';
$TCA['tt_content']['palettes']['tx_videoce_size']['canNotCollapse'] = '1';
$TCA['tt_content']['palettes']['tx_videoce_layout']['showitem'] = 'imagecols;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.cols,image_noRows;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.rows';
$TCA['tt_content']['palettes']['tx_videoce_layout']['canNotCollapse'] = '1';

// define used fields
$TCA['tt_content']['types'][$pluginSignature]['showitem'] = '
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.header;header,
			--div--;Videos,
				image_link,imagecaption,imagecaption_position,--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.widthheight;tx_videoce_size,--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.rowcol;tx_videoce_layout,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.textlayout;textlayout,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended';

?>