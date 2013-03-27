<?php namespace Menu\Items;

use Menu\Renderer;
use Menu\FilterRepository as Filters;

class Collection extends Item {

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
		parent::__construct($filters);

		$this->setRenderer($renderer);

		// All of the collection's items will use the instance of this
		// class as its menu.
		$this->setMenu($this);
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
	public function filter($filter)
	{
		$this->filters->addFilter($filter, $this->menu->Name);
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