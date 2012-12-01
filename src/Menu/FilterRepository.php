<?php

namespace Menu;

use Closure;
use Menu\Items\Item as MenuItem;

class FilterRepository {

	/**
	 * The registered item filters.
	 *
	 * @var array
	 */
	protected $filters = array();

	/**
	 * The registered filters that only apply to specific menus.
	 *
	 * @var array
	 */
	protected $menuFilter = array();

	/**
	 * Register a new filter.
	 *
	 * @param  Closure  $filter
	 * @param  string   $menu
	 * @return void
	 */
	public function addFilter(Closure $filter, $menu = null)
	{
		if(is_null($menu))
		{
			$this->filters[] = $filter;
		}

		else
		{
			$this->menuFilter[$menu] = $filter;
		}
	}

	/**
	 * Execute the filters on an item.
	 *
	 * @param  Menu\Items\Item $item
	 * @param  string          $menu
	 * @return bool
	 */
	public function filter(MenuItem $item, $menu = null)
	{
		$filters = $this->filters;

		if( ! is_null($menu))
		{
			$filters = array_merge($filters, $this->menuFilters[$menu]);
		}

		foreach($filters as $filter)
		{
			if($filter($item) == true)
			{
				return true;
			}
		}

		return false;
	}
}