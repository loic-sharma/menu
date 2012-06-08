<?php namespace menu;

use Menu;

class Item {

	/**
	 * The name of the item.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The URL of the item.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * The subitems of this item.
	 *
	 * @var array
	 */
	public $items = array();

	/**
	 * The attributes of the item.
	 *
	 * @var array
	 */
	public $attributes = array();

	/**
	 * Create a new item.
	 *
	 * @param  string  $name
	 * @param  string  $url
	 * @param  array   $sub_items
	 * @return Item
	 */
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

	/**
	 * Add a new subitem to the current item.
	 *
	 * @param  string  $name
	 * @param  string  $url
	 * @param  array   $sub_items
	 * @return Item
	 */
	public function add($name, $url = null, $sub_items = null)
	{
		$item = Item::create($name, $url, $sub_items);

		if(Menu::filter($item) == false)
		{
			$this->items[] = $item;
		}

		return $this;
	}

	/**
	 * Add attributes to the last added item.
	 *
	 * @param  array
	 * @return Item
	 */
	public function attributes($attributes)
	{
		$item = end($this->items);

		$item->attributes = array_merge($this->attributes, $attributes);

		return $this;
	}
}