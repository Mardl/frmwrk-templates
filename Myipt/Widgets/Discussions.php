<?php

namespace Templates\Myipt\Widgets;


class Discussions extends \Templates\Myipt\Widget
{

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($view, $messages, $active = null, $moreUrl = null, $classOrAttributes = 'colThird fLeft flow')
	{
		parent::__construct('Nachrichten', null, $classOrAttributes);
		$this->setView($view);

		if (!is_null($moreUrl)){
			$this->setMoreLink($moreUrl, "alle Nachrichten >");
		}


		$list = new \Templates\Html\Tag("div", array(), "messages");
		$this->append($list);

		if (!empty($messages)){
			foreach ($messages as $m){
				$class = '';

				if (!$m->isRead($this->view->login)){
					$class = 'unread';
				}

				if ($active == $m->getId()){
					$class .= ' active';
				}

				$wrapper = new \Templates\Html\Tag("div",'','item '.$class);
				$anchor = new \Templates\Html\Anchor(
					$this->view->url(array("id"=>$m->getId()), "nachrichten"),
					''
				);
				$wrapper->append($anchor);

				$participant = $m->getParticipant($this->view->login);
				$file = $participant->getAvatarFile();

				$name =  $participant->getFullname();
				if ($participant->getTrainer() || $participant->getAdmin()){
					$name = $participant->getFirstname();
				}

				if (!$file){
					$avatar = new \Templates\Html\Image($participant->getAvatar(45,45), $name, $name);
				} else {
					$avatar = $file->getThumbnail(45,45,'','', null, true);
					$avatar->addAttribute("title", $name);
				}
				$image = new \Templates\Html\Tag("span", $avatar, 'img smallimage');

				$imgWrapper = new \Templates\Html\Tag("div", $image, 'imageWrapper fLeft');
				$anchor->append($imgWrapper);

				$cWrapper = new \Templates\Html\Tag("div", '', 'contentWrapper');
				$anchor->append($cWrapper);
				$cWrapper->append(new \Templates\Html\Tag("span", $m->getModified()->format("Y-m-d H:i"), "littlefont column"));
				$cWrapper->append(new \Templates\Html\Tag("span", $participant->getUsername(), "littlefont fLeft"));
				$cWrapper->append("<br/>");
				$cWrapper->append(sebr($m->getSubject()));

				$list->append($wrapper, $class);
			}
		} else {
			$list->append(new \Templates\Html\Tag("div",new \Templates\Html\Tag("div", "Noch keine Nachrichten vorhanden", 'contentWrapper'),'item noBorder'));
		}





	}

}
