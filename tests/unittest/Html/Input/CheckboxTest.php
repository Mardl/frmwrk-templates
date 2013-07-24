<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sebastian.Rupp
 * Date: 24.07.13
 * Time: 11:27
 * To change this template use File | Settings | File Templates.
 */

namespace unittest\Html\Input;


use Templates\Html\Input\Checkbox;

class CheckboxTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @return void
	 */
	public function testConstruct()
	{
		$checkbox = new Checkbox('test', 'test1');

		$expected = array(
			'type' => 'checkbox',
			'id' => 'test',
			'name' => 'test',
			'value' => 'test1'
		);

		$this->assertSame($expected, $this->readAttribute($checkbox, 'tagAttributes'));
	}

	/**
	 * @return void
	 */
	public function testCheckedEXPDefault()
	{
		$checkbox = new Checkbox('test', 'test1');

		$checkbox->checked();

		$expected = array(
			'type' => 'checkbox',
			'id' => 'test',
			'name' => 'test',
			'value' => 'test1',
			'checked' => 'checked'
		);

		$this->assertSame($expected, $this->readAttribute($checkbox, 'tagAttributes'));
	}

	/**
	 * @return void
	 */
	public function testChecked()
	{
		$checkbox = new Checkbox('test', 'test1');

		$checkbox->checked();

		$expected = array(
			'type' => 'checkbox',
			'id' => 'test',
			'name' => 'test',
			'value' => 'test1',
			'checked' => 'checked'
		);

		$this->assertSame($expected, $this->readAttribute($checkbox, 'tagAttributes'));

		$checkbox->checked(false);

		$expected = array(
			'type' => 'checkbox',
			'id' => 'test',
			'name' => 'test',
			'value' => 'test1',
		);

		$this->assertSame($expected, $this->readAttribute($checkbox, 'tagAttributes'));
	}

	/**
	 * @return void
	 */
	public function testValidateEXPRequiredAndChecked()
	{
		$checkbox = new Checkbox('test', 'test1', '', true);

		$checkbox->checked(false);

		$this->assertEquals('Fehlende Eingabe für test', $checkbox->validate());
	}

	/**
	 * @return void
	 */
	public function testValidate()
	{
		$checkbox = new Checkbox('test', 'test1');

		$this->assertTrue($checkbox->validate());
	}

	/**
	 * @return void
	 */
	public function testToString()
	{
		$checkbox = new Checkbox('test', 'test1', 'place' , false, array('test'));

		$checkbox->addAttribute('class', array('test4', 'test5'));

		$this->assertEquals('<label class="test4 test5"><input 0="test" type="checkbox" id="test" name="test" value="test1" />place</label>', $checkbox->toString());
	}
}
