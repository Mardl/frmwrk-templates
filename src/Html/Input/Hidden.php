<?php

namespace Templates\Html\Input;

/**
 * Class Hidden
 *
 * @category Templates
 * @package  Templates\Html\Input
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Hidden extends \Templates\Html\Input
{

	/**
	 * @param string $name
	 * @param string $value
	 * @param array  $classOrAttributes
	 */
	public function __construct($name, $value = '', $classOrAttributes = array())
	{
		parent::__construct($name, $value, '', false, 'hidden', $classOrAttributes);
	}
}