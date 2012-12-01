<?php

namespace Menu;

use Closure;

class Factory {

	protected $renderer;
	protected $filters;
	protected $menus;

	public function __construct(FilterRepository $filters, Renderer $renderer)
	{
		$this->filters = $filters;
		$this->renderer = $renderer;
	}

	public function get($name)
	{
		if( ! isset($this->menus[$name]))
		{
			$this->menus[$name] = new Items\Collection($name, $this->filters, $this->renderer);
		}

		return $this->menus[$name];
	}

	public function filter($filter)
	{
		$this->filters->addFilter($filter);
	}
}