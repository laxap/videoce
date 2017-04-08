<?php

// Adds the content element to the "Type" dropdown
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:plugin.videoce_videocontent',
        'videoce_videocontent',
        'tx-videocontent-plugin'
    ],
    'CType',
    'videoce'
);

// show an icon in the page view
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['videoce_videocontent'] = 'tx-videocontent-plugin';

// add field for video caption
$tempColumn = array(
    'tx_videoce_caption' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.caption',
        'config' => array (
            'type' => 'text',
            'cold' => 30,
            'rows' => 6,
            'softref' => 'typolink_tag,images,email[subst],url'
        )
    ),
);
// Add field to tt_content
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumn);

// define palettes
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_size']['showitem'] = 'imagewidth;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.width,imageheight;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.height,image_zoom;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.clickenlarge';
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_size']['canNotCollapse'] = '1';
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_layout']['showitem'] = 'imagecols;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.cols,image_noRows;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.rows';
$GLOBALS['TCA']['tt_content']['palettes']['tx_videoce_layout']['canNotCollapse'] = '1';

// define used fields
$GLOBALS['TCA']['tt_content']['types']['videoce_videocontent']['showitem'] = '
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.header;header,
			--div--;Videos,
				bodytext;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.links,tx_videoce_caption,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
				--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.widthheight;tx_videoce_size,
				--palette--;LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.pal.rowcol;tx_videoce_layout,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.textlayout;textlayout,
			--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
			--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.extended';
