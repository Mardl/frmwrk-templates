<?php

namespace Templates\Srabon;

class Button extends \Templates\Html\Input\Button
{
	/**
	 * @param string $name
	 * @param array|string $value
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $value, $classOrAttributes = array())
	{
		parent::__construct($name,$value,$classOrAttributes);

		$this->addClass('btn');
		$this->addClass('btn-inverse');

		if (empty($this->defaultClass))
		{
			$this->addClass('btn-mini');
		}
	}
}