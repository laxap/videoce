<?php
namespace Simplicity\Videoce\Domain\Model;

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