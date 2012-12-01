<?php

namespace Menu;

use Closure;
use Menu\Items\Item as MenuItem;

class FilterRepository {

	protected $filters = array();

	protected $menuFilter = array();

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
	}
}