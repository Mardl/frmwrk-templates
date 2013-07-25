<?php

namespace Templates\Html\Input;

/**
 * Class Button
 *
 * @category Templates
 * @package  Templates\Html\Input
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Button extends \Templates\Html\Tag
{

	/**
	 * @param string       $name
	 * @param array|string $value
	 * @param array        $classOrAttributes
	 */
	public function __construct($name, $value, $classOrAttributes = array())
	{
		parent::__construct('button', $value, $classOrAttributes);

		$this->addAttribute('name', $name);
	}
}