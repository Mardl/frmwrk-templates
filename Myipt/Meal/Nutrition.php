<?php

namespace Templates\Myipt\Meal;


class Nutrition extends \Templates\Html\Tag
{

	protected $controls;
	protected $menge = 0;
	protected $substratBlock;
	protected $isMeal = false;
	protected $nutrition;
	protected $view;

	public function __construct($nutrition, $view)
	{
		$this->nutrition = $nutrition;
		$this->menge = $nutrition->getPromenge();
		$this->view = $view;

		parent::__construct('div', '', 'colFull box meals');
		$this->addAttribute("id", "bigBlock");

		$this->append(new \Templates\Html\Tag('h2', $nutrition->getName(), 'headline'));

		$this->initImageBlock();
		$this->initSubstratBlock();
		$this->initDescriptionBlock();

	}

	public function initImageBlock(){
		$imageBlock = new \Templates\Html\Tag('div', '', 'colQuarter fLeft');
		$this->append($imageBlock);
		$imageBlock->append( new \Templates\Html\Tag("span", $this->nutrition->getFile()->getThumbnail(204,204,'',''), 'img') );
		$this->controls = new \Templates\Html\Tag('div', '', 'controls');

		$imageBlock->append($this->controls);
		$add = new \Templates\Html\Tag("span",'','icon little add');
		$favorite = new \Templates\Html\Anchor("#", $add);
		$favorite->append("zu Favoriten hinzufügen");
		$this->controls->append($favorite);



	}

	public function initSubstratBlock(){
		$this->substratBlock = new \Templates\Html\Tag('div', '', 'colQuarter fLeft');
		$this->append($this->substratBlock);

		$this->substratBlock->append(new \Templates\Html\Tag("h3",'Nährwertangaben'));

	}

	public function initDescriptionBlock(){
		$description = new \Templates\Html\Tag('div', '', 'colHalf fLeft');
		$this->append($description);

		$description->append(new \Templates\Html\Tag("h3", 'Beschreibung'));

		$description->append(new \Templates\Html\Tag("p", $this->nutrition->getDescription()));

	}



	public function setMenge($menge){
		$this->menge = $menge;
	}

	public function setIsMeal($is){
		$this->isMeal = $is;
	}

	public function toString(){

		if ($this->isMeal){
			$remove = new \Templates\Html\Tag("span",'','icon little remove');
			$anchor = new \Templates\Html\Anchor("#", $remove);
			$anchor->append("aus Mahlzeiten entfernen");
			$this->controls->append($anchor);
		}

		if (!$this->isMeal){
			$food = new \Templates\Html\Tag("span",'','icon little food');
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

		if ($this->menge != $this->nutrition->getPromenge()){
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

		$list->append(new \Templates\Html\Tag('span',"Menge <span>".$this->menge.' '. $this->nutrition->getEinheit()."</span>"));

		if ($kcal > 0){
			$list->append(new \Templates\Html\Tag('span',"Kcal <span>".$kcal."</span>"));
		}

		if ($kj > 0){
			$list->append(new \Templates\Html\Tag('span',"KJoule <span>".$kj."</span>"));
		}

		if ($kohlenhydrate > 0){
			$list->append(new \Templates\Html\Tag('span',"Kohlenhydrate <span>".$kohlenhydrate."</span>"));
		}

		if ($gfette > 0){
			$list->append(new \Templates\Html\Tag('span',"Fett <span>".$gfette."</span>"));
		}


		if ($ufette > 0){
			$list->append(new \Templates\Html\Tag('span',"ungesättigte Fette <span>".$ufette."</span>"));
		}

		if ($eiweiss > 0){
			$list->append(new \Templates\Html\Tag('span',"Protein <span>".$eiweiss."</span>"));
		}

		if ($ballaststoffe > 0){
			$list->append(new \Templates\Html\Tag('span',"Ballaststoffe <span>".$ballaststoffe."</span>"));
		}

		if ($alkohol > 0){
			$list->append(new \Templates\Html\Tag('span',"Alkohol <span>".$alkohol."</span>"));
		}

		if ($wasser > 0){
			$list->append(new \Templates\Html\Tag('span',"Wasser <span>".$wasser."</span>"));
		}

		if ($cholesterin > 0){
			$list->append(new \Templates\Html\Tag('span',"Cholesterin <span>".$cholesterin."</span>"));
		}

		if ($natrium > 0){
			$list->append(new \Templates\Html\Tag('span',"Natrium <span>".$kohlenhydrate."</span>"));
		}

		if ($kalium > 0){
			$list->append(new \Templates\Html\Tag('span',"Kalium <span>".$kalium."</span>"));
		}

		if ($calcium > 0){
			$list->append(new \Templates\Html\Tag('span',"Calcium <span>".$calcium."</span>"));
		}

		if ($phosphor > 0){
			$list->append(new \Templates\Html\Tag('span',"Phosphor <span>".$phosphor."</span>"));
		}

		if ($magnesium > 0){
			$list->append(new \Templates\Html\Tag('span',"Magnesium <span>".$magnesium."</span>"));
		}

		if ($eisen > 0){
			$list->append(new \Templates\Html\Tag('span',"Eisen <span>".$eisen."</span>"));
		}

		if ($niacin > 0){
			$list->append(new \Templates\Html\Tag('span',"Niacin <span>".$niacin."</span>"));
		}

		if ($vitaminA > 0){
			$list->append(new \Templates\Html\Tag('span',"Vitamin A <span>".$vitaminA."</span>"));
		}

		if ($vitaminB1 > 0){
			$list->append(new \Templates\Html\Tag('span',"Vitamin B1 <span>".$vitaminB1."</span>"));
		}

		if ($vitaminB2 > 0){
			$list->append(new \Templates\Html\Tag('span',"Vitamin B2 <span>".$vitaminB2."</span>"));
		}

		if ($vitaminB6 > 0){
			$list->append(new \Templates\Html\Tag('span',"Vitamin B6 <span>".$vitaminB6."</span>"));
		}

		if ($vitaminC > 0){
			$list->append(new \Templates\Html\Tag('span',"Vitamin C <span>".$vitaminC."</span>"));
		}

		if ($vitaminE > 0){
			$list->append(new \Templates\Html\Tag('span',"Vitamin E <span>".$vitaminE."</span>"));
		}


		$br = new \Templates\Html\Tag("br",'','clear');
		$this->append($br);
		return parent::toString();
	}

}