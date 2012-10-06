<?php

namespace Mustache;

class ParserNodeContainer
{
	/**
	 * Children
	 *
	 * @int ParserNode[]
	 */
	public $children = array();

	/**
	 * Append a child node
	 *
	 * @param $node
	 */
	public function append ($node)
	{
		$this->children[] = $node;
	}
}
