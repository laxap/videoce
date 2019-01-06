<?php
namespace Laxap\Videoce\Domain\Model;

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

/**
 * @package Videoce
 * @author Pascal Mayer <typo3@lascap.ch>
 *
 */
class YoutubeVideo extends ExternalVideo  {

	/**
	 * @var string
	 */
	protected $type = 'youtube';



	/**
	 * @param $link
	 * @return bool
	 */
	public function initByLink($link) {
		$matches = array();
		preg_match($this->config['pattern'], $link, $matches);
		if (isset($matches[1])) {
			$this->videoId = $matches[1];
			return true;
		}
		return false;
	}
}