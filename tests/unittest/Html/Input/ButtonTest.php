<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sebastian.Rupp
 * Date: 24.07.13
 * Time: 11:09
 * To change this template use File | Settings | File Templates.
 */

namespace unittest\Html\Input;


use Templates\Html\Input\Button;

class ButtonTest extends \PHPUnit_Framework_TestCase {

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
