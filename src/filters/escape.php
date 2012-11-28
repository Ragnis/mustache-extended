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
		return htmlspecialchars($data);
	}
}
