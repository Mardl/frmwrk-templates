<?php

namespace Templates\Html;

class Form extends Tag
{
	public function __construct($action=null)
	{
		parent::__construct('form');
		if(!is_null($action))
		{
			$this->setAction($action);
		}
	}

	public function setMethod($value)
	{
		return $this->addAttribute('method', $value);
	}

	public function setAction($value)
	{
		return $this->addAttribute('value', $value);
	}
}