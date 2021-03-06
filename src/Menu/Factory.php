<?php namespace Menu;

use Closure;
use Menu\Items\Collection;

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
	public function __construct(FilterRepository $filters = null, Renderer $renderer = null)
	{
		if(is_null($filters))
		{
			$this->filters = new FilterRepository;
		}

		else
		{
			$this->filters = $filters;
		}

		if(is_null($renderer))
		{
			$this->renderer = new Renderer;
		}

		else
		{
			$this->renderer = $renderer;
		}
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
			$this->menus[$name] = new Collection($this->filters, $this->renderer);

			$this->menus[$name]->name = $name;
		}

		return $this->menus[$name];
	}

	/**
	 * Register a new filter.
	 *
	 * @param  Closure  $filter
	 * @return void
	 */
	public function addFilter($filter)
	{
		$this->filters->addFilter($filter);
	}
}