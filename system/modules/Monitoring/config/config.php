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
 * Backend modules
 */
array_insert($GLOBALS['BE_MOD'], array_search('system', array_keys($GLOBALS['BE_MOD'])), array
(
  'ContaoMonitoring' => array
  (
    'monitoring' => array
    (
      'icon'       => 'system/modules/Monitoring/assets/icon_monitoring.png',
      'tables'     => array('tl_monitoring', 'tl_monitoring_test'),
      'stylesheet' => 'system/modules/Monitoring/assets/styles.css',
      'checkOne'   => array('Monitoring', 'checkOne'),
      'checkAll'   => array('Monitoring', 'checkAll')
    )
  )
));

// Load icon in Contao 4.4 backend
if ('BE' === TL_MODE) {
  $GLOBALS['TL_CSS'][] = 'system/modules/Monitoring/assets/backend_svg.css';
}

/**
 * Cron
 */
// Hourly cron job to check all server
$GLOBALS['TL_CRON']['hourly'][] = array('Monitoring', 'checkScheduled');

/**
 * Hooks
 */
// Adding HOOK to customize backend template
$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array('MonitoringHookImpl', 'outputTemplate');

/**
 * Global names
 */
$GLOBALS['TL_CONFIG']['MONITORING_AGENT_NAME'] = "ContaoMonitoringClient";

/**
 * Notification Center Notification Types
 */
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['ContaoMonitoring']['ErrorNotification'] = array(
  'recipients'          => array('admin_email','customer_email','user_email','creator_email'),
  'email_recipient_cc'  => array('admin_email','customer_email','user_email','creator_email'),
  'email_recipient_bcc' => array('admin_email','customer_email','user_email','creator_email'),
  'email_replyTo'       => array('admin_email','user_email','creator_email'),
  'email_subject'       => array('customer_*', 'order_*'),
  'email_text'          => array('customer_*', 'order_*', 'order_positions_text', 'order_total'),
  'email_html'          => array('customer_*', 'order_*', 'order_positions_html', 'order_total')
);
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['ContaoMonitoring']['AgainOkayNotification'] = array(
  'recipients'          => array('admin_email','customer_email','user_email','creator_email'),
  'email_recipient_cc'  => array('admin_email','customer_email','user_email','creator_email'),
  'email_recipient_bcc' => array('admin_email','customer_email','user_email','creator_email'),
  'email_replyTo'       => array('admin_email','user_email','creator_email'),
  'email_subject'       => array('customer_*', 'order_*'),
  'email_text'          => array('customer_*', 'order_*', 'order_positions_text', 'order_total'),
  'email_html'          => array('customer_*', 'order_*', 'order_positions_html', 'order_total')
);

?>