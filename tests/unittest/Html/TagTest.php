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
	 * @return void
	 */
	public function testSetId()
	{
		$tag = new Tag();

		$prob = $this->readAttribute($tag, 'tagAttributes');
		$this->assertFalse(isset($prob['id']));

		$tag->setId(5);

		$prob = $this->readAttribute($tag, 'tagAttributes');

		$this->assertTrue(isset($prob['id']));
		$this->assertEquals(5, $prob['id']);

	}

	/**
	 * @return void
	 */
	public function testGetId()
	{
		$tag = new Tag();

		$tag->setId(99);

		$id = $tag->getId();
		$this->assertSame(99, $id);

	}

	/**
	 * @return void
	 */
	public function testGetIdEXPnull()
	{
		$tag = new Tag();

		$id = $tag->getId();
		$this->assertNull($id);

	}

	/**
	 * @return void
	 */
	public function testGetAttributeEXPdefault()
	{
		$tag = new Tag();

		$ret = $tag->getAttribute('foo', 'unittest');
		$this->assertSame('unittest', $ret);

		$ret = $tag->getAttribute('foo2');
		$this->assertNull($ret);
	}

	/**
	 * @return void
	 */
	public function testGetAttributeEXPvalue()
	{
		$tag = new Tag(
			'div',
			'',
			array(
				'test1' => 'foobar',
				'test2' => 'blub'
			)
		);

		$ret = $tag->getAttribute('test1', 'unittest');
		$this->assertSame('foobar', $ret);

		$ret = $tag->getAttribute('test2');
		$this->assertSame('blub', $ret);
	}

	/**
	 * @return void
	 */
	public function testSetFormat()
	{
		$tag = new Tag();

		$tag->setFormat("format");

		$format = $this->readAttribute($tag, 'formatOutput');
		$this->assertEquals($format, "format");
	}

	/**
	 * @return void
	 */
	public function testSetTagname()
	{
		$tag = new Tag();
		$tag->setTagname('test');

		$name = $this->readAttribute($tag, 'tagName');
		$this->assertEquals('test', $name);
	}

	/**
	 * @depends testAppend
	 * @return void
	 */
	public function testHasInner()
	{
		$tag = new Tag();
		$this->assertFalse($tag->hasInner());

		$tag->append('test');
		$tag->append('test2');

		$this->assertTrue($tag->hasInner());
	}

	/**
	 * @depends testAppend
	 * @return void
	 */
	public function testGetInner()
	{
		$tag = new Tag();

		$tag->append('test');
		$tag->append('test2');

		$this->assertEquals($tag->getInner(), array('test', 'test2'));
	}
}