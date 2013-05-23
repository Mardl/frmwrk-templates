<?php

namespace Templates\Myipt;


class Openfriendlist extends \Templates\Html\Tag
{

	protected $view = null;
	protected $friends = array();
	protected $type = true;

	public function __construct(array $friends, $type = "incoming", $classOrAttributes = array())
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "friendList";
		} else {
			$classOrAttributes .= " friendList";
		}

		parent::__construct('div', '', $classOrAttributes);

		$this->friends = $friends;
		$this->type = $type;

	}

	public function setView($view){
		$this->view = $view;
	}


	public function toString(){

		foreach ($this->friends as $f){
			if ($this->type == "incoming"){
				$u = $f->getUser1();
			} else {
				$u = $f->getUser2();
			}

			$div = new \Templates\Html\Tag("div",'', 'item mini');
			$this->append($div);

			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'details', 'id' => $u->getId())), '');
			$anchor->addClass("get-ajax");
			$div->append($anchor);

			//Avatar
			$file = $u->getAvatarFile();
			if (!$file){
				$avatar = new \Templates\Html\Image($u->getAvatar());
			} else {
				$avatar =  $file->getThumbnail(60,60,'','');
			}
			$span = new \Templates\Html\Tag("span", $avatar, 'img');
			$anchor->append($span);

			//Headline
			$name = $u->getFullname();
			if ($u->getTrainer() || $u->getAdmin()){
				$name = $u->getFirstname();
			}

			$h = new \Templates\Html\Tag("h2", $name);
			$anchor->append($h);

			//State
			$state = new \Templates\Html\Tag("div",'', 'state');
			$state->append( $f->getCreated()->format('d.m.Y') );
			$anchor->append($state);

			//Controls
			$controls = new \Templates\Html\Tag("div",'', 'controls');
			$anchor->append($controls);

			if ($this->type == "incoming"){

				$invite = new \Templates\Html\Tag('div', '');
				$controls->append($invite);

				$accept = new \Templates\Myipt\Iconanchor($this->view->url(array('action'=>'friendships', 'method' => 'accept', 'id' => $f->getId())), "big check green");
				$invite->append($accept);


				$remove = new \Templates\Myipt\Iconanchor($this->view->url(array('action'=>'friendships', 'method' => 'accept', 'id' => $f->getId())), "big remove red");
				$invite->append($remove);

			} else {
				$invite = new \Templates\Html\Tag('div', '');
				$controls->append($invite);

				$remove = new \Templates\Myipt\Iconanchor($this->view->url(array('action'=>'friendships', 'method' => 'remove', 'id' => $f->getId())), "big remove red");
				$invite->append($remove);
			}






		}

		return parent::toString();
	}

}
