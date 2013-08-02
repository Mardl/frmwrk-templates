<?php

namespace Templates\Html\Input;

/**
 * Class Textarea
 *
 * @category Templates
 * @package  Templates\Html\Input
 * @author   Vadim Justus <vadim@dreiwerken.de>
 */
class Textarea extends \Templates\Html\Input
{

	/**
	 * @var bool
	 */
	protected $forceClose = true;
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
	 * @param array  $classOrAttributes
	 */
	public function __construct($name, $value = '', $placeholder = '', $required = false, $classOrAttributes = array())
	{
		parent::__construct($name, $value, $placeholder, $required, 'textarea', $classOrAttributes);

		$this->setTagname('textarea');
		$this->removeAttribute('type');
		$this->removeAttribute('value');
	}

	/**
	 * @param string $anz
	 * @return void
	 */
	public function rows($anz)
	{
		$this->addAttribute('rows', $anz);
	}

	/**
	 * @param string $anz
	 * @return void
	 */
	public function cols($anz)
	{
		$this->addAttribute('cols', $anz);
	}

	/**
	 * @param string $value
	 * @return void
	 */
	public function setValue($value)
	{
		$this->set($value);
		$this->value = $value;
	}

}