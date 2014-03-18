<?php

namespace Templates\Myipt;


class Friendlist extends \Templates\Html\Tag
{

	protected $view = null;
	protected $friends = array();
	protected $friendships = true;

	public function __construct(array $friends, $friendships = true, $classOrAttributes = array())
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "friendList";
		} else {
			$classOrAttributes .= " friendList";
		}

		parent::__construct('div', '', $classOrAttributes);

		$this->friends = $friends;
		$this->friendships = $friendships;

	}

	public function setView($view){
		$this->view = $view;
	}


	public function toString(){

		/**
		 * @var $u \App\Models\User
		 */
		foreach ($this->friends as $u){
			$div = new \Templates\Html\Tag("div",'', 'item');
			$this->append($div);

			$infos = new \Templates\Html\Anchor($this->view->url(array('action'=>'details', 'id' => $u->getId())), "", "get-ajax");
			$div->append($infos);

			//Avatar
			$file = $u->getAvatarFile();
			if (!$file){
				$avatar = new \Templates\Html\Image($u->getAvatar());
			} else {
				$avatar =  $file->getThumbnail(96,96,'','', null, false, true);
			}
			$span = new \Templates\Html\Tag("span", $avatar, 'img');
			$infos->append($span);

			//Headline
			$name = $u->getFullname();
			if ($u->getTrainer() || $u->getAdmin()){
				$name = $u->getFirstname();
			}

			$h = new \Templates\Html\Tag("h2", $name);
			$infos->append($h);

			//State
			$state = new \Templates\Html\Tag("div",'', 'state');
			$infos->append($state);

			//Controls
			$controls = new \Templates\Html\Tag("div",'', 'controls');
			$infos->append($controls);

			if ($this->friendships){
				$state->append("offline");

				$invite = new \Templates\Html\Tag('div', '');
				$controls->append($invite);

				$anchor = new \Templates\Html\Anchor($this->view->url(array("action"=>"discussion", "receiver" => $u->getId()), "nachrichten"), '', 'fancybox fancybox.ajax');
				$icon = new \Templates\Html\Tag('span', '', 'icon little message');
				$anchor->append($icon);
				$anchor->append("Nachricht senden");
				$invite->append($anchor);

				$invite = new \Templates\Html\Tag('div', '');
				$controls->append($invite);
				$anchor = new \Templates\Html\Anchor('#','');//$this->view->url(array('action'=>'friendships', 'method' => 'remove', 'id' => $u->getId())), '');
				$icon = new \Templates\Html\Tag('span', '', 'icon little award');
				$anchor->append($icon);
				$anchor->append("Herausfordern");
				$invite->append($anchor);

			} else {

				$invite = new \Templates\Html\Tag('div', '');
				$controls->append($invite);

				$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'friendships', 'method' => 'request', 'id' => $u->getId())), '');
				$icon = new \Templates\Html\Tag('span', '', 'icon little add');
				$anchor->append($icon);
				$anchor->append("Freundschaft anbieten");

				$invite->append($anchor);
			}






		}

		return parent::toString();
	}

}
