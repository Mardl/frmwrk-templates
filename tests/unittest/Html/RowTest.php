<?php

namespace unittest\Html;

use Templates\Html\Cell;
use Templates\Html\Row;

/**
 * Class RowTest
 *
 * @category Templates
 * @package  Unittest\Html
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class RowTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var row
	 */
	protected $row = null;

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
	public function testHeader()
	{
		$this->row->header();
		$ret = $this->readAttribute($this->row, 'header');

		$this->assertEquals(true, $ret);
	}


	/**
	 * @return void
	 */
	public function testAddCell()
	{
		$cell = new Cell('test');
		$this->row->addCell($cell);

		$this->assertEquals('<tr ><td >test</td></tr>', $this->row->toString());
	}

	/**
	 * @return void
	 */
	public function testAddCellEXPNewCell()
	{
		$this->row->addCell('test', 'foo');
		$this->assertEquals('<tr ><td class="foo">test</td></tr>', $this->row->toString());
	}

	/**
	 * @return void
	 */
	public function getCell()
	{

	}


	/**
	 * @return void
	 */
	public function testSetCell()
	{

	}


	/**
	 * @return void
	 */
	public function testToString()
	{
		$ret = $this->row->toString();
		$this->assertEquals('<tr ></tr>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPHeader()
	{
		$cell = new Cell('foo');

		$this->row->header();
		$this->row->addCell($cell);

		$this->row->toString();

		$ret = $this->readAttribute($cell, 'header');
		$this->assertEquals(true, $ret);
	}



	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->row = new Row();
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->row);
	}
}