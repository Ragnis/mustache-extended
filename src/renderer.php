<?php

namespace Mustache;

class Renderer
{
	/**
	 * Render a template
	 *
	 * @param string $template
	 * @param mixed $view
	 */
	public function render ($template, $vars)
	{
		$root = (new Parser())->parse($template);
		return $this->render_node($root, $vars);
	}

	/**
	 * Render a node
	 *
	 * @param $node
	 * @param ParserNodeContainer mixed $vars
	 * @return string
	 */
	protected function render_node (ParserNodeContainer $node, $vars)
	{
		$out = array();

		if (!is_object($vars))
		{
			$vars = (object) $vars;
		}

		foreach ($node->children as $child)
		{
			switch (get_class($child))
			{
				case 'Mustache\ParserNodeVariable':
					$var = $this->find_variable($child->variable, $vars);
					$var = $this->apply_filters($child->filters, $var);

					// Escape variables by default
					if (!in_array('raw', $child->filters))
					{
						$var = $this->apply_filters(array('escape'), $var);
					}

					$out[] = $var;
				break;

				case 'Mustache\ParserNodeText':
					$out[] = $child->text;
				break;

				case 'Mustache\ParserNodeBlock':
					$arg = $this->find_variable($child->variable, $vars);
					$arg = $this->apply_filters($child->filters, $arg);

					if (is_object($arg))
					{
						$arg = get_object_vars($arg);
					}

					if (is_array($arg))
					{
						foreach ($arg as $key => $value)
						{
							if (is_object($value))
							{
								$value = get_object_vars($value);
							}

							$local_vars = clone $vars;

							// Insert array item variables into local scope
							if (is_array($value))
							{
								$local_vars = (object) array_merge((array) $local_vars, $value);
							}
							else
							{
								$local_vars->{'.'} = $value;
							}

							// Create a fake parent for children so we can pass
							// them to parse_node
							$fake_parent = new ParserNodeContainer();
							$fake_parent->children = $child->children;

							$out[] = $this->render_node($fake_parent, $local_vars);
						}
					}
					else
					{
						if ((bool) $arg xor $child->negative)
						{
							$out[] = $this->render_node($child, $vars);
						}
					}
				break;

				default:
					if (get_class($child, 'Mustache\ParserNodeContainer'))
					{
						$out[] = $this->render_node($child, $vars);
					}
				break;
			}
		}

		return implode('', $out);
	}

	/**
	 * Apply filters on data
	 *
	 * @param string[] $filters
	 * @param mixed $data
	 * @return mixed
	 */
	protected function apply_filters (array $filters, $data)
	{
		foreach ($filters as $filter)
		{
			$data = Filter::call($filter, $data);
		}

		return $data;
	}

	/**
	 * Find a variable
	 *
	 * @param string $name
	 * @param mixed $vars
	 * @return mixed
	 */
	protected function find_variable ($name, $vars)
	{
		if (!is_object($vars))
		{
			$vars = (object) $vars;
		}

		if ($name === '.')
		{
			return isset($vars->{'.'}) ? $vars->{'.'} : null;
		}

		$name = explode('.', $name);
		$name_first = $name[0];

		if (isset($vars->{$name[0]}))
		{
			if (count($name) === 1)
			{
				return $vars->{$name[0]};
			}

			$name_first = $name[0];
			array_shift($name);

			return $this->find_variable(implode('.', $name), $vars->{$name_first});
		}

		return null;
	}
}
