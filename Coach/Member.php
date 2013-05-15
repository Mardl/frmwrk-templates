<?php

namespace Templates\Coach;

use	Templates\Html\Tag;

class Member extends Tag
{
	protected $member = null;
	protected $view = null;

	protected $disableControls = false;
	protected $url;

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($member, $url = null)
	{
		parent::__construct('div', '', 'item');
		$this->member = $member;
		$this->url = $url;
	}

	public function setView($view){
		$this->view = $view;
	}

	public function disableControls(){
		$this->disableControls = true;
	}

	public function enableControls(){
		$this->disableControls = false;
	}

	public function toString(){

		$container = $this;

		if ($this->url){
			$anchor = new \Templates\Html\Anchor($this->url, '');
			$container = $anchor;
			$this->append($anchor);
		}

		//Avatar
		$file = $this->member->getAvatarFile();
		if (!$file){
			$avatar = new \Templates\Html\Image($this->member->getAvatar());
		} else {
			$avatar =  $file->getThumbnail(96,96,'','');
		}
		$span = new \Templates\Html\Tag("span", $avatar, 'img');
		$container->append($span);

		//Headline
		$h = new \Templates\Html\Tag("h2", $this->member->getFullname());
		$container->append($h);

		//State
		$state = new \Templates\Html\Tag("div",'', 'state');
		$container->append($state);

		//Controls
		$controls = new \Templates\Html\Tag("div",'', 'controls');
		$container->append($controls);

		$loginStates = $this->member->getLoginStates();
		$states = array();

		if (array_sum($loginStates) == 0){
			$onoff = new \Templates\Html\Tag("span", "offline", 'inaktive');
		} else {
			foreach ($loginStates as $key => $s){
				if ($s == 1){
					switch($key){
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


		if (!$this->disableControls){
			$wrapper = new \Templates\Html\Tag('div', '');
			$controls->append($wrapper);

			$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('action'=>'edit', 'id' => $this->member->getId())), 'icon edit', "Bearbeiten");
			$wrapper->append($anchor);

			$wrapper = new \Templates\Html\Tag('div', '');
			$controls->append($wrapper);

			$anchor = new \Templates\Coach\Iconanchor($this->view->url(array('action'=>'status', 'id' => $this->member->getId())), 'icon speed', "Statusfoto");
			$wrapper->append($anchor);
		}


		return parent::toString();
	}

}
