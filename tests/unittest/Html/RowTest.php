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
	public function testGetCell()
	{
		$this->row->addCell('bla');
		$this->row->addCell('bar');
		$this->row->addCell('test');


		$cell = $this->row->getCell(1);
		$inner = $cell->getInner();

		$this->assertEquals(array('bar'), $inner);
	}

	/**
	 * @return void
	 */
	public function testGetCellEXPInvalidArgExc()
	{
		$this->row->addCell('bla');
		$this->row->addCell('bar');
		$this->row->addCell('test');

		$this->setExpectedException('\InvalidArgumentException', 'Keine Zeile auf Position 3 vorhanden!');

		$cell = $this->row->getCell(3);
	}


	/**
	 * @return void
	 * @depends testGetCell
	 */
	public function testSetCell()
	{
		$this->row->addCell('bla');
		$this->row->addCell('bar');
		$this->row->addCell('test');

		$this->row->setCell(1, new Cell('blubb'));

		$cell = $this->row->getCell(1);
		$inner = $cell->getInner();

		$this->assertEquals(array('blubb'), $inner);
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
	public function testConstructEXPHeader()
	{
		$row = new Row(array('test'), true);
		$header = $this->readAttribute($row, 'header');

		$this->assertEquals(true, $header);
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