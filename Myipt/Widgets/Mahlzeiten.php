<?php

namespace Templates\Myipt\Widgets;


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
		$headline = "Mahlzeiten <span class='column'>fett</span><span class='column'>kh</span><span class='column'>kcal</span><span class='column'>Menge</span>";

		parent::__construct($headline, null, "colThreeQuarter mahlzeiten");

	}

}
