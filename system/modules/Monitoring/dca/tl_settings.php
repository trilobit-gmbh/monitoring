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
 */

/**
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'monitoringMailingActive';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{monitoring_legend},monitoringMailingActive,monitoringTestCirculation,monitoringTestCirculationDelay,monitoringDebugMode,monitoringColorStatusOkay,monitoringColorStatusIncomplete,monitoringColorStatusError';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['monitoringMailingActive'] = 'monitoringAdminEmail,monitoringErrorNotification,monitoringAgainOkayNotification'; 

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringMailingActive'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringMailingActive'],
  'inputType'               => 'checkbox',
  'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringAdminEmail'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringAdminEmail'],
  'inputType'               => 'text',
  'eval'                    => array('mandatory'=>true, 'rgxp'=>'email', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringErrorNotification'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringErrorNotification'],
  'inputType'               => 'select',
  'foreignKey'              => 'tl_nc_notification.title',
  'options_callback'        => array('MonitoringMailSender', 'getErrorNotificationChoices'),
  'eval'                    => array('chosen'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50 clr')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringAgainOkayNotification'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringAgainOkayNotification'],
  'inputType'               => 'select',
  'foreignKey'              => 'tl_nc_notification.title',
  'options_callback'        => array('MonitoringMailSender', 'getAgainOkayNotificationChoices'),
  'eval'                    => array('chosen'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringTestCirculation'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringTestCirculation'],
  'inputType'               => 'select',
  'default'                 => \Monitoring::TEST_CIRCULATION,
  'options'                 => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
  'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50 clr'),
  'load_callback'           => array(array('tl_settings_Monitoring', 'generateDefaultTestCirculation'))
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringTestCirculationDelay'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringTestCirculationDelay'],
  'default'                 => \Monitoring::TEST_CIRCULATION_DELAY,
  'inputType'               => 'text',
  'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50', 'minlength'=>1, 'maxlength'=>2, 'rgxp'=>'digit'),
  'load_callback'           => array(array('tl_settings_Monitoring', 'generateDefaultTestCirculationDelay'))
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringDebugMode'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringDebugMode'],
  'inputType'               => 'checkbox',
  'eval'                    => array('tl_class'=>'w50 m12 clr')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringColorStatusOkay'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringColorStatusOkay'],
  'inputType'               => 'text',
  'eval'                    => array('maxlength'=>6, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'clr w50 wizard'),
  'load_callback'           => array(array('MonitoringColorHelper', 'generateDefaultColorStatusOkay'))
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringColorStatusIncomplete'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringColorStatusIncomplete'],
  'inputType'               => 'text',
  'eval'                    => array('maxlength'=>6, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
  'load_callback'           => array(array('MonitoringColorHelper', 'generateDefaultColorStatusIncomplete'))
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['monitoringColorStatusError'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['monitoringColorStatusError'],
  'inputType'               => 'text',
  'eval'                    => array('maxlength'=>6, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'),
  'load_callback'           => array(array('MonitoringColorHelper', 'generateDefaultColorStatusError'))
);

/**
 * Class tl_settings_Monitoring
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * PHP version 5
 * @copyright  Cliff Parnitzky 2018-2019
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class tl_settings_Monitoring extends Backend
{
  /**
   * Import the back end user object
   */
  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * Generate a default value for test circulation.
   * @param mixed
   * @param object
   * @return string
   */
  public function generateDefaultTestCirculation($varValue, DataContainer $dc)
  {
    if (strlen($varValue) == 0)
    {
      $varValue = \Monitoring::TEST_CIRCULATION;
      \Config::persist('monitoringTestCirculation', $varValue);
    }
    return $varValue;
  }
  
  /**
   * Generate a default value for test circulation delay.
   * @param mixed
   * @param object
   * @return string
   */
  public function generateDefaultTestCirculationDelay($varValue, DataContainer $dc)
  {
    if (strlen($varValue) == 0)
    {
      $varValue = \Monitoring::TEST_CIRCULATION_DELAY;
      \Config::persist('monitoringTestCirculationDelay', $varValue);
    }
    return $varValue;
  }
}

?>