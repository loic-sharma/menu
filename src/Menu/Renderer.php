<?php namespace menu;

class Renderer {

	/**
	 * The renderer options.
	 *
	 * @var array
	 */
	public $options = array();

	/**
	 * Set the default renderer options.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->options = array(
			'class.first'   => 'first',
			'class.last'    => 'last',
			'class.single'  => 'single',
		);
	}

	/**
	 * Render a menu.
	 *
	 * @param  Menu\Items\Collection  $menu
	 * @return string
	 */
	public function renderMenu($menu)
	{
		$output = '';

		$items = $menu->items();
		$last = count($items)-1;

		foreach($items as $key => $item)
		{
			if($key == 0)
			{
				$item['li.class'] = $this->options['class.first'];
			}

			elseif($key == $last)
			{
				$item['li.class'] = $this->options['class.last'];
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
	public function renderItem($item, $depth = 1)
	{
		$output = $this->format('<li'.$this->attributes($item['li']).'>', $depth);

		if( ! empty($item['a']))
		{
			$link = '<a'.$this->attributes($item['a']).'>'.$item->name.'</a>';

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
	public function renderList($list, $depth = 1)
	{
		$output = '';

		$items = $list->items();

		if( ! empty($items))
		{
			$output = $this->format('<ul'.$this->attributes($list['ul']).'>', $depth);

			$itemCount = count($items);

			foreach($items as $key => $item)
			{
				if($itemCount == 1)
				{
					$item['li.class'] = $this->options['class.single'];
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
	 * Generate the attributes to an item.
	 *
	 * @param  array   $item
	 * @return string
	 */
	protected function attributes(array $attributes)
	{
		$output = '';

		foreach($attributes as $attribute => $value)
		{
			$output .= ' '.$attribute.'="'.$value.'"';
		}

		return $output;	
	}
}