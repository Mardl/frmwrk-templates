<?php

namespace Templates\Html\Input;

class Checkbox extends \Templates\Html\Input
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
		parent::__construct($name, $value, $placeholder, $required, 'checkbox', $classOrAttributes);
	}

	public function checked($default=true)
	{
		if ($default)
		{
			$this->addAttribute('checked','checked');
		}
		else
		{
			$this->removeAttribute('checked');
		}
	}

	public function validate()
	{
		if ($this->isRequired() && !$this->hasAttribute('checked'))
		{
			return "Fehlende Eingabe für ".$this->getErrorLabel();
		}

		return true;
	}

	public function toString()
	{

		$imageLabel = new \Templates\Html\Tag('label');
		foreach($this->getAttribute('class') as $class)
		{
			$imageLabel->addClass($class);
		}

		$placeholder = $this->getAttribute('placeholder','');
		$this->removeAttribute('class');
		$this->removeAttribute('placeholder');

		$strOut = parent::toString();

		$imageLabel->append($strOut);
		$imageLabel->append($placeholder);


		return $imageLabel->toString();
	}
}