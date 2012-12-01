<?php

namespace Menu;

use Closure;
use Menu\Items\Collection as ItemCollection;

class Factory {

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
	 * The instances of the created menus.
	 *
	 * @var array
	 */
	protected $menus;

	/**
	 * Register the Filter Repository and Renderer.
	 *
	 * @param  Menu\FilterRepository  $filters
	 * @param  Menu\Renderer          $renderer
	 * @return void
	 */
	public function __construct(FilterRepository $filters, Renderer $renderer)
	{
		$this->filters = $filters;
		$this->renderer = $renderer;
	}

	/**
	 * Get the instance to a menu.
	 *
	 * @param  string                 $name
	 * @return Menu\Items\Collection
	 */
	public function get($name)
	{
		if( ! isset($this->menus[$name]))
		{
			$this->menus[$name] = new ItemCollection($name, $this->filters, $this->renderer);
		}

		return $this->menus[$name];
	}

	/**
	 * Register a new filter.
	 *
	 * @param  Closure  $filter
	 * @return void
	 */
	public function filter($filter)
	{
		$this->filters->addFilter($filter);
	}
}