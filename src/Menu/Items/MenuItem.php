<?php

namespace Menu\Items;

class MenuItem extends Item {

	/**
	 * Render the current item.
	 *
	 * @return string
	 */
	public function render()
	{
		return $this->renderer->renderItem($this);
	}
}