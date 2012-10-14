<?php

namespace Mustache\Filters;

class ToA extends \Mustache\Filter
{
	/**
	 * Set filter name
	 */
	public $name = 'to_a';

	/**
	 * Filter
	 */
	public function filter ($data)
	{
		if (is_array($data))
		{
			return array_values($data);
		}

		return (array) $data;
	}
}
