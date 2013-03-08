<?php

class FilterTest extends PHPUnit_Framework_TestCase {

	public function testAddFilters()
	{
		$filters = new Menu\FilterRepository;

		$filters->addFilter(function() {});
		$filters->addFilter(function() {});
		$filters->addFilter(function() {}, 'foo');

		$this->assertEquals(2, count($filters->getFilters()));
		$this->assertEquals(3, count($filters->getFilters('foo')));
	}

	public function testFilterItems()
	{
		$filters = new Menu\FilterRepository;
		$renderer = new Menu\Renderer;
		$item = new Menu\Items\Item('foo', $filters, $renderer);

		$filters->addFilter(function($item)
		{
			return false;
		});

		$filters->addFilter(function($item)
		{
			return true;
		}, 'bar');

		$this->assertFalse($filters->filter($item));
		$this->assertTrue($filters->filter($item, 'bar'));
	}
}