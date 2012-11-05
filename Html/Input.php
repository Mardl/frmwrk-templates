<?php

namespace Templates\Html;

class Input extends Tag
{

	protected $required = false;
	protected $value = '';
	protected $placeholder = '';

	public function __construct($name, $value='', $placeholder='',$required=false, $type='text', $classOrAttributes = array())
	{
		parent::__construct('input','',$classOrAttributes);


		$this->setType($type);
		$this->setName($name);
		$this->setValue($value);
		$this->setRequired($required);
		if (!empty($placeholder))
		{
			$this->setPlaceholder($placeholder .($required ? ' *' : ''));
		}
	}

	public function setRequired($required=true)
	{
		$this->required = $required;
	}
	public function isRequired(){
		return $this->required;

	}
	public function setValue($value)
	{
		$this->addAttribute('value', $value);
		$this->value=$value;
	}
	public function getValue()
	{
		return $this->value;
	}
	public function setName($name)
	{
		$this->setId($name);
		return $this->addAttribute('name', $name);
	}
	public function getName()
	{
		return $this->getAttribute('name','');
	}
	public function setType($type)
	{
		return $this->addAttribute('type', empty($type) ? 'text' : $type);
	}

	public function setPlaceholder($placeholder)
	{
		$this->placeholder = $placeholder;
		return $this->addAttribute('placeholder', $placeholder);
	}

	public function getErrorLabel()
	{
		return (empty($this->placeholder) ? $this->getName() : $this->placeholder);
	}

	public function validate()
	{
		if ($this->isRequired() && empty($this->value))
		{
			return "Fehlende Eingabe für ".$this->getErrorLabel();
		}

		return true;
	}

}