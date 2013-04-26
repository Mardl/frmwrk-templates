<?php

namespace Templates\Myipt\Meal;


class Receipt extends \Templates\Html\Tag
{
	protected $mengen = array();
	protected $nutritions = array();
	protected $isMeal = false;
	protected $meals;

	public function __construct($receipt, $view)
	{
		$this->receipt = $receipt;

		$vars = $receipt->getVariables();

		foreach ($vars as $nuts){
			$nutrition = $nuts->getLink();
			$this->mengen[$nutrition->getId()] = $nuts->getMenge().' '.$nutrition->getEinheit();
			$this->nutritions[$nutrition->getId()] = $nutrition;
		}

		parent::__construct('div', '', 'colFull box meals');
		$this->addAttribute("id", "bigBlock");

		$this->append(new \Templates\Html\Tag('h2', $receipt->getName(), 'headline'));

		$this->initImageBlock();
		$this->initSubstratBlock();
		$this->initDescriptionBlock();

	}

	public function initImageBlock(){
		$imageBlock = new \Templates\Html\Tag('div', '', 'colQuarter fLeft');
		$this->append($imageBlock);
		$imageBlock->append( new \Templates\Html\Tag("span", $this->receipt->getFile()->getThumbnail(204,204,'',''), 'img') );
		$this->controls = new \Templates\Html\Tag('div', '', 'controls');

		$imageBlock->append($this->controls);
		$add = new \Templates\Html\Tag("span",'','icon little add');
		$favorite = new \Templates\Html\Anchor("#", $add);
		$favorite->append("zu Favoriten hinzufügen");
		$this->controls->append($favorite);
	}

	public function initSubstratBlock(){
		$this->substratBlock = new \Templates\Html\Tag('div', '', 'colThird fLeft');
		$this->append($this->substratBlock);

		$this->substratBlock->append(new \Templates\Html\Tag("h3",'Zutaten'));

	}

	public function initDescriptionBlock(){
		$description = new \Templates\Html\Tag('div', '', 'colThird fLeft');
		$this->append($description);

		$description->append(new \Templates\Html\Tag("h3", "Zubereitung, Dauer: ~{$this->receipt->getZubereitungszeit()} min"));

		$description->append(new \Templates\Html\Tag("p", $this->receipt->getDescription()));

	}
	public function setMenge($nutid, $menge){
		$this->mengen[$nutid] = $menge;
	}

	public function setIsMeal($is){
		$this->isMeal = $is;
	}

	public function setMeals(array $meals){
		$this->setIsMeal(true);
		$this->meals = $meals;

		foreach ($meals as $meal){
			$this->mengen[$meal->getNutrition()->getId()] = $meal->getMenge().' '.$meal->getNutrition()->getEinheit();
		}

	}


	public function toString(){

		if ($this->isMeal){
			$remove = new \Templates\Html\Tag("span",'','icon little remove');
			$anchor = new \Templates\Html\Anchor("#", $remove);
			$anchor->append("aus Mahlzeiten entfernen");
			$this->controls->append($anchor);
		}

		$list = new \Templates\Myipt\UnsortedList();
		$this->substratBlock->append($list);

		foreach ($this->mengen as $id => $menge){
			$name = $this->nutritions[$id]->getName();
			if (strlen($name) > 30){
				$name = mb_str($this->nutritions[$id]->getName(), 0, 30, 'UTF-8').' ...';
			}

			$list->append(new \Templates\Html\Tag('span',"<span class='menge'>{$menge}</span> {$name}"));

		}

		$br = new \Templates\Html\Tag("br",'','clear');
		$this->append($br);
		return parent::toString();
	}
}