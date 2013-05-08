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

		$state->append("offline");

		if (!$this->disableControls){
			$wrapper = new \Templates\Html\Tag('div', '');
			$controls->append($wrapper);
			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'edit', 'id' => $this->member->getId())),'');
			$icon = new \Templates\Html\Tag('span', '', 'icon edit');
			$anchor->append($icon);
			$anchor->append("Bearbeiten");
			$wrapper->append($anchor);

			$wrapper = new \Templates\Html\Tag('div', '');
			$controls->append($wrapper);
			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'status', 'id' => $this->member->getId())),'');
			$icon = new \Templates\Html\Tag('span', '', 'icon speed');
			$anchor->append($icon);
			$anchor->append("Statusfoto");
			$wrapper->append($anchor);
		}


		return parent::toString();
	}

}
