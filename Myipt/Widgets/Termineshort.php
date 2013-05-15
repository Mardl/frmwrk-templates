<?php

namespace Templates\Myipt\Widgets;


class Termineshort extends \Templates\Myipt\Widget
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
		/*
		parent::__construct('div', '', $classOrAttributes);

		$this->initHead();
		$this->initContent();
		$this->initFoot();

		if(!empty($headerText))
		{
			$this->setHeader($headerText);
		}
		if (!empty($value))
		{
			$this->append($value);
		}
		*/

		parent::__construct("Termine", null, "colHalf");
		$this->setMoreLink($moreUrl, "alle Termine >");

		$list = new \Templates\Myipt\UnsortedList('',array(),'termine');

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


		$this->append($list);


		/*
		$wTermine->append(
				new \Templates\Myipt\UnsortedList(
						'',
						array(
								'Cardio Workout',
								'Butterfly',
								'Crunch Training',
								'Medical Check'
						),
						'termine'
				)
		);
		*/
	}

}
