<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Monitoring',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Monitoring\Monitoring'            => 'system/modules/Monitoring/classes/Monitoring.php',
	'Monitoring\MonitoringColorHelper' => 'system/modules/Monitoring/classes/MonitoringColorHelper.php',
	'Monitoring\MonitoringHookImpl'    => 'system/modules/Monitoring/classes/MonitoringHookImpl.php',

	// Models
	'Monitoring\MonitoringModel'       => 'system/modules/Monitoring/models/MonitoringModel.php',
	'Monitoring\MonitoringTestModel'   => 'system/modules/Monitoring/models/MonitoringTestModel.php',
));
