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
	'Laxap.' . $_EXTKEY,
	'VideoContent',
	'Video (Youtube, Vimeo, Dailymotion)',
	$pluginIcon
);

// create plugin sig key
$pluginSignature = str_replace('_','',$_EXTKEY) . '_videocontent';

// show an icon in the page view
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('tt_content', $pluginSignature, $pluginIcon);


// Redefine non-existing fields in TYPO3 >= 7.2
if ( TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 7002000 ) {
	$tempColumn = array(
		'image_link' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:tt_content.image_link',
			'config' => array (
				'type' => 'text',
				'cold' => 30,
				'rows' => 3,
			)
		),
		'imagecaption' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:tt_content.imagecaption',
			'config' => array (
				'type' => 'text',
				'cold' => 30,
				'rows' => 3,
				'softref' => 'typolink_tag,images,email[subst],url'
			)
		),
	);

	if ( TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 7004000 ) {
		$tempColumn['imagecaption_position'] = array(
			'label' => 'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:tt_content.imagecaption_position',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array(
						'LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
						''
					),
					array(
						'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:tt_content.imagecaption_position.I.1',
						'center'
					),
					array(
						'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:tt_content.imagecaption_position.I.2',
						'right'
					),
					array(
						'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:tt_content.imagecaption_position.I.3',
						'left'
					)
				),
				'default' => ''
			)
		);
	}

	// Add field to tt_content
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumn, 1);
}


// define palettes
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_size']['showitem'] = 'imagewidth;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.width,imageheight;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.height,image_zoom;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.clickenlarge';
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_size']['canNotCollapse'] = '1';
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_layout']['showitem'] = 'imagecols;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.cols,image_noRows;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.rows';
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_layout']['canNotCollapse'] = '1';

// define used fields
if ( TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 7004000 ) {
	// EXT:frontend vs EXT:cms
	$GLOBALS['TCA']['tt_content']['types'][$pluginSignature]['showitem'] = '
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
			--div--;Videos,
				image_link,imagecaption,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
				imagecaption_position,
				--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.widthheight;tx_videoce_size,
				--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.rowcol;tx_videoce_layout,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.textlayout;textlayout,
			--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
			--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended';
} else {
	$GLOBALS['TCA']['tt_content']['types'][$pluginSignature]['showitem'] = '
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.header;header,
			--div--;Videos,
				image_link,imagecaption,
            --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance,
				imagecaption_position,
				--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.widthheight;tx_videoce_size,
				--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.rowcol;tx_videoce_layout,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.textlayout;textlayout,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
				--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended';
}

?>