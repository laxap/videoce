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
 * @author Sébastien Convers
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
