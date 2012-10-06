<?php

namespace Mustache\Filters;

class Raw extends \Mustache\Filter
{
	/**
	 * Set filter name
	 */
	public $name = 'raw';

	/**
	 * Filter
	 */
	public function filter ($data)
	{
		return $data;
	}
}
