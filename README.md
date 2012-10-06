Mustache Extended
=================

Mustache Extended is a mustache-like template renderer with some extra
functionality. Some things like partials and lambdas have been removed.

Basic usage
-----------

	require_once('lib/mustache.php');

	$renderer = new \Mustache\Renderer();
	echo $renderer->render('Hello {{who}}', array(
		'who' => 'world'
	));

Filters
-------

One way to use filters is with variables:

	{{myvar|myfilter}}

This code will first apply filter `myfilter` on variable `myvar` and then
display the the result. You can also use multiple filters on a variable. In that
case the filters would be executed from left to right.

It is also possible to use filters with blocks. You can find an example for
doing so below.

### Creating your own filters

	class Bold extends \Mustache\Filter
	{
		public $name = 'bold';

		public function filter ($data)
		{
			return '<strong>' . $data . '</strong>';
		}
	}

	\Mustache\Filter::register(new Bold());

### Built-in filters

#### raw
Using this filter will prevent the engine from automatically escaping the
variable. This has no effect on blocks.

#### bool
This filter will convert the variable into a boolean value. This can be
especially useful when used with blocks:

	{{#problems|bool}}
		Some problems were found:
		{{#problems}}
			{{.}}<br />
		{{/problems}}
	{{/problems}}

With the following dataset:

	array(
		'problems' => array(
			'Lorem ipsum dolor sit amet',
			'Donec ut imperdiet lorem'
		)
	)
