<?php

class ElementTest extends PHPUnit_Framework_TestCase {

	public function testAddAttribute()
	{
		$element = new Menu\Items\Element;

		$this->assertFalse($element->has('foo'));

		$element->attribute('foo', 'bar');

		$this->assertEquals('bar', $element->attribute('foo'));
		$this->assertTrue($element->has('foo'));
	}

	public function testMagicMethods()
	{
		$element = new Menu\Items\Element;		

		$element->foo = 'bar';

		$this->assertEquals('bar', $element->foo);
	}

	public function testAppendElementAttribute()
	{
		$element = new Menu\Items\Element;

		$element->attribute('foo', 'bar');
		$element->append('foo', 'baz');

		$this->assertEquals('bar baz', $element->attribute('foo'));
	}

	public function testRemoveElementAttribute()
	{
		$element = new Menu\Items\Element;

		$element->attribute('foo', 'bar');

		$this->assertEquals('bar', $element->attribute('foo'));
		$this->assertTrue($element->has('foo'));

		$element->remove('foo');
		$this->assertFalse($element->has('foo'));
	}

	public function testGetElementAttributes()
	{
		$expected = array('foo' => 'bar', 'bob' => 'marley');

		$element = new Menu\Items\Element;

		$element->attribute('foo', 'bar');
		$element->attribute('fooz', 'baz');
		$element->attribute('bob', 'marley');
		$element->remove('fooz');

		$this->assertEquals($expected, $element->attributes());
	}
}