<?php

namespace unittest\Html;

use Templates\Html\Input;

/**
 * Class InuptTest
 *
 * @category Templates
 * @package  Unittest\Html
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class InputTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var input
	 */
	protected $input = null;

	/**
	 * @param string $object
	 * @param string $propertyName
	 * @param string $value
	 * @return \ReflectionProperty
	 */
	protected function setValueToProperty($object, $propertyName, $value)
	{
		$refl = new \ReflectionObject($object);
		$prop = $refl->getProperty($propertyName);
		$prop->setAccessible(true);
		$prop->setValue($object, $value);

		return $prop;
	}


	/**
	 * @return void
	 */
	public function testConstructEXPPlaceholder()
	{
		$inp = new Input('foo', 'bar', 'test');
		$ret = $this->readAttribute($inp, 'placeholder');

		$this->assertEquals('test', $ret);
	}

	/**
	 * @return void
	 */
	public function testSetRequired()
	{
		$this->input->setRequired();
		$ret = $this->readAttribute($this->input, 'required');

		$this->assertEquals(true, $ret);

		$this->input->setRequired(false);
		$ret2 = $this->readAttribute($this->input, 'required');

		$this->assertEquals(false, $ret2);
	}

	/**
	 * @return void
	 */
	public function testIsRequired()
	{
		$this->setValueToProperty($this->input, 'required', true);
		$this->assertEquals(true, $this->input->isRequired());
	}


	/**
	 * @return void
	 */
	public function testSetValue()
	{
		$this->input->setValue('foo');
		$ret = $this->readAttribute($this->input, 'value');

		$this->assertEquals('foo', $ret);

	}

	/**
	 * @return void
	 */
	public function testGetValue()
	{
		$this->setValueToProperty($this->input, 'value', 'foo');
		$this->assertEquals('foo', $this->input->getValue());
	}

	/**
	 * @return void
	 */
	public function testSetName()
	{
		$this->input->setName('test');
		$ret = $this->readAttribute($this->input, 'tagAttributes');

		$this->assertEquals('test', $ret['name']);
	}

	/**
	 * @return void
	 */
	public function testGetName()
	{
		$this->setValueToProperty($this->input, 'tagAttributes', array('name' => 'test'));

		$this->assertEquals('test', $this->input->getName());
	}


	/**
	 * @return void
	 */
	public function testSetType()
	{
		$this->input->setType('submit');
		$ret = $this->readAttribute($this->input, 'tagAttributes');

		$this->assertEquals('submit', $ret['type']);
	}

	/**
	 * @return void
	 */
	public function testSetTypeEXPDefault()
	{
		$this->input->setType('');
		$ret = $this->readAttribute($this->input, 'tagAttributes');

		$this->assertEquals('text', $ret['type']);
	}


	/**
	 * @return void
	 */
	public function testSetPlaceholder()
	{
		$this->input->setPlaceholder('foo');
		$ret = $this->readAttribute($this->input, 'placeholder');

		$this->assertEquals('foo', $ret);
	}


	/**
	 * @return void
	 */
	public function testGetErrorLabel()
	{
		$this->input->setPlaceholder('foo');
		$ret = $this->input->getErrorLabel();

		$this->assertEquals('foo', $ret);
	}

	/**
	 * @return void
	 */
	public function testGetErrorLabelEXPDefault()
	{
		$ret = $this->input->getErrorLabel();

		$this->assertEquals('Test', $ret);
	}

	/**
	 * @return void
	 */
	public function testValidate()
	{
		$this->setValueToProperty($this->input, 'required', true);
		$this->setValueToProperty($this->input, 'value', '');

		$ret = $this->input->validate();

		$this->assertEquals('Fehlende Eingabe für Test', $ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPOk()
	{
		$ret = $this->input->validate();

		$this->assertEquals(true, $ret);
	}


	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->input = new Input('Test');
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->input);
	}
}