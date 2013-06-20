<?php

namespace Templates\Srabon;

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
		$this->content = new \Templates\Html\Tag('div');
		$this->label = new \Templates\Html\Tag('label',$label,'control-label');

		parent::__construct('div',$value,$classOrAttributes);

		$this->addClass('control-group');

		$this->required = $required;

		$this->initLabel();
		$this->initControls();
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
		$this->content->prepend($value);
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

	protected function initControls()
	{
		$div = new \Templates\Html\Tag('div',$this->content,'controls');
		parent::append($div);
	}
}
