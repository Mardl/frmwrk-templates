<?php

namespace Templates\Coach;


class Members extends \Templates\Html\Tag
{
	/**
	 * @var null
	 */
	protected $view = null;

	/**
	 * @var array
	 */
	protected $members = array();

	/**
	 * @var array|bool
	 */
	protected $selectLink = false;

	/**
	 * @var bool
	 */
	protected $disableControls = false;

	/**
	 * @param array       $members
	 * @param array       $classOrAttributes
	 * @param bool|array  $selectLink
	 * @param bool        $disableControls
	 */
	public function __construct(array $members, $classOrAttributes = array(), $selectLink = false, $disableControls = false)
	{
		if (is_array($classOrAttributes))
		{
			$classOrAttributes[] = "memberList";
		}
		else
		{
			$classOrAttributes .= " memberList";
		}

		parent::__construct('div', '', $classOrAttributes);

		$this->members = $members;
		$this->selectLink = $selectLink;
		$this->disableControls = $disableControls;
	}

	/**
	 * @param \Core\View $view
	 * @return void
	 */
	public function setView($view)
	{
		$this->view = $view;
	}

	/**
	 * @return string
	 */
	public function toString()
	{

		foreach ($this->members as $u)
		{
			if ($this->selectLink)
			{
				$this->selectLink["userid"] = $u->getId();
				$m = new \Templates\Coach\Member($u, $this->view->url($this->selectLink));
			}
			else
			{
				$m = new \Templates\Coach\Member($u);
			}

			if ($this->disableControls)
			{
				$m->disableControls();
			}

			$m->setView($this->view);
			$this->append($m);
		}

		return parent::toString();
	}

}
