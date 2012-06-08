<?php

class Menu {

	protected static $instances = array();
	protected static $last_instance = null;

	protected static $filters = array();

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

	public static function get($instance = null)
	{
		return static::instance($instance);
	}

	public static function create($instance = null)
	{
		if(isset(static::$instances[$instance]))
		{
			unset(static::$instances[$instance]);
		}

		return static::instance($instance);
	}

	public static function add_filter($filter)
	{
		static::$filters[] = $filter;
	}

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