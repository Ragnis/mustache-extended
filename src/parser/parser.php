<?php

namespace Mustache;

class Parser
{
	/**
	 * Parse template
	 *
	 * @param string $template
	 * @return ParserNodeContainer
	 */
	public function parse ($template)
	{
		$root = new ParserNodeContainer();

		$search_offset_prev = 0;
		$search_offset = 0;

		$stack = array();

		// Use raw filter instead of triple-brace tags.
		$template = preg_replace('/\{\{\{([#^\/A-Za-z0-9_\-.|]+)\}\}\}/', '{{$1|raw}}', $template);

		while (preg_match('/\{\{(?<type>[#^\/])?(?<tag_name>[a-zA-Z0-9_\-.]+)(?<filters>[|][a-z0-9\-_|]+)?()\}\}/',
			$template, $matches, PREG_OFFSET_CAPTURE, $search_offset))
		{
			$match = $matches[0][0];
			$offset = $matches[0][1];
			$type = $matches['type'][0];
			$tag_name = $matches['tag_name'][0];
			$filters = array_filter(explode('|', $matches['filters'][0]));

			$search_offset_prev = $search_offset;
			$search_offset = $offset + strlen($match);

			$parent = count($stack) > 0 ? $stack[count($stack) - 1] : $root;

			$text = substr($template, $search_offset_prev, $offset - $search_offset_prev);

			if (strlen($text) > 0)
			{
				$parent->append(new ParserNodeText($text));
			}

			switch ($type)
			{
				case '^':
				case '#':
					$node = new ParserNodeBlock($tag_name, $type === '^');
					$node->filters = $filters;

					$parent->append($node);
					$stack[] = $node;
				break;

				case '/':
					$node = array_pop($stack);

					if ($node->variable !== $tag_name)
					{
						throw new TagMismatchException('Unexpected close: ' . $tag_name);
					}

					break;

				case '': // A variable
					$node = new ParserNodeVariable($tag_name);
					$node->filters = $filters;
					$parent->append($node);

					break;
			}
		}

		if (count($stack) !== 0)
		{
			throw new TagMismatchException('Unclosed tags');
		}

		// Insert the last block of text
		$node = new ParserNodeText(substr($template, $search_offset));
		$root->append($node);

		return $root;
	}
}
