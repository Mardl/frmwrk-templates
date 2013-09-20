<?php

namespace Templates\Coach\Widgets;

/**
 * Class Memberselect
 *
 * @category Lifemeter
 * @package  Templates\Coach\Widgets
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Memberselect extends \Templates\Coach\Widget
{

	/**
	 * @var array
	 */
	protected $members;

	/**
	 * @var array
	 */
	protected $urlarray = array("action"=>"index");

	/**
	 * @var array
	 */
	protected $view;


	/**
	 * @param array $members
	 * @param array $view
	 * @param null  $moreUrl
	 */
	public function __construct(array $members, $view, $moreUrl = null)
	{
		parent::__construct("Mitglieder", null, "colFull membersWidget");

		if (!is_null($moreUrl))
		{
			$this->setMoreLink($moreUrl, "alle Termine >");
		}

		$this->members = $members;
		$this->view = $view;

	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function setUrlData(array $data)
	{
		$this->urlarray = $data;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		if (!empty($this->members))
		{
			$list = new \Templates\Coach\Members($this->members, '', $this->urlarray, true);
			$list->setView($this->view);
			$this->append($list);

		}
		else
		{
			//TODO keine direkten HTML Ausgaben!!!
			$this->append("<h4>Du hast keinen Zugriff auf die Mitglieder</h4>");
		}

		return parent::toString();
	}

}
