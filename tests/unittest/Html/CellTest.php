<?php

namespace unittest\Html;

use Templates\Html\Cell;

/**
 * Class CellTest
 *
 * @category Templates
 * @package  Unittest\Html
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class CellTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Cell
	 */
	protected $cell = null;

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
	public function testConstructEXPHeader()
	{
		$cell = new Cell('Test', true);

		$this->assertEquals(true, $this->readAttribute($cell, 'header'));
	}

	/**
	 * @return void
	 */
	public function testHeader()
	{
		$this->cell->header();
		$header = $this->readAttribute($this->cell, 'header');

		$this->assertEquals(true, $header);
	}


	/**
	 * @return void
	 */
	public function testSetColspan()
	{
		$this->cell->setColspan('7');
		$ret = $this->readAttribute($this->cell, 'colspan');

		$this->assertEquals('7', $ret);
	}

	/**
	 * @return void
	 */
	public function testGetColspan()
	{
		$this->setValueToProperty($this->cell, 'colspan', '5');
		$ret = $this->cell->getColspan();

		$this->assertEquals('5', $ret);
	}

	/**
	 * @return void
	 */
	public function testToString()
	{
		$ret = $this->cell->toString();

		$this->assertEquals('<td >Test</td>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPHeader()
	{
		$this->cell->header();
		$ret = $this->cell->toString();

		$this->assertEquals('<th >Test</th>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPColspan()
	{
		$this->cell->setColspan('5');
		$ret = $this->cell->toString();

		$this->assertEquals('<td colspan="5">Test</td>', $ret);
	}


	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->cell = new Cell('Test');
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->cell);
	}
}
