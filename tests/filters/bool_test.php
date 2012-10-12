<?php

require_once(dirname(__FILE__) . '/../../src/mustache.php');

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

	public function testTrue ()
	{
		$out = $this->renderer->render('{{test|bool}}', array('test' => true));
		$this->assertSame($out, '1');

		$out = $this->renderer->render('{{test|bool}}', array('test' => 1));
		$this->assertSame($out, '1');

		$out = $this->renderer->render('{{test|bool}}', array('test' => 'hi'));
		$this->assertSame($out, '1');

		$out = $this->renderer->render('{{test|bool}}', array('test' => '0'));
		$this->assertSame($out, '1');

		$out = $this->renderer->render('{{test|bool}}', array('test' => '0x00'));
		$this->assertSame($out, '1');
	}

	public function testFalse ()
	{
		$out = $this->renderer->render('{{test|bool}}', array('test' => false));
		$this->assertEmpty($out);

		$out = $this->renderer->render('{{test|bool}}', array('test' => 0));
		$this->assertEmpty($out);

		$out = $this->renderer->render('{{test|bool}}', array('test' => ''));
		$this->assertEmpty($out);
	}
}
