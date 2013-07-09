<?php

class RenderTest extends PHPUnit_Framework_TestCase {

	public function testSingleItemClassDoesNotOverwrite()
	{
		$filters  = new Menu\FilterRepository;
		$renderer = new Menu\Renderer;
		$factory  = new Menu\Factory($filters, $renderer);

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