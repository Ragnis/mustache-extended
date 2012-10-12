<?php

require_once(dirname(__FILE__) . '/../src/mustache.php');

class RendererTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var \Mustache\Renderer
	 */
	public $renderer;

	public function setUp ()
	{
		$this->renderer = new \Mustache\Renderer();
	}

	public function tearDown ()
	{
		$this->renderer = null;
	}

	/**
	 * Test simple variable rendering
	 */
	public function testRenderVariable ()
	{
		$out = $this->renderer->render('{{test}};{{deep.two}}', array(
			'test' => 'Hello',
			'deep' => array(
				'one' => '1',
				'two' => '2',
				'three' => '3'
			)
		));

		$this->assertSame($out, 'Hello;2');
	}

	/**
	 * Test rendering of boolean values
	 */
	public function testRenderVariableBool ()
	{
		$out = $this->renderer->render('{{yes}};{{no}}', array(
			'yes' => true,
			'no' => false
		));

		$this->assertSame($out, '1;');
	}

	/**
	 * Test rendering of undefined variables
	 */
	public function testRenderVariableUndefined ()
	{
		$out = $this->renderer->render('{{none}}', array(
			'hello' => 'hola'
		));

		$this->assertEmpty($out);
	}

	/**
	 * Test escaping and unescaping
	 */
	public function testRenderVariableEscape ()
	{
		// Test escaping
		$out = $this->renderer->render('{{test}}', array(
			'test' => 'Testing <b>HTML</b> escaping'
		));

		$this->assertSame($out, 'Testing &lt;b&gt;HTML&lt;/b&gt; escaping');

		// Test raw filter
		$out = $this->renderer->render('{{test|raw}}', array(
			'test' => 'Testing <b>HTML</b> escaping'
		));

		$this->assertSame($out, 'Testing <b>HTML</b> escaping');

		// Test triple-brace support
		$out = $this->renderer->render('{{{test}}}', array(
			'test' => 'Testing <b>HTML</b> escaping'
		));

		$this->assertSame($out, 'Testing <b>HTML</b> escaping');
	}

	/**
	 * Test boolean blocks
	 */
	public function testRenderBooleanBlock ()
	{
		// Test true block
		$out = $this->renderer->render('{{#test}}hello{{/test}}', array(
			'test' => true
		));

		$this->assertSame($out, 'hello');

		// Test false block
		$out = $this->renderer->render('{{#test}}hello{{/test}}', array(
			'test' => false
		));

		$this->assertEmpty($out);

		// Test negative true block
		$out = $this->renderer->render('{{^test}}hello{{/test}}', array(
			'test' => true
		));

		$this->assertEmpty($out);

		// Test negative false block
		$out = $this->renderer->render('{{^test}}hello{{/test}}', array(
			'test' => false
		));

		$this->assertSame($out, 'hello');
	}

	/**
	 * Test rendering of 1-dimensional arrays
	 */
	public function testRenderArray1D ()
	{
		$out = $this->renderer->render('{{#numbers}}{{.}}{{/numbers}}', array(
			'numbers' => array(1, 'two', 3, 'four')
		));

		$this->assertSame($out, '1two3four');
	}

	/**
	 * Test rendering of 2-dimensional arrays
	 */
	public function testRenderArray2D ()
	{
		$out = $this->renderer->render('{{#numbers}}{{n}}:{{name}};{{/numbers}}', array(
			'numbers' => array(
				array('n' => 1, 'name' => 'one'),
				array('n' => 2, 'name' => 'two'),
				array('n' => 3, 'name' => 'three')
			)
		));

		$this->assertSame($out, '1:one;2:two;3:three;');
	}
}
