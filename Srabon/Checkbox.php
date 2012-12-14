<?php

namespace Templates\Srabon;

class Checkbox extends \Templates\Html\Input\Checkbox
{
	/**
	 * @param string $name
	 * @param string $value
	 * @param string $placeholder
	 * @param bool $required
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $value='', $placeholder='',$required=false, $classOrAttributes = array())
	{
		parent::__construct($name, $value, $placeholder, $required, $classOrAttributes);
		$this->addClass('checkbox');
	}
}