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
	 * @param \App\Models\User $member   User
	 * @param string           $url      url
	 * @param bool             $itemlink true => ganzes Item ist verlinkt, false => nur der Title ist verlinkt
	 */
	public function __construct($member, $url = null, $itemlink = true)
	{
		parent::__construct('div', '', 'item');
		$this->member = $member;
		$this->url = $url;
		$this->itemlink = $itemlink;
	}

	/**
	 * @param $view
	 * @return void
	 */
	public function setView($view)
	{
		$this->view = $view;
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
		$container = $this;

		//komplettes Item verlinken?
		if ($this->url && $this->itemlink)
		{
			$anchor = new \Templates\Html\Anchor($this->url, '');
			$container = $anchor;
			$this->append($anchor);
		}

		//Avatar
		$file = $this->member->getAvatarFile();
		if (!$file)
		{
			$avatar = new \Templates\Html\Image($this->member->getAvatar());
		}
		else
		{
			$avatar =  $file->getThumbnail(96, 96, '', '');
		}

		$span = new \Templates\Html\Tag("span", $avatar, 'img');
		$container->append($span);

		$h = new \Templates\Html\Tag("h2", $this->member->getFullname());

		//Headline verlinken?
		if ($this->url && !$this->itemlink)
		{
			$anchor = new \Templates\Html\Anchor($this->url, '');
			$anchor->addClass('get-ajax');
			$anchor->append($h);
			$container->append($anchor);
		}
		else
		{
			//headline
			$container->append($h);
		}

		//State
		$state = new \Templates\Html\Tag("div", '', 'state');
		$container->append($state);

		//Controls
		$controls = new \Templates\Html\Tag("div", '', 'controls');
		$container->append($controls);

		$loginStates = $this->member->getLoginStates();
		$states = array();

		if (array_sum($loginStates) == 0)
		{
			$onoff = new \Templates\Html\Tag("span", "offline", 'inaktive');
		}
		else
		{
			foreach ($loginStates as $key => $s)
			{
				if ($s == 1)
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

		$state->append($onoff);


		if (!$this->disableControls)
		{
			$wrapper = new \Templates\Html\Tag('div', '');
			$controls->append($wrapper);

			$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('action'=>'edit', 'id' => $this->member->getId())), 'icon edit', "Bearbeiten");
			$wrapper->append($anchor);

			$wrapper = new \Templates\Html\Tag('div', '');
			$controls->append($wrapper);

			$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('action'=>'status', 'id' => $this->member->getId())), 'icon speed', "Statusfoto");
			$wrapper->append($anchor);

			/*$wrapper = new \Templates\Html\Tag('div', '');
			$controls->append($wrapper);

			$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('action'=>'trainingsplan', 'id' => $this->member->getId())), 'icon power', "Trainingsplan");
			$wrapper->append($anchor);*/
		}

		return parent::toString();
	}

}
