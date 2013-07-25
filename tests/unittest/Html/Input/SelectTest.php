<?php

namespace unittest\Html\Input;


use Templates\Html\Input\Select;

/**
 * Class SelectTest
 *
 * @category Templates
 * @package  Unittest\Html\Input
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class SelectTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var select
	 */
	protected $select = null;

	/**
	 * @return void
	 */
	public function testValidate()
	{
		$ret = $this->select->validate();
		$this->assertEquals(true, $ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPnotFound()
	{
		$this->select->addOption('foo', 'bar');
		$this->select->setRequired();

		$ret = $this->select->validate();
		$this->assertEquals('Fehlende Eingabe für test', $ret);
	}

	/**
	 * @return void
	 */
	public function testSetOption()
	{
		$opt = array('foo' => 'bar', 'test' => '123');
		$this->select->setOption($opt);

		$ret = $this->readAttribute($this->select, 'options');

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

		$this->assertEquals($expected, $ret);
	}

	/**
	 * @return void
	 */
	public function testSetOptionEXParray()
	{
		$opt = array('foo' => array('test' => '123', 'test2' => '456'), 'test' => '123');
		$this->select->setOption($opt);

		$ret = $this->readAttribute($this->select, 'options');
		$group = $this->readAttribute($this->select, 'optGroups');

		$expected = array(
			array(
				0 => 'test',
				1 => '123',
				2 => false
			)
		);

		$expectedGroup = array(
			'foo' => array(
				0 => array(
					0 => 'test',
					1 => '123',
					2 => false
				),
				1 => array(
					0 => 'test2',
					1 => '456',
					2 => false
				)
			)
		);

		$this->assertEquals($expected, $ret);
		$this->assertEquals($expectedGroup, $group);
	}


	/**
	 * @return void
	 */
	public function testAddOption()
	{
		$this->select->addOption('foo', 'bar', false);
		$this->select->addOption('test', '123', true);
		$ret = $this->readAttribute($this->select, 'options');

		$this->assertEquals(
			array(
				0 => array(
					0 => 'foo',
					1 => 'bar',
					2 => false
				),
				1 => array(
					0 => 'test',
					1 => '123',
					2 => true
				)
			), $ret
		);
	}

	/**
	 * @return void
	 */
	public function testAddOptionGrouped()
	{
		$this->select->addOptionGrouped('foo', 'bar', 'group1', false);
		$this->select->addOptionGrouped('test', '123', 'group1', true);
		$this->select->addOptionGrouped('unit', 'test', 'group2', false);

		$ret = $this->readAttribute($this->select, 'optGroups');

		$expected = array(
			'group1' => array(
				0 => array(
					0 => 'foo',
					1 => 'bar',
					2 => false
				),
				1 => array(
					0 => 'test',
					1 => '123',
					2 => true
				)
			),
			'group2' => array(
				0 => array(
					0 => 'unit',
					1 => 'test',
					2 => false,
				)
			)
		);

		$this->assertEquals($expected, $ret);
	}

	/**
	 * @return void
	 */
	public function testSetSize()
	{
		$default = $this->readAttribute($this->select, 'size');
		$this->assertEquals('1', $default);

		$this->select->setSize('42');
		$ret = $this->readAttribute($this->select, 'size');

		$this->assertEquals('42', $ret);
	}

	/**
	 * @return void
	 */
	public function testSetMultiSelect()
	{
		$default = $this->readAttribute($this->select, 'multiselect');
		$this->assertEquals(false, $default);

		$this->select->setMultiSelect(true);
		$ret = $this->readAttribute($this->select, 'multiselect');

		$this->assertEquals(true, $ret);
	}

	/**
	 * @return void
	 */
	public function testToString()
	{
		$ret = $this->select->toString();
		$this->assertEquals('Form element \'select\' has no options.', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPmultiselect()
	{
		$this->select->setMultiSelect(true);
		$this->select->addOption('foo', 'bar');
		$ret = $this->select->toString();

		$this->assertEquals('<select id="test" name="test" multiple="multiple"><option value="foo">bar</option></select>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPsize()
	{
		$this->select->setSize('5');
		$this->select->addOption('foo', 'bar');
		$ret = $this->select->toString();

		$this->assertEquals('<select id="test" name="test" size="5"><option value="foo">bar</option></select>', $ret);
	}

	/**
	 * @return void
	 */
	public function testRenderOptions()
	{

	}


	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->select = new Select('test');
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->select);
	}
}