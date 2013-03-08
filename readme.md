# Menu Package

Create an HTML menu easily!

## A Few Examples

### Creating a New Menu

```php
<?php

$factory = new Menu\Factory(new Menu\FilterRepository, new Menu\Renderer);

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

### Adding Attributes to an Item

```php
<?php

$menu->add('Name', function($item)
{
	$item['url'] = '/uri';

	$item['li.id']    = 'name-id';
	$item['li.class'] = 'name-class';
	$item['a.class']  = 'another-class';
});

```

### Filtering Menu Items

Filters can be used to either remove an item from a menu, or to add more attributes to an item.

```php
<?php

// Filter all the menus.
$factory->filter(function($item)
{
	if($item->name = 'Admin' or $item['url'] == '/admin')
	{
		// Returning true will remove the item from the menu.
		return true;
	}
});

// Filter a specific menu.
$menu->filter(function($item)
{
	// Modify the li elements.
	$item['li.class'] = 'prettify';
});

```