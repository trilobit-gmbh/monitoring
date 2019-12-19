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
 * Class MonitoringHookImpl
 *
 * Customize the backend.
 * @copyright  Cliff Parnitzky 2019-2019
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class MonitoringHookImpl extends \System {
  
  /**
   * Add the customizations
   */
  public function outputTemplate($strContent, $strTemplate)
  {
    if ($strTemplate == 'be_main')
    {
      $strContent = $this->addCssColors($strContent);
    }
    return $strContent;
  }
  
  /**
   * Add the special CSS colors
   */
  private function addCssColors($strContent)
  {
    return str_replace("</head>",
                       "<style>.monitoring_status_okay{background-color: #"
                       . MonitoringColorHelper::getColorStatusOkay()
                       . ";} .monitoring_status_incomplete{background-color: #"
                       . MonitoringColorHelper::getColorStatusIncomplete()
                       . ";} .monitoring_status_error{background-color: #"
                       . MonitoringColorHelper::getColorStatusError()
                       . ";}</style></head>", $strContent);
  }
}

?>