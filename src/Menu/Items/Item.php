<?php namespace Menu\Items;

use Closure;
use Menu\FilterRepository;

class Item extends Element {

	/**
	 * The name of the item.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Wether the current item has been removed.
	 *
	 * @var bool
	 */
	public $hasBeenRemoved = false;

	/**
	 * The current item's menu.
	 *
	 * @var Menu\Items\Collection
	 */
	public $menu;

	/**
	 * The current item's parent.
	 *
	 * @var Menu\Items\Item
	 */
	public $parent;

	/**
	 * The URL of the item.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * The item's elements.
	 *
	 * @var array
	 */
	protected $elements = array();

	/**
	 * The list of items that belong to this item.
	 *
	 * @var array
	 */
	protected $items = array();

	/**
	 * Set the current item's menu.
	 *
	 * @param  Menu\Item  $menu
	 * @return void
	 */
	public function setMenu(Item $menu)
	{
		$this->menu = $menu;
	}

	/**
	 * Set the current item's parent.
	 *
	 * @param  Menu\Item  $parent
	 * @return void
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * Verify that the current item exists.
	 *
	 * @return bool
	 */
	public function exists()
	{
		return ! $this->hasBeenRemoved;
	}

	/**
	 * Verify that the current item has a subitem.
	 *
	 * @param  string  $name
	 * @return bool
	 */
	public function has($name)
	{
		return (isset($this->items[$name]));
	}

	/**
	 * Add a new sub-item to the current item.
	 *
	 * @param  string          $name
	 * @param  string|Closure  $attributes
	 * @param  Closure         $callback
	 * @return void
	 */
	public function add($name, $attributes = null, $callback = null)
	{
		$item = new Item;

		// Set the new item's parents.
		if( ! is_null($this->menu))
		{
			$item->setMenu($this->menu);
		}

		$item->setParent($this);

		// Set the new item's attributes.
		$item->name = $name;

		if( ! is_null($attributes))
		{
			// If the attributes is just a string, then it is the  URL
			// for the menu item.
			if(is_string($attributes))
			{
				$item->url = $attributes;
			}
 
			elseif($attributes instanceof Closure)
			{
				$attributes($item);
			}

			else
			{
				throw new \InvalidArgumentException;
			}
		}

		if($callback instanceof Closure)
		{
			$callback($item);
		}

		$this->items[$name] = $item;
	}

	/**
	 * Remove the current item, or remove a sub-item.
	 *
	 * @param  string  $item
	 * @return void
	 */
	public function remove($name = null)
	{
		// Remove the current item if no name was inputted.
		if(is_null($name))
		{
			// Remove the item from its parent, if it has one.
			if( ! is_null($this->parent))
			{
				$this->parent->remove($this->name);
			}

			$this->hasBeenRemoved = true;
		}

		// Otherwise, remove a sub-item.
		else
		{
			$this->items[$name]->hasBeenRemoved = true;

			unset($this->items[$name]);
		}
	}

	/**
	 * Fetch a specific item.
	 *
	 * @param  string|Closure   $item
	 * @return Menu\Items\Item
	 */
	public function get($filter)
	{
		foreach($this->items as $item)
		{
			if(is_string($filter) and $item->name == $filter)
			{
				return $item;
			}

			if($filter instanceof Closure and $filter($item) == true)
			{
				return $item;
			}

			if( ! is_null($item->get($filter)))
			{
				return $item;
			}
		}

		return null;
	}

	/**
	 * Fetch all of the item's sub-items.
	 *
	 * @return array
	 */
	public function items()
	{
		if( ! is_null($this->menu))
		{
			foreach($this->items as $item)
			{
				$this->menu->filter($item);
			}
		}

		return $this->items;
	}

	/**
	 * Fetch an item's element.
	 *
	 * @param  string   $name
	 * @param  Closure  $closure
	 * @return Menu\Items\Element
	 */
	public function element($name, Closure $closure = null)
	{
		if( ! isset($this->elements[$name]))
		{
			$this->elements[$name] = new Element;
		}

		// Run the element through the closure if one was passed.
		if( ! is_null($closure))
		{
			$closure($this->elements[$name]);
		}

		return $this->elements[$name];
	}

	/**
	 * Fetch an attribute from one of the item's elements.
	 *
	 * @param  string  $attribute
	 * @param  string  $value
	 * @return string
	 */
	public function attribute($attribute, $value = null)
	{
		list($element, $attribute) = explode('.', $attribute);

		$element = $this->element($element);

		if( ! is_null($value) or ! $element->has($attribute))
		{
			$element->attribute($attribute, $value);
		}

		return $element->attribute($attribute);
	}
}