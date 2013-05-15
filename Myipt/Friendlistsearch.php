<?php

namespace Templates\Myipt;


class Friendlistsearch extends \Templates\Html\Tag
{

	protected $view = null;
	protected $members = array();
	protected $friendships = true;
	protected $phrase = null;

	public function __construct(array $members, $phrase, $classOrAttributes = array())
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "memberList";
		} else {
			$classOrAttributes .= " memberList";
		}

		parent::__construct('div', '', $classOrAttributes);

		$this->members = $members;
		$this->phrase = $phrase;
	}

	public function setView($view){
		$this->view = $view;
	}


	public function toString(){

		foreach ($this->members as $u){
			$this->append(
				new \Templates\Coach\Member($u)
			);
		}

		return parent::toString();
	}

}
