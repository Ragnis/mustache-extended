<?php

namespace Mustache;

class ParserNodeText
{
	/**
	 * Text
	 *
	 * @param string
	 */
	public $text = null;

	/**
	 * Constructor
	 *
	 * @param string $text
	 */
	public function __construct ($text)
	{
		$this->text = $text;
	}
}
