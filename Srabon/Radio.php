<?php

namespace Templates\Srabon;

class Radio extends \Templates\Html\Input\Radio
{
	/**
	 * @param string $name
	 * @param string $value
	 * @param array $opt
	 * @param bool $required
	 * @param string $placeholder
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $value='', $opt= array(),$required=false, $placeholder='',  $classOrAttributes = array())
	{
		parent::__construct($name, $value, $opt,$required, $placeholder='',  $classOrAttributes);
		$this->addClass('radio');
	}
}
