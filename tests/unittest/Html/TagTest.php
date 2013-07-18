<?php

namespace unittest\Templates\Html;

use Templates\Html\Tag;

/**
 * Class TagTest
 *
 * @category Templates
 * @package  Unittest\Templates\Html
 * @author   Sebastian Rupp <sebastian@dreiwerken.de>
 */
class TagTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Tag
	 */
	protected $tag = null;

	protected function setValueToProperty($object, $propertyName, $value)
	{
		$refl = new \ReflectionObject($object);
		$prop = $refl->getProperty($propertyName);
		$prop->setAccessible(true);
		$prop->setValue($object, $value);

		return $prop;
	}

	protected function setUp()
	{
		parent::setUp();

		$this->tag = new Tag();
	}

	protected function tearDown()
	{
		parent::tearDown();

		unset($this->tag);
	}

	/**
	 * @return void
	 */
	public function testSetId()
	{
		// $this->tag = new Tag();

		$prob = $this->readAttribute($this->tag, 'tagAttributes');
		$this->assertFalse(isset($prob['id']));

		$this->tag->setId(5);

		$prob = $this->readAttribute($this->tag, 'tagAttributes');

		$this->assertTrue(isset($prob['id']));
		$this->assertEquals(5, $prob['id']);

	}

	/**
	 * @return void
	 */
	public function testGetId()
	{
		// $this->tag = new Tag();

		$this->tag->setId(99);

		$id = $this->tag->getId();
		$this->assertSame(99, $id);

	}

	/**
	 * @return void
	 */
	public function testGetIdEXPnull()
	{
		// $this->tag = new Tag();

		$id = $this->tag->getId();
		$this->assertNull($id);

	}

	/**
	 * @return void
	 */
	public function testGetAttributeEXPdefault()
	{
		$ret = $this->tag->getAttribute('foo', 'unittest');
		$this->assertSame('unittest', $ret);

		$ret = $this->tag->getAttribute('foo2');
		$this->assertNull($ret);
	}

	/**
	 * @return void
	 */
	public function testGetAttributeEXPvalue()
	{
		$this->tag = new Tag(
			'div',
			'',
			array(
				'test1' => 'foobar',
				'test2' => 'blub'
			)
		);

		$ret = $this->tag->getAttribute('test1', 'unittest');
		$this->assertSame('foobar', $ret);

		$ret = $this->tag->getAttribute('test2');
		$this->assertSame('blub', $ret);
	}

	/**
	 * @return void
	 */
	public function testSetFormat()
	{
		// $this->tag = new Tag();

		$this->tag->setFormat("format");

		$format = $this->readAttribute($this->tag, 'formatOutput');
		$this->assertEquals($format, "format");
	}

	/**
	 * @return void
	 */
	public function testSetTagname()
	{
		// $this->tag = new Tag();
		$this->tag->setTagname('test');

		$name = $this->readAttribute($this->tag, 'tagName');
		$this->assertEquals('test', $name);
	}

	/**
	 * @return void
	 */
	public function testHasInner()
	{
		// $this->tag = new Tag();
		$this->assertFalse($this->tag->hasInner());

		$this->tag->append('test');
		$this->tag->append('test2');

		$this->assertTrue($this->tag->hasInner());
	}

	/**
	 * @return void
	 */
	public function testGetInner()
	{
		// $this->tag = new Tag();

		$this->tag->append('test');
		$this->tag->append('test2');

		$this->assertEquals($this->tag->getInner(), array('test', 'test2'));
	}

	/**
	 * @return void
	 */
	public function testGetInnerAsString()
	{
		$mock = $this->getMock('\Templates\Html\Tag', array('renderToString'));
		$mock->expects($this->once())->method('renderToString');

		/** @var $mock Tag */
		$mock->getInnerAsString();
	}

	/**
	 * @depends testGetInnerAsString
	 * @return void
	 */
	public function testRenderToStringEXPStringOrInt()
	{
		// $this->tag = new Tag();

		$int = $this->tag->append(1);
		$this->assertEquals(($this->tag->getInnerAsString($int)), '1');

	}

	/**
	 * @depends testGetInnerAsString
	 * @return void
	 */
	public function testRenderToStringEXPStringOrIntFormat()
	{
		// $this->tag = new Tag();

		$this->tag->setFormat(1);

		$value = $this->tag->append(1);

		$this->assertEquals(($this->tag->getInnerAsString($value)), '1');
	}

	/**
	 * @return void
	 */
	public function testAddInner()
	{
		// $this->tag = new Tag();

		$this->tag->addInner('test');

		$this->assertEquals($this->readAttribute($this->tag, 'tagInner'), array('test'));
	}

	/**
	 * @depends testAddInner
	 * @return void
	 */
	public function testCountInnersEXPArray()
	{
		// $this->tag = new Tag();

		$this->tag->addInner('test');
		$this->tag->addInner('test1');
		$this->tag->addInner('test2');

		$count = $this->tag->countInners();

		$this->assertEquals($count, 3);
	}

	/**
	 * @depends testAddInner
	 * @return void
	 */


	public function testCountInnersEXPEmpty()
	{
		// $this->tag = new Tag();

		$this->setValueToProperty($this->tag, 'tagInner', '');
		$count = $this->tag->countInners();

		$this->assertEquals($count, 0);
	}

	/**
	 * @return void
	 */
	public function testAddAttribute()
	{
		// $this->tag = new Tag();

		$key = 'test';
		$value = 'test1';

		$this->tag->addAttribute($key, $value);
		$params = $this->readAttribute($this->tag, 'tagAttributes');

		$this->assertTrue(isset($params[$key]) && $params[$key] == $value);

	}

	/**
	 * @return void
	 */
	public function testRemoveAttribute()
	{
		// $this->tag = new Tag();

		$key = 'test';
		$value = 'test1';

		$this->tag->addAttribute($key, $value);
		$params = $this->readAttribute($this->tag, 'tagAttributes');

		$this->assertTrue(isset($params[$key]) && $params[$key] == $value);

		$this->tag->removeAttribute($key);
		$params = $this->readAttribute($this->tag, 'tagAttributes');

		$this->assertFalse(isset($params[$key]) && $params[$key] == $value);
	}

	/**
	 * @return void
	 */
	public function testHasAttribute()
	{
		// $this->tag = new Tag();

		$key = 'test';
		$value = 'test1';

		$this->tag->addAttribute($key, $value);

		$this->assertTrue($this->tag->hasAttribute('test'));
	}

	/**
	 * @return void
	 */
	public function testAddStyle()
	{
		// $this->tag = new Tag();

		$key = 'test';
		$value = 'test1';

		$this->tag->addStyle($key, $value);
		$params = $this->readAttribute($this->tag, 'tagStyle');

		$this->assertTrue(isset($params[$key]) && $params[$key] == $value);
	}

	/**
	 * @return void
	 */
	public function testHasStyle()
	{
		// $this->tag = new Tag();

		$key = 'test';
		$value = 'test1';

		$this->tag->addStyle($key, $value);

		$this->assertTrue($this->tag->hasStyle('test'));
	}

	/**
	 * @return void
	 */
	public function testHasStyles()
	{
		// $this->tag = new Tag();

		$key = 'test';
		$value = 'test1';

		$this->tag->addStyle($key, $value);

		$this->assertTrue($this->tag->hasStyles());
	}

	/**
	 * @return void
	 */
	public function testSet()
	{
		// $this->tag = new Tag();

		$value = 'test5';

		$this->tag->set($value);

		$this->assertEquals($this->tag->getInnerAsString(), 'test5');
	}

	/**
	 * @return void
	 */
	public function testAppendEXPStringEmpty()
	{
		$value = ' ';

		// $this->tag = new Tag();
		$ret = $this->tag->append($value);

		$this->assertSame($ret, $this->tag);
	}

	/**
	 * @return void
	 */
	public function testAppendEXPArrayEmpty()
	{
		$value = array();

		// $this->tag = new Tag();
		$ret = $this->tag->append($value);

		$this->assertSame($ret, $this->tag);
	}

	/**
	 * @return void
	 */
	public function testAppendEXPNoArrayNotEmpty()
	{
		$this->setValueToProperty($this->tag, 'tagInner', 'test2');
		$value = 'test1';
		// $this->tag = new Tag();
		$ret = $this->tag->append($value);

		$this->assertSame($ret, $this->tag);
	}

	public function testAddClass()
	{
		$tagAttributes = $this->readAttribute($this->tag, 'tagAttributes');
		$this->assertEmpty($tagAttributes);

		// Erste Class hinzufügen
		$this->tag->addClass('test1');
		$tagAttributes = $this->readAttribute($this->tag, 'tagAttributes');
		$expected = array(
			'class' => array(
				'test1' => 'test1'
			)
		);
		$this->assertSame($expected, $tagAttributes);

		// Zweite Class hinzufügen
		$this->tag->addClass('test2');
		$tagAttributes = $this->readAttribute($this->tag, 'tagAttributes');
		$expected = array(
			'class' => array(
				'test1' => 'test1',
				'test2' => 'test2'
			)
		);
		$this->assertSame($expected, $tagAttributes);
	}

	/**
	 * @depends testAddClass
	 * @return void
	 */
	public function testRemoveClass()
	{
		$tagAttributes = $this->readAttribute($this->tag, 'tagAttributes');
		$this->assertEmpty($tagAttributes);

		$this->tag->addClass('test1');
		$tagAttributes = $this->readAttribute($this->tag, 'tagAttributes');
		$expected = array(
			'class' => array(
				'test1' => 'test1'
			)
		);
		$this->assertSame($expected, $tagAttributes);

		$expectedRemove = array(
			'class' => array()
		);
		$this->tag->removeClass('test1');
		$tagAttributes = $this->readAttribute($this->tag, 'tagAttributes');
		$this->assertEquals($expectedRemove, $tagAttributes);
	}
}
