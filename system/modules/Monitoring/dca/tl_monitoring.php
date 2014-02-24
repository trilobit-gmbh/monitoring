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

$GLOBALS['TL_DCA']['tl_monitoring'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false,
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
			'mode'                    => 2,
			'flag'                    => 1,
			'fields'                  => array('customer', 'website'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('customer', 'website', 'system', 'date', 'time', 'status'),
			'showColumns'             => true,
			'label_callback'          => array('tl_monitoring', 'getLable')
		),
		'global_operations' => array
		(
			 'checkall' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['checkall'],
				'href'                => 'key=checkall',
				'class'               => 'header_icon checkall'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'open_url' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['open_url'],
				'icon'                => 'system/modules/es_webcheck/html/open_url.png',
				'button_callback'     => array('tl_monitoring', 'getOpenUrlButton')
			),
			'check' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['check'],
				'href'                => 'key=check',
				'icon'                => 'system/modules/es_webcheck/html/server_grey.png',
				'button_callback'     => array('tl_monitoring', 'getStatusIcon')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{website_legend},name,customer,website,system,added;{test_legend},url,test_string,disable'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		), 
		'customer' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['customer'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50', 'mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'website' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['website'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50', 'mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'system' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['system'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50', 'mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'added' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['added'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'load_callback'           => array(array('tl_monitoring', 'setDate')),
			'eval'                    => array('maxlength'=>20, 'mandatory'=>true, 'tl_class'=>'w50', 'doNotCopy'=>true),
			'sql'                     => "varchar(20) NOT NULL default ''"
		),
		'url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['url'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'save_callback'           => array(array('tl_monitoring', 'storeUrl')),
			'eval'                    => array('tl_class'=>'long', 'mandatory'=>true, 'rgxp'=>'url'),
			'sql'                     => "text NOT NULL"
		),
		'test_string' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['test_string'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('tl_class'=>'long clr', 'mandatory'=>true),
			'sql'                     => "text NOT NULL"
		),
		'response_string' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['response_string'],
			'inputType'               => 'hidden',
			'eval'                    => array('readonly'=>true, 'doNotCopy'=>true),
			'sql'                     => "text NOT NULL"
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['date'],
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'hidden',
			'eval'                    => array('readonly'=>true, 'doNotCopy'=>true),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'time' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['time'],
			'search'                  => true,
			'sorting'                 => true,
			'inputType'               => 'hidden',
			'eval'                    => array('readonly'=>true, 'doNotCopy'=>true),
			'sql'                     => "varchar(8) NOT NULL default ''"
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['status'],
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'hidden',
			'default'                 => Monitoring::STATUS_UNTESTED,
			'reference'               => &$GLOBALS['TL_LANG']['tl_monitoring']['statusTypes'],
			'eval'                    => array('readonly'=>true, 'doNotCopy'=>true),
			'sql'                     => "varchar(64) NOT NULL default '" . Monitoring::STATUS_UNTESTED . "'"
		),
		'disable' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['disable'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'sql'                     => "char(1) NOT NULL default ''"
		)
	)
);

/**
 * Class tl_monitoring
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class tl_monitoring extends Backend
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns the date as formated string
	 */
	public function setDate()
	{
		return date('Y.m.d H:i:s');
	}

	/**
	 * Returns the formatted row columns
	 */
	public function getLable($row, $label, DataContainer $dc, $args)
	{
		$args[3] = '<span style="color:#b3b3b3;">' . $row['date'] . '</span>';
		$args[4] = '<span style="color:#b3b3b3;">' . $row['time'] . '</span>';
		$args[5] = '<span class="' . strtolower($row['status']) . '">' . $args[5] . '</span>';

		return $args;
	}

	/**
	 * Empties test values when editing the url
	 */
	public function storeUrl($value, DataContainer $dc)
	{
		if ($value != $dc->activeRecord->url)
		{
			// url is new ... set unchecked
			$arrSet = array();
			$arrSet['response_string'] = '';
			$arrSet['date'] = '';
			$arrSet['time'] = '';
			$arrSet['status'] = Monitoring::STATUS_UNTESTED;

			$this->Database->prepare("UPDATE tl_monitoring %s WHERE id=?")
						   ->set($arrSet)
						   ->execute(\Input::get('id'));
		}

		if ($value != '' && !preg_match('@^https?://@', $value))
		{
			$value = 'http://' . $value;
		}
		return $value;
	}

	/**
	 * Returns the link and icon for each test entry
	 */
	public function getStatusIcon($arrRow, $href, $label, $title, $icon, $attributes, $strTable, $arrRootIds, $arrChildRecordIds, $blnCircularReference, $strPrevious, $strNext)
	{
		$icon = 'system/modules/Monitoring/assets/';

		if ($arrRow['disable'] == '1')
		{
			return $this->generateImage($icon .= 'status_disabled.png', $GLOBALS['TL_LANG']['tl_monitoring']['disabled'][0], 'title="' . $GLOBALS['TL_LANG']['tl_monitoring']['disabled'][1] . '"');
		}

		$href .= '&id=' . $arrRow['id'];
		$now = time() - (60 * 60); // now - 60 min. * 60 sek. (last test not older than 60 min)
		$last = strtotime($arrRow['date'] . ' ' . $arrRow['time']);

		if ($arrRow['date'] == '' OR $last < $now)
		{
			// untested
			$icon .= 'status_untested.png';
		}
		else
		{
			switch ($arrRow['status'])
			{
				case Monitoring::STATUS_OKAY       : $icon .= 'status_okay.png'; break;
				case Monitoring::STATUS_ERROR      : $icon .= 'status_error.png'; break;
				case Monitoring::STATUS_INCOMPLETE : $icon .= 'status_incomplete.png'; break;
			}
		}

		return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a>';
	}

	/**
	 * Returns the link and icon for each test entry
	 */
	public function getOpenUrlButton($arrRow, $href, $label, $title, $icon, $attributes, $strTable, $arrRootIds, $arrChildRecordIds, $blnCircularReference, $strPrevious, $strNext)
	{
		return '<a href="' . $arrRow['url'] . '" title="' . specialchars($title) . '" target="_blank" ' . $attributes . '>' . $this->generateImage('system/modules/Monitoring/assets/open_url.png', $label) . '</a>';
	}
}

?>