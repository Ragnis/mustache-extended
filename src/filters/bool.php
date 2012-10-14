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
		if ($data === '0')
		{
			return true;
		}

		return (bool) $data;
	}
}
