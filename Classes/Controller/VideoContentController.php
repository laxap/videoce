<?php
namespace Simplicity\Videoce\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Pascal Mayer <typo3(a)simple.ch>, simplicity gmbh
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @package Videoce
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class VideoContentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	const VIDEO_TYPE_YOUTUBE = 'Youtube';
	const VIDEO_TYPE_VIMEO = 'Vimeo';


	/**
	 * Action show
	 *
	 * @return void
	 */
	public function showAction() {
		// get content object
		$contentObj = $this->configurationManager->getContentObject();
		// initial check
		if ( ! is_object($contentObj) || ! is_array($contentObj->data) ) {
			$this->view->assign('videos', 0);
			return;
		}

		// get content data
		$data = $contentObj->data;
		// check if video links defined
		if ( trim($data['image_link']) == '' ) {
			$this->view->assign('videos', 0);
			return;
		}

		// set pure ts settings
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
			$this->view->assign('spanNum', floor(12 / $cols));
		} else {
			// no cols
			$this->view->assign('videos', $videoObjArray);
			$this->view->assign('spanNum', 0);
		}
		// caption position
		if ( $data['imagecaption_position']  ) {
            $this->view->assign('captionPosition', $data['imagecaption_position']);
		} else {
			$this->view->assign('captionPosition', '');
		}

		// full data
		$this->view->assign('data', $data);

		// add fitvids
		$this->addJsFooterLib('typo3conf/ext/videoce/Resources/Public/Js/jquery.fitvid.js', 'jQueryFitvid');
		$this->addJsFooterLib('typo3conf/ext/videoce/Resources/Public/Js/videoce.js', 'videoce');
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

		/** @var \Simplicity\Videoce\Domain\Model\ExternalVideo $videoObj */
		$videoObjList = array();
		foreach ( $videoLinkArray as $index => $videoLink ) {
			// get type
			$videoType = \Simplicity\Videoce\Domain\Model\ExternalVideo::getVideoType($videoLink, $this->settings['videoTypes']);

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
	 * @param $file
	 * @param string $key
	 * @param bool $excludeFromConcatenation
	 */
	protected function addJsFooterLib($file, $key = '', $excludeFromConcatenation = false) {
		if ( $key == '' ) {
			$key = $this->extensionName;
		}
		$GLOBALS['TSFE']->getPageRenderer()->addJsFooterLibrary($key, $file, 'text/javascript', false, false, '', $excludeFromConcatenation);
	}



}
?>