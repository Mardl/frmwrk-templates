<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Termineshort
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Alexander Jonser <aj@whm-gmbh.net>
 */
class Termineshort extends \Templates\Myipt\Widget
{

	/**
	 * Konstruktor
	 *
	 * @param array       $termine
	 * @param \Core\View  $view
	 * @param string|null $moreUrl
	 */
	public function __construct(array $termine, $view, $moreUrl = null)
	{
		parent::__construct("Termine", null, "colHalf flow");
		$this->setView($view);

		if (!is_null($moreUrl))
		{
			$this->setMoreLink($moreUrl, "alle Termine >");
		}

		if (!empty($termine))
		{
			$week = null;
			foreach ($termine as $termin)
			{
				if ($week != $termin->getDateFrom()->format("W"))
				{
					$list = new \Templates\Myipt\UnsortedList('', array(), 'termine '.$termin->getDateFrom()->format("W-d"));
					$this->append($list);
				}

				$anchor = new \Templates\Html\Anchor(
					$this->view->url(array("id"=>$termin->getId(), "userid" => $termin->getUser()->getId()), "termindetails"),
					sprintf(
						"%s %s %s %s",
						$termin->getSubject(),
						new \Templates\Html\Tag('span', ' - ' . $termin->getDateTil()->format('H:i'), 'time'),
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
		}
		else
		{
			$list = new \Templates\Myipt\UnsortedList('', array(), 'termine ');
			$this->append($list);
			$list->append("Keine offenen Termine", "noBorder");
		}

	}

}
