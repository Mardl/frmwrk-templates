<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sebastian.Rupp
 * Date: 24.07.13
 * Time: 13:46
 * To change this template use File | Settings | File Templates.
 */

namespace unittest\Html\Input;


use Templates\Html\Input\Radio;

class RadioTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @return void
	 */
	public function testConstruct()
	{
		$radio = new Radio('test');

		$expected = array(
			'type' => 'radio',
			'id' => 'test',
			'name' => 'test',
			'value' => ''
		);

		$this->assertEquals($expected, $this->readAttribute($radio, 'tagAttributes'));
	}

	/**
	 * @return void
	 */
	public function testAddOption()
	{
		$radio = new Radio('test');

		$radio->addOption('foo', 'bar', false);

		$expected = array(
			array(
				0 => 'foo',
				1 => 'bar',
				2 => false
			)
		);

		$this->assertEquals($expected, $this->readAttribute($radio, 'options'));
	}

	/**
	 * @return void
	 */
	public function testSetOptionEXPNotEmpty()
	{
		$radio = new Radio('test', '', array());

		$obj = array(
			'foo' => 'bar',
			'test' => '123'
		);

		$radio->setOption($obj);

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

		$this->assertEquals($expected, $this->readAttribute($radio, 'options'));
	}

	/**
	 * @return void
	 */
	public function testGetOptions()
	{
		$radio = new Radio('test');

		$radio->addOption('foo', 'bar', true);

		$expected = array(
			0 => array(
				0 => 'foo',
				1 => 'bar',
				2 => true
			)
		);

		$this->assertEquals($expected, $radio->getOptions());
	}

	/**
	 * @return void
	 */
	public function testValidate()
	{
		
	}
}
