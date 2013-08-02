<?php

namespace unittest\Html\Input;


use Templates\Html\Input\Button;

/**
 * Class ButtonTest
 *
 * @category Templates
 * @package  Unittest\Html\Input
 * @author   Sebastian Rupp <sebastian@dreiwerken.de>
 */
class ButtonTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @return void
	 */
	public function testConstruct()
	{
		$button = new Button('button', 'test', array());

		$expected = array(
			'name' => 'button'
		);

		$this->assertSame($expected, $this->readAttribute($button, 'tagAttributes'));
	}
}