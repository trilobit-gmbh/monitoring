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
		'ctable'                      => array('tl_monitoring_test'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onsubmit_callback' => array
		(
			array('tl_monitoring', 'storeDateAdded'),
		),
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
			'fields'                  => array('icon', 'customer', 'website', 'system', 'last_test_date', 'last_test_status'),
			'showColumns'             => true,
			'label_callback'          => array('tl_monitoring', 'getLabel')
		),
		'global_operations' => array
		(
			'checkAll' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['checkAll'],
				'href'                => 'key=checkAll',
				'class'               => 'header_icon tl_monitoring_check_all'
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
				'icon'                => 'header.gif'
			),
			'tests' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['tests'],
				'href'                => 'table=tl_monitoring_test',
				'icon'                => 'system/modules/Monitoring/assets/icon_tests.png',
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
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_monitoring', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'showPage' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['showPage'],
				'button_callback'     => array('tl_monitoring', 'getShowPageButton'),
			    'icon'                => 'system/modules/Monitoring/assets/show_page.png',
				'attributes'          => 'target="_blank" onclick="Backend.openModalIframe({\'width\':765,\'title\':\'' . $GLOBALS['TL_LANG']['tl_monitoring']['showPage'][0] . '\',\'url\':this.href});return false"'
			),
			'checkOne' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_monitoring']['checkOne'],
				'href'                => 'key=checkOne',
				'icon'                => 'system/modules/Monitoring/assets/check_one.png',
				'button_callback'     => array('tl_monitoring', 'getStatusIcon')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{website_legend},customer,website,system,added;{test_legend},url,test_string;{last_test_legend},last_test_date,last_test_status;{disable_legend},disable'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'label'                   => array("ID"),
			'search'                  => true,
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
			'eval'                    => array('tl_class'=>'clr w50', 'mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'added' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['added'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 6,
			'inputType'               => 'text',
			'load_callback'           => array(array('tl_monitoring', 'setDate')),
			'eval'                    => array('tl_class'=>'w50', 'doNotCopy'=>true, 'readonly'=>true, 'rgxp'=>'datim'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
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
		'last_test_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['last_test_date'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'default'                 => '',
			'inputType'               => 'text',
			'flag'                    => 6,
			'eval'                    => array('tl_class'=>'w50', 'readonly'=>true, 'rgxp'=>'datim', 'doNotCopy'=>true),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'last_test_status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['last_test_status'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'default'                 => Monitoring::STATUS_UNTESTED,
			'options'                 => array(Monitoring::STATUS_UNTESTED, Monitoring::STATUS_OKAY, Monitoring::STATUS_INCOMPLETE, Monitoring::STATUS_ERROR),
			'reference'               => &$GLOBALS['TL_LANG']['tl_monitoring']['statusTypes'],
			'eval'                    => array('tl_class'=>'w50', 'readonly'=>true, 'helpwizard'=>true, 'doNotCopy'=>true),
			'sql'                     => "varchar(64) NOT NULL default '" . Monitoring::STATUS_UNTESTED . "'"
		),
		'disable' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_monitoring']['disable'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50'),
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
		$this->import('BackendUser', 'User');
	}

	/**
	 * Returns the date as formated string
	 */
	public function setDate($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->tstamp == 0)
		{
			return time();
		}
		return $varValue;
	}

	/**
	 * Store the date when the entry has been added
	 * @param object
	 */
	public function storeDateAdded($dc)
	{
		// Front end call
		if (!$dc instanceof \DataContainer)
		{
			return;
		}

		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		// Fallback solution for existing accounts
		if ($dc->activeRecord->added > 0)
		{
			$time = $dc->activeRecord->added;
		}
		else
		{
			$time = time();
		}

		$this->Database->prepare("UPDATE tl_monitoring SET added=? WHERE id=?")
					   ->execute($time, $dc->id);
	}

	/**
	 * Returns the formatted row columns
	 */
	public function getLabel($row, $label, DataContainer $dc, $args)
	{
		$image = 'icon_monitoring';
		if ($row['disable'])
		{
			$image .= '_';
		}
		$args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'system/modules/Monitoring/assets/%s.png\')">&nbsp;</div>', $image);

		$intLastTestStatusIndex = array_search("last_test_status", $GLOBALS['TL_DCA']['tl_monitoring']['list']['label']['fields']);
		if ($intLastTestStatusIndex !== FALSE)
		{
			$args[$intLastTestStatusIndex] = '<img src="system/modules/Monitoring/assets/status_' . strtolower($row['last_test_status']) . '.png" alt="' . $args[$intLastTestStatusIndex] . '" title="' . $args[$intLastTestStatusIndex] . '"/>';
		}

		// HOOK: format list
		if (isset($GLOBALS['TL_HOOKS']['monitoringFormatList']) && is_array($GLOBALS['TL_HOOKS']['monitoringFormatList']))
		{
		    foreach ($GLOBALS['TL_HOOKS']['monitoringFormatList'] as $callback)
		    {
		        $this->import($callback[0]);
		        $args = $this->$callback[0]->$callback[1]($row, $dc, $args);
		    }
		}

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
			$arrSet['last_test_date'] = 0;
			$arrSet['last_test_status'] = Monitoring::STATUS_UNTESTED;

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
		$href .= '&id=' . $arrRow['id'];

		return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
	}

	/**
	 * Returns the link and icon for each test entry
	 */
	public function getShowPageButton($arrRow, $href, $label, $title, $icon, $attributes, $strTable, $arrRootIds, $arrChildRecordIds, $blnCircularReference, $strPrevious, $strNext)
	{
		return '<a href="' . $arrRow['url'] . '" title="' . specialchars($title) . '"  ' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
	}

		/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_monitoring::disable', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.$row['disable'];

		if ($row['disable'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable an entry
	 * @param integer
	 * @param boolean
	 * @param \DataContainer
	 */
	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Check permissions
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_monitoring::disable', 'alexf'))
		{
			$this->log('Not enough permissions to activate/deactivate monitoring entry ID "'.$intId.'"', __METHOD__, TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_monitoring', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_monitoring']['fields']['disable']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_monitoring']['fields']['disable']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		$time = time();

		// Update the database
		$this->Database->prepare("UPDATE tl_monitoring SET tstamp=$time, disable='" . ($blnVisible ? '' : 1) . "' WHERE id=?")
					   ->execute($intId);

		$objVersions->create();
		$this->log('A new version of record "tl_monitoring.id='.$intId.'" has been created'.$this->getParentEntries('tl_monitoring', $intId), __METHOD__, TL_GENERAL);
	}
}

?>