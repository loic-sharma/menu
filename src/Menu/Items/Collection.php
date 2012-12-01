<?php

namespace Menu\Items;

class Collection extends Item {

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

	/**
	 * Render the current menu.
	 *
	 * @return string
	 */
	public function render()
	{
		return $this->renderer->renderMenu($this);
	}
}