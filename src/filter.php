<?php

namespace Mustache;

abstract class Filter
{
	/**
	 * Filter name
	 *
	 * @var string
	 */
	public $name = null;

	/**
	 * Array of registered filters
	 */
	protected static $filters = array();

	/**
	 * Register a filter
	 *
	 * @param Filter $filter
	 */
	public static function register ($filter)
	{
		self::$filters[$filter->name] = $filter;
	}

	/**
	 * Call a filter
	 *
	 * @param string $name
	 * @param mixed $data
	 */
	public static function call ($name, $data)
	{
		if (!isset(self::$filters[$name]))
		{
			throw new FilterNotFoundException('Filter: ' . $name);
		}

		return self::$filters[$name]->filter($data);
	}

	abstract public function filter ($data);
}
