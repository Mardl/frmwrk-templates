<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sebastian.Rupp
 * Date: 24.07.13
 * Time: 13:41
 * To change this template use File | Settings | File Templates.
 */

namespace unittest\Html\Input;


use Templates\Html\Input\Hidden;

class HiddenTest extends \PHPUnit_Framework_TestCase {


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
