<?php
/**
 * Mesour Nette DataGrid
 *
 * Documentation here: http://grid.mesour.com
 *
 * @license LGPL-3.0 and BSD-3-Clause
 * @copyright (c) 2013 - 2015 Matous Nemec <matous.nemec@mesour.com>
 */

namespace Mesour\DataGrid;

/**
 * @author mesour <matous.nemec@mesour.com>
 * @package Mesour DataGrid
 */
class Grid extends ExtendedGrid
{

	private $colapseExpandAll = false;

	/**
	 * @return Extensions\SubItem
	 */
	public function enableSubItems()
	{
		$this->hasSubItems = true;
		new Extensions\SubItem($this, 'subitem', $this->page_limit);
		return $this['subitem'];
	}

	/**
	 * @param string $name
	 */
	public function setExpandAll($name)
	{
		$this->colapseExpandAll = $name;
	}

	/**
	 * @return bool
	 */
	public function hasSubItems()
	{
		return $this->colapseExpandAll != false;
	}

	/**
	 * @return bool
	 */
	public function handleExpandAllSubItems()
	{
		if (!isset($this['subitem'])) {
			return false;
		}

		unset($this['subitem']->settings[$this->colapseExpandAll]);
		$from = $this->getPaginator()->getPage();
		$items = $from + $this->getPaginator()->getItemsPerPage();
		for ($i = $from; $i < $items; $i++) {
			$this['subitem']->settings[$this->colapseExpandAll][] = $i;
		}
		$this->redrawControl();
		$this->presenter->redrawControl();
	}

	/**
	 * @return bool
	 */
	public function handleColapseAllSubItems()
	{
		if (!isset($this['subitem'], $this['subitem']->settings[$this->colapseExpandAll])) {
			return false;
		}
		unset($this['subitem']->settings[$this->colapseExpandAll]);
		$this->redrawControl();
		$this->presenter->redrawControl();

	}

}
