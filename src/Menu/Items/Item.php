<?php

namespace Menu\Items;

use Closure;
use ArrayAccess;
use Menu\FilterRepository as MenuFilters;
use Menu\Renderer as MenuRenderer;

abstract class Item implements ArrayAccess {

	public $name;
	public $menuName;
	protected $filters;
	protected $attributes = array(
		'ul' => array(),
		'li' => array(),
		'a'  => array(),
	);
	protected $items = array();

	public function __construct($menuName, MenuFilters $filters, MenuRenderer $renderer)
	{
		$this->menuName = $menuName;
		$this->filters = $filters;
		$this->renderer = $renderer;
	}

	public function setAttributes(array $attributes)
	{
		foreach($attributes as $offset => $value)
		{
			$this->offsetSet($offset, $value);
		}
	}

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

	public function getAttributes($type = 'li')
	{
		return $this->attributes[$type];
	}

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

	//abstract public function render();

	public function __toString()
	{
		return $this->render();
	}

	public function offsetExists($offset)
	{
		return isset($this->attributes[$offset]);
	}

	public function offsetSet($offset, $value)
	{
		$type =  'url';

		if($offset == 'url')
		{
			$offset = 'a.href';
		}

		foreach(array('ul', 'li', 'a') as $element)
		{
			if(strpos($offset, $element.'.') === 0)
			{
				$type   = $element;
				$offset = substr($offset, strlen($element)+1);

				break;
			}
		}

		if($offset == 'id' || $offset == 'class')
		{
			if(isset($this->attributes[$type][$offset]))
			{
				$value = $this->attributes[$type][$offset].' '.$value;
			}
		}

		$this->attributes[$type][$offset] = $value;
	}

	public function offsetGet($offset)
	{
		return $this->attributes[$offset];
	}

	public function offsetUnset($offset)
	{
		unset($this->attributes[$offset]);
	}
}