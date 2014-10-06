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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_monitoring']['customer']                    = array('Customer', 'The customer of the website to be monitored.');
$GLOBALS['TL_LANG']['tl_monitoring']['website']                     = array('Website', 'The website to be monitored.');
$GLOBALS['TL_LANG']['tl_monitoring']['system']                      = array('System', 'The system of the website to be monitored.');
$GLOBALS['TL_LANG']['tl_monitoring']['added']                       = array('Created on', 'The creation date of the monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['url']                         = array('URL', 'The adress of the page to be tested. Enter with protocol (e.g. http:// or https://)!');
$GLOBALS['TL_LANG']['tl_monitoring']['test_string']                 = array('Test string', 'The text to searched on the page to be tested (HTML tags will be deleted).');
$GLOBALS['TL_LANG']['tl_monitoring']['disable']                     = array('Deactivate', 'Temporarily disable the monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['last_test_date']              = array('Last test', 'The date of the last test');
$GLOBALS['TL_LANG']['tl_monitoring']['last_test_status']            = array('Last status', 'The status of the last test.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_actuality']   = array('Actuality', 'Specify what is actual and outdated for this monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_contact']     = array('Contact information', 'Specify the data for cantacting someone for this monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_contao']      = array('Contao configuration', 'Specify the data of the Contao configuration for this monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_maintenance'] = array('Maintenance configuration', 'Specify the data for the maintenance of this monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_system']      = array('System configuration', 'Specify the data of the web system for this monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_field']       = array('Field', 'Select a field.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_actual']      = array('Yes or no', 'Specify whether the field condition is true.');
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_value']       = array('Value', 'Enter a value for the field.');


/**
 * Legenden
 */
$GLOBALS['TL_LANG']['tl_monitoring']['website_legend']         = 'Website';
$GLOBALS['TL_LANG']['tl_monitoring']['test_legend']            = 'Test';
$GLOBALS['TL_LANG']['tl_monitoring']['last_test_legend']       = 'Last test result';
$GLOBALS['TL_LANG']['tl_monitoring']['additional_info_legend'] = 'Additional information';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_monitoring']['statusTypes'][Monitoring::STATUS_OKAY]       = array('Okay', 'The Webserver is available and the test string could be checked successfully.');
$GLOBALS['TL_LANG']['tl_monitoring']['statusTypes'][Monitoring::STATUS_INCOMPLETE] = array('Incomplete', 'The webserver is available but the test string could not be checked successfully.');
$GLOBALS['TL_LANG']['tl_monitoring']['statusTypes'][Monitoring::STATUS_ERROR]      = array('Error', 'The webserver is not available.');
$GLOBALS['TL_LANG']['tl_monitoring']['statusTypes'][Monitoring::STATUS_UNTESTED]   = array('Untested', 'The webserver was not yet tested.');

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_monitoring']['new']        = array('New monitoring entry', 'Create a new monitoring entry.');
$GLOBALS['TL_LANG']['tl_monitoring']['edit']       = array('Edit monitoring tests', 'Edit the monitoring tests with ID %s.');
$GLOBALS['TL_LANG']['tl_monitoring']['editheader'] = array('Edit monitoring entry', 'Edit the monitoring entry with ID %s.');
$GLOBALS['TL_LANG']['tl_monitoring']['copy']       = array('Copy monitoring entry', 'Copy the monitoring entry with ID %s.');
$GLOBALS['TL_LANG']['tl_monitoring']['delete']     = array('Delete monitoring entry', 'Delete the monitoring entry with ID %s.');
$GLOBALS['TL_LANG']['tl_monitoring']['show']       = array('Show monitoring entry', 'Show infos of monitoring entry with ID %s.');
$GLOBALS['TL_LANG']['tl_monitoring']['open_url']   = array('Open test page', 'Open test page in a new window for monitoring entry with ID %s.');
$GLOBALS['TL_LANG']['tl_monitoring']['check']      = array('Check server', 'Check server for monitoring entry with ID %s.');
$GLOBALS['TL_LANG']['tl_monitoring']['checkall']   = array('Check all server', 'Tests the availability of all servers.');
$GLOBALS['TL_LANG']['tl_monitoring']['disabled']   = array('Deactivated monitoring entry', 'A deactivated monitoring entry could not be checked.');

?>