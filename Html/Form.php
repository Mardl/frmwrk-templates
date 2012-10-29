<?php

namespace Templates\Html;

class Form extends Tag
{
	public function __construct($method='post', $classOrAttributes = array())
	{
		parent::__construct('form', '', $classOrAttributes);
		$this->method($method);
	}

	public function method($value)
	{
		return $this->addAttribute('method', $value);
	}

	public function action($value)
	{
		return $this->addAttribute('action', $value);
	}
}