<?php

namespace Templates\Coach\Widgets;


class Termineshort extends \Templates\Coach\Widget
{

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct(array $termine, $moreUrl)
	{
		parent::__construct("Termine", null, "colHalf");
		$this->setMoreLink($moreUrl, "alle Termine >");

		$list = new \Templates\Coach\UnsortedList('',array(),'termine');
		$this->append($list);

		foreach ($termine as $termin){
			$list->append(
				sprintf(
					"%s %s %s",
					$termin->getSubject(),
					new \Templates\Html\Tag('span', $termin->getDateFrom()->format('H:i'), 'time'),
					new \Templates\Html\Tag('span', $termin->getDateFrom()->format('d.m'), 'date')
				)
			);
		}

	}

}
