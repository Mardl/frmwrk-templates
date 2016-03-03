<?php

namespace unittest\Html;

use Templates\Html\Form;
use Templates\Html\Input;
use Templates\Html\Tag;

/**
 * Class FormTest
 *
 * @category Templates
 * @package  Unittest\Html
 * @author   Julia Blum <julia@dreiwerken.de>
 */
class FormTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var form
	 */
	protected $form = null;

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
	public function testConstruktor()
	{
		$form = new Form('halloDuDa');

		$link = $form->getAction();
		$this->assertSame('halloDuDa', $link);

	}

	/**
	 * @return void
	 */
	public function testSetData()
	{
		$this->form->setData(array('test'));
		$ret = $this->readAttribute($this->form, 'values');

		$this->assertEquals(array('test'), $ret);
	}


	/**
	 * @return void
	 */
	public function testSetDataValue()
	{
		$this->form->setDataValue('foo', 'bar');
		$ret = $this->readAttribute($this->form, 'values');

		$this->assertEquals(array('foo' => 'bar'), $ret);
	}

	/**
	 * @return void
	 */
	public function testGetValue()
	{
		$ret = $this->form->getValue('test');
		$this->assertEmpty($ret);
	}

	/**
	 * @return void
	 */
	public function testGetValueEXPKeyExists()
	{
		$this->form->setDataValue('foo', 'bar');

		$ret = $this->form->getValue('foo');
		$this->assertEquals('bar', $ret);
	}

	/**
	 * @return void
	 */
	public function testMethod()
	{
		$this->form->method('foobar');
		$ret = $this->readAttribute($this->form, 'tagAttributes');

		$this->assertEquals(array('method' => 'foobar'), $ret);
	}

	/**
	 * @return void
	 */
	public function testAction()
	{
		$this->form->action('foobar');
		$ret = $this->readAttribute($this->form, 'tagAttributes');

		$this->assertEquals(array('action' => 'foobar', 'method' => 'post'), $ret);
	}


	/**
	 * @return void
	 */
	public function testGetAction()
	{
		$this->form->action('foobar');
		$ret = $this->form->getAction();

		$this->assertEquals('foobar', $ret);
	}

	/**
	 * @return void
	 */
	public function testValidate()
	{
		$ret = $this->form->validate();

		$this->assertEquals(true, $ret);
	}


	/**
	 * @return void
	 */
	public function testValidateEXPInput()
	{
		$input = new \Templates\Html\Input('name1');
		$ret = $this->form->validate($input);
		$this->assertTrue($ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPinputFailed()
	{
		$input = new \Templates\Html\Input('name1','','',true);
		$ret = $this->form->validate($input);
		$this->assertFalse($ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPInnerInput()
	{
		$tag = new Tag();
		$input = new \Templates\Html\Input('name1');
		$tag->append($input);
		$ret = $this->form->validate($tag);
		$this->assertTrue($ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPInnerInputFailed()
	{
		$tag = new Tag();
		$input = new \Templates\Html\Input('name1','','',true);
		$tag->append($input);
		$ret = $this->form->validate($tag);
		$this->assertFalse($ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPInnerTagInput()
	{
		$tag = new Tag();
		$spanTag = new Tag('span');
		$input = new \Templates\Html\Input('name1');
		$spanTag->append($input);
		$tag->append($spanTag);

		$ret = $this->form->validate($tag);
		$this->assertTrue($ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPInnerTagInputFailed()
	{
		$tag = new Tag();
		$spanTag = new Tag('span');
		$input = new \Templates\Html\Input('name1','','',true);
		$spanTag->append($input);
		$tag->append($spanTag);

		$ret = $this->form->validate($tag);
		$this->assertFalse($ret);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPInnerArrayInput()
	{
		$tag = new Tag();
		$input = new \Templates\Html\Input('name1');
		$tag->append(array($input));

		$ret = $this->form->validate($tag);
		$this->assertTrue($ret);
	}


	/**
	 * @return void
	 */
	public function testGetValidateErrors()
	{
		$ret = $this->form->getValidateErrors();
		$current = $this->readAttribute($this->form, 'validateMessage');

		$this->assertSame(array(), $current);

		$this->setValueToProperty($this->form, 'validateMessage', 'foobar');

		$ret = $this->form->getValidateErrors();
		$current = $this->readAttribute($this->form, 'validateMessage');

		$this->assertSame('foobar', $current);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPInnerArrayInputFailed()
	{
		$tag = new Tag();
		$input = new \Templates\Html\Input('name1','','',true);
		$tag->append(array($input));

		$ret = $this->form->validate($tag);
		$this->assertFalse($ret);
	}


	/**
	 * @return void
	 */
	public function testFindByName()
	{
		$name = 'foo';

		$this->assertEmpty($this->form->findByName($name));
	}

	/**
	 * @return void
	 */
	public function testFindByNameEXPInstanceOfInput()
	{
		$name = 'foo';
		$inner = new Input($name);

		$this->form->addInner($inner);
		$ret = $this->form->findByName($name);

		$this->assertEquals($inner, $ret);


	}

	/**
	 * @return void
	 */
	public function testFindByNameEXPArray()
	{
		$name = 'foo';

		$inner = new Input('test');
		$inner2 = new Input($name);
		$inner3 = new Input('bar');

		$inner->addInner($inner2);

		$this->setValueToProperty(
			$this->form,
			'tagInner',
			array(
				array(
					$inner,
					$inner3
				)
			)
		);

		$ret = $this->form->findByName($name);

		$this->assertEquals($inner2, $ret);
	}

	/**
	 * @return void
	 */
	public function testFindByNameEXPInstanceInput()
	{

		$name = 'foo';

		$inner = new Input('test');
		$inner2 = new Input($name);

		$inner->append($inner2);


		$this->form->append($inner);

		$ret = $this->form->findByName($name);

		$this->assertEquals($inner2, $ret);

	}

	/**
	 * @return void
	 */
	public function testFindByNameEXPTag()
	{
		$name = 'foo';

		$tag = new Tag();
		$input = new Input($name);
		//$tag2->addAttribute('name', $name);
		$tag3 = new Tag();

		$tag->addInner($input);

		$this->setValueToProperty(
			$this->form,
			'tagInner',
			array(
				$tag,
				$tag3
			)
		);

		$ret = $this->form->findByName($name);

		$this->assertEquals($input, $ret);
	}





	/**
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->form = new Form();
	}

	/**
	 * @return void
	 */
	protected function tearDown()
	{
		parent::tearDown();

		unset($this->form);
	}
}