<?php

namespace Templates\Html;

class Fieldset extends Tag
{
	/**
	 * @var Tag
	 */
	protected $legend = null;

	public function __construct($legend=null)
	{
		parent::__construct('fieldset');

		$this->legend = new Tag('legend');
		if(!is_null($legend)) {
			$this->setLegend($legend);
		}
	}

	public function setLegend($legend)
	{
		$this->legend->setValue($legend);
	}

	public function 
}