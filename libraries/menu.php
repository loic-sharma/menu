<?php

class Menu {

	/**
	 * All of the instances of the created menus.
	 *
	 * @var array
	 */
	protected static $instances = array();

	/**
	 * The name of the last used menu.
	 *
	 * @var string
	 */
	protected static $last_instance;

	/**
	 * All of the registered item filters.
	 *
	 * @var array
	 */
	protected static $filters = array();

	/**
	 * Create a new instance of a menu.
	 *
	 * @param  string           $instance
	 * @return Item_Collection
	 */
	public static function instance($instance = null)
	{
		if(is_null($instance))
		{
			$instance = static::$last_instance;
		}

		else
		{
			static::$last_instance = $instance;
		}

		if( ! isset(static::$instances[$instance]))
		{
			static::$instances[$instance] = new Menu\Item_Collection;
		}

		return static::$instances[$instance];
	}

	/**
	 * Get the instance of a created menu.
	 *
	 * @param  string           $instance
	 * @return Item_Collection
	 */ 
	public static function get($instance = null)
	{
		return static::instance($instance);
	}

	/**
	 * Create a new menu.
	 *
	 * @param  string           $instance
	 * @return Item_Collection
	 */ 
	public static function create($instance = null)
	{
		if(isset(static::$instances[$instance]))
		{
			unset(static::$instances[$instance]);
		}

		return static::instance($instance);
	}

	/**
	 * Add an item filter.
	 *
	 * @param  Closure  $filter
	 * @return void
	 */
	public static function add_filter($filter)
	{
		static::$filters[] = $filter;
	}

	/**
	 * Filter an item.
	 *
	 * @param  Item  $item
	 * @return bool
	 */
	public static function filter($item)
	{
		foreach(static::$filters as $filter)
		{
			if($filter($item) == true)
			{
				return true;
			}
		}

		return false;
	}
}