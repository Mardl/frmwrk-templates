<?php

namespace Templates\Coach;

use	Templates\Html\Tag;

/**
 * Class Member
 *
 * @category Lifemeter
 * @package  Templates\Coach
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Member extends Tag
{

	/**
	 * @var \App\Models\User|null
	 */
	protected $member = null;

	/**
	 * @var null
	 */
	protected $view = null;

	/**
	 * @var bool
	 */
	protected $disableControls = false;

	/**
	 * @var null|string
	 */
	protected $url;

	/**
	 * @var bool
	 */
	protected $itemlink;

	/**
	 *@var false
	 */
	protected $showZielChart = false;

	/**
	 * @var \App\Manager\Reports\Position|null
	 */
	protected $reportPositionManager = null;

	/**
	 * @var \App\Manager\Analyses|null
	 */
	protected $analyseManager = null;


	/**
	 * @param \App\Models\User $member   User
	 * @param string           $url      url
	 * @param bool             $itemlink true => ganzes Item ist verlinkt, false => nur der Title ist verlinkt
	 */
	public function __construct($member, $url = null, $itemlink = true)
	{
		$this->reportPositionManager = new \App\Manager\Reports\Position();
		$this->analyseManager = new \App\Manager\Analyses();

		parent::__construct('div', '', 'item');
		$this->member = $member;
		$this->url = $url;
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
	 * @param \Templates\Coach\false $showZielChart
	 * @return void
	 */
	public function setShowZielChart($showZielChart)
	{
		$this->showZielChart = $showZielChart;
	}

	/**
	 * @return void
	 */
	public function disableControls()
	{
		$this->disableControls = true;
	}

	/**
	 * @return void
	 */
	public function enableControls()
	{
		$this->disableControls = false;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		//Holt sich das Container Element (Entweder das Item selbst oder den Anchor)
		$container = $this->getContainer();

		//Avatar
		$avatar = $this->getAvatar();

		$divLeftColumn = new Tag('div');

		$span = new \Templates\Html\Tag("span", $avatar, 'img');
		$divLeftColumn->append($span);
		$divLeftColumn->addClass('memberList-left-column');
		$container->append($divLeftColumn);

		$divRightColumn = new Tag('div');
		$divRightColumn->addClass('memberList-right-column');

		$h = new \Templates\Html\Tag("h2", $this->member->getFullname());

		//Headline verlinken?
		if ($this->url && !$this->itemlink)
		{
			$anchor = new \Templates\Html\Anchor($this->url, '');
			$anchor->addClass('get-ajax');
			$anchor->append($h);
			$divRightColumn->append($anchor);
		}
		else
		{
			//headline
			$divRightColumn->append($h);
		}

		//State
		$state = new \Templates\Html\Tag("div", '', 'state');
		$divRightColumn->append($state);
		$this->showLoginState($state);

		// Controls
		$this->showControls($divRightColumn);

		//Charts
		$this->showZielChart($divRightColumn);
		$container->append($divRightColumn);



		return parent::toString();
	}

	/**
	 * @param Tag $appendTo
	 * @return bool
	 */
	private function showControls(\Templates\Html\Tag $appendTo)
	{
		if ($this->disableControls)
		{
			return;
		}
		$controls = new \Templates\Html\Tag("div", '', 'controls');
		$wrapper = new \Templates\Html\Tag('div', '');
		$controls->append($wrapper);

		$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('module'=>'users', 'controller'=>'index', 'action'=>'edit', 'id' => $this->member->getId())), 'icon edit', "Bearbeiten");
		$wrapper->append($anchor);

		$wrapper = new \Templates\Html\Tag('div', '');
		$controls->append($wrapper);

		$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('module'=>'users', 'controller'=>'index', 'action'=>'status', 'id' => $this->member->getId())), 'icon speed', "Statusfoto");
		$wrapper->append($anchor);

		$wrapper = new \Templates\Html\Tag('div', '');
		$controls->append($wrapper);

		$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('action'=>'trainingsplan', 'id' => $this->member->getId())), 'icon power', "Trainingsplan");
		$wrapper->append($anchor);


		$wrapper = new \Templates\Html\Tag('div', '');
		$controls->append($wrapper);

		$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('action'=>'urkunden', 'id' => $this->member->getId())), 'icon award', "Urkunden");
		$wrapper->append($anchor);


		$appendTo->append($controls);

		return true;
	}

	/**
	 * @param Tag $appendTo
	 * @return bool
	 */
	private function showZielChart(\Templates\Html\Tag $appendTo)
	{
		if(!$this->showZielChart)
		{
			return;
		}

		$chartsDiv = new \Templates\Html\Tag("div", '', 'charts');
		$appendTo->append($chartsDiv);

		$reportPositions = $this->reportPositionManager->getZielReportPositionsByUser($this->member);

		foreach ($reportPositions as $reportPosition)
		{
			$divMemberChart = new \Templates\Html\Tag('div', '', 'memberchart');

			$position = $reportPosition[0]->getPosition();
			$analyseData = $this->analyseManager->getLastetAnalysesByUserAndObject($this->member, $position);
			$serialized = json_decode($analyseData->getSerialized(), true);


			if(!empty($serialized))
			{
				$charts = new \Templates\Myipt\Chart($serialized, 'abs');
				$charts->setId($serialized['id'] . $this->member->getId() . 'abs');
				$charts->setDataRel($serialized['id'] . $this->member->getId() . 'abs');
				$charts->setHeight(30);
				$charts->setWidth(180);
				$charts->setShowMainValues(false);
				$charts->setHorizontalView(true);

				//Beschriftung hinzufügen
				$spanPositionText = new \Templates\Html\Tag('span', $position->getName());
				$divMemberChart->append($spanPositionText);

				//Chart hinzufügen
				$divMemberChart->append($charts);
			}
			$chartsDiv->append($divMemberChart);
		}
		$divClear = new Tag('div', '', 'clear');
		$chartsDiv->append($divClear);

		return true;
	}

	/**
	 * @return \Templates\Html\Image
	 */
	private function getAvatar()
	{
		$file = $this->member->getAvatarFile();
		if (!$file)
		{
			$avatar = new \Templates\Html\Image($this->member->getAvatar());
		}
		else
		{
			$avatar =  $file->getThumbnail(96, 96, '', '', null, false, true);
		}
		return $avatar;
	}

	/**
	 * @param Tag $appendTo
	 * @return void
	 */
	private function showLoginState(\Templates\Html\Tag $appendTo)
	{
		$loginStates = $this->member->getLoginStates();
		$states = array();

		if (array_sum($loginStates) == 0)
		{
			$onoff = new \Templates\Html\Tag("span", "offline", 'inaktive');
		}
		else
		{
			foreach ($loginStates as $key => $state)
			{
				if ($state == 1)
				{
					switch($key)
					{
						case \App\Models\User\Login::TYPE_COACH:
							$states[] = "Trainer";
							break;
						case \App\Models\User\Login::TYPE_MYIPT_APP:
						case \App\Models\User\Login::TYPE_MYIPT_APP_RECONNECT:
							$states[] = "mobil Online";
							break;
						case \App\Models\User\Login::TYPE_MYIPT_WEB:
							$states[] = "online";
							break;
						case \App\Models\User\Login::TYPE_STUDIO:
							$states[] = "im Training";
							break;
					}
				}
			}

			$onoff = new \Templates\Html\Tag("span", implode(" / ", $states), 'aktive');
		}

		$appendTo->append($onoff);
	}

	/**
	 * @return \Templates\Coach\Member|\Templates\Html\Anchor
	 */
	private function getContainer()
	{
		$container = $this;

		//komplettes Item verlinken?
		if ($this->url && $this->itemlink)
		{
			$anchor = new \Templates\Html\Anchor($this->url, '');
			$container = $anchor;
			$this->append($container);
		}

		return $container;
	}

}
