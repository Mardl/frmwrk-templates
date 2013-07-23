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
	public function testSetData()
	{
		$this->form->setData('test');
		$ret = $this->readAttribute($this->form, 'values');

		$this->assertEquals('test', $ret);
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
	public function testGetValidateErrors()
	{

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
	public function testFindByNameEXPTag()
	{
		$name = 'foo';

		$tag = new Tag();
		$tag2 = new Tag();
		$tag2->addAttribute('name', $name);
		$tag3 = new Tag();

		$tag->addInner($tag2);

		$this->setValueToProperty(
			$this->form,
			'tagInner',
			array(
				$tag,
				$tag3
			)
		);

		$ret = $this->form->findByName($name);
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