<?php
namespace Templates\Html\Input;

class Select extends \Templates\Html\Input
{

	private $options = array();
	private $optGroups = array();
	private $size = 1;
	private $multiselect = false;

	public function __construct($name, $selectedValue = '', $opt = array(), $required = false, $placeholder = '', $classOrAttributes = array())
	{
		parent::__construct($name, $selectedValue, $placeholder, $required, 'select', $classOrAttributes);

		$this->setOption($opt);

		$this->setTagname('select');
		$this->removeAttribute('type');
		$this->removeAttribute('value');
	}

	public function validate()
	{
		if ($this->isRequired())
		{
			$found = false;
			$count = 0;
			foreach ($this->options as $option)
			{
				$count++;
				if ($count == 1)
				{
					continue;
				}
				$found = $found || $option[2];
			}
			if (!$found)
			{
				return "Fehlende Eingabe für " . $this->getErrorLabel();
			}
		}

		return true;
	}

	public function setOption($opt)
	{
		$finish = array();

		foreach ($opt as $key => $value)
		{
			if (is_array($value))
			{
				if (isset($finish[$key]))
				{
					continue;
				}
				foreach ($opt[$key] as $keyNeu => $valueNeu)
				{

					$this->addOptionGrouped($keyNeu, $valueNeu, $key, ((string)$this->getValue() === (string)$keyNeu));
				}
				$finish[$key] = $key;
			}
			else
			{
				$this->addOption($key, $value, ((string)$this->getValue() === (string)$key));
			}
		}

		return $this;
	}

	public function addOption($value, $tag, $selected = false)
	{
		$this->options[] = array($value, $tag, $selected);

	}

	public function addOptionGrouped($value, $tag, $optgroup, $selected = false)
	{
		if (!isset($this->optGroups[$optgroup]))
		{
			$this->optGroups[$optgroup] = array();
		}

		$this->optGroups[$optgroup][] = array($value, $tag, $selected);

	}

	public function setSize($size)
	{
		$this->size = $size;

	}

	public function setMultiSelect($boolean)
	{
		$this->multiselect = $boolean;

	}

	public function toString()
	{

		if ($this->multiselect)
		{
			$this->addAttribute('multiple', 'multiple');
		}
		if ($this->size > 1)
		{
			$this->addAttribute('size', $this->size);
		}
		if (empty($this->options) && empty($this->optGroups))
		{
			return "Form element 'select' has no options.";
		}

		$this->set($this->renderOptions());

		return parent::toString();
	}

	private function renderOptions()
	{
		$opts = '';
		foreach ($this->options as $option)
		{
			$opts .= '<option value="' . $option[0] . '"';

			if ($option[2] || ((string)$this->getValue() === (string)$option[0]))
			{
				$opts .= ' selected="selected"';
			}
			$opts .= '>' . $option[1] . '</option>';
		}

		foreach ($this->optGroups as $group => $options)
		{
			$opts .= "<optgroup label='" . $group . "'>";
			foreach ($options as $option)
			{
				$opts .= '<option value="' . $option[0] . '"';

				if ($option[2] || ((string)$this->getValue() === (string)$option[0]))
				{
					$opts .= 'selected="selected"';
				}
				$opts .= '>' . $option[1] . '</option>';
			}
			$opts .= "</optgroup>";
		}

		return $opts;
	}

}