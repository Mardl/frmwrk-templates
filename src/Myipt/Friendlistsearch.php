<?php

namespace Templates\Myipt;


class Friendlistsearch extends \Templates\Html\Tag
{

	protected $view = null;
	protected $friends = array();
	protected $phrase = null;

	public function __construct(array $friends, $phrase, $classOrAttributes = array())
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "friendList";
		} else {
			$classOrAttributes .= " friendList";
		}

		parent::__construct('div', '', $classOrAttributes);

		$this->friends = $friends;
		$this->phrase = $phrase;
	}

	public function setView($view){
		$this->view = $view;
	}

	public function toString(){

		foreach ($this->friends as $u){
			$div = new \Templates\Html\Tag("div",'', 'item');
			$this->append($div);

			//Avatar
			$file = $u->getAvatarFile();
			if (!$file){
				$avatar = new \Templates\Html\Image($u->getAvatar());
			} else {
				$avatar =  $file->getThumbnail(96,96,'','', null, false, true);
			}

			$span = new \Templates\Html\Tag("span", $avatar, 'img');
			$div->append($span);

			//Headline
			$h = new \Templates\Html\Tag("h2", $u->getUsername());
			$div->append($h);

			//State
			$state = new \Templates\Html\Tag("div",'', 'info');
			$div->append($state);

			//Controls
			$controls = new \Templates\Html\Tag("div",'', 'controls');
			$div->append($controls);



			if ($u->isFriendTo($this->view->login)){

				$wrapper = new \Templates\Html\Tag('div', '');
				$controls->append($wrapper);
				$anchor = new \Templates\Myipt\Iconanchor(
					$this->view->url(array('action'=>'details', 'id' => $u->getId(), 'search' => $this->phrase)),
					'little search', "Mehr Informationen", "get-ajax"
				);
				$wrapper->append($anchor);

				$wrapper = new \Templates\Html\Tag('div', '');
				$controls->append($wrapper);
				$anchor = new \Templates\Myipt\Iconanchor(
					$this->view->url(array("action"=>"discussion", "receiver" => $u->getId()), "nachrichten"),
					'little message', "Nachricht senden", "fancybox fancybox.ajax"
				);
				$wrapper->append($anchor);

				$wrapper = new \Templates\Html\Tag('div', '');
				$controls->append($wrapper);
				$anchor = new \Templates\Myipt\Iconanchor(
					"#",
					'little award', "Herausfordern"
				);
				$wrapper->append($anchor);


			} else {

				$wrapper = new \Templates\Html\Tag('div', '');
				$controls->append($wrapper);
				$anchor = new \Templates\Myipt\Iconanchor(
						$this->view->url(array('action'=>'details', 'id' => $u->getId(), 'search' => $this->phrase)),
						'little search', "Mehr Informationen", "get-ajax"
				);
				$wrapper->append($anchor);

			}

			/*
			if ($this->friendships){

				$invite = new \Templates\Html\Tag('div', '');
				$controls->append($invite);

				$anchor = new \Templates\Html\Anchor($this->view->url(array("action"=>"discussion", "receiver" => $u->getId()), "nachrichten"), '', 'fancybox fancybox.ajax');
				$icon = new \Templates\Html\Tag('span', '', 'icon little message');
				$anchor->append($icon);
				$anchor->append("Nachricht senden");
				$invite->append($anchor);

			} else {

			}
			*/
		}

		return parent::toString();
	}

}
