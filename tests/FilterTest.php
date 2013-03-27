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

		$item = new Menu\Items\Item($filters);

		$filters->addFilter(function($item) {});

		$filters->addFilter(function($item)
		{
			$item->remove();

		}, 'bar');

		$this->assertTrue($item->exists());

		$filters->filter($item);

		$this->assertTrue($item->exists());

		$filters->filter($item, 'bar');

		$this->assertFalse($item->exists());
	}
}