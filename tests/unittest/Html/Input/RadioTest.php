<?php

namespace unittest\Html\Input;


use Templates\Html\Input\Radio;

/**
 * Class RadioTest
 *
 * @category Templates
 * @package  Unittest\Html\Input
 * @author   Sebastian Rupp <sebastian@dreiwerken.de>
 */
class RadioTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var radio
	 */
	protected $radio = null;

	/**
	 * @return void
	 */
	public function testConstruct()
	{
		$expected = array(
			'type' => 'radio',
			'id' => 'test',
			'name' => 'test',
			'value' => ''
		);

		$this->assertEquals($expected, $this->readAttribute($this->radio, 'tagAttributes'));
	}

	/**
	 * @return void
	 */
	public function testAddOption()
	{
		$this->radio->addOption('foo', 'bar', false);

		$expected = array(
			array(
				0 => 'foo',
				1 => 'bar',
				2 => false
			)
		);

		$this->assertEquals($expected, $this->readAttribute($this->radio, 'options'));
	}

	/**
	 * @return void
	 */
	public function testSetOptionEXPNotEmpty()
	{
		$obj = array(
			'foo' => 'bar',
			'test' => '123'
		);

		$this->radio->setOption($obj);

		$expected = array(
			0 => array(
				0 => 'foo',
				1 => 'bar',
				2 => false
			),
			1 => array(
				0 => 'test',
				1 => '123',
				2 => false
			)
		);

		$this->assertEquals($expected, $this->readAttribute($this->radio, 'options'));
	}

	/**
	 * @return void
	 */
	public function testGetOptions()
	{
		$this->radio->addOption('foo', 'bar', true);

		$expected = array(
			0 => array(
				0 => 'foo',
				1 => 'bar',
				2 => true
			)
		);

		$this->assertEquals($expected, $this->radio->getOptions());
	}

	/**
	 * @return void
	 */
	public function testValidate()
	{
		$ret = $this->radio->validate();

		$this->assertEquals(true, $ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPIsRequired()
	{

		$this->radio->addOption('foo', 'bar', true);
		$this->radio->setRequired();

		$ret = $this->radio->validate();

		$this->assertEquals(true, $ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPIsRequiredNotFound()
	{

		$this->radio->addOption('foo', 'bar');
		$this->radio->setRequired();

		$ret = $this->radio->validate();

		$this->assertEquals('Fehlende Eingabe für test', $ret);
	}

	/**
	 * @return void
	 */
	public function testToString()
	{
		$ret = $this->radio->toString();

		$this->assertEquals('', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPOptions()
	{
		$obj = array(
			'foo' => 'bar',
			'test' => '123'
		);

		$this->radio->setOption($obj);
		$ret = $this->radio->toString();

		$this->assertEquals('<label ><input type="radio" id="test-1" name="test" value="foo" />bar</label><label ><input type="radio" id="test-2" name="test" value="test" />123</label>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPOptionsChecked()
	{
		$obj = array(
			'foo' => 'bar'
		);

		$this->radio->setOption($obj);
		$this->radio->addOption('check', 'this', true);
		$ret = $this->radio->toString();

		$this->assertEquals('<label ><input type="radio" id="test-1" name="test" value="foo" />bar</label><label ><input type="radio" id="test-2" name="test" value="check" checked="checked" />this</label>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPOptionsClass()
	{
		$radio = new Radio('test', '', array('foo' => 'foo', 'bar' => 'bar'), false, 'place', 'testclass');
		$ret = $radio->toString();

		$this->assertEquals('<label class="testclass"><input type="radio" id="test-1" name="test" value="foo" />foo</label><label class="testclass"><input type="radio" id="test-2" name="test" value="bar" />bar</label>', $ret);
	}


	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->radio = new Radio('test');
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->radio);
	}
}
