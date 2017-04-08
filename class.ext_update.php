<?php
namespace Laxap\Videoce;

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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;


/**
 * This class updates videoce from version 0.8.x to 0.9.x
 * @package Videoce
 * @author Pascal Mayer <typo3@bsdist.ch>
 *
 */
class ext_update {

    /** @var \TYPO3\CMS\Core\Database\DatabaseConnection */
    protected $dbCon;

    /**
     * @var string
     */
    protected $dbName = '';

    /**
     * @var string
     */
    protected $tblContent = 'tt_content';

    /**
     * Constructor, assigns dbCon.
     */
    public function __construct() {
        $this->dbCon = $GLOBALS['TYPO3_DB'];
    }

    /**
     * Checks if the script should execute.
     * @return bool
     */
    public function access() {
        if ( ! isset($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname']) ) {
            return false;
        }
        return true;
    }

    /**
     * Runs the update process.
     */
    public function main() {
        $this->dbName = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'];

        $fieldsExist = 0;
        if ( $this->checkIfFieldExist('image_link') ) {
            $fieldsExist++;
            $this->copyField('image_link', 'bodytext');
        }
        if ( $this->checkIfFieldExist('imagecaption') ) {
            $fieldsExist++;
            $this->copyField('imagecaption', 'tx_videoce_caption');
        }
        if ( $fieldsExist == 0 ) {
            return 'The fields image_link and imagecaption do not exist in tt_content. Nothing to copy.';
        }
        return 'Video elements updated!';
    }

    /**
     * @param string $field
     * @return bool
     */
    protected function checkIfFieldExist($field) {
        $ret = $this->dbCon->sql_query("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . $this->dbName . "' AND TABLE_NAME = '" . $this->tblContent . "' AND COLUMN_NAME = '" . $field . "'");
        if ( ! $ret ) {
            return false;
        }
        if ( ! $this->dbCon->sql_fetch_assoc($ret) ) {
            return false;
        }
        return true;
    }

    /**
     * @param string $oldField
     * @param string $newField
     * @return bool
     */
    protected function copyField($oldField, $newField) {
        $ret = $this->dbCon->sql_query("UPDATE " . $this->tblContent . " SET " . $newField . "=" . $oldField . " WHERE CType='videoce_videocontent'");
        return true;
    }
}
?>