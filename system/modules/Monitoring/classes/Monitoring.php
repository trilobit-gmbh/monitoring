<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    Monitoring
 * @license    LGPL
 * @filesource [eS_Webcheck] by Patrick Froch
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Monitoring;

/**
 * Class Monitoring
 *
 * Read the text from the given url and compare with test string.
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class Monitoring extends \Backend
{
    const STATUS_OKAY       = 'OKAY';
    const STATUS_ERROR      = 'ERROR';
    const STATUS_INCOMPLETE = 'INCOMPLETE';
    const STATUS_UNTESTED   = 'UNTESTED';
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executes a check
     */
    public function checkOne ()
    {
        $this->checkSingle(\Input::get('id'));
        $this->returnToList(\Input::get('do'));
    }


    /**
     * Check all monitoring entries
     */
    public function checkAll ()
    {
        $this->checkMultiple();
        $this->returnToList(\Input::get('do'));
    }

    /**
     * Check all monitoring entries triggered by cron
     */
    public function checkScheduled ()
    {
        $blnNoErrors = $this->checkMultiple();
        if (!$blnNoErrors)
        {
            $errorMsg = "Scheduled monitoring check ended with errors.\n\nThe following ckecks ended erroneous:\n\n" . $this->getErroneousCheckEntriesAsString();
            $this->log($errorMsg, 'Monitoring checkScheduled()', TL_ERROR);
            if ($GLOBALS['TL_CONFIG']['monitoringMailingActive'] && $GLOBALS['TL_CONFIG']['monitoringAdminEmail'] != '')
            {
                $this->log('Send email to monitoring admin with error report after erroneous check.', 'Monitoring checkScheduled()', TL_CRON);
                $objEmail = new \Email();
                $objEmail->subject = "Montoring errors detected";
                $objEmail->text = $errorMsg . "\n\nPlease check your system for further information: " . \Environment::get('base') . "contao\n\nThis is an automatically generated email by Contao extension [Monitoring].";
                $objEmail->sendTo($GLOBALS['TL_CONFIG']['monitoringAdminEmail']); 
            }
            else
            {
                $this->log('No email send ... check monitoring settings.', 'Monitoring checkScheduled()', TL_GENERAL);
            }
        }
    }

    /**
     * Executes a check
     */
    private function checkSingle ($id)
    {
        $data = $this->loadMonitoringEntry($id);

        if($data)
        {
            $url = $this->valString($data['url'], false);
            $testString = $this->valString($data['test_string'], true);
            $responseString = $this->loadSite($url);

            $arrSet['date']            = date('d.m.Y');
            $arrSet['time']            = date('H:i:s');
            $arrSet['response_string'] = substr($responseString, 0, 255);
            $arrSet['status']          = $this->compareSite($responseString, $testString);

            $this->saveMonitoringEntry($id, $arrSet);
            
            return ($arrSet['status'] == self::STATUS_OKAY);
        }
        // no data, no test ... no error !!!
        return true;
    }

    /**
     * Check all monitoring entries
     */
    private function checkMultiple ()
    {
        $blnNoErrors = true;
        $result = $this->Database->prepare("SELECT id FROM tl_monitoring WHERE disable = ''")
                                 ->execute();
        
        while($result->next())
        {
            $id = $result->id;
            if (!$this->checkSingle($id))
            {
                $blnNoErrors = false;
            }
        }
        return $blnNoErrors;
    }
    
    /**
     * Return the list of erroneous check entries
     */
    private function getErroneousCheckEntries ()
    {
        $result = $this->Database->prepare("SELECT * FROM tl_monitoring WHERE disable = '' AND (status = 'ERROR' OR status = 'INCOMPLETE')")
                                 ->execute();
        
        return $result->fetchAllAssoc();
    }
    
    /**
     * Return the list of erroneous check entries as string
     */
    private function getErroneousCheckEntriesAsString ()
    {
        $strReturn = '';
        foreach ($this->getErroneousCheckEntries() as $entry)
        {
            $strReturn .= "- " . $entry['customer'] . " " . $entry['website'] . " " . $entry['system'] . " (" . $entry['status'] . ")\n";
        }
        
        return $strReturn;
    }
    
    /**
     * Save data of entry to database
     */
    private function saveMonitoringEntry ($id, $arrSet)
    {
        $this->Database->prepare("UPDATE tl_monitoring %s WHERE id=?")
                       ->set($arrSet)
                       ->execute($id); 
    }

    /**
     * Load entry from database
     */
    private function loadMonitoringEntry ($id)
    {
        $result = $this->Database->prepare('SELECT * FROM tl_monitoring WHERE id = ?')
                                 ->execute($id);
        if($result)
        {
            return $result->fetchAssoc();
        }
        return false;
    }

    /**
     * Load the url and return the response text
     */
    private function loadSite ($url)
    {
        if(substr_count($url, 'http://') == 0)
        {
            $url = 'http://' . $url;
        }

        if($responseText = @file_get_contents($url))
        {
            return $this->valString($responseText, true);
        }
        return false;
    }

    /**
     * Check the test string against the server response
     */
    private function compareSite ($source, $search)
    {
        if($source != '' AND $search != '')
        {
            if(substr_count($source, $search) != 0)
            {
                return self::STATUS_OKAY;
            }
            else
            {
                return self::STATUS_INCOMPLETE;
            }
        }
        return self::STATUS_ERROR;
    }

    /**
     * Validate the given string.
     */
    private function valString ($str, $toLower)
    {
        if ($toLower)
        {
            $str = strtolower($str);
        }
        $str = strip_tags($str);
        $str = str_replace(' ', '', $str);
        $str = str_replace("\n", '', $str);
        $str = \String::decodeEntities($str);

        return $str;
    }

    /**
     * Redirect to the list.
     */
    private function returnToList ($act)
    {
        $path = \Environment::get('base') . 'contao/main.php?do=' . $act;
        $this->redirect($path, 301);
    }
}
?>
