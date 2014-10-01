<?php

namespace Simplicity\Videoce\Domain\Model;

/* * *************************************************************
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
 * ************************************************************* */

/**
 * @package Videoce
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class DailymotionVideo extends ExternalVideo {

    /**
     * @var string
     */
    protected $type = 'dailymotion';

    /**
     * @param $link
     * @return bool
     */
    public function initByLink($link)
    {

        // strip the "domain" and "video" parts from $link
        $videoIdPart = preg_replace($this->config['pattern'], '', $link);

        // only by api!
        if ($this->retrieveVideoData($videoIdPart)) {
            if (isset($this->videoData['id'])) {
                $this->videoId = $this->videoData['id'];
                return true;
            }
        }
        return false;
    }

}
