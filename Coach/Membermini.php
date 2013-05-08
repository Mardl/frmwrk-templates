<?php

namespace Templates\Coach;

use	Templates\Html\Tag;

class Membermini extends Tag
{
	protected $member = null;

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($member, $url = null)
	{
		parent::__construct('div', '', 'userInfo');
		$this->member = $member;
		#$this->append("Gewählter Benutzer: ".$this->user->getFullname());
	}

	public function toString(){
		//Avatar
		$file = $this->member->getAvatarFile();
		if (!$file){
			$avatar = new \Templates\Html\Image($this->member->getAvatar());
		} else {
			$avatar =  $file->getThumbnail(60,60,'','');
		}
		$span = new \Templates\Html\Tag("span", $avatar, 'img smallimage');
		$this->append($span);

		//Headline
		$h = new \Templates\Html\Tag("h4", $this->member->getFullname());
		$this->append($h);

		return parent::toString();
	}

}
