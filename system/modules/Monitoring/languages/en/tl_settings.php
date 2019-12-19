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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['monitoringMailingActive']         = array('Activate mailing', 'Select if mailing should be active.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdminEmail']            = array('Monitoring admin email', 'The email address of the monitoring admin.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringErrorNotification']     = array('Error notification', 'Please select the notification to be send, if a check fails.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAgainOkayNotification'] = array('Again okay notification', 'Please select the notification to be send, if an erroneous check is again okay.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringTestCirculation']       = array('Test circulation', 'Select how often the test should be repeated if it fails.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringTestCirculationDelay']  = array('Test circulation delay', 'Select how many seconds should elapse between the test cycles.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringDebugMode']             = array('Enable debug mode', 'If the debug mode is enabled, additional information will be logged in the system log.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringColorStatusOkay']       = array('Color for status <i>Okay</i>', 'Define the color to be used for displaing the status <i>Okay</i>.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringColorStatusIncomplete'] = array('Color for status <i>Incomplete</i>', 'Define the color to be used for displaing the status <i>Incomplete</i>.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringColorStatusError']      = array('Color for status <i>Error</i>', 'Define the color to be used for displaing the status <i>Error</i>.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_settings']['monitoring_legend'] = 'Monitoring';

?>