<?php

namespace Mustache;

class ParserNodeBlock extends ParserNodeContainer
{
	/**
	 */
	public $variable = null;

	/**
	 */
	public $negative = false;

	/**
	 * Filters that will be applied to the block argument
	 *
	 * @var string[]
	 */
	public $filters = array();

	/**
	 * Constructor
	 */
	public function __construct ($variable, $negative = false)
	{
		$this->variable = $variable;
		$this->negative = $negative;
	}
}
