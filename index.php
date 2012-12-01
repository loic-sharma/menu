<?php

$autoloader = include 'vendor/autoload.php';

$autoloader->add('Menu', __DIR__.'/src/');

$factory = new Menu\Factory(new Menu\FilterRepository, new Menu\Renderer);

$menu = $factory->get('header');

$menu->add('Home', function($item)
{
	$item['url'] = '/';
	$item['a.class'] = 'test';
});

$menu->add('Blog', '/blog');

$menu->add('Menu', '/menu', function($menu)
{
	$menu->add('Item 1', '/menu/item-1');
	$menu->add('Item 2', '/menu/item-2');
});

echo $menu;