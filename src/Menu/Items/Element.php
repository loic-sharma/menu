<?php namespace Menu\Items;

use ArrayAccess;

class Element implements ArrayAccess {

	/**
	 * The element's attributes.
	 *
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * Fetch the element's attributes.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return $this->attributes;
	}

	/**
	 * Verify if the element has an attribute.
	 *
	 * @param  string  $attribute
	 * @return bool
	 */
	public function has($attribute)
	{
		return isset($this->attributes[$attribute]);
	}

	/**
	 * Fetch an element's attribute.
	 *
	 * @param  string  $attribute
	 * @param  string  $value
	 * @return string
	 */
	public function attribute($attribute, $value = null)
	{
		if( ! is_null($value))
		{
			$this->attributes[$attribute] = $value;
		}

		return $this->attributes[$attribute];
	}

	/**
	 * Append to the value of an element's attribute.
	 *
	 * @param  string  $attribute
	 * @param  string  $value
	 * @return void
	 */
	public function append($attribute, $value)
	{
		if(isset($this->attributes[$attribute]))
		{
			$this->attributes[$attribute] .= ' '.$value;
		}

		else
		{
			$this->attributes[$attribute] = $value;
		}
	}

	/**
	 * Remove an element's attribute.
	 *
	 * @param  string  $attribute
	 * @return void
	 */
	public function remove($attribute)
	{
		unset($this->attributes[$attribute]);
	}

	/**
	 * Get an attribute.
	 *
	 * @param  string  $key
	 * @return string
	 */
	public function __get($key)
	{
		return $this->attribute($key);
	}

	/**
	 * Set an attribute.
	 *
	 * @param  string  $key
	 * @param  string  $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->attribute($key, $value);
	}

	/**
	 * Check that an attribute exists.
	 *
	 * @param  string  $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return $this->has($offset);
	}

	/**
	 * Get an attribute.
	 *
	 * @param  string  $offset
	 * @return string
	 */
	public function offsetGet($offset)
	{
		return $this->attribute($offset);
	}

	/**
	 * Set an attribute.
	 *
	 * @param  string  $offset
	 * @param  string  $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		return $this->attribute($offset, $value);
	}

	/**
	 * Remove an element's attribute.
	 *
	 * @param  string  $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		$this->remove($offset);
	}
}