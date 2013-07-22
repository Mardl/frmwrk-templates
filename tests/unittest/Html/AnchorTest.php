<?php

namespace unittest\Html;

use Templates\Html\Anchor;

/**
 * Class AnchorTest
 *
 * @category Templates
 * @package  Unittest\Html
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class AnchorTest extends \PHPUnit_Framework_TestCase
{

	protected $anchor = null;

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
	public function testSetHref()
	{
		$this->anchor->setHref('foo');

		$ret = $this->readAttribute($this->anchor, 'tagAttributes');
		$this->assertSame(array('href' => 'foo'), $ret);
	}

	/**
	 * @return void
	 */
	public function testGetHref()
	{
		$ret = $this->anchor->getHref();

		$this->assertEquals('test', $ret);
	}

	/**
	 * @return void
	 */
	public function testExternal()
	{
		$this->anchor->external();
		$ret = $this->readAttribute($this->anchor, 'tagAttributes');

		$this->assertEquals(array('target' => '_blank', 'href' => 'test'), $ret);
	}


	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->anchor = new Anchor('test', 'linktext');
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->anchor);
	}
}