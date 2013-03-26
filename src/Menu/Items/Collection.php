<?php namespace Menu\Items;

class Collection extends Item {

	/**
	 * Register the item collection.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// All of the collection's items will use the instance of this
		// class as its menu.
		$this->setMenu($this);
	}

	/**
	 * Register a new filter for the current menu.
	 *
	 * @param  Closure $filter
	 * @return void
	 */
	public function filter($filter)
	{
		$this->filters->addFilter($filter, $this->menuName);
	}
}