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
	const STATUS_OKAY = 'OKAY';
	const STATUS_INCOMPLETE = 'INCOMPLETE';
	const STATUS_ERROR = 'ERROR';
	const STATUS_UNTESTED = 'UNTESTED';
	
	const CHECK_TYPE_MANUAL = 'MANUAL';
	const CHECK_TYPE_AUTOMATIC = 'AUTOMATIC';

	const EMAIL_SUBJECT = 'Montoring errors detected';
	const EMAIL_MESSAGE_START = "Scheduled monitoring check ended with errors.\n\nThe following checks ended erroneous:\n\n";
	const EMAIL_MESSAGE_ENTRY = "- %s %s %s (%s)\n";
	const EMAIL_MESSAGE_END = "\nPlease check your system for further information: %s\n\nThis is an automatically generated email by Contao extension [Monitoring].";

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
	public function checkOne()
	{
		$this->checkSingle(\Input::get('id'), self::CHECK_TYPE_MANUAL);
		
		$urlParam = \Input::get('do');
		
		if (\Input::get('table') == "tl_monitoring_test" && \Input::get('id'))
		{
			$urlParam .= "&table=tl_monitoring_test&id=" . \Input::get('id');
		}
		
		$this->returnToList($urlParam);
	}

	/**
	 * Check all monitoring entries
	 */
	public function checkAll()
	{
		$this->checkMultiple(self::CHECK_TYPE_MANUAL);
		$this->returnToList(\Input::get('do'));
	}

	/**
	 * Check all monitoring entries triggered by cron
	 */
	public function checkScheduled()
	{
		$blnNoErrors = $this->checkMultiple(self::CHECK_TYPE_AUTOMATIC);
		if (!$blnNoErrors)
		{
			$errorMsg = self::EMAIL_MESSAGE_START . $this->getErroneousCheckEntriesAsString();
			$this->log($errorMsg, __METHOD__, TL_ERROR);
			if ($GLOBALS['TL_CONFIG']['monitoringMailingActive'] && $GLOBALS['TL_CONFIG']['monitoringAdminEmail'] != '')
			{
				$objEmail = new \Email();
				$objEmail->subject = self::EMAIL_SUBJECT;
				$objEmail->text = $errorMsg . sprintf(self::EMAIL_MESSAGE_END, \Environment::get('base') . "contao");
				$objEmail->sendTo($GLOBALS['TL_CONFIG']['monitoringAdminEmail']);
			}
			else
			{
				$this->log('No email send ... check monitoring settings.', __METHOD__, TL_GENERAL);
			}
		}
	}

	/**
	 * Executes a check
	 */
	private function checkSingle($id, $checkType)
	{
		$data = $this->loadMonitoringEntry($id);

		if ($data)
		{
			$status = self::STATUS_UNTESTED;
			
			$url = $this->valString($data['url'], false);
			$testString = $this->valString($data['test_string'], true);
			
			$repitition = 0;
			$maxRepititions = $GLOBALS['TL_CONFIG']['monitoringTestCirculation'];
			if (!is_int($maxRepititions) || $maxRepititions < 1)
			{
				$maxRepititions = 1;
			}
			$delay = $GLOBALS['TL_CONFIG']['monitoringTestCirculationDelay'];
			if (!is_int($delay) || $delay < 1 || $delay > 99)
			{
				$delay = 10;
			}
			
			$arrSetEntry = array();
			$arrSetTest = array();
			do
			{
				if ($repitition > 0)
				{
					sleep($delay);
				}
				
				$responseString = $this->loadSite($url);
				
				$time = time();
				$status = $this->compareSite($responseString, $testString);
				$repitition++;

				$arrSetEntry['tstamp'] = $time;
				$arrSetEntry['last_test_date'] = $time;
				$arrSetEntry['last_test_status'] = $status;
				
				$arrSetTest['pid'] = $id;
				$arrSetTest['tstamp'] = $time;
				$arrSetTest['date'] = $time;
				$arrSetTest['type'] = $checkType;
				$arrSetTest['status'] = $status;
				$arrSetTest['repetitions'] = $repitition;
				$arrSetTest['response_string'] = $responseString; //substr($responseString, 0, 255);
				
			} while ($status != self::STATUS_OKAY && $repitition < $maxRepititions);
			


			$this->saveMonitoringEntry($id, $arrSetEntry);
			$this->saveMonitoringTest($arrSetTest);

			return ($status == self::STATUS_OKAY);
		}
		// no data, no test ... no error !!!
		return true;
	}

	/**
	 * Check all monitoring entries
	 */
	private function checkMultiple($checkType)
	{
		$blnNoErrors = true;
		$result = $this->Database->prepare("SELECT id FROM tl_monitoring WHERE disable = ''")
								 ->execute();

		while ($result->next())
		{
			$id = $result->id;
			if (!$this->checkSingle($id, $checkType))
			{
				$blnNoErrors = false;
			}
		}
		return $blnNoErrors;
	}

	/**
	 * Return the list of erroneous check entries
	 */
	private function getErroneousCheckEntries()
	{
		$result = $this->Database->prepare("SELECT * FROM tl_monitoring WHERE disable = '' AND (status = 'ERROR' OR status = 'INCOMPLETE')")
								 ->execute();

		return $result->fetchAllAssoc();
	}

	/**
	 * Return the list of erroneous check entries as string
	 */
	private function getErroneousCheckEntriesAsString()
	{
		$strReturn = '';
		foreach ($this->getErroneousCheckEntries() as $entry)
		{
			$strReturn .= sprintf(self::EMAIL_MESSAGE_ENTRY, $entry['customer'], $entry['website'], $entry['system'], $entry['status']);
		}

		return $strReturn;
	}

	/**
	 * Save data of entry to database
	 */
	private function saveMonitoringEntry($intId, $arrSet)
	{
		$this->Database->prepare("UPDATE tl_monitoring %s WHERE id=?")
					   ->set($arrSet)
					   ->execute($intId);
					   
		$this->createNewVersion('tl_monitoring', $intId);
	}

	/**
	 * Save data of test to database
	 */
	private function saveMonitoringTest($arrSet)
	{
		$this->Database->prepare("INSERT INTO tl_monitoring_test %s")
					   ->set($arrSet)
					   ->execute();
	}

	/**
	 * Load entry from database
	 */
	private function loadMonitoringEntry($id)
	{
		$result = $this->Database->prepare('SELECT * FROM tl_monitoring WHERE id = ?')
								 ->execute($id);
		if ($result)
		{
			return $result->fetchAssoc();
		}
		return false;
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

		if ($responseText = @file_get_contents($url))
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
		if ($source != '' AND $search != '')
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
		$str = str_replace("\n", '', $str);
		$str = \String::decodeEntities($str);

		return $str;
	}

	/**
	 * Redirect to the list.
	 */
	private function returnToList($act)
	{
		$path = \Environment::get('base') . 'contao/main.php?do=' . $act;
		$this->redirect($path, 301);
	}
}
?>
