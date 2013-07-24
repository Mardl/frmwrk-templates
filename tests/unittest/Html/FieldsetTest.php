<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sebastian.Rupp
 * Date: 24.07.13
 * Time: 09:01
 * To change this template use File | Settings | File Templates.
 */

namespace unittest\Html;


use Templates\Html\Fieldset;
use Templates\Html\Tag;

class FieldsetTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Tag
	 */
	protected $fieldSet = null;

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
	 * return void
	 */
	public function testLegend()
	{
		$fieldSet = new Fieldset();

		$fieldSet->legend('test');

		/** @var $legend Tag */
		$legend = $this->readAttribute($fieldSet, 'legend');

		$this->assertEquals('test', $legend->getInnerAsString());
	}

	/**
	 * @return void
	 */
	public function testConstruct()
	{
		$fieldSet = new Fieldset();

		/** @var $legend Tag */
		$legend = $this->readAttribute($fieldSet, 'legend');

		$this->assertEquals('legend', $this->readAttribute($legend, 'tagName'));
	}

	/**
	 * @return void
	 */
	public function testInitLegend()
	{
		$fieldSet = new Fieldset('test');

		/** @var $legend Tag */
		$legend = $this->readAttribute($fieldSet, 'legend');

		$this->assertEquals(array('test'), $this->readAttribute($legend, 'tagInner'));
	}
	/**
	 * @return void
	 */
	public function testToStringEXPEmpty()
	{
		$fieldSet = new Fieldset();

		$this->setValueToProperty($fieldSet, 'tagName', 'test');
		$this->setValueToProperty($fieldSet, 'tagInner', 'test1');

		$this->assertEquals($fieldSet->toString(), '<test >test1</test>');
	}

	/**
	 * @return void
	 */
	public function testToStringNotEmpty()
	{
		$fieldSet = new Fieldset('test');

		$this->assertEquals($fieldSet->toString(), '<fieldset ><legend >test</legend></fieldset>');
	}
}
