<?php

namespace unittest\Html;

use Templates\Html\Cell;
use Templates\Html\Row;
use Templates\Html\Table;
use Templates\Html\Tag;

/**
 * Class FormTest
 *
 * @category Templates
 * @package  Unittest\Html
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class TableTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var table
	 */
	protected $table = null;

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
	public function testAddHeader()
	{
		$row = new Row(array('foo', 'test'), true);

		$this->table->addHeader($row);

		/** @var $ret Array */
		$ret = $this->readAttribute($this->table, 'headerRow');
		$maxCell = $this->readAttribute($this->table, 'maxCell');

		$this->assertCount(1, $ret);
		$this->assertArrayHasKey(0, $ret);
		$this->assertEquals($row, $ret[0]);
		$this->assertEquals(2, $maxCell);
	}

	/**
	 * @return void
	 */
	public function testAddHeaderEXPArray()
	{
		$this->table->addHeader(array('foo', 'bar'));

		$ret = $this->readAttribute($this->table, 'headerRow');
		$maxCell = $this->readAttribute($this->table, 'maxCell');

		$this->assertCount(1, $ret);
		$this->assertArrayHasKey(0, $ret);
		$this->assertEquals(2, $maxCell);
	}

	/**
	 * @return void
	 */
	public function testSetMaxCellEXPmaxCell5()
	{
		$row = new Row(array('foo', 'test', 'test2', 'test3', 'test4'), true);

		$this->table->addHeader($row);

		$maxCell = $this->readAttribute($this->table, 'maxCell');
		$this->assertEquals(5, $maxCell);
	}

	/**
	 * @return void
	 */
	public function testSetMaxCellEXPlayoutException()
	{
		$row = new Row(array('foo', 'test', 'test2', 'test3', 'test4'), true);
		$this->table->addHeader($row);

		$row = new Row(array('foo', 'test', 'test2', 'test3', 'test4', 'test5'), true);

		$this->setExpectedException('Templates\Exceptions\Layout', "Spaltenanzahl ungültig in (tbody) Row (7 Columns). Erste Definition: 5 Columns.");
		$this->table->addRow($row);
	}

	/**
	 * @return void
	 */
	public function testAddFooter()
	{
		$row = new Row(array('foo', 'test'));

		$this->table->addFooter($row);

		/** @var $ret Array */
		$ret = $this->readAttribute($this->table, 'footerRow');
		$maxCell = $this->readAttribute($this->table, 'maxCell');

		$this->assertCount(1, $ret);
		$this->assertArrayHasKey(0, $ret);
		$this->assertEquals($row, $ret[0]);
		$this->assertEquals(2, $maxCell);
	}

	/**
	 * @return void
	 */
	public function  testAddFooterEXPArray()
	{
		$this->table->addFooter(array('foo', 'bar'));

		$ret = $this->readAttribute($this->table, 'footerRow');
		$maxCell = $this->readAttribute($this->table, 'maxCell');

		$this->assertCount(1, $ret);
		$this->assertArrayHasKey(0, $ret);
		$this->assertEquals(2, $maxCell);
	}

	/**
	 * @return void
	 */
	public function testAddRowEXPinvalidArgExc()
	{
		$this->setExpectedException('\InvalidArgumentException', 'addRow von Table benötigt Instanze von Row');

		$this->table->addRow('test');
	}

	/**
	 * @return void
	 */
	public function testAddRow()
	{
		$ret = $this->table->addRow(array('unittest'));

		$inner = $ret->getInner();
		$cells = $inner[0]->getInner();
		$text = $cells[0]->getInner();

		$this->assertInstanceOf('\Templates\Html\Cell', $cells[0]);

		$this->assertSame('unittest', $text[0]);
	}

	/**
	 * @return void
	 */
	public function testAddRowEXPtag()
	{
		$ret = $this->table->addRow(array(new Tag()));

		$inner = $ret->getInner();
		$cells = $inner[0]->getInner();
		$text = $cells[0]->getInner();

		$this->assertInstanceOf('\Templates\Html\Cell', $cells[0]);
		$this->assertInstanceOf('\Templates\Html\Tag', $text[0]);

	}

	/**
	 * @return void
	 */
	public function testAddRowEXProw()
	{
		$ret = $this->table->addRow(array(new Row(array('unittest'))));
		$inner = $ret->getInner();
		$cells = $inner[0]->getInner();
		$text = $cells[0]->getInner();

		$this->assertInstanceOf('\Templates\Html\Cell', $cells[0]);
		$this->assertSame('unittest', $text[0]);

	}

	/**
	 * @return void
	 */
	public function testGetRow()
	{
		$row = new Row(array('bar'));

		$this->table->addRow(new Row(array('bla')));
		$this->table->addRow($row);
		$this->table->addRow(new Row(array('test')));

		$ret = $this->table->getRow(1);

		$this->assertEquals($row, $ret);
	}

	/**
	 * @return void
	 */
	public function testGetRowEXPfalse()
	{
		$last = new Row(array('test'));

		$this->table->addRow(new Row(array('bla')));
		$this->table->addRow(new Row(array('bar')));
		$this->table->addRow($last);

		$ret = $this->table->getRow();

		$this->assertEquals($last, $ret);
	}


	/**
	 * @return void
	 */
	public function testGetRowEXPinvalidArgException()
	{
		$row = new Row(array('bar'));

		$this->table->addRow(new Row(array('bla')));
		$this->table->addRow($row);
		$this->table->addRow(new Row(array('test')));

		$this->setExpectedException('\InvalidArgumentException', 'Keine Zeile auf Position 4 vorhanden!');

		$ret = $this->table->getRow(4);
	}


	/**
	 * @return void
	 * @depends testGetRow
	 */
	public function testSetRow()
	{
		$this->table->addRow(new Row(array('bla')));
		$this->table->addRow(new Row(array('bar')));
		$this->table->addRow(new Row(array('test')));

		$new = new Row(array('blubb'));
		$this->table->setRow(1, $new);

		$row = $this->table->getRow(1);

		$this->assertEquals($new, $row);
	}

	/**
	 * @return void
	 */
	public function testAddAttrColumn()
	{
		$row1 = new Row(array('foo'));

		$this->table->append($row1);

		$this->table->addAttrColumn(0);

		$exp = $this->readAttribute($this->table->getRow(0)->getCell(0), 'tagInner');

		$this->assertSame($exp, array('foo'));
	}

	/**
	 * @return void
	 */
	public function testFormatColumn()
	{
		$row1 = new Row(array('foo'));
		$format = 'test';

		$this->table->append($row1);

		$this->table->formatColumn(0, $format);

		$exp = $this->readAttribute($this->table->getRow(0)->getCell(0), 'formatOutput');

		$this->assertEquals('test', $exp);
	}

	/**
	 * @return void
	 */
	public function testSetRowAttributesEXPString()
	{
		$row1 = new Row(array('foo'));

		$this->table->append($row1);

		$this->table->addAttrColumn(0, 'test');

		$exp = $this->readAttribute($this->table->getRow(0)->getCell(0), 'tagAttributes');

		$ret = array(
			'class' => array(
				'test' => 'test'
			)
		);

		$this->assertSame($exp, $ret);
	}

	/**
	 * @return void
	 */
	public function testSetRowAttributesEXPArrayKeyValue()
	{
		$row1 = new Row(array('foo'));

		$this->table->append($row1);

		$array = array(
			'foo' => 'bar'
		);

		$this->table->addAttrColumn(0, $array);

		$exp = $this->readAttribute($this->table->getRow(0)->getCell(0), 'tagAttributes');

		$ret = array(
			'foo' => 'bar'
		);

		$this->assertSame($exp, $ret);
	}

	/**
 * @return void
 */
	public function testToString()
	{
		$ret = $this->table->toString();

		$this->assertEquals('<table cellpadding="0" cellspacing="0" border="0"><tbody></tbody></table>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPHeaderRow()
	{
		$this->table->addHeader(new Row(array('header')));

		$ret = $this->table->toString();

		$this->assertEquals('<table cellpadding="0" cellspacing="0" border="0"><thead><tr ><th >header</th></tr></thead><tbody></tbody></table>', $ret);
	}

	/**
	 * @return void
	 */
	public function testToStringEXPFooterRow()
	{
		$this->table->addFooter(new Row(array('footer')));

		$ret = $this->table->toString();

		$this->assertEquals('<table cellpadding="0" cellspacing="0" border="0"><tbody></tbody><tfoot><tr ><td >footer</td></tr></tfoot></table>', $ret);
	}

	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->table = new Table();
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->table);
	}
}
