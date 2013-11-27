<?php

namespace Templates\Myipt\Meallist;

/**
 * Class Receipt
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Meallist
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Receipt extends \Templates\Myipt\Meallist
{

	/**
	 * @param string $receipts
	 * @param array  $view
	 * @param array  $cat
	 * @param        $searchphrase
	 */
	public function __construct($receipts, $view, $cat, $searchphrase)
	{
		parent::__construct("Rezepte", array('fett','kh','kcal','Dauer'), $receipts, $view, $cat, $searchphrase);

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

			$info =  new \Templates\Html\Tag("div", '0', 'info');
			$info->append(new \Templates\Html\Tag("span", $meal->getFile()->getThumbnail(96, 96, '', ''), 'img'));

			$div->append($info);
			$controls = new \Templates\Html\Tag("div", '', 'controls');
			$dauer =  new \Templates\Html\Tag("div", '0', 'substrat');
			$fett =  new \Templates\Html\Tag("div", '0', 'substrat');
			$kh =  new \Templates\Html\Tag("div", '0', 'substrat');
			$kcal =  new \Templates\Html\Tag("div", '0', 'substrat');
			$div->append($fett);
			$div->append($kh);
			$div->append($kcal);
			$div->append($dauer);

			$desc = $meal->getDescription();
			if (strlen($desc) > 200)
			{
				$desc = mb_substr($desc, 0, 200, 'UTF-8').' ...';
			}

			$info->append(new \Templates\Html\Tag("h4", $meal->getName()));
			$info->append(new \Templates\Html\Tag("p", $desc.'&nbsp;'));
			$kcal->append('0 g');
			$kh->append('0 g');
			$fett->append('0 g');
			$dauer->append("~ {$meal->getZubereitungszeit()} min");

			$info->append($controls);
			$infoButton = new \Templates\Html\Tag("span",'','icon little info');
			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'details', 'format' => 'json', 'id' => $meal->getId())), $infoButton);
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