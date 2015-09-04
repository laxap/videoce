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
class ExternalVideo extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject  {

	/**
	 * @var string
	 */
	protected $type = '';

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var string
	 */
	protected $videoLink;

	/**
	 * @var \string
	 */
	protected $videoId;

	/**
	 * @var string
	 */
	protected $caption;

	/**
	 * @var int
	 */
	protected $width;

	/**
	 * @var int
	 */
	protected $height;

	/**
	 * @var array
	 */
	protected $videoData;


	/**
	 * Returns the type
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}


	/**
	 * @return array
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param array $config
	 * @return void
	 */
	public function setConfig($config) {
		$this->config = $config;
	}

	/**
	 * @return \string
	 */
	public function getVideoId() {
		return $this->videoId;
	}

	/**
	 * @param \string $videoId
	 * @return void
	 */
	public function setVideoId($videoId) {
		$this->videoId = $videoId;
	}

	/**
	 * Returns the caption
	 * @return string
	 */
	public function getCaption() {
		return $this->caption;
	}

	/**
	 * Sets the caption
	 * @param string $caption
	 * @return void
	 */
	public function setCaption($caption) {
		$this->caption = $caption;
	}

	/**
	 * Returns the videoLink
	 * @return string
	 */
	public function getVideoLink() {
		return $this->videoLink;
	}

	/**
	 * Sets the videoLink
	 * @param string $videoLink
	 * @return void
	 */
	public function setVideoLink($videoLink) {
		$this->videoLink = $videoLink;
	}

	/**
	 * Returns the width
	 * @return int
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * Sets the width
	 * @param int $width
	 * @return void
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * Returns the height
	 * @return int
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * Sets the height
	 * @param int $height
	 * @return void
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * Returns the videoData
	 * @return array
	 */
	public function getVideoData() {
		return $this->videoData;
	}

	/**
	 * Sets the videoData
	 * @param array $videoData
	 * @return void
	 */
	public function setVideoData($videoData) {
		$this->videoData = $videoData;
	}


	/** @cond
	 * --- Special init method (overwritten) ---
	 * @endcond
	 */

	/**
	 * @param $link
	 * @return bool
	 */
	public function initByLink($link) {
		return false;
	}



	/** @cond
	 * --- Output methods ---
	 * @endcond
	 */

	/**
	 * @param string $playlist
	 * @return string
	 */
	public function getEmbedCode($playlist = '') {
		// via videoId (youtube, vimeo)
		$iFrameCode = '<iframe src="' . $this->getIframeSrcUrl($playlist) . '" ';
		$iFrameCode .= ' width="' . $this->getCalculatedWidth()  . '" height="' . $this->getCalculatedHeight()  . '"';
		$iFrameCode .= $this->getIframeAttrib();
		$iFrameCode .= ' ></iframe>';
		return $iFrameCode;
	}

	/**
	 * @param string $playlist
	 * @return string
	 */
	public function getIframeSrcUrl($playlist = '') {
		// get video url
		$videoUrl = $this->config['embed']['url'] . $this->videoId . $this->config['embed']['urlParam'];
		// support playlist in embed player?
		if ( $playlist != '' && $this->config['embed']['urlParamPlaylist'] ) {
			$videoUrl .= $this->config['embed']['urlParamPlaylist'] . $playlist;
		}
		return $videoUrl;
	}

	/**
	 * @return string
	 */
	public function getLinkUrl() {
		if ( $this->config['lightbox']['enabled'] ) {
			return $this->getLightboxLinkUrl();
		}
		return $this->getNormalLinkUrl();
	}

	/**
	 * @return string
	 */
	public function getNormalLinkUrl() {
		$videoUrl = $this->config['link']['url'] . $this->videoId . $this->config['link']['urlParam'];
		return $videoUrl;
	}

	/**
	 * @return string
	 */
	public function getLightboxLinkUrl() {
		$videoUrl = $this->config['lightbox']['url'] . $this->videoId . $this->config['lightbox']['urlParam'];
		return $videoUrl;
	}

	/**
	 * @return mixed
	 */
	public function getIframeAttrib() {
		if ( ! isset($this->config['embed']['iframeAttrib']) ) {
			return '';
		}
		return $this->config['embed']['iframeAttrib'];
	}


	/**
	 * @return int
	 */
	public function getCalculatedWidth() {
		return $this->width;
	}

	/**
	 * @return int
	 */
	public function getCalculatedHeight() {
		return $this->height;
	}


	/**
	 * @param string $link
	 * @return bool
	 */
	protected function retrieveVideoData($link) {
		// get infos from vimeo by sending url
		// proxy problem fix: thanks to Sébastien Convers
		$response = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($this->config['api']['url'] . urlencode($link));
		if ( $response ) {
			$videoData = json_decode($response, true);
			if ( is_array($videoData) ) {
				$this->videoData = $videoData;
				return true;
			}
		}
		return false;
	}


	/** @cond
	 * --- Static methods ---
	 * @endcond
	 */

	/**
	 * @param string $link
	 * @param array $videoTypes
	 * @return boolean|string
	 */
	static public function getVideoType($link, $videoTypes) {
		if ( trim($link) == '' ) {
			return false;
		}
		if ( ! is_array($videoTypes) ) {
			return false;
		}
		foreach ( $videoTypes as $videoType => $videoTypeSettings ) {
			if (preg_match($videoTypeSettings['config']['pattern'], $link)) {
				return $videoType;
			}
		}
		return false;
	}

}