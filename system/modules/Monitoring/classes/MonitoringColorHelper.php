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
 * Class MonitoringColorHelper
 *
 * Class for handling the colors;
 * @copyright  Cliff Parnitzky 2019-2019
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class MonitoringColorHelper extends \System {
  
  const COLOR_STATUS_OKAY_KEY = "monitoringColorStatusOkay";
  const COLOR_STATUS_OKAY_VALUE = "3e9a3c";
  const COLOR_STATUS_INCOMPLETE_KEY = "monitoringColorStatusIncomplete";
  const COLOR_STATUS_INCOMPLETE_VALUE = "d6b400";
  const COLOR_STATUS_ERROR_KEY = "monitoringColorStatusError";
  const COLOR_STATUS_ERROR_VALUE = "d30000";

  /**
   * Generate a default value for status color `Okay`.
   * @param mixed
   * @param object
   * @return string
   */
  public static function generateDefaultColorStatusOkay($varValue, \DataContainer $dc)
  {
    if (strlen($varValue) == 0)
    {
      $varValue = self::COLOR_STATUS_OKAY_VALUE;
      \Config::persist(self::COLOR_STATUS_OKAY_KEY, $varValue);
    }
    return $varValue;
  }
  
  /**
   * Generate a default value for status color `Incomplete`.
   * @param mixed
   * @param object
   * @return string
   */
  public static function generateDefaultColorStatusIncomplete($varValue, \DataContainer $dc)
  {
    if (strlen($varValue) == 0)
    {
      $varValue = self::COLOR_STATUS_INCOMPLETE_VALUE;
      \Config::persist(self::COLOR_STATUS_INCOMPLETE_KEY, $varValue);
    }
    return $varValue;
  }
  
  /**
   * Generate a default value for status color `Error`.
   * @param mixed
   * @param object
   * @return string
   */
  public static function generateDefaultColorStatusError($varValue, \DataContainer $dc)
  {
    if (strlen($varValue) == 0)
    {
      $varValue = self::COLOR_STATUS_ERROR_VALUE;
      \Config::persist(self::COLOR_STATUS_ERROR_KEY, $varValue);
    }
    return $varValue;
  }
  
  /**
   * Return the color for status `Okay`.
   * @param mixed
   * @param object
   * @return string
   */
  public static function getColorStatusOkay()
  {
    $color = \Config::get(self::COLOR_STATUS_OKAY_KEY);
    if (empty($color))
    {
      return self::COLOR_STATUS_OKAY_VALUE;
    }
    return $color;
  }
  
  /**
   * Return the color for status `Incomplete`.
   * @param mixed
   * @param object
   * @return string
   */
  public static function getColorStatusIncomplete()
  {
    $color = \Config::get(self::COLOR_STATUS_INCOMPLETE_KEY);
    if (empty($color))
    {
      return self::COLOR_STATUS_INCOMPLETE_VALUE;
    }
    return $color;
  }
  
  /**
   * Return the color for status `Error`.
   * @param mixed
   * @param object
   * @return string
   */
  public static function getColorStatusError()
  {
    $color = \Config::get(self::COLOR_STATUS_ERROR_KEY);
    if (empty($color))
    {
      return self::COLOR_STATUS_ERROR_VALUE;
    }
    return $color;
  }
}

?>