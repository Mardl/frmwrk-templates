<?php

namespace unittest\Html\Input;

use Templates\Html\Input\Hidden;

/**
 * Class HiddenTest
 *
 * @category Templates
 * @package  Unittest\Html\Input
 * @author   Sebastian Rupp <sebastian@dreiwerken.de>
 */
class HiddenTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @return void
	 */
	public function testConstruct()
	{
		$hidden = new Hidden('test', '123');

		$expected = array(
			'type' => 'hidden',
			'id' => 'test',
			'name' => 'test',
			'value' => '123'
		);

		$this->assertSame($expected, $this->readAttribute($hidden, 'tagAttributes'));
	}
}
