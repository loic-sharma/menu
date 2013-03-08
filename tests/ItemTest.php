<?php

class ItemTest extends PHPUnit_Framework_TestCase {

	public function testGetElement()
	{
		$item = $this->getItem();

		$this->assertInstanceOf('Menu\Items\Element', $item->element('foo'));
	}

	public function testSetElementAttributesThroughClosure()
	{
		$expected = 'baz';
		$item = $this->getItem();
		$me = $this;

		$item->element('foo', function($element) use($me, $expected)
		{
			$me->assertInstanceOf('Menu\Items\Element', $element);

			$element->bar = $expected;
		});

		return $this->assertEquals($expected, $item->element('foo')->bar);
	}

	protected function getItem()
	{
		$filters = new Menu\FilterRepository;
		$renderer = new Menu\Renderer;

		return new Menu\Items\Item('menu', $filters, $renderer);
	}
}