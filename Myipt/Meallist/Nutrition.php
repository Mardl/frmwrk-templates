<?php

namespace Templates\Myipt\Meallist;


class Nutrition extends \Templates\Myipt\Meallist
{


	public function __construct($nutritions, $view, $cat, $searchphrase)
	{
		parent::__construct("Nahrungsmittel", array('fett','kh','kcal'), $nutritions, $view, $cat, $searchphrase);

		$this->initContent();
	}


	public function initContent(){

		foreach ($this->data as $meal){
			$div = new \Templates\Html\Tag("div", '', 'meal');
			$this->content->append($div);

			$info =  new \Templates\Html\Tag("div", '0', 'info');
			$info->append(new \Templates\Html\Tag("span", $meal->getFile()->getThumbnail(96,96,'',''), 'img'));

			$div->append($info);
			$controls = new \Templates\Html\Tag("div", '', 'controls');
			$fett =  new \Templates\Html\Tag("div", '0', 'substrat');
			$kh =  new \Templates\Html\Tag("div", '0', 'substrat');
			$kcal =  new \Templates\Html\Tag("div", '0', 'substrat');
			$div->append($fett);
			$div->append($kh);
			$div->append($kcal);


			$info->append(new \Templates\Html\Tag("h4", $meal->getName()));
			$info->append(new \Templates\Html\Tag("p", $meal->getDescription().'&nbsp;'));
			$kcal->append(floor($meal->getKcal() + 0.5).'');
			$kh->append(floor($meal->getKohlenhydrate() + 0.5).' g');
			$fett->append(floor($meal->getGfette() + 0.5).' g');


			$info->append($controls);
			$infoButton = new \Templates\Html\Tag("span",'','icon little info');
			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'details', 'id' => $meal->getId(), 'category' => $this->category, 'search' => $this->search)), $infoButton);
			$anchor->append("Details");
			$controls->append($anchor);
			$anchor->addClass("get-ajax");
		}
	}

}