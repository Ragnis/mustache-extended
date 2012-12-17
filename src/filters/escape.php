<?php

namespace Mustache\Filters;

class Escape extends \Mustache\Filter
{
	/**
	 * Set filter name
	 */
	public $name = 'escape';

	/**
	 * Filter
	 */
	public function filter ($data)
	{
		if (is_string($data) || is_bool($data) || is_numeric($data) || is_object($data))
		{
			return htmlspecialchars((string) $data);
		}
	}
}
