<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Mahlzeiten
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Mahlzeiten extends \Templates\Myipt\Widget
{

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct()
	{

		//TODO keine direkte HTML Ausgabe!!!!!
		$headline = "Mahlzeiten <span class='column'>Fett</span><span class='column'>Protein</span><span class='column'>kh</span><span class='column'>kcal</span><span class='column'>Menge</span>";

		parent::__construct($headline, null, "colThreeQuarter mahlzeiten");

	}

}
