<?php

namespace Templates\Html\Input;

class Hidden extends \Templates\Html\Input
{

	public function __construct($name, $value='',$classOrAttributes = array())
	{
		parent::__construct($name,$value,'',false,'hidden',$classOrAttributes);
	}
}