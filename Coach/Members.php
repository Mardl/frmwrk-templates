<?php

namespace Templates\Coach;


class Members extends \Templates\Html\Tag
{

	protected $view = null;
	protected $members = array();

	protected $selectLink = false;
	protected $disableControls = false;

	public function __construct(array $members, $classOrAttributes = array(), $selectLink = false, $disableControls = false)
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "memberList";
		} else {
			$classOrAttributes .= " memberList";
		}

		parent::__construct('div', '', $classOrAttributes);

		$this->members = $members;
		$this->selectLink = $selectLink;
		$this->disableControls = $disableControls;
	}

	public function setView($view){
		$this->view = $view;
	}


	public function toString(){

		foreach ($this->members as $u){
			if ($this->selectLink){
				$this->selectLink["userid"] = $u->getId();
				$m = new \Templates\Coach\Member($u, $this->view->url($this->selectLink));
			} else {
				$m = new \Templates\Coach\Member($u);
			}

			if ($this->disableControls){
				$m->disableControls();
			}

			$m->setView($this->view);
			$this->append($m);
		}

		return parent::toString();
	}

}
