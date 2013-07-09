<?php namespace Menu\Items;

use Menu\Renderer;
use Menu\FilterRepository as Filters;

class Collection extends Item {

	/**
	 * The instance of the Filter Repository.
	 *
	 * @var Menu\FilterRepository
	 */
	protected $filters;

	/**
	 * The renderer that will be used to translate menu objects
	 * into HTML.
	 *
	 * @var Menu\Render
	 */
	protected $renderer;

	/**
	 * Register the item collection.
	 *
	 * @return void
	 */
	public function __construct(Filters $filters, Renderer $renderer)
	{
		$this->setFilters($filters);
		$this->setRenderer($renderer);

		// All of the collection's items will use this instance as their menu.
		$this->setMenu($this);
	}

	/**
	 * Set the filters that will be used to filter the menu's items.
	 *
	 * @param  Menu\FilterRepository  $filters
	 * @return void
	 */
	public function setFilters(Filters $filters)
	{
		$this->filters = $filters;
	}

	/**
	 * Set the renderer that will be used to display the menu.
	 *
	 * @param  Menu\Renderer  $renderer
	 * @return void
	 */
	public function setRenderer(Renderer $renderer)
	{
		$this->renderer = $renderer;
	}

	/**
	 * Register a new filter for the current menu.
	 *
	 * @param  Closure $filter
	 * @return void
	 */
	public function addFilter($filter)
	{
		$this->filters->addFilter($filter, $this->menu->name);
	}

	/**
	 * Run a menu item through a filter.
	 *
	 * @param  Menu\Items\Item  $item
	 * @return void
	 */
	public function filter(Item $item)
	{
		$this->filters->filter($item);
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