<?php

namespace Menu\Items;

class Collection extends Item {

	public function filter($closure)
	{
		$this->filters->addFilter($closure, $this->menuName);
	}

	public function render()
	{
		return $this->renderer->renderMenu($this);
	}
}