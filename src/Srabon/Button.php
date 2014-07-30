<?php

namespace Templates\Srabon;

/**
 * Class Button
 *
 * @category Dreiwerken
 * @package  Templates\Srabon
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Button extends \Templates\Html\Input\Button
{

	/**
	 * @param string       $name
	 * @param array|string $value
	 * @param array        $classOrAttributes
	 */
	public function __construct($name, $value, $classOrAttributes = array())
	{
		parent::__construct($name, $value, $classOrAttributes);

		$this->addClass('btn');
		$this->addClass('btn-inverse');

		if (empty($this->defaultClass))
		{
			$this->addClass('btn-mini');
		}
	}

	/**
	 * Constante definiert in Templates\Srabon\Form
	 *
	 * @param mixed $key
	 * @return void
	 */
	public function setShortcut($key)
	{
		$this->addAttribute('data-key', $key);
	}
}