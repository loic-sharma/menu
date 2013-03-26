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

	public function testRemoveItem()
	{
		$item = $this->getItem();

		$item->add('foo');
		$item->add('bar');
		$item->add('blah');

		$this->assertEquals(3, $item->items());

		$item->get('bar')->remove();

		$this->assertEquals(2, $item->items());
	}

	public function testRemoveSubItems()
	{
		$item = $this->getItem();

		$item->add('foo');
		$item->add('bar');
		$item->add('blah');

		$this->assertEquals(3, $item->items());

		$item->remove('bar');

		$this->assertEquals(2, $item->items());
	}

	protected function getItem()
	{
		$filters = new Menu\FilterRepository;
		$renderer = new Menu\Renderer;

		return new Menu\Items\Item('menu', $filters, $renderer);
	}
}