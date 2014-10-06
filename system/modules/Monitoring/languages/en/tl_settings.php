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
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['monitoringMailingActive']                = array('Activate mailing', 'Select if mailing should be active.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdminEmail']                   = array('Monitoring admin email', 'The email address aof the monitoring admin.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringTestCirculation']              = array('Test circulation', 'Select how often the test should be repeated if it fails.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringTestCirculationDelay']         = array('Test circulation delay', 'Select how many seconds should elapse between the test cycles.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringDebugMode']                    = array('Enable debug mode', 'If the debug mode is enabled, additional information will be logged in the system log.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFields']         = array('Additional info fields', 'Define additional info fields which should be available for the monitoring entries.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFieldsCategory'] = array('Category', 'The category, the field should appear.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFieldsName']     = array('Field name', 'The name of the field.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_settings']['monitoring_legend'] = 'Monitoring';

/**
 * Options
 */
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFieldsCategoryOptions'][AdditionalInfoField::CATEGORY_ACTUALITY]   = array('Actuality', 'Fields in this category will be shown as <u>checkboxes</u>. They are used to define if something is actual or outdated.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFieldsCategoryOptions'][AdditionalInfoField::CATEGORY_CONTACT]     = array('Contact information', 'Fields in this category will be shown as <u>text fields</u>. They are used to define data for contacting someone.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFieldsCategoryOptions'][AdditionalInfoField::CATEGORY_CONTAO]      = array('Contao configuration', 'Fields in this category will be shown as <u>text fields</u>. They are used to define Contao configuration data.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFieldsCategoryOptions'][AdditionalInfoField::CATEGORY_MAINTENANCE] = array('Maintenance configuration', 'Fields in this category will be shown as <u>checkboxes</u>. They are used to define maintenance data.');
$GLOBALS['TL_LANG']['tl_settings']['monitoringAdditionalInfoFieldsCategoryOptions'][AdditionalInfoField::CATEGORY_SYSTEM]      = array('System configuration', 'Fields in this category will be shown as <u>text fields</u>. They are used to define data of the web system.');

?>