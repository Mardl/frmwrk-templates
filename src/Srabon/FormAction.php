<?php

namespace Templates\Srabon;

class FormAction extends \Templates\Html\Tag
{
	/**
	 * @param mixed $buttons
	 * @param array $classOrAttributes
	 */
	public function __construct($buttons=array(), $classOrAttributes = array())
	{
		parent::__construct('div','',$classOrAttributes);
		$this->addClass('form-actions');

		if (!empty($buttons))
		{
			$this->append($buttons);
		}
	}
}