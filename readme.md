# Menu Package

Create an HTML menu easily!

## A Few Examples

### Creating a New Menu

```php
<?php

$factory = new Menu\Factory;

$menu = $factory->get('header');

$menu->add('Home', '/');
$menu->add('Blog', '/blog');

$menu->add('Menu', '/menu', function($menu)
{
	$menu->add('Item 1', '/menu/item-1');
	$menu->add('Item 2', '/menu/item-2');
});

echo $menu;

```

### Adding Attributes to Menus

```php
<?php

$menu->add('Link', function($item)
{
	$item->url = '/uri';

	$item->link->id = 'a-id';
	$item->link->class = 'a-class';

	$item->label->id = 'li-id';
	$item->label->class = 'li-class';

	$item->list->id = 'ul-id';
	$item->list->class = 'ul-class';

	// Or:
	$item->element('list')->attribute('id', 'ul-id');

	// Or:
	$item->attribute('list.id', 'ul-id');

	// Or;
	$item['list.id'] = 'ul-id';

	// Or:
	$item->element('li', function($element)
	{
		$element->id = 'name-id';
		$element->class = 'name-class';
	});
});
```

### Filtering Menu Items

Filters can be used to either remove an item from a menu, or to add more attributes to an item.

```php
<?php

// Filter all the menus.
$factory->addFilter(function($item)
{
	// Remove any items that have the name 'Admin'
	if($item->name == 'Admin')
	{
		$item->remove();
	}
});

// Filter a specific menu.
$menu->addFilter(function($item)
{
	// Modify the li elements.
	$item['li.class'] = 'prettify';
});

```