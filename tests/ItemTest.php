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

		$subItem = $item->get('bar');

		$this->assertEquals(3, count($item->items()));
		$this->assertTrue($subItem->exists());

		$subItem->remove();

		$this->assertFalse($subItem->exists());
		$this->assertEquals(2, count($item->items()));
	}

	public function testRemoveSubItems()
	{
		$item = $this->getItem();

		$item->add('foo');
		$item->add('bar');
		$item->add('blah');

		$this->assertEquals(3, count($item->items()));

		$item->remove('bar');

		$this->assertEquals(2, count($item->items()));
		$this->assertFalse($item->has('bar'));
	}

	protected function getItem()
	{
		$filters = new Menu\FilterRepository;

		return new Menu\Items\Item($filters);
	}
}