<?php namespace menu;

class HTML extends \Laravel\HTML {

	/**
	 * Generate a HTML link.
	 *
	 * <code>
	 *		// Generate a link to a location within the application
	 *		echo HTML::link('user/profile', 'User Profile');
	 *
	 *		// Generate a link to a location outside of the application
	 *		echo HTML::link('http://google.com', 'Google');
	 * </code>
	 *
	 * @param  string  $url
	 * @param  string  $title
	 * @param  array   $attributes
	 * @param  bool    $https
	 * @return string
	 */
	public static function link($url, $title, $attributes = array(), $https = false)
	{
		return '<a href="'.$url.'"'.static::attributes($attributes).'>'.static::entities($title).'</a>';
	}

	/**
	 * Generate a list of items.
	 *
	 * @param  array   $list
	 * @param  array   $attributes
	 * @return string
	 */
	public static function menu($items, $attributes = array())
	{
		$html = '<ul'.static::attributes($attributes).'>'.PHP_EOL;

		foreach($items as $item)
		{
			if( ! is_null($item->url))
			{
				$menu_item = static::link($item->url, $item->name, $item->attributes);
			}

			else
			{
				$menu_item = static::entities($item->name);
			}

			if( ! is_null($item->items))
			{
				$menu_item .= static::menu($item->items, $attributes);
			}

			$html .= '<li>'.$menu_item.'</li>'.PHP_EOL;
		}

		return $html.'</ul>';
	}
}