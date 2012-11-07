<?php

namespace Templates\Html\Input;

class Textarea extends \Templates\Html\Input
{

	protected $required = false;
	protected $value = '';
	protected $placeholder = '';

	public function __construct($name, $value='', $placeholder='', $required=false, $classOrAttributes = array())
	{
		parent::__construct($name, $value, $placeholder, $required, 'textarea', $classOrAttributes);

		$this->setTagname('textarea');
		$this->removeAttribute('type');
		$this->removeAttribute('value');
	}

	public function setValue($value)
	{
		$this->set($value);
		$this->value=$value;
	}

}