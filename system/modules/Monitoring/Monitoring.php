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
 * Class Monitoring
 *
 * Read the text from the given url and compare with test string.
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class Monitoring extends Backend
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->import('Database');
        $this->import('Input');
        $this->import('String');

        parent::__construct();
    }

    /**
     * Executes a check
     */
    public function run($id)
    {
        // if this is a single check, there will be not id, get it from url
        $goBack = false;
        if(!is_numeric($id))
        {
            $id = \Input::get('id');
            $goBack = true;
        }
        
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
        }
        // only return to list, if the check is a single check
        if($goBack)
        {
            $this->returnToList(\Input::get('do'));
        }
    }


    /**
     * Check all monitoring entries
     */
    public function checkall ()
    {
        $result = $this->Database->prepare('SELECT id FROM tl_monitoring')
                                 ->execute();
        
        while($result->next())
        {
            $id = $result->id;
            $this->run($id);
        }

        $this->returnToList(\Input::get('do'));
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
                return 'OKAY';
            }
            else
            {
                return 'INCOMPLETE';
            }
        }
        return 'ERROR';
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
