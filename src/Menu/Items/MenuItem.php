<?php

namespace Menu\Items;

class MenuItem extends Item {

	public function render()
	{
		return $this->renderer->renderItem($this);
/*
		$output = '<li>';

		if(isset($this->attributes['url']))
		{
			$output .= '<a href="'.$this->attributes['url'].'">'.$this->name.'</a>';
		}

		else
		{
			$output .= $this->name;
		}

		if( ! empty($this->items))
		{
			$output .= PHP_EOL.'<ul>'.PHP_EOL;

			foreach($this->items() as $item)
			{
				$output .= $item->render();
			}

			$output .= '</ul>'.PHP_EOL;
		}

		else
		{

		}

		$output .= '</li>'.PHP_EOL;*/

		return $output;
	}
}