<?php

namespace Templates\MandyLane;

use \Templates\Html\Tag;

class ControlGroup extends \Templates\Html\Tag
{

	protected $content = null;
	protected $label = null;
	protected $required = false;
	/**
	 * @param $label
	 * @param array $value
	 * @param bool $required
	 * @param array $classOrAttributes
	 */
	public function __construct($label,$value=array(), $required=false, $classOrAttributes = array())
	{
		$this->label = new \Templates\Html\Tag('label',$label);

		parent::__construct('p','',$classOrAttributes);

		$this->required = $required;

		$this->initLabel();
		parent::append($value);

	}

	public function setLabel($label)
	{
		$this->label->set($label);
	}

	public function append($value)
	{
		$this->content->append($value);
	}

	public function prepend($value)
	{
		//$this->content->prepend($value);
	}

	public function toString()
	{
/*		$this->initLabel();
		$this->initControls();*/
		return parent::toString();
	}

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