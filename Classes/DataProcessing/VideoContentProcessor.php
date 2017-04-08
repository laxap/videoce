<?php
namespace Laxap\Videoce\DataProcessing;

/*
 *
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *
 */
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package Videoce
 * @author Pascal Mayer <typo3@bsdist.ch>
 *
 */
class VideoContentProcessor implements DataProcessorInterface {

    /**
     * @var array
     */
    protected $settings = array();

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager = null;

    /**
     * Process data for the content element "My new content element"
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData) {
        // get object manager
        $this->objectManager =  GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        /** @var \TYPO3\CMS\Core\TypoScript\TypoScriptService $tsService */
        $tsService = $this->objectManager->get('TYPO3\CMS\Core\TypoScript\TypoScriptService');
        $tsSettings = $tsService->convertTypoScriptArrayToPlainArray($processorConfiguration);
        if ( isset($tsSettings['settings'])) {
            $this->settings = $tsSettings['settings'];
        }

        // link to platform icon
        $processedData['extLinkIcon'] = $this->settings['default']['extLinkIcon'];
        $processedData['clickEnlargeLinkAttribute'] = $this->settings['clickEnlargeLinkAttribute'];

        $videoObjArray = $this->getVideoObjects($cObj->data['bodytext'], $cObj->data['tx_videoce_caption'], $cObj->data['imagewidth'], $cObj->data['imageheight']);
        if ( $videoObjArray === false ){
            $processedData['videos'] = 0;
            return $processedData;
        }

        if ( $cObj->data['imagecols'] > 1 ) {
            $cols = $cObj->data['imagecols'];
            $colIndex = 0;
            $colsCount = 0;
            $videoColArray = array();
            foreach ( $videoObjArray as $videoObj ) {
                if ( $colsCount == $cols) {
                    $colsCount = 0;
                    $colIndex++;
                }
                $videoColArray[$colIndex][$colsCount] = $videoObj;
                $colsCount++;
            }
            $processedData['videos'] = $videoColArray;
            $processedData['colClass'] = $this->settings['colClasses'][$cols];
            $processedData['rowClass'] = $this->settings['rowClass'];
        } else {
            // no cols
            $processedData['videos'] = $videoObjArray;
            $processedData['colClass'] = 0;
            $processedData['rowClass'] = $this->settings['rowClass'];
        }

        // full data (for cstm templates)
        $processedData['data'] = $cObj->data;

        // add javascript files
        $this->includeJsFiles();

        // return processed data
        return $processedData;
    }


    /** @cond
     * --- internal methods ---
     * @endcond
     */

    /**
     * @param string $links
     * @param string $captions
     * @param int $width
     * @param int $height
     * @return array|bool
     */
    protected function getVideoObjects($links, $captions, $width, $height) {
        if ( trim($links) == '' ) {
            return false;
        }
        $videoLinkArray = explode("\n", trim($links));
        // caption (no trim, to support e.g. first video without caption)
        if ( $captions == '' ) {
            $captionArray = array();
        } else {
            $captionArray = explode("\n", $captions);
        }

        $width = $width?$width:$this->settings['default']['width'];
        $height = $height?$height:$this->settings['default']['height'];

        /** @var \Laxap\Videoce\Domain\Model\ExternalVideo $videoObj */
        $videoObjList = array();
        foreach ( $videoLinkArray as $index => $videoLink ) {
            // get type
            $videoType = \Laxap\Videoce\Domain\Model\ExternalVideo::getVideoType($videoLink, $this->settings['videoTypes']);

            if ( $videoType !== false && $this->settings['videoTypes'][$videoType]['class'] ) {
                // get object based on type class
                $videoObj = $this->objectManager->get($this->settings['videoTypes'][$videoType]['class']);
                if ( ! is_object($videoObj) ) {
                    continue;
                }
                // set default config for video type
                $videoObj->setConfig($this->settings['videoTypes'][$videoType]['config']);
                // init by video link
                if ( ! $videoObj->initByLink($videoLink) ) {
                    continue;
                }
                // set width and height
                $videoObj->setWidth($width);
                $videoObj->setHeight($height);

                // add caption
                if ( isset($captionArray[$index]) ) {
                    $videoObj->setCaption($captionArray[$index]);
                }
                $videoObjList[] = $videoObj;
            }
        }
        return $videoObjList;
    }

    /**
     * @return bool
     */
    protected function includeJsFiles() {
        if ( ! isset($this->settings['jsFiles']) && ! is_array($this->settings['jsFiles']) && count($this->settings['jsFiles']) == 0 ) {
            return false;
        }
        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
        $pageRenderer = $this->objectManager->get(\TYPO3\CMS\Core\Page\PageRenderer::class);

        // add as footer file
        if ( isset($this->settings['jsIncludeAsFooterFile']) && $this->settings['jsIncludeAsFooterFile'] == 1 ) {
            foreach ( $this->settings['jsFiles'] as $jsFile ) {
                $pageRenderer->addJsFooterFile($jsFile);
            }
            return true;
        }
        // add as footer libs
        foreach ( $this->settings['jsFiles'] as $key => $jsFile ) {
            $pageRenderer->addJsFooterLibrary($key, $jsFile);
        }
        return true;
    }

}
?>