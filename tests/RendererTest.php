<?php

class RenderTest extends PHPUnit_Framework_TestCase {

	public function testBasicMenu()
	{
		$factory  = new Menu\Factory;

		$menu = $factory->get('menu');

		$menu->add('Home', '/');
		$menu->add('Blog', '/blog');

		$menu->add('Menu', '/menu', function($menu)
		{
			$menu->add('Item 1', '/menu/item-1');
			$menu->add('Item 2', '/menu/item-2');
		});

		$this->assertEquals($this->view(__FUNCTION__), $menu->render());
	}

	public function testElementAliases()
	{
		$factory  = new Menu\Factory;

		$menu = $factory->get('menu');

		$menu->add('Link', function($item)
		{
			$item->url = '/uri';

			$item->link->id = 'a-id';
			$item->link->class = 'a-class';

			$item->label->id = 'li-id';
			$item->label->class = 'li-class';

			$item->list->id = 'ul-id';
			$item->list->class = 'ul-class';

			$item->add('Sub-Link');
		});

		$this->assertEquals($this->view(__FUNCTION__), $menu->render());
	}

	public function testSingleItemClassDoesNotOverwrite()
	{
		$factory  = new Menu\Factory;

		$menu = $factory->get('menu');

		$menu->add('First', 'first', function($item)
		{
			$item->add('Second', 'second', function($item)
			{
				$item->element('li')->attribute('class', 'foo');
			});
		});

		$this->assertEquals($this->view(__FUNCTION__), $menu->render());
	}

	protected function view($test)
	{
		return file_get_contents(__DIR__.'/views/'.$test.'.html');
	}
}