<?php

namespace Templates\Coach\Widgets;


/**
 * Class Members
 *
 * @category Lifemeter
 * @package  Templates\Coach\Widgets
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Members extends \Templates\Coach\Widget
{

	/**
	 * @param array  $members
	 * @param array  $view
	 * @param null   $moreUrl
	 * @param string $moreTitle
	 */
	public function __construct(array $members, $view, $moreUrl = null, $moreTitle = "alle Termine >")
	{
		parent::__construct("Mitglieder", null, "colFull membersWidget");

		if (!is_null($moreUrl))
		{
			$this->setMoreLink($moreUrl, $moreTitle);
		}

		if (!empty($members))
		{
			$list = new \Templates\Coach\Members($members, '',  array('module' => 'index', 'controller' => 'index', 'action'=>'select'), false, false);
			$list->setView($view);
			$this->append($list);

		}
		else
		{
			$this->append("<h4>Du hast keinen Zugriff auf die Mitglieder</h4>");
		}


	}

}
