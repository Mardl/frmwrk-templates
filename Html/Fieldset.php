<?php

namespace Templates\Html;

class Fieldset extends Tag
{
	/**
	 * @var Tag
	 */
	protected $legend = null;

	public function __construct($legend=null, $classOrAttributes = array())
	{
		parent::__construct('fieldset', '', $classOrAttributes);

		$this->legend = new Tag('legend');
		if(!is_null($legend)) {
			$this->legend($legend);
		}
	}

	public function legend($legend)
	{
		return $this->legend->setValue($legend);
	}

}