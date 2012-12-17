<?php

namespace Templates\Html\Input;

class Button extends \Templates\Html\Tag
{
	/**
	 * @param string $name
	 * @param array|string $value
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $value, $classOrAttributes = array())
	{
		parent::__construct('button',$value,$classOrAttributes);

		$this->addAttribute('name',$name);
	}
}