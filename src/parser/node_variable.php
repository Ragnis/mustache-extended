<?php

namespace Mustache;

class ParserNodeVariable
{
	/**
	 * Variable name
	 *
	 * @var string
	 */
	public $variable = null;

	/**
	 * Filters that will be applied to this variable
	 *
	 * @var string[]
	 */
	public $filters = array();

	/**
	 * Constructor
	 *
	 * @param string $variable variable name
	 */
	public function __construct ($variable)
	{
		$this->variable = $variable;
	}
}
