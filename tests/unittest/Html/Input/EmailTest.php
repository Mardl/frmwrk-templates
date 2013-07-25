<?php

namespace unittest\Html\Input;


use Templates\Html\Input\Email;


/**
 * Class EmailTest
 *
 * @category Templates
 * @package  Unittest\Html\Input
 * @author   Sebastian Rupp <sebastian@dreiwerken.de>
 */
class EmailTest extends \PHPUnit_Framework_TestCase
{

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
	public function testValidateEXPRequiredAndEmpty()
	{
		$email = new Email('input');

		$this->setValueToProperty($email, 'required', true);

		$error = $email->validate();

		$this->assertEquals('Fehlende Eingabe für input', $error);
	}

	/**
	 * @return void
	 */
	public function testValidateEXPValueNotEmpty()
	{
		$email = new Email('input', 'test');

		$error = $email->validate();

		$this->assertEquals('Die Emailadresse wird als ungültig angesehen', $error);
	}

	/**
	 * @return void
	 */
	public function testValidate()
	{
		$email = new Email('input', 'test@test.de');

		$this->setValueToProperty($email, 'required', false);

		$this->assertTrue($email->validate());
	}

}
