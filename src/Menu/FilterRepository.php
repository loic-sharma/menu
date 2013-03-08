<?php namespace Menu;

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
	 * Get all of the matching filters. If a menu name is given,
	 * fetch the filters that match that menu as well.
	 *
	 * @param  string  $menu
	 * @return array
	 */
	public function getFilters($menu = null)
	{
		$filters = $this->filters;

		// Add the menu-specific filters if we are given a menu name.
		if( ! is_null($menu))
		{
			$filters = array_merge($filters, $this->menuFilters[$menu]);
		}

		return $filters;
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
		// Run the item through each matching filter.
		foreach($this->getFilters($menu) as $filter)
		{
			// We're done if the filter returns true.
			if($filter($item) == true)
			{
				return true;
			}
		}

		return false;
	}
}