<?php

namespace Templates\MandyLane;

/**
 * Class Input
 * @package Templates\MandyLane
 */
class Datepicker extends \Templates\MandyLane\Input
{

	/**
	 * @param string $name
	 * @param string $value
	 * @param string $placeholder
	 * @param bool   $required
	 * @param string $type
	 * @param array  $classOrAttributes
	 */
	public function __construct($name, $value = '', $placeholder = '', $required = false, $type = 'text', $classOrAttributes = array())
	{
		$this->addClass('datepicker');
		$this->addClass('hasdatepicker');

		parent::__construct($name, $value, $placeholder, $required, $type, $classOrAttributes);
	}

}