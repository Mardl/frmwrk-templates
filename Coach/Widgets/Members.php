<?php

namespace Templates\Coach\Widgets;


class Members extends \Templates\Coach\Widget
{

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct(array $members, $view, $moreUrl = null, $moreTitle = "alle Termine >")
	{
		parent::__construct("Mitglieder", null, "colThreeQuarter membersWidget");

		if (!is_null($moreUrl)){
			$this->setMoreLink($moreUrl, $moreTitle);
		}

		if (!empty($members)){
			$list = new \Templates\Coach\Members($members, '');
			$list->setView($view);
			$this->append($list);

		} else {
			$this->append("<h4>Du hast keinen Zugriff auf die Mitglieder</h4>");
		}


	}

}
