<?php
namespace Templates\Html\Input;

/**
 * Class Select
 *
 * @category Templates
 * @package  Templates\Html\Input
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Select extends \Templates\Html\Input
{

	/**
	 * @var array
	 */
	private $options = array();
	/**
	 * @var array
	 */
	private $optGroups = array();
	/**
	 * @var int
	 */
	private $size = 1;
	/**
	 * @var bool
	 */
	private $multiselect = false;

	/**
	 * @param string $name
	 * @param string $selectedValue
	 * @param array  $opt
	 * @param bool   $required
	 * @param string $placeholder
	 * @param array  $classOrAttributes
	 */
	public function __construct($name, $selectedValue = '', $opt = array(), $required = false, $placeholder = '', $classOrAttributes = array())
	{
		parent::__construct($name, $selectedValue, $placeholder, $required, 'select', $classOrAttributes);

		$this->setOption($opt);

		$this->setTagname('select');
		$this->removeAttribute('type');
		$this->removeAttribute('value');
	}

	/**
	 * @return bool|string
	 */
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

	/**
	 * @param array $opt
	 * @return $this
	 */
	public function setOption(array $opt)
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

	/**
	 * @param string $value
	 * @param string $tag
	 * @param bool   $selected
	 * @return void
	 */
	public function addOption($value, $tag, $selected = false)
	{
		$this->options[] = array($value, $tag, $selected);

	}

	/**
	 * @param string $value
	 * @param string $tag
	 * @param string $optgroup
	 * @param bool   $selected
	 * @return void
	 */
	public function addOptionGrouped($value, $tag, $optgroup, $selected = false)
	{
		if (!isset($this->optGroups[$optgroup]))
		{
			$this->optGroups[$optgroup] = array();
		}

		$this->optGroups[$optgroup][] = array($value, $tag, $selected);

	}

	/**
	 * @param int $size
	 * @return void
	 */
	public function setSize($size)
	{
		$this->size = $size;

	}

	/**
	 * @param bool $boolean
	 * @return void
	 */
	public function setMultiSelect($boolean)
	{
		$this->multiselect = $boolean;

	}

	/**
	 * @return string
	 */
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

	/**
	 * @return string
	 */
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