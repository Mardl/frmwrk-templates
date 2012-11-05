<?php

namespace Templates\Html\Input;

class Hidden extends \Templates\Html\Input
{

	public function __construct($name, $value='')
	{
		parent::__construct($name,$value,'',false,'hidden');
	}
}