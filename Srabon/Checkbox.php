<?php

namespace Templates\Srabon;

class Checkbox extends \Templates\Html\Input\Checkbox
{
	/**
	 * @param string $text
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $value='', $placeholder='',$required=false, $classOrAttributes = array())
	{
		parent::__construct($name, $value, $placeholder, $required, $classOrAttributes);
		$this->addClass('checkbox');
	}
}