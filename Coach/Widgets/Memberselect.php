<?php

namespace Templates\Coach\Widgets;


class Memberselect extends \Templates\Coach\Widget
{

	protected $members;
	protected $urlarray = array("action"=>"index");
	protected $view;


	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct(array $members, $view, $moreUrl = null)
	{
		parent::__construct("Mitglieder", null, "colThreeQuarter membersWidget");

		if (!is_null($moreUrl)){
			$this->setMoreLink($moreUrl, "alle Termine >");
		}

		$this->members = $members;
		$this->view = $view;

	}

	public function setUrlData(array $data){
		$this->urlarray = $data;
	}

	public function toString(){
		if (!empty($this->members)){
			$list = new \Templates\Coach\Members($this->members, '', $this->urlarray, true);
			$list->setView($this->view);
			$this->append($list);

		} else {
			$this->append("<h4>Du hast keinen Zugriff auf die Mitglieder</h4>");
		}

		return parent::toString();
	}

}
