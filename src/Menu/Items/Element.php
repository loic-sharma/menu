<?php namespace Menu\Items;

class Element {

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
	 * @param  string  $name
	 * @return bool
	 */
	public function has($attribute)
	{
		return isset($this->attributes[$attribute]);
	}

	/**
	 * Fetch an element's attribute.
	 *
	 * @param  string  $name
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
	 * @param  string  $name
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
	 * Remove an element's attributes.
	 *
	 * @param  string  $name
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
}