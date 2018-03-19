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
 * Run in a custom namespace, so the class can be replaced
 */
namespace Monitoring;

/**
 * Class MonitoringModel
 *
 * Read monitoring entries.
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    Models
 */
class MonitoringModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_monitoring';

	/**
	 * Find an active monitoring entry by its id
	 *
	 * @param int $intId    The entry id
	 *
	 * @return \Model|null The model or null if there is no monitoring entry
	 */
	public static function findActiveById($intId)
	{
		$t = static::$strTable;

		$arrColumns = array("$t.id=? AND $t.disable=''");

		return static::findOneBy($arrColumns, array($intId));
	}

	/**
	 * Find all active monitoring entries
	 *
	 * @param array $arrOptions An optional options array
	 *
	 * @return \Model\Collection|null A collection of models or null if there are no monitoring entries
	 */
	public static function findAllActive(array $arrOptions=array())
	{
	    $t = static::$strTable;

	    return static::findBy(array("$t.disable=''"), null, $arrOptions);
	}

	/**
	 * Find all active monitoring entries that are erroneous
	 *
	 * @param array $arrOptions An optional options array
	 *
	 * @return \Model\Collection|null A collection of models or null if there are no monitoring entries
	 */
	public static function findAllActiveErroneous(array $arrOptions=array())
	{
	    $t = static::$strTable;

	    return static::findBy(array("$t.disable='' AND ($t.last_test_status='ERROR' OR $t.last_test_status='INCOMPLETE')"), null, $arrOptions);
	}
}
?>
