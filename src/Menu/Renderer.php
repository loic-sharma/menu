<?php

namespace menu;

class Renderer {

	public $classes = array();

	public function __construct()
	{
		$this->classes = array(
			'class.first'   => 'first',
			'class.last'    => 'last',
			'class.single'  => 'single',
		);
	}

	public function renderMenu($menu)
	{
		$output = '';

		foreach($menu->items() as $item)
		{
			$output .= $this->renderItem($item);
		}

		return $output;
	}

	public function renderItem($item)
	{
		$output = '<li'.$this->attributes($item, 'li').'>';

		if( ! empty($item['a']))
		{
			$output .= '<a'.$this->attributes($item, 'a').'>';
			$output .= $item->name.'</a>';
		}

		else
		{
			$output .= $item->name;
		}

		$output .= $this->renderList($item);

		$output .= '</li>'.PHP_EOL;

		return $output;
	}

	public function renderList($list, $nested = true)
	{
		$items = $list->items();

		$output = '';

		if( ! empty($items))
		{
			$first = true;
			$keys = count($items);

			foreach($items as $key => $item)
			{
				if($keys == 1 && $nested == true)
				{
					$item['class'] = $this->classes['class.single'];
				}

				elseif($first == true)
				{
					$item['class'] = $this->classes['class.first'];

					$first = false;
				}

				elseif($nested == false && $key == $keys-1)
				{
					$item['class'] = $this->classes['class.last'];
				}

				$output .= $this->renderItem($item);
			}
		}

		if($nested == false || ! empty($items))
		{
			$itemsOutput = $output;
			$output = '';

			if($nested == true)
			{
				$output  = PHP_EOL;
				$output .= '<ul'.$this->attributes($list, 'ul').'>'.PHP_EOL;
			}

			else
			{
				$output .= '<ul'.$this->attributes($list, 'ul').'>'.PHP_EOL;
			}

			$output .= $itemsOutput.'</ul>'.PHP_EOL;
		}

		return $output;
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