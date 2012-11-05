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

		$this->initLegend($legend);


	}

	public function legend($legend)
	{
		return $this->legend->append($legend);
	}

	protected function initLegend($legend)
	{
		$this->legend = new Tag('legend');
		if(!is_null($legend)) {
			$this->legend($legend);
		}
	}

	public function toString()
	{
		$legend = $this->legend->getInner();
		if (!empty($legend))
		{
			parent::prepend($this->legend);
		}
		return parent::toString();
	}



}