<?php

include 'vendor/autoload.php';

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