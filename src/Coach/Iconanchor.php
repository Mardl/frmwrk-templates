<?php

namespace Templates\Coach;

/**
 * Class Iconanchor
 *
 * @category Lifemeter
 * @package  Templates\Coach
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Iconanchor extends \Templates\Html\Anchor
{

	/**
	 * @param string       $href
	 * @param array|string $iconclass
	 * @param null         $text
	 * @param string       $classOrAttributes
	 */
	public function __construct($href, $iconclass, $text = null, $classOrAttributes = '')
	{
		$icon = new \Templates\Html\Tag("span", '', "icon {$iconclass}");

		$linktext = $icon.' '.$text;

		parent::__construct($href, $linktext, $classOrAttributes);
	}

}