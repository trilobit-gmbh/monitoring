<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2019 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2014-2019
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
 * @copyright  Cliff Parnitzky 2014-2019
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class Monitoring extends \Backend
{
  const STATUS_OKAY = 'OKAY';
  const STATUS_INCOMPLETE = 'INCOMPLETE';
  const STATUS_ERROR = 'ERROR';
  const STATUS_UNTESTED = 'UNTESTED';

  const CHECK_TYPE_MANUAL = 'MANUAL';
  const CHECK_TYPE_AUTOMATIC = 'AUTOMATIC';

  const ERROR_MESSAGE_START = "Scheduled monitoring check ended.\n\nThe following checks ended erroneous:\n\n";
  const ERROR_MESSAGE_ENTRY = "- %s %s %s [%s] (%s)\n";
  
  const TEST_CIRCULATION = 1;
  const TEST_CIRCULATION_DELAY = 10;

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
    $this->loadLanguageFile("tl_monitoring");
  }

  /**
   * Executes a check
   */
  public function checkOne()
  {
    $status = $this->checkSingle(\Input::get('id'), self::CHECK_TYPE_MANUAL);
    $this->logDebugMsg("Checking one monitoring entry for ID " . \Input::get('id') . " ended with status: " . $status, __METHOD__);

    $urlParam = \Input::get('do');

    if (\Input::get('table') == "tl_monitoring_test" && \Input::get('id'))
    {
      $urlParam .= "&table=tl_monitoring_test&id=" . \Input::get('id');
    }

    $this->addCheckMessage(\Input::get('id'), $status);

    $this->returnToList($urlParam);
  }

  /**
   * Check all monitoring entries
   */
  public function checkAll()
  {
    $status = $this->checkMultiple(self::CHECK_TYPE_MANUAL, true);
    $this->logDebugMsg("Checking all monitoring entries ended with status: " . $status, __METHOD__);
    $this->returnToList(\Input::get('do'));
  }

  /**
   * Check all monitoring entries triggered by cron
   */
  public function checkScheduled()
  {
    $mailSender = new MonitoringMailSender();
    
    $oldErroneousCheckEntries = $this->removeMailingDeactivatedEntries($this->getErroneousCheckEntries());
    
    $status = $this->checkMultiple(self::CHECK_TYPE_AUTOMATIC);
    $this->logDebugMsg("Scheduled checking all monitoring entries ended with status: " . $status, __METHOD__);
    
    $allErroneousCheckEntries = $this->getErroneousCheckEntries();
    $newErroneousCheckEntries = $this->removeMailingDeactivatedEntries($allErroneousCheckEntries);
    
    // only needed when there where errors detected
    if ($status != self::STATUS_OKAY)
    {
      $errorMsg = self::ERROR_MESSAGE_START . $this->getCheckEntriesAsString($allErroneousCheckEntries);
      $this->log($errorMsg, __METHOD__, TL_ERROR);
      
      if (!empty($newErroneousCheckEntries) && \Config::get('monitoringMailingActive') && \Config::get('monitoringAdminEmail') != '')
      {
        foreach($newErroneousCheckEntries as $entry)
        {
          $mailSender->sendErrorEmail($entry);
        }
        $this->logDebugMsg("Scheduled monitoring check ended. Some checks ended erroneous. The monitoring admin was informed via email (" . \Config::get('monitoringAdminEmail') . ").", __METHOD__);
      }
      else
      {
        $this->logDebugMsg('No "error" email send ... check monitoring settings.', __METHOD__);
      }
    }
    
    // send an email, if previously erroneous checks are okay again
    $againOkayCheckEntries = array_diff_key($oldErroneousCheckEntries, $newErroneousCheckEntries);
    if (!empty($againOkayCheckEntries) && \Config::get('monitoringMailingActive') && \Config::get('monitoringAdminEmail') != '')
    {
      foreach($againOkayCheckEntries as $entry)
      {
        $mailSender->sendAgainOkayEmail($entry);
      }
      $this->logDebugMsg("Scheduled monitoring check ended. Some checks are okay again. The monitoring admin was informed via email (" . \Config::get('monitoringAdminEmail') . ").", __METHOD__);
    }
  }
  
  /**
   * Remove all entries from the array, that have mailing deactivated.
   */
  private function removeMailingDeactivatedEntries($arrEntries)
  {
    return array_filter(
      $arrEntries,
      function ($entry)
      {
        return $entry->disableMailing == "";
      }
    );
  }

  /**
   * Executes a check
   */
  private function checkSingle($id, $checkType)
  {
    $objMonitoringEntry = \MonitoringModel::findByPk($id);

    if ($objMonitoringEntry !== null)
    {
      $status = self::STATUS_UNTESTED;

      //$url = $this->valString($objMonitoringEntry->url, false);
      $testString = $this->valString($objMonitoringEntry->test_string, true);

      $url = $objMonitoringEntry->url;

      $repitition = 0;
      $maxRepititions = \Config::get('monitoringTestCirculation');
      if (!is_int($maxRepititions) || $maxRepititions < 1)
      {
        $maxRepititions = self::TEST_CIRCULATION;
      }

      $delay = \Config::get('monitoringTestCirculationDelay');
      if (!is_int($delay) || $delay < 1 || $delay > 99)
      {
        $delay = self::TEST_CIRCULATION_DELAY;
      }

      $arrSetEntry = array();
      $arrSetTest = array();
      do
      {
        if ($repitition > 0)
        {
          $this->logDebugMsg("Repeating single check for entry with ID " . $id . " because status was: " . $status, __METHOD__);
          sleep($delay);
        }

        $time = time();
        $microtime = microtime(true);

        $responseString = $this->loadSite($url);

        $responseTime = round(microtime(true) - $microtime, 3);

        $status = $this->compareSite($responseString, $testString);
        $repitition++;

        $arrSetEntry['tstamp'] = $time;
        $arrSetEntry['last_test_date'] = $time;
        $arrSetEntry['last_test_status'] = $status;
        $arrSetEntry['last_test_response_time'] = $responseTime;

        $arrSetTest['pid'] = $id;
        $arrSetTest['tstamp'] = $time;
        $arrSetTest['date'] = $time;
        $arrSetTest['type'] = $checkType;
        $arrSetTest['status'] = $status;
        $arrSetTest['response_time'] = $responseTime;
        $arrSetTest['repetitions'] = $repitition;
        $arrSetTest['response_string'] = $responseString; //substr($responseString, 0, 255);

      } while ($status != self::STATUS_OKAY && $repitition < $maxRepititions);


      $this->saveMonitoringEntry($id, $arrSetEntry);
      $this->saveMonitoringTest($arrSetTest);

      $this->logDebugMsg("Returning status for entry with ID " . $id . " after single check is: " . $status, __METHOD__);

      return $status;
    }
    // no data, no test ... no error !!!
    return null;
  }

  /**
   * Check all monitoring entries
   */
  private function checkMultiple($checkType, $blnAddTestMessage=false)
  {
    $status = self::STATUS_UNTESTED;
    $objMonitoringEntry = \MonitoringModel::findAllActive();

    if ($objMonitoringEntry !== null)
    {
        while ($objMonitoringEntry->next())
        {
          $id = $objMonitoringEntry->id;

          $tmpStatus = $this->checkSingle($id, $checkType);
          if ($tmpStatus == self::STATUS_ERROR)
          {
            $status = self::STATUS_ERROR;
          }
          else if ($tmpStatus == self::STATUS_INCOMPLETE && $status != self::STATUS_ERROR)
          {
            $status = self::STATUS_ERROR;
          }
          else if ($tmpStatus == self::STATUS_OKAY && $status != self::STATUS_INCOMPLETE && $status != self::STATUS_ERROR)
          {
              $status = self::STATUS_OKAY;
          }
          $this->logDebugMsg("Multiple checking status after entry ID " . $id . " is: " . $status, __METHOD__);
          if ($blnAddTestMessage)
          {
            $this->addCheckMessage($id, $tmpStatus);
          }
        }
    }
    $this->logDebugMsg("Multiple checking monitoring entries ended with status: " . $status, __METHOD__);
    return $status;
  }

  /**
   * Return the list of erroneous check entries
   */
  private function getErroneousCheckEntries()
  {
    $arrResult = array();
    $objMonitoringEntry = \MonitoringModel::findAllActiveErroneous();

    if ($objMonitoringEntry !== null)
    {
        while ($objMonitoringEntry->next())
        {
          $arrResult[$objMonitoringEntry->id] = $objMonitoringEntry->current();
        }
    }
    
    return $arrResult;
  }

  /**
   * Return the list of erroneous check entries as string
   */
  private function getCheckEntriesAsString($arrErroneousCheckEntries)
  {
    $strReturn = '';
    foreach ($arrErroneousCheckEntries as $key=>$entry)
    {
      $strReturn .= sprintf(self::ERROR_MESSAGE_ENTRY, $entry->customer, $entry->website, $entry->system, $entry->last_test_status, $entry->url);
    }

    return $strReturn;
  }

  /**
   * Save data of entry to database
   */
  private function saveMonitoringEntry($intId, $arrSet)
  {
    \Database::getInstance()->prepare("UPDATE tl_monitoring %s WHERE id=?")
                                ->set($arrSet)
                                ->execute($intId);
  }

  /**
   * Save data of test to database
   */
  private function saveMonitoringTest($arrSet)
  {
    \Database::getInstance()->prepare("INSERT INTO tl_monitoring_test %s")
                                ->set($arrSet)
                                ->execute();
  }

  /**
   * Load the url and return the response text
   */
  private function loadSite($url)
  {
    if ($url != '' && !preg_match('@^https?://@', $url))
    {
      $url = 'http://' . $url;
    }
    
    $opts = array
    (
      'http'=>array
      (
        'user_agent' => \Config::get('MONITORING_AGENT_NAME'),
        'header' => "Content-type: text/html\r\n"
      )
    );
    $context = stream_context_create($opts);

    if ($responseText = @file_get_contents($url, false, $context))
    {
      return $this->valString($responseText, true);
    }
    return false;
  }

  /**
   * Check the test string against the server response
   */
  private function compareSite($source, $search)
  {
    if (!empty($source) && !empty($search))
    {
      if (substr_count($source, $search) != 0)
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
  private function valString($str, $toLower)
  {
    if ($toLower)
    {
      $str = strtolower($str);
    }

    $str = strip_tags($str);
    $str = str_replace(' ', '', $str);
    $str = str_replace(["\n", "\r",], '', $str);
    $str = \StringUtil::decodeEntities($str);

    return trim($str);
  }

  /**
   * Redirect to the list.
   */
  private function returnToList($act)
  {
    $path = \Environment::get('base') . 'contao/main.php?do=' . $act;
    $this->redirect($path, 301);
  }

  /**
   * Logs the given message if the debug mode is anabled.
   */
  private function logDebugMsg($msg, $origin)
  {
    if (\Config::get('monitoringDebugMode') === TRUE)
    {
      $this->log($msg, $origin, TL_GENERAL);
    }
  }

  /**
   * Logs the given message if the debug mode is anabled.
   */
  private function addCheckMessage($intEntryId, $strStatus)
  {
    $this->addRawMessage('<p class="tl_message_monitoring_status monitoring_status_' . strtolower($strStatus) . '">' . sprintf($GLOBALS['TL_LANG']['MSC']['monitoringCheckResult'], $intEntryId, $GLOBALS['TL_LANG']['tl_monitoring']['statusTypes'][$strStatus][0]) . '</p>');
  }
}
?>
