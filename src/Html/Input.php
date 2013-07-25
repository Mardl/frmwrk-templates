<?php

namespace Templates\Html;

/**
 * Class Input
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Input extends Tag
{

	/**
	 * @var bool
	 */
	protected $forceClose = false;
	/**
	 * @var bool
	 */
	protected $required = false;
	/**
	 * @var string
	 */
	protected $value = '';
	/**
	 * @var string
	 */
	protected $placeholder = '';

	/**
	 * @param string $name
	 * @param string $value
	 * @param string $placeholder
	 * @param bool   $required
	 * @param string $type
	 * @param array  $classOrAttributes
	 */
	public function __construct($name, $value = '', $placeholder = '', $required = false, $type = 'text', $classOrAttributes = array())
	{
		parent::__construct('input', '', $classOrAttributes);


		$this->setType($type);
		$this->setName($name);
		$this->setValue($value);
		$this->setRequired($required);
		if (!empty($placeholder))
		{
			$this->setPlaceholder($placeholder . ($required ? ' *' : ''));
		}
	}

	/**
	 * @param bool $required
	 * @return void
	 */
	public function setRequired($required = true)
	{
		$this->required = $required;
	}

	/**
	 * @return bool
	 */
	public function isRequired()
	{
		return $this->required;

	}

	/**
	 * @param string $value
	 * @return void
	 */
	public function setValue($value)
	{
		$this->addAttribute('value', $value);
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param string $name
	 * @return Tag
	 */
	public function setName($name)
	{
		$this->setId($name);

		return $this->addAttribute('name', $name);
	}

	/**
	 * @return null|string
	 */
	public function getName()
	{
		return $this->getAttribute('name', '');
	}

	/**
	 * @param string $type
	 * @return Tag
	 */
	public function setType($type)
	{
		return $this->addAttribute('type', empty($type) ? 'text' : $type);
	}

	/**
	 * @param string $placeholder
	 * @return Tag
	 */
	public function setPlaceholder($placeholder)
	{
		$this->placeholder = $placeholder;

		return $this->addAttribute('placeholder', $placeholder);
	}

	/**
	 * @return null|string
	 */
	public function getErrorLabel()
	{
		return (empty($this->placeholder) ? $this->getName() : $this->placeholder);
	}

	/**
	 * @return bool|string
	 */
	public function validate()
	{
		if ($this->isRequired() && empty($this->value))
		{
			return "Fehlende Eingabe für " . $this->getErrorLabel();
		}

		return true;
	}

}