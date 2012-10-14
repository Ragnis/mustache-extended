<?php

require_once(dirname(__FILE__) . '/../../src/mustache.php');

class Filters_ToATest extends PHPUnit_Framework_TestCase
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

	public function testFilter ()
	{
		$out = $this->renderer->render('{{#array|to_a}}{{.}};{{/array}}', array(
			'array' => array(
				'one' => 'one',
				'two' => 'two',
				'three' => 'three'
			)
		));
		
		$this->assertSame($out, 'one;two;three;');

		$out = $this->renderer->render('{{#array|to_a}}{{n}};{{/array}}', array(
			'array' => array(
				'one' => array('n' => 'one'),
				'two' => array('n' => 'two'),
				'three' => array('n' => 'three')
			)
		));

		$this->assertSame($out, 'one;two;three;');
	}
}
