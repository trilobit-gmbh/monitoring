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

$GLOBALS['TL_DCA']['tl_monitoring_test'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_monitoring',
		'enableVersioning'            => false,
		'closed'                      => true,
		'doNotCopyRecords'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('date DESC'),
			'headerFields'            => array('customer', 'website', 'system', 'url'),
			'header_callback'         => array('tl_monitoring_test', 'extendHeader'),
			'child_record_callback'   => array('tl_monitoring_test', 'getTestResultOutput'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_class'      => 'no_padding'
		),
		'global_operations' => array
		(
			'checkOne' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring_test']['checkOne'],
				'href'                => 'key=checkOne',
				'class'               => 'header_icon tl_monitoring_check_one'
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring_test']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring_test']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring_test']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{result_legend},date,type,status,repetitions,response_string;{comment_legend},comment'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'eval'                    => array('doNotShow'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'eval'                    => array('doNotShow'=>true),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring_test']['date'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'default'                 => time(),
			'flag'                    => 6,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50', 'readonly'=>true, 'rgxp'=>'datim'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring_test']['type'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'default'                 => Monitoring::CHECK_TYPE_MANUAL,
			'options'                 => array(Monitoring::CHECK_TYPE_MANUAL, Monitoring::CHECK_TYPE_AUTOMATIC),
			'reference'               => &$GLOBALS['TL_LANG']['tl_monitoring_test']['types'],
			'eval'                    => array('tl_class'=>'w50', 'readonly'=>true, 'helpwizard'=>true),
			'sql'                     => "varchar(64) NOT NULL default '" . Monitoring::CHECK_TYPE_MANUAL . "'"
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring_test']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'default'                 => Monitoring::STATUS_OKAY,
			'options'                 => array(Monitoring::STATUS_OKAY, Monitoring::STATUS_INCOMPLETE, Monitoring::STATUS_ERROR),
			'reference'               => &$GLOBALS['TL_LANG']['tl_monitoring_test']['statusTypes'],
			'eval'                    => array('tl_class'=>'w50', 'readonly'=>true, 'helpwizard'=>true),
			'sql'                     => "varchar(64) NOT NULL default '" . Monitoring::STATUS_OKAY . "'"
		),
		'repetitions' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring_test']['repetitions'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50', 'readonly'=>true, 'rgxp'=>'digit'),
			'sql'                     => "varchar(2) NOT NULL default '1'"
		),
		'response_string' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring_test']['response_string'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('tl_class'=>'long clr', 'readonly'=>true, 'doNotCopy'=>true),
			'sql'                     => "text NOT NULL"
		),
		'comment' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring_test']['comment'],
			'search'                  => true,
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('tl_class'=>'long clr'),
			'sql'                     => "text NULL"
		),
	)
);

/**
 * Class tl_monitoring_test
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class tl_monitoring_test extends Backend
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Return the label for an test entry
	 * @param array
	 * @return string
	 */
	public function getTestResultOutput($arrRow)
	{
		$cssClass = "tl_message_monitoring_status_" . strtolower($arrRow['status']);

		$arrOutputTable = array
		(
		    array
		    (
		        'col_0' => $GLOBALS['TL_LANG']['tl_monitoring_test']['date'][0],
		        'col_1' => \Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['date'])
		    ),
		    array
		    (
		        'col_0' => $GLOBALS['TL_LANG']['tl_monitoring_test']['type'][0],
		        'col_1' => $GLOBALS['TL_LANG']['tl_monitoring_test']['types'][$arrRow['type']][0]
		    ),
		    array
		    (
		        'col_0' => $GLOBALS['TL_LANG']['tl_monitoring_test']['status'][0],
		        'col_1' => '<img src="system/modules/Monitoring/assets/status_' . strtolower($arrRow['status']) . '_small.png" alt="' . $GLOBALS['TL_LANG']['tl_monitoring_test']['statusTypes'][$arrRow['status']][0] . '" title="' . $GLOBALS['TL_LANG']['tl_monitoring_test']['statusTypes'][$arrRow['status']][0] . '" class="tl_monitoring_test_status" /> <span class="' . $cssClass . '">' . $GLOBALS['TL_LANG']['tl_monitoring_test']['statusTypes'][$arrRow['status']][0] . '</span>'
		    ),
		    array
		    (
		        'col_0' => $GLOBALS['TL_LANG']['tl_monitoring_test']['repetitions'][0],
		        'col_1' => $arrRow['repetitions']
		    )
		);

		// HOOK: modify the test label
		if (isset($GLOBALS['TL_HOOKS']['monitoringExtendTestResultOutput']) && is_array($GLOBALS['TL_HOOKS']['monitoringExtendTestResultOutput']))
		{
		    foreach ($GLOBALS['TL_HOOKS']['monitoringExtendTestResultOutput'] as $callback)
		    {
		        $this->import($callback[0]);
		        $arrOutputTable = $this->$callback[0]->$callback[1]($arrRow, $arrOutputTable);
		    }
		}


		$label = '<div><table>';
		foreach ($arrOutputTable as $arrTableRow)
		{
		    $label .= '<tr><td><span class="tl_label">' . $arrTableRow['col_0'] . ':</span></td><td>' . $arrTableRow['col_1'] . '</td></tr>';
		}
		$label .= '</table></div>';
		$label .="\n";
		return $label;
	}

	/**
	 * Extend the header ...
	 * @param  $arrHeaderFields  the headerfields given from list->sorting
	 * @param  DataContainer $dc a DataContainer Object
	 * @return Array             The manipulated headerfields
	 */
	public function extendHeader($arrHeaderFields, DataContainer $dc)
	{
	    $strUrlFieldLabel = $GLOBALS['TL_LANG']['tl_monitoring']['url'][0];
	    if (array_key_exists($strUrlFieldLabel, $arrHeaderFields) )
	    {
	        $arrHeaderFields[$strUrlFieldLabel] = '<a href="' . $arrHeaderFields[$strUrlFieldLabel] . '" target="_blank">' . $arrHeaderFields[$strUrlFieldLabel] . '</a>';
	    }

	    // HOOK: modify the header
		if (isset($GLOBALS['TL_HOOKS']['monitoringExtendEntryHeader']) && is_array($GLOBALS['TL_HOOKS']['monitoringExtendEntryHeader']))
		{
			foreach ($GLOBALS['TL_HOOKS']['monitoringExtendEntryHeader'] as $callback)
			{
				$this->import($callback[0]);
				$arrHeaderFields = $this->$callback[0]->$callback[1]($arrHeaderFields, $dc);
			}
		}

	    return $arrHeaderFields;
	}
}

?>