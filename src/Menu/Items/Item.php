<?php namespace Menu\Items;

use Closure;
use Menu\FilterRepository as MenuFilters;
use Menu\Renderer as MenuRenderer;

class Item extends Element {

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
	 * The URL of the item.
	 *
	 * @var string
	 */
	public $url;

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
		$item = new Item($this->menuName, $this->filters, $this->renderer);

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

	/**
	 * Render the current menu.
	 *
	 * @return string
	 */
	public function render()
	{
		return $this->renderer->renderMenu($this);
	}

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