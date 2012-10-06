<?php

namespace Mustache;

class Autoloader
{
	protected static $classes = array(
		'Mustache\Renderer' => 'renderer.php',
		'Mustache\Parser' => 'parser/parser.php',
		'Mustache\ParserNodeContainer' => 'parser/node_container.php',
		'Mustache\ParserNodeBlock' => 'parser/node_block.php',
		'Mustache\ParserNodeVariable' => 'parser/node_variable.php',
		'Mustache\ParserNodeText' => 'parser/node_text.php',
		'Mustache\Filter' => 'filter.php',
		'Mustache\Filters\Raw' => 'filters/raw.php',
		'Mustache\Filters\Escape' => 'filters/escape.php',
		'Mustache\Filters\Bool' => 'filters/bool.php',
		'Mustache\TagMismatchException' => 'exceptions/tag_mismatch.php',
		'Mustache\FilterNotFoundException' => 'excpetions/filter_not_found.php'
	);

	/**
	 * Load a class
	 *
	 * @param string $class
	 */
	public static function load ($class)
	{
		$root = dirname(__FILE__);
		
		if (isset(self::$classes[$class]))
		{
			require_once($root . '/' . self::$classes[$class]);
		}
	}

	/**
	 * Register the autoloader
	 */
	public static function register ()
	{
		spl_autoload_register(__CLASS__ . '::load');
	}
}

// Register the autoloader
Autoloader::register();

// Register core filters
Filter::register(new Filters\Raw());
Filter::register(new Filters\Escape());
Filter::register(new Filters\Bool());
