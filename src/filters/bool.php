<?php

namespace Mustache\Filters;

class Bool extends \Mustache\Filter
{
	/**
	 * Set filter name
	 */
	public $name = 'bool';

	/**
	 * Filter
	 */
	public function filter ($data)
	{
		return (bool) $data;
	}
}
