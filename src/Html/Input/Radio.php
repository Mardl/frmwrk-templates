<?php
namespace Templates\Html\Input;

class Radio extends \Templates\Html\Input
{

	private $options = array();

	public function __construct($name, $selectedValue='', $opt = array(),$required=false, $placeholder='', $classOrAttributes = array())
	{
		parent::__construct($name, $selectedValue, $placeholder ,$required, 'radio', $classOrAttributes);

		$this->setOption($opt);
	}

	public function addOption($value, $title, $selected = false)
	{
		$this->options[] = array($value,$title,$selected);

	}

	public function setOption($opt)
	{
		if (!empty($opt))
		{
			foreach($opt as $value => $title)
			{
				$this->addOption($value, $title, $value == $this->getValue());
			}
		}
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function validate()
	{

		if ($this->isRequired())
		{
			$found = false;
			foreach($this->options as $option)
			{
				$found = $found || $option[2];
			}
			if (!$found)
			{
				return "Fehlende Eingabe für ".$this->getErrorLabel();
			}
		}

		return true;
	}

	public function toString()
	{
		parent::set('');
		$count=0;
		$arRadios = array();
		foreach ($this->options as $option)
		{
			$count++;
			$radio = new \Templates\Html\Input( $this->getName(), $option[0], $option[1], $this->isRequired(), 'radio' );
			$radio->setId( $this->getName().'-'.$count );
			if ($option[2])
			{
				$radio->addAttribute('checked','checked');
			}


			$radioLabel = new \Templates\Html\Tag('label');
			foreach($this->getAttribute('class',array()) as $class)
			{
				$radioLabel->addClass($class);
			}
			$radioLabel->append($radio);
			$radioLabel->append($radio->getAttribute('placeholder',''));

			$radio->removeAttribute('placeholder');

			$arRadios[] = $radioLabel;
		}

		$strOut = '';
		foreach($arRadios as $radio)
		{
			$strOut .= $radio->toString();
		}
		return $strOut;
	}
}