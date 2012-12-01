<?php

namespace menu;

class Renderer {

	public $options = array();

	public function __construct()
	{
		$this->options = array(
			'class.first'   => 'first',
			'class.last'    => 'last',
			'class.single'  => 'single',
		);
	}

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

	public function renderItem($item, $depth = 1)
	{
		$output = $this->format('<li'.$this->attributes($item, 'li').'>', $depth);

		if( ! empty($item['a']))
		{
			$link = '<a'.$this->attributes($item, 'a').'>'.$item->name.'</a>';

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

	public function renderList($list, $depth = 1)
	{
		$output = '';

		$items = $list->items();

		if( ! empty($items))
		{
			$output = $this->format('<ul'.$this->attributes($list, 'ul').'>', $depth);

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

	protected function format($html, $depth)
	{
		return str_repeat(' ', $depth * 4).$html.PHP_EOL;
	}

	protected function attributes($item, $type)
	{
		$output = '';

		foreach($item->getAttributes($type) as $attribute => $value)
		{
			$output .= ' '.$attribute.'="'.$value.'"';
		}

		return $output;	
	}
}