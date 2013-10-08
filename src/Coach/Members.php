<?php

namespace Templates\Coach;

/**
 * Class Members
 *
 * @category Lifemeter
 * @package  Templates\Coach
 * @author   Stefan Orthofer <stefan@dreiwerken.de>
 */
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
	 * @var bool
	 */
	protected $itemlink = true;

	/**
	 * @var boolean
	 */
	protected $showZielChart = false;

	/**
	 * @param array       $members
	 * @param array       $classOrAttributes
	 * @param bool|string $selectLink
	 * @param bool        $disableControls
	 * @param bool        $itemlink
	 * @internal param bool $chartArr
	 */
	public function __construct(array $members, $classOrAttributes = array(), $selectLink = false, $disableControls = false, $itemlink = true)
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
		$this->itemlink = $itemlink;
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
	 * @param bool $showZielChart
	 * @return void
	 */
	public function setShowZielChart($showZielChart)
	{
		$this->showZielChart = $showZielChart;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		foreach ($this->members as $member)
		{
			if ($this->selectLink)
			{
				$this->selectLink["userid"] = $member->getId();
				$memberItem = new \Templates\Coach\Member($member, $this->view->url($this->selectLink), $this->itemlink);
			}
			else
			{
				$memberItem = new \Templates\Coach\Member($member);
			}

			if ($this->disableControls)
			{
				$memberItem->disableControls();
			}

			$memberItem->setShowZielChart($this->showZielChart);
			$memberItem->setView($this->view);
			$this->append($memberItem);
		}

		return parent::toString();
	}

}
