<?php namespace Menu;

use Menu;

class Item_Collection extends Item {

	/**
	 * Render the menu.
	 *
	 * @return string
	 */
	public function render()
	{
		return HTML::menu($this->items);
	}

	/**
	 * Render the menu
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
}