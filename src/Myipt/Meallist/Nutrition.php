<?php

namespace Templates\Myipt\Meallist;

/**
 * Class Nutrition
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Meallist
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Nutrition extends \Templates\Myipt\Meallist
{

	/**
	 * @param string $nutritions
	 * @param array  $view
	 * @param array  $cat
	 * @param        $searchphrase
	 */
	public function __construct($nutritions, $view, $cat, $searchphrase)
	{
		parent::__construct("Nahrungsmittel", array('fett','kh','kcal'), $nutritions, $view, $cat, $searchphrase);

		$this->initContent();
	}

	/**
	 * @return void
	 */
	public function initContent()
	{

		foreach ($this->data as $meal){
			$div = new \Templates\Html\Tag("div", '', 'meal');
			$this->content->append($div);

			$info =  new \Templates\Html\Tag("div", '', 'info');
			$info->append(new \Templates\Html\Tag("span", $meal->getFile()->getThumbnail(96, 96, '', ''), 'img'));

			$div->append($info);
			$controls = new \Templates\Html\Tag("div", '', 'controls');
			$fett =  new \Templates\Html\Tag("div", '', 'substrat');
			$kh =  new \Templates\Html\Tag("div", '', 'substrat');
			$kcal =  new \Templates\Html\Tag("div", '', 'substrat');
			$div->append($fett);
			$div->append($kh);
			$div->append($kcal);


			$info->append(new \Templates\Html\Tag("h4", $meal->getName()));
			$info->append(new \Templates\Html\Tag("p", $meal->getDescription().'&nbsp;'));
			$kcal->append(floor($meal->getKcal() + 0.5).'');
			$kh->append(floor($meal->getKohlenhydrate() + 0.5).' g');
			$fett->append(floor($meal->getGfette() + 0.5).' g');


			$info->append($controls);
			$infoButton = new \Templates\Html\Tag("span", '', 'icon little info');
			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'details', 'format' => 'json', 'id' => $meal->getId(), 'category' => $this->category, 'search' => $this->search)), $infoButton);
			$anchor->append("Details");
			$anchor->addClass("get-ajax");
			$controls->append($anchor);

			$food = new \Templates\Html\Tag("span", '', 'icon little food');
			$addfood = new \Templates\Html\Anchor(
				$this->view->url(array("action"=>"add", "id"=>$meal->getId())),
				$food,
				"fancybox fancybox.ajax"
			);
			$addfood->append("zu Mahlzeiten hinzufügen");
			$controls->append($addfood);
		}
	}

}