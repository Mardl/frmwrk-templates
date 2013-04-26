<?php

namespace Templates\Myipt\Widgets;


class Friends extends \Templates\Myipt\Widget
{

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct(array $friends, $view, $moreUrl = null)
	{
		parent::__construct("Meine Freunde", null, "colThreeQuarter");

		if (!is_null($moreUrl)){
			$this->setMoreLink($moreUrl, "alle Termine >");
		}

		if (!empty($friends)){
			$list = new \Templates\Myipt\Friendlist($friends, true, '');
			$list->setView($view);
			$this->append($list);

		} else {
			$this->append("<h4>Du hast noch keine Freundschaften geschlossen</h4>");
		}


	}

}
