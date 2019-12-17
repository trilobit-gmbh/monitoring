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
 * @copyright  Cliff Parnitzky 2019-2019
 * @author     Cliff Parnitzky
 * @package    Monitoring
 * @license    LGPL
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Monitoring;

/**
 * Class MonitoringMailSender
 *
 * Send mails for different status.
 * @copyright  Cliff Parnitzky 2019-2019
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class MonitoringMailSender extends \Backend
{

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();
    $this->loadLanguageFile("tl_monitoring");
  }

  /**
   * Get notification choices for error notification
   *
   * @return array
   */
  public function getErrorNotificationChoices()
  {
    return $this->getNotificationChoices('ErrorNotification');
  }

  /**
   * Get notification choices for again okay notification
   *
   * @return array
   */
  public function getAgainOkayNotificationChoices()
  {
    return $this->getNotificationChoices('AgainOkayNotification');
  }

  /**
   * Get notification choices for given type
   *
   * @return array
   */
  private function getNotificationChoices($strType)
  {
    $arrChoices = array();
    $objNotifications = \Database::getInstance()->prepare("SELECT id,title FROM tl_nc_notification WHERE type=? ORDER BY title")
                                                ->execute($strType);
    while ($objNotifications->next())
    {
      $arrChoices[$objNotifications->id] = $objNotifications->title;
    }
    return $arrChoices;
  }

}
?>
