<?php namespace Menu;

use Menu;

class Item_Collection extends Item {

	public $items = array();

	public function render()
	{
		return HTML::menu($this->items);
	}

	public function __toString()
	{
		return $this->render();
	}
}