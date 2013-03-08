<?php

class MenuFactoryTest extends PHPUnit_Framework_TestCase {

	public function testCreateMenu()
	{
		$filters  = new Menu\FilterRepository;
		$renderer = new Menu\Renderer;
		$factory  = new Menu\Factory($filters, $renderer);

		$this->assertInstanceOf('Menu\Items\Collection', $factory->get('foo'));
	}

	public function testAddFilter()
	{
		$expected = function() {};

		$filters  = $this->getMock('Menu\FilterRepository');
		$filters->expects($this->once())
			->method('addFilter')
			->with($this->equalTo($expected), $this->equalTo(null));

		$renderer = new Menu\Renderer;
		$factory  = new Menu\Factory($filters, $renderer);

		$factory->filter($expected);
	}
}