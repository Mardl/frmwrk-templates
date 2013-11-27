<?php

namespace Templates\MandyLane;

/**
 * Class PageTitle
 *
 * @category Lifemeter
 * @package  Templates\MandyLane
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class PageTitle extends \Templates\Html\Tag
{
	/**
	 * @param string       $name
	 * @param array|string $value
	 * @param array        $classOrAttributes
	 */
	public function __construct($title, $classOrAttributes = array())
	{
		parent::__construct('h1', $title, $classOrAttributes);
		$this->addClass('pageTitle');
	}
}