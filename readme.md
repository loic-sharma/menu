# Menu Laravel Bundle

Create an HTML menu easily!

## A Few Examples

### Creating a new Menu

```php
<?php

$menu = Menu::create('main');

$menu->add('Home', URL::home());
$menu->add('Register', URL::to('register'));
$menu->add('Login', URL::to('login'));
$menu->add('Manage Account', URL::to('account'));

$menu->add('Nested Menu', 'multi-url', function($menu)
{
	$menu->add('First thing', 'first-url');
	$menu->add('Second thing', 'second-url');

	$menu->add('Nested Menu', 'another-url', function($menu)
	{
		$menu->add('test', 'test');
	});
});

$menu->add('Logout', URL::to('logout'));
```

### Filtering Menu Items

```php
<?php

// The filter should be registered BEFORE you add items to your menu.
Menu::add_filter(function($item)
{
	if(Auth::check())
	{
		// If the user is logged in, remove the register and login links
		// from the menu.
		$remove = array(URL::to('register'), URL::to('login'));
	}

	else
	{
		// If the user is logged out, remove the account and logout links
		// from the menu.
		$remove = array(URL::to('account'), URL::to('logout'));			
	}

	if(in_array($item->url, $remove))
	{
		// If the filter returns true, the item will be removed.
		return true;
	}
});
```

### Adding attributes to a Menu Items
```php
<?php

$menu = Menu::create('main');

$menu->add('Some link')->attibutes(array('style' => 'color: blue;'));

```

### Displaying a Menu

```php
<?php

$menu = Menu::create('main');

// ...

echo $menu

// Or:
echo Menu::get('main');
```