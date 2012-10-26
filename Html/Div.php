<?php

namespace Templates\Html;

class Div extends Tag
{
	public function __construct($value=array())
	{
		parent::__construct('div', $value);
	}
}