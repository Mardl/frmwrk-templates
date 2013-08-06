<?php

namespace unittest\Html;

use Templates\Html\Image;

/**
 * Class ImageTest
 *
 * @category Templates
 * @package  Unittest\Html
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class ImageTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var image
	 */
	protected $image = null;

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
	public function testSrc()
	{
		$this->image->src('foo');
		$ret = $this->readAttribute($this->image, 'tagAttributes');

		$this->assertSame(array('src' => 'foo', 'alt' => '' ), $ret);
	}

	/**
	 * @return void
	 */
	public function testAlt()
	{
		$this->image->alt('foo');
		$ret = $this->readAttribute($this->image, 'tagAttributes');

		$this->assertSame(array('src' => 'Test', 'alt' => 'foo', ), $ret);
	}

	/**
	 * @return void
	 */
	public function testTitle()
	{
		$this->image->title('foo');
		$ret = $this->readAttribute($this->image, 'tagAttributes');

		$this->assertSame(array('src' => 'Test', 'alt' => '', 'title' => 'foo' ), $ret);
	}

	/**
	 * @return void
	 */
	public function testWidth()
	{
		$this->image->width('123');
		$ret = $this->readAttribute($this->image, 'tagAttributes');

		$this->assertSame(array('src' => 'Test', 'alt' => '', 'width' => '123' ), $ret);
	}

	/**
	 * @return void
	 */
	public function testHeight()
	{
		$this->image->heigth('123');
		$ret = $this->readAttribute($this->image, 'tagAttributes');

		$this->assertSame(array('src' => 'Test', 'alt' => '', 'height' => '123' ), $ret);
	}

	/**
	 * @return void
	 */
	public function testConstructorEXPalt()
	{
		$image = new Image('Test', 'altText');
		$ret = $this->readAttribute($image, 'tagAttributes');

		$this->assertSame(array('src' => 'Test', 'alt' => 'altText', 'title' => 'altText' ), $ret);
	}

	/**
	 * @return void
	 */
	public function testConstructorEXPtitle()
	{
		$image = new Image('Test', '', 'titleText');
		$ret = $this->readAttribute($image, 'tagAttributes');

		$this->assertSame(array('src' => 'Test', 'alt' => 'titleText', 'title' => 'titleText' ), $ret);
	}




	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->image = new Image('Test');
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->image);
	}
}