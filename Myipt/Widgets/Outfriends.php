<?php

namespace Templates\Myipt\Widgets;


class Outfriends extends \Templates\Myipt\Widget
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
		parent::__construct("eigene Anfragen", null, "colQuarter flow");
		if (!is_null($moreUrl)){
			$this->setMoreLink($moreUrl, "alle Termine >");
		}

		if (!empty($friends)){

			$list = new \Templates\Myipt\Openfriendlist($friends, "outgoing", '');
			$list->setView($view);

			$this->append($list);

		} else {
			$this->append("<h4>Du hast noch keine Freundschaften geschlossen</h4>");
		}


	}

}