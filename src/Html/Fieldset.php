<?php

namespace Templates\Html;

/**
 * Class Fieldset
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Fieldset extends Tag
{

	/**
	 * @var Tag
	 */
	protected $legend = null;

	/**
	 * @param null  $legend
	 * @param array $classOrAttributes
	 */
	public function __construct($legend = null, $classOrAttributes = array())
	{
		parent::__construct('fieldset', '', $classOrAttributes);

		$this->initLegend($legend);


	}

	/**
	 * @param string $legend
	 * @return Tag
	 */
	public function legend($legend)
	{
		return $this->legend->append($legend);
	}

	/**
	 * @param string $legend
	 * @return void
	 */
	protected function initLegend($legend)
	{
		$this->legend = new Tag('legend');
		if (!is_null($legend))
		{
			$this->legend($legend);
		}
	}

	/**
	 * @return string
	 */
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