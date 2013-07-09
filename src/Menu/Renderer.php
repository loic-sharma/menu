<?php namespace menu;

use Menu\Items\Collection;
use Menu\Items\Element;
use Menu\Items\Item;

class Renderer {

	/**
	 * The renderer options.
	 *
	 * @var array
	 */
	public $options = array(
		'class.first' => 'first',
		'class.last' => 'last',
		'class.single' => 'single',
	);

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

		$options = $this->options;
		$items = $menu->items();
		$last = count($items)-1;

		foreach($items as $key => $item)
		{
			if($key == 0)
			{
				$item->element('li')->append('class', $options['class.first']);
			}

			elseif($key == $last)
			{
				$item->element('li')->append('class', $options['class.last']);
			}

			$output .= $this->renderItem($item, 1);
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
		$output = $this->format('<li'.$this->attributes($item->element('li')).'>', $depth);

		if( ! empty($item->url))
		{
			$item->element('a')->attribute('href', $item->url);
		}

		if(count($item->element('a')->attributes()) != 0)
		{
			$link = '<a'.$this->attributes($item->element('a')).'>'.$item->name.'</a>';

			$output .= $this->format($link, $depth+1);
		}

		else
		{
			$output .= $this->format($item->name, $depth+1);
		}

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
			$output = $this->format('<ul'.$this->attributes($list->element('ul')).'>', $depth);

			$itemCount = count($items);

			foreach($items as $item)
			{
				if($itemCount == 1)
				{
					$item->element('li')->append('class', $this->options['class.single']);
				}

				$output .= $this->renderItem($item, $depth+1);
			}

			$output .= $this->format('</ul>', $depth);
		}

		return $output;
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
		return str_repeat(' ', $depth * 4).$html.PHP_EOL;
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