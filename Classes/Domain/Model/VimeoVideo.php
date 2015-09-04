<?php
namespace Laxap\Videoce\Domain\Model;

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
class VimeoVideo extends ExternalVideo  {

	/**
	 * @var string
	 */
	protected $type = 'vimeo';

	/**
	 * @return int
	 */
	public function getCalculatedWidth() {
		if ( $this->config['respectAspectRatio'] !== 'width') {
			return $this->width;
		}
		// check aspect ratio
		if ( $this->videoData['width'] > 0 && $this->videoData['height'] > 0 ) {
			$origRatio = $this->videoData['width'] / $this->videoData['height'];
			$ratio = $this->width / $this->height;
			if ( $origRatio != $ratio ) {
				return (int)($this->height * $origRatio);
			}
		}
		return $this->width;
	}

	/**
	 * @return int
	 */
	public function getCalculatedHeight() {
		if ( $this->config['respectAspectRatio'] !== 'height') {
			return $this->height;
		}
		// check aspect ratio
		if ( $this->videoData['width'] > 0 && $this->videoData['height'] > 0 ) {
			$origRatio = $this->videoData['width'] / $this->videoData['height'];
			$ratio = $this->width / $this->height;
			if ( $origRatio != $ratio ) {
				return (int)($this->width / $origRatio);
			}
		}
		return $this->height;
	}


	/**
	 * @param $link
	 * @return bool
	 */
	public function initByLink($link) {
		// only by api!
		if ( $this->retrieveVideoData($link) ) {
			if ( isset($this->videoData['video_id']) ) {
				$this->videoId = $this->videoData['video_id'];
				return true;
			}
		}
		return false;
	}

}