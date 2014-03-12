<?php

namespace Templates\Myipt\Meal;

/**
 * Class Nutrition
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Meal
 * @author   Alex Jonser <alex@dreiwerken.de>
 */
class Nutrition extends \Templates\Myipt\BigBlock
{

	/**
	 * @var
	 */
	protected $controls;
	/**
	 * @var int
	 */
	protected $menge = 0;
	/**
	 * @var
	 */
	protected $substratBlock;
	/**
	 * @var bool
	 */
	protected $isMeal = false;
	/**
	 * @var string
	 */
	protected $nutrition;
	/**
	 * @var string
	 */
	protected $view;

	/**
	 * @var int
	 */
	protected $mealId = 0;

	/**
	 * @param string $nutrition
	 * @param string $view
	 * @param array  $mealId
	 */
	public function __construct($nutrition, $view, $mealId)
	{
		$this->nutrition = $nutrition;
		$this->menge = $nutrition->getPromenge();
		$this->view = $view;
		$this->mealId = $mealId;

		parent::__construct($nutrition->getName(), 'meals');

		$this->initImageBlock();
		$this->initSubstratBlock();
		$this->initDescriptionBlock();
	}

	/**
	 * @return void
	 */
	public function initImageBlock()
	{
		$imageBlock = new \Templates\Html\Tag('div', '', 'colQuarter fLeft');
		$this->append($imageBlock);
		$imageBlock->append(new \Templates\Html\Tag("span", $this->nutrition->getFile()->getThumbnail(204, 204, '', ''), 'img bigimage'));
		$this->controls = new \Templates\Html\Tag('div', '', 'controls');

		$imageBlock->append($this->controls);
		$add = new \Templates\Html\Tag("span", '', 'icon little add');
		$favorite = new \Templates\Html\Anchor("#", $add);
		$favorite->append("zu Favoriten hinzufügen");
		$this->controls->append($favorite);
	}

	/**
	 * @return void
	 */
	public function initSubstratBlock()
	{
		$this->substratBlock = new \Templates\Html\Tag('div', '', 'colQuarter fLeft');
		$this->append($this->substratBlock);

		$this->substratBlock->append(new \Templates\Html\Tag("h3", 'Nährwertangaben'));
	}

	/**
	 * @return void
	 */
	public function initDescriptionBlock()
	{
		$description = new \Templates\Html\Tag('div', '', 'colHalf fLeft');
		$this->append($description);

		$description->append(new \Templates\Html\Tag("h3", 'Beschreibung'));
		$description->append(new \Templates\Html\Tag("p", $this->nutrition->getDescription()));
	}

	/**
	 * @param string $menge
	 * @return void
	 */
	public function setMenge($menge)
	{
		$this->menge = $menge;
	}

	/**
	 * @param bool $is
	 * @return void
	 */
	public function setIsMeal($is)
	{
		$this->isMeal = $is;
	}

	/**
	 * @param float   $wert
	 * @param int     $anz
	 * @return float
	 */
	private function roundNaerwerte($wert, $anz=2)
	{
		$roundedWert = round($wert, $anz);
		return $roundedWert;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		if ($this->isMeal)
		{
			$remove = new \Templates\Html\Tag("span", '', 'icon little remove');
			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'remove',  'format' => 'json', 'id' => 'nut_'.$this->mealId, 'date' => date('Y-m-d'), 'type' => 'meal')), $remove);
			$anchor->addClass('get-ajax');
			$anchor->append("aus Mahlzeiten entfernen");
			$this->controls->append($anchor);
		}

		if (!$this->isMeal)
		{
			$food = new \Templates\Html\Tag("span", '', 'icon little food');
			$addfood = new \Templates\Html\Anchor(
				$this->view->url(array("action"=>"add", "id"=>$this->nutrition->getId())),
				$food,
				"fancybox fancybox.ajax"
			);
			$addfood->append("zu Mahlzeiten hinzufügen");
			$this->controls->append($addfood);
		}

		$kcal 			= $this->nutrition->getKcal();
		$kj 			= $this->nutrition->getKj();
		$kohlenhydrate 	= $this->nutrition->getKohlenhydrate();
		$gfette 		= $this->nutrition->getGfette();
		$ufette 		= $this->nutrition->getUfette();
		$eiweiss 		= $this->nutrition->getEiweiss();
		$ballaststoffe 	= $this->nutrition->getBallaststoffe();
		$alkohol 		= $this->nutrition->getAlkohol();
		$wasser 		= $this->nutrition->getWasser();
		$cholesterin 	= $this->nutrition->getCholesterin();
		$natrium 		= $this->nutrition->getNatrium();
		$kalium 		= $this->nutrition->getKalium();
		$calcium 		= $this->nutrition->getCalcium();
		$phosphor		= $this->nutrition->getPhosphor();
		$magnesium 		= $this->nutrition->getMagnesium();
		$eisen 			= $this->nutrition->getEisen();
		$vitaminA 		= $this->nutrition->getVitaminA();
		$vitaminE 		= $this->nutrition->getVitaminE();
		$vitaminB1 		= $this->nutrition->getVitaminB1();
		$vitaminB2		= $this->nutrition->getVitaminB2();
		$niacin 		= $this->nutrition->getNiacin();
		$vitaminB6 		= $this->nutrition->getVitaminB6();
		$vitaminC 		= $this->nutrition->getVitaminC();
		$orgsaeure 		= $this->nutrition->getOrgsaeure();

		if ($this->menge != $this->nutrition->getPromenge())
		{
			$kcal 			= $kcal * $this->menge / $this->nutrition->getPromenge();
			$kj 			= $kj * $this->menge / $this->nutrition->getPromenge();
			$kohlenhydrate 	= $kohlenhydrate * $this->menge / $this->nutrition->getPromenge();
			$gfette 		= $gfette * $this->menge / $this->nutrition->getPromenge();
			$ufette 		= $ufette * $this->menge / $this->nutrition->getPromenge();
			$eiweiss 		= $eiweiss * $this->menge / $this->nutrition->getPromenge();
			$ballaststoffe 	= $ballaststoffe * $this->menge / $this->nutrition->getPromenge();
			$alkohol 		= $alkohol * $this->menge / $this->nutrition->getPromenge();
			$wasser 		= $wasser * $this->menge / $this->nutrition->getPromenge();
			$cholesterin 	= $cholesterin * $this->menge / $this->nutrition->getPromenge();
			$natrium 		= $natrium * $this->menge / $this->nutrition->getPromenge();
			$kalium 		= $kalium * $this->menge / $this->nutrition->getPromenge();
			$calcium 		= $calcium * $this->menge / $this->nutrition->getPromenge();
			$phosphor		= $phosphor * $this->menge / $this->nutrition->getPromenge();
			$magnesium 		= $magnesium * $this->menge / $this->nutrition->getPromenge();
			$eisen 			= $eisen * $this->menge / $this->nutrition->getPromenge();
			$vitaminA 		= $vitaminA * $this->menge / $this->nutrition->getPromenge();
			$vitaminE 		= $vitaminE * $this->menge / $this->nutrition->getPromenge();
			$vitaminB1 		= $vitaminB1 * $this->menge / $this->nutrition->getPromenge();
			$vitaminB2		= $vitaminB2 * $this->menge / $this->nutrition->getPromenge();
			$niacin 		= $niacin * $this->menge / $this->nutrition->getPromenge();
			$vitaminB6 		= $vitaminB6 * $this->menge / $this->nutrition->getPromenge();
			$vitaminC 		= $vitaminC * $this->menge / $this->nutrition->getPromenge();
			$orgsaeure 		= $orgsaeure * $this->menge / $this->nutrition->getPromenge();
		}

		$list = new \Templates\Myipt\UnsortedList();
		$this->substratBlock->append($list);

		$list->append(new \Templates\Html\Tag('span', "Menge <span>".$this->menge.' '. $this->nutrition->getEinheit()."</span>"));

		if ($kcal > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Kcal <span>".$this->roundNaerwerte($kcal, 0)."</span>"));
		}

		if ($kj > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "KJoule <span>".$this->roundNaerwerte($kj)."</span>"));
		}

		if ($kohlenhydrate > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Kohlenhydrate <span>".$this->roundNaerwerte($kohlenhydrate)."</span>"));
		}

		if ($gfette > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Fett <span>".$this->roundNaerwerte($gfette)."</span>"));
		}


		if ($ufette > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "ungesättigte Fette <span>".$this->roundNaerwerte($ufette)."</span>"));
		}

		if ($eiweiss > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Protein <span>".$this->roundNaerwerte($eiweiss)."</span>"));
		}

		if ($ballaststoffe > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Ballaststoffe <span>".$this->roundNaerwerte($ballaststoffe)."</span>"));
		}

		if ($alkohol > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Alkohol <span>".$this->roundNaerwerte($alkohol)."</span>"));
		}

		if ($wasser > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Wasser <span>".$this->roundNaerwerte($wasser)."</span>"));
		}

		if ($cholesterin > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Cholesterin <span>".$this->roundNaerwerte($cholesterin)."</span>"));
		}

		if ($natrium > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Natrium <span>".$this->roundNaerwerte($kohlenhydrate)."</span>"));
		}

		if ($kalium > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Kalium <span>".$this->roundNaerwerte($kalium)."</span>"));
		}

		if ($calcium > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Calcium <span>".$this->roundNaerwerte($calcium)."</span>"));
		}

		if ($phosphor > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Phosphor <span>".$this->roundNaerwerte($phosphor)."</span>"));
		}

		if ($magnesium > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Magnesium <span>".$this->roundNaerwerte($magnesium)."</span>"));
		}

		if ($eisen > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Eisen <span>".$this->roundNaerwerte($eisen)."</span>"));
		}

		if ($niacin > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Niacin <span>".$this->roundNaerwerte($niacin)."</span>"));
		}

		if ($vitaminA > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Vitamin A <span>".$this->roundNaerwerte($vitaminA)."</span>"));
		}

		if ($vitaminB1 > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Vitamin B1 <span>".$this->roundNaerwerte($vitaminB1)."</span>"));
		}

		if ($vitaminB2 > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Vitamin B2 <span>".$this->roundNaerwerte($vitaminB2)."</span>"));
		}

		if ($vitaminB6 > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Vitamin B6 <span>".$this->roundNaerwerte($vitaminB6)."</span>"));
		}

		if ($vitaminC > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Vitamin C <span>".$this->roundNaerwerte($vitaminC)."</span>"));
		}

		if ($vitaminE > 0)
		{
			$list->append(new \Templates\Html\Tag('span', "Vitamin E <span>".$this->roundNaerwerte($vitaminE)."</span>"));
		}


		$br = new \Templates\Html\Tag("br", '', 'clear');
		$this->append($br);
		return parent::toString();
	}

}