<?php

namespace Templates\Myipt;

use \Templates\Html\Tag;

/**
 * Class ControlGroup
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class ControlGroup extends \Templates\Html\Tag
{

	/**
	 * @var null
	 */
	protected $content = null;

	/**
	 * @var null|\Templates\Html\Tag
	 */
	protected $label = null;

	/**
	 * @var bool
	 */
	protected $required = false;

	/**
	 * @param string $label
	 * @param array  $value
	 * @param bool   $required
	 * @param array  $classOrAttributes
	 */
	public function __construct($label,$value=array(), $required=false, $classOrAttributes = array())
	{
		$this->label = new \Templates\Html\Tag('label', $label);

		parent::__construct('p', '', $classOrAttributes);

		$this->required = $required;

		$this->initLabel();
		parent::append($value);

	}

	/**
	 * @param string $label
	 * @return void
	 */
	public function setLabel($label)
	{
		$this->label->set($label);
	}

	/**
	 * @param mixed $value
	 * @return Tag|void
	 */
	public function append($value)
	{
		parent::append($value);
	}

	/**
	 * @param mixed $value
	 * @return Tag|void
	 */
	public function prepend($value)
	{
		//$this->content->prepend($value);
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return parent::toString();
	}

	/**
	 * @return void
	 */
	protected function initLabel()
	{
		$label = $this->label->getInner();
		if (!empty($label))
		{
			if ($this->required)
			{
				$this->label->append(' *');
			}
			parent::append($this->label);
		}
	}

}