<?php

namespace Templates\MandyLane;

class Button extends \Templates\Html\Input\Button
{
	/**
	 * @param string $text
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $value, $classOrAttributes = array())
	{
		parent::__construct($name,$value,$classOrAttributes);


		$this->addClass('button');
		$this->addClass('button_red');

		/*if (empty($this->defaultClass))
		{
			$this->addClass('btn-mini');
		}*/
	}
}