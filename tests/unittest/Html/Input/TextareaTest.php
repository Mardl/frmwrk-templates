<?php

namespace unittest\Html\Input;

use Templates\Html\Input\Textarea;

/**
 * Class TextareaTest
 *
 * @category Templates
 * @package  Unittest\Html\Input
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class TextareaTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var textarea
	 */
	protected $textarea = null;

	/**
	 * @return void
	 */
	public function testRows()
	{
		$this->textarea->rows('99');
		$ret = $this->readAttribute($this->textarea, 'tagAttributes');

		$this->assertEquals('99', $ret['rows']);
	}

	/**
	 * @return void
	 */
	public function testCols()
	{
		$this->textarea->cols('5');
		$ret = $this->readAttribute($this->textarea, 'tagAttributes');

		$this->assertEquals('5', $ret['cols']);
	}

	/**
	 * @return void
	 */
	public function testSetValue()
	{
		$this->textarea->setValue('foo');
		$ret = $this->readAttribute($this->textarea, 'value');

		$this->assertEquals('foo', $ret);
	}

	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->textarea = new Textarea('test');
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->textarea);
	}
}