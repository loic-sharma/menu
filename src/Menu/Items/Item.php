<?php

namespace Menu\Items;

use Closure;
use ArrayAccess;
use Menu\FilterRepository as MenuFilters;
use Menu\Renderer as MenuRenderer;

abstract class Item implements ArrayAccess {

	/**
	 * The name of the item.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The name of the menu the item belongs to.
	 *
	 * @var string
	 */
	public $menuName;

	/**
	 * The instance of the Filter Repository.
	 *
	 * @var Menu\FilterRepository
	 */
	protected $filters;

	/**
	 * The instance of the Renderer.
	 *
	 * @var Menu\Renderer
	 */
	protected $renderer;

	/**
	 * The list of attributes for this item.
	 *
	 * @var array
	 */
	protected $attributes = array(
		'ul' => array(),
		'li' => array(),
		'a'  => array(),
	);

	/**
	 * The list of items that belong to this item.
	 *
	 * @var array
	 */
	protected $items = array();

	/**
	 * Prepare the new item.
	 *
	 * @param  string                 $menuName
	 * @param  Menu\FilterRepository  $filters
	 * @param  Menu\Renderer          $renderer
	 * @return void
	 */
	public function __construct($menuName, MenuFilters $filters, MenuRenderer $renderer)
	{
		$this->menuName = $menuName;
		$this->filters = $filters;
		$this->renderer = $renderer;
	}

	/**
	 * Set new attributes.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function setAttributes(array $attributes)
	{
		foreach($attributes as $offset => $value)
		{
			$this->offsetSet($offset, $value);
		}
	}

	/**
	 * Get all of the attributes for an element of the item.
	 *
	 * @param  string  $element
	 * @return array
	 */
	public function getAttributes($element = 'li')
	{
		return $this->attributes[$element];
	}

	/**
	 * Add a new sub-item to the current item.
	 *
	 * @param  string          $name
	 * @param  string|Closure  $attributes
	 * @param  Closure         $subItems
	 * @return void
	 */
	public function add($name, $attributes = null, $subItems = null)
	{
		$item = new MenuItem($this->menuName, $this->filters, $this->renderer);

		$item->name = $name;

		if( ! is_null($attributes))
		{
			if(is_string($attributes))
			{
				$attributes = array('url' => $attributes);
			}

			if(is_array($attributes))
			{
				$item->setAttributes($attributes);
			}

			elseif($attributes instanceof Closure)
			{
				$attributes($item);
			}
		}

		if($subItems instanceof Closure)
		{
			$subItems($item);
		}

		$this->items[$name] = $item;
	}

	/**
	 * Fetch a specific item.
	 *
	 * @param  string|Closure  $item
	 * @return Menu\Item
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
		$items = array();

		foreach($this->items as $item)
		{
			if($this->filters->filter($item) != true)
			{
				$items[] = $item;
			}

		}

		return $items;
	}

	protected function parseOffset($offset)
	{
		if($offset == 'url')
		{
			return array('a', 'href');
		}

		foreach(array('ul', 'li', 'a') as $element)
		{
			if($offset == $element)
			{
				return array($offset, null);
			}

			if(strpos($offset, $element.'.') === 0)
			{
				return array($element, substr($offset, strlen($element)+1));
			}
		}
	}

	/**
	 * Determine if a given offset exists.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		list($element, $offset) = $this->parseOffset($offset);

		if( ! is_null($offset))
		{
			return isset($this->attributes[$element][$offset]);
		}

		else
		{
			return isset($this->attributes[$element]);
		}
	}

	/**
	 * Get the value at a given offset.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		list($element, $offset) = $this->parseOffset($offset);

		if( ! is_null($offset))
		{
			return $this->attributes[$element][$offset];
		}

		else
		{
			return $this->attributes[$element];
		}
	}

	/**
	 * Set the value at a given offset.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */	
	public function offsetSet($offset, $value)
	{
		list($element, $offset) = $this->parseOffset($offset);

		if($offset == 'id' || $offset == 'class')
		{
			if(isset($this->attributes[$element][$offset]))
			{
				$value = $this->attributes[$element][$offset].' '.$value;
			}
		}

		$this->attributes[$element][$offset] = $value;
	}

	/**
	 * Unset the value at a given offset.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		list($element, $offset) = $this->parseOffset($offset);

		unset($this->attributes[$element][$offset]);
	}

	/**
	 * Render the current item.
	 *
	 * @return string
	 */
	abstract function render();

	/**
	 * Render the current item.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
}