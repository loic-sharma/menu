<?php namespace menu;

use Menu\Items\Collection;
use Menu\Items\Element;
use Menu\Items\Item;

class Renderer {

	/** 
	 * The class for the first menu item on its level.
	 *
	 * @var string
	 */
	public $firstClass = 'first';

	/**
	 * The class for the last menu item on its level.
	 *
	 * @var string
	 */
	public $lastClass = 'last';

	/**
	 * The class for a menu item that has no siblings on its level.
	 *
	 * @var string
	 */
	public $singleClass = 'single';

	/**
	 * The number of spaces used for each indentation.
	 *
	 * @var int
	 */
	public $spaces = 4;

	/**
	 * Convert a menu item into HTML.
	 *
	 * @param  Menu\Items\Item  $item
	 * @return string
	 */
	public function render(Item $item)
	{
		if($item instanceof Collection)
		{
			$this->renderMenu($item);
		}

		if($item instanceof Item)
		{
			$this->renderItem($item);
		}
	}

	/**
	 * Render a menu.
	 *
	 * @param  Menu\Items\Collection  $menu
	 * @return string
	 */
	public function renderMenu(Collection $menu)
	{	
		$output = '';

		$items = $menu->items();

		$key = 0;
		$lastKey = count($items) - 1;

		foreach($items as $item)
		{
			if($key == 0)
			{
				$this->addClass($item->label, $this->firstClass);
			}

			elseif($key == $lastKey)
			{
				$this->addClass($item->label, $this->lastClass);
			}

			$output .= $this->renderItem($item);

			$key++;
		}

		return $output;
	}

	/**
	 * Render an item of a menu.
	 *
	 * @param  Menu\Items\Item  $menu
	 * @param  int              $depth
	 * @return string
	 */
	public function renderItem(Item $item, $depth = 1)
	{
		$output = $this->format('<li'.$this->attributes($item->label).'>', $depth);

		if( ! empty($item->url))
		{
			$item->link->href = $item->url;
		}

		// If the anchor attribute exists, wrap the label around with it. Otherwise,
		// wrap the label with a span element.
		if(count($item->link->attributes()) != 0)
		{
			$label = '<a'.$this->attributes($item->link).'>'.$item->name.'</a>';
		}

		else
		{
			$label = '<span>'.$item->name.'</span>';
		}

		$output .= $this->format($label, $depth+1);
		$output .= $this->renderList($item, $depth+1);
		$output .= $this->format('</li>', $depth);

		return $output;
	}

	/**
	 * Render an item's sub-items.
	 *
	 * @param  Menu\Items\Item  $list
	 * @param  int              $depth
	 * @return string
	 */
	public function renderList(Item $list, $depth = 1)
	{
		$output = '';

		$items = $list->items();

		if( ! empty($items))
		{
			$output = $this->format('<ul'.$this->attributes($list->ul).'>', $depth);

			$itemCount = count($items);

			foreach($items as $item)
			{
				// If this is the only item of its level, give it the single item class.
				if($itemCount == 1)
				{
					$this->addClass($item->label, $this->singleClass);
				}

				$output .= $this->renderItem($item, $depth+1);
			}

			$output .= $this->format('</ul>', $depth);
		}

		return $output;
	}

	/**
	 * Add a class to an element.
	 *
	 * @param  Menu\Items\Element $element
	 * @param  string  $class
	 * @return void
	 */
	protected function addClass($element, $class)
	{
		// Don't do anything if the class is null.
		if( ! is_null($class))
		{
			// Make sure that the element does not already have the class
			// before appending the class to the element.
			if(strpos($element->class, ' '.$class.' ') === false)
			{
				$element->append('class', $class);
			}
		}
	}

	/**
	 * Provide correct spacing in HTML Code.
	 *
	 * @param  string  $html
	 * @param  int     $depth
	 * @return string
	 */
	protected function format($html, $depth)
	{
		return str_repeat(' ', $depth * $this->spaces).$html.PHP_EOL;
	}

	/**
	 * Generate the attributes of an element.
	 *
	 * @param  Menu\Items\Element  $item
	 * @return string
	 */
	protected function attributes(Element $element)
	{
		$output = '';

		foreach($element->attributes() as $attribute => $value)
		{
			$output .= ' '.$attribute.'="'.$value.'"';
		}

		return $output;	
	}
}