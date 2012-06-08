<?php namespace menu;

use Menu;

class Item {

	public $name;
	public $url;
	public $items;
	public $attributes = array();

	public static function create($name, $url = null, $sub_items = null)
	{
		$item = new static;

		$item->name = $name;

		if(is_string($url) || is_null($url))
		{
			$item->url = $url;

			if( ! is_null($sub_items))
			{
				$sub_items($item);
			}
		}

		else
		{
			$url($item);
		}

		return $item;
	}

	public function add($name, $url = null, $sub_items = null)
	{
		$item = Item::create($name, $url, $sub_items);

		if(Menu::filter($item) == false)
		{
			$this->items[] = $item;
		}

		return $this;
	}

	public function attributes($attributes)
	{
		$item = end($this->items);

		$item->attributes = $attributes;

		return $this;
	}
}