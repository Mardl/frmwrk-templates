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
	public function __construct(array $termine, $view, $moreUrl)
	{
		parent::__construct("Termine", null, "colHalf");
		$this->setView($view);
		if (!is_null($moreUrl)){
			$this->setMoreLink($moreUrl, "alle Termine >");
		}


		$list = new \Templates\Myipt\UnsortedList('',array(),'termine');

			foreach ($termine as $termin){

				$anchor = new \Templates\Html\Anchor(
					$this->view->url(array("id"=>$termin->getId()), "termindetails"),
					sprintf(
						"%s %s %s",
						$termin->getSubject(),
						new \Templates\Html\Tag('span', $termin->getDateFrom()->format('H:i'), 'time'),
						new \Templates\Html\Tag('span', $termin->getDateFrom()->format('d.m'), 'date')
					),
					"get-ajax"
				);

				$list->append(
					$anchor,
					($termin->getStatus()>=3)?'rejected':null
				);
			}


		$this->append($list);

	}

}
