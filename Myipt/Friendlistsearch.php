<?php

namespace Templates\Myipt;


class Friendlistsearch extends \Templates\Html\Tag
{

	protected $view = null;
	protected $friends = array();
	protected $friendships = true;
	protected $phrase = null;

	public function __construct(array $friends, $phrase, $friendships = true, $classOrAttributes = array())
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "friendList";
		} else {
			$classOrAttributes .= " friendList";
		}

		parent::__construct('div', '', $classOrAttributes);

		$this->friends = $friends;
		$this->friendships = $friendships;
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
				$avatar =  $file->getThumbnail(96,96,'','');
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

			if ($this->friendships){
				//$active = new \Templates\Html\Tag
			} else {


				$invite = new \Templates\Html\Tag('div', '');
				$controls->append($invite);

				$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'details', 'id' => $u->getId(), 'search' => $this->phrase)), '');
				$anchor->addClass("get-ajax");
				/*$anchor->addAttribute("data-transition", "leftOut");
				$anchor->addAttribute("data-rel", "#bigBlock");*/

				$icon = new \Templates\Html\Tag('span', '', 'icon little search');
				$anchor->append($icon);
				$anchor->append("Mehr Informationen");

				$invite->append($anchor);
			}






		}

		return parent::toString();
	}

}
