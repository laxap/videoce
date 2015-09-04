<?php
namespace Laxap\Videoce\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * @package Videoce
 * @author Pascal Mayer <typo3@bsdist.ch>
 *
 */
class VideoContentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {


	/**
	 * @return void
	 */
	public function showAction() {
		// get content data
		$data = $this->getContentObjectData();
		if ( $data === false ) {
			$this->view->assign('videos', 0);
			return;
		}

		// link to platform icon
		$this->view->assign('extLinkIcon',$this->settings['default']['extLinkIcon']);

		$videoObjArray = $this->getVideoObjects($data['image_link'], $data['imagecaption'], $data['imagewidth'], $data['imageheight']);
		if ( $videoObjArray === false ){
			$this->view->assign('videos', 0);
			return;
		}

		if ( $data['imagecols'] > 1 ) {
			$cols = $data['imagecols'];
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
			$this->view->assign('videos', $videoColArray);
			$this->view->assign('colClass', $this->settings['colClasses'][$cols]);
			$this->view->assign('rowClass', $this->settings['rowClass']);
		} else {
			// no cols
			$this->view->assign('videos', $videoObjArray);
			$this->view->assign('colClass', 0);
			$this->view->assign('rowClass', $this->settings['rowClass']);
		}
		// caption position
		if ( $data['imagecaption_position']  ) {
            $this->view->assign('captionPosition', $data['imagecaption_position']);
		} else {
			$this->view->assign('captionPosition', '');
		}

		// full data (for cstm templates)
		$this->view->assign('data', $data);

		// add javascript files
		$this->includeJsFiles();
	}


	/** @cond
	 * --- internal methods ---
	 * @endcond
	 */
	
	/**
	 * @return array|bool
	 */
	protected function getContentObjectData() {
		// get content object
		$contentObj = $this->configurationManager->getContentObject();
		if ( ! is_object($contentObj) ) {
			return false;
		}
		// check if video links set
		if ( ! is_array($contentObj->data) || trim($contentObj->data['image_link']) == '' ) {
			return false;
		}
		return $contentObj->data;
	}

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
		// add as footer file
		if ( isset($this->settings['jsIncludeAsFooterFile']) && $this->settings['jsIncludeAsFooterFile'] == 1 ) {
			foreach ( $this->settings['jsFiles'] as $jsFile ) {
				$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($jsFile);
			}
			return true;
		}
		// add as footer libs
		foreach ( $this->settings['jsFiles'] as $key => $jsFile ) {
			$GLOBALS['TSFE']->getPageRenderer()->addJsFooterLibrary($key, $jsFile);
		}
		return true;
	}

}
?>