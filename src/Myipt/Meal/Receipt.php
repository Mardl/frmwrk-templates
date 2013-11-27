<?php

namespace Templates\Myipt\Meal;

/**
 * Class Receipt
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Meal
 * @author   Alex Jonser <alex@dreiwerken.de>
 */
class Receipt extends \Templates\Html\Tag
{

	/**
	 * @var array
	 */
	protected $mengen = array();
	/**
	 * @var array
	 */
	protected $nutritions = array();
	/**
	 * @var bool
	 */
	protected $isMeal = false;
	/**
	 * @var
	 */
	protected $meals;
	/**
	 * @var string
	 */
	protected $view;

	/**
	 * @var int
	 */
	protected $mealId = 0;

	/**
	 * @param string $receipt
	 * @param string $view
	 * @param array  $mealId
	 */
	public function __construct($receipt, $view, $mealId)
	{
		$this->receipt = $receipt;
		$this->view = $view;
		$vars = $receipt->getVariables();
		$this->mealId = $mealId;

		foreach ($vars as $nuts)
		{
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

	/**
	 * @return void
	 */
	public function initImageBlock()
	{
		$imageBlock = new \Templates\Html\Tag('div', '', 'colQuarter fLeft');
		$this->append($imageBlock);
		$imageBlock->append(new \Templates\Html\Tag("span", $this->receipt->getFile()->getThumbnail(204, 204, '', ''), 'img bigimage'));
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
		$this->substratBlock = new \Templates\Html\Tag('div', '', 'colThird fLeft');
		$this->append($this->substratBlock);

		$this->substratBlock->append(new \Templates\Html\Tag("h3", 'Zutaten'));

	}

	/**
	 * @return void
	 */
	public function initDescriptionBlock()
	{
		$description = new \Templates\Html\Tag('div', '', 'colThird fLeft');
		$this->append($description);

		$description->append(new \Templates\Html\Tag("h3", "Zubereitung, Dauer: ~{$this->receipt->getZubereitungszeit()} min"));

		$description->append(new \Templates\Html\Tag("p", $this->receipt->getDescription()));

	}

	/**
	 * @param int   $nutid
	 * @param float $menge
	 * @return void
	 */
	public function setMenge($nutid, $menge)
	{
		$this->mengen[$nutid] = $menge;
	}

	/**
	 * @param int $is
	 * @return void
	 */
	public function setIsMeal($is)
	{
		$this->isMeal = $is;
	}

	/**
	 * @param array $meals
	 * @return void
	 */
	public function setMeals(array $meals)
	{
		$this->setIsMeal(true);
		$this->meals = $meals;

		foreach ($meals as $meal)
		{
			$this->mengen[$meal->getNutrition()->getId()] = $meal->getMenge().' '.$meal->getNutrition()->getEinheit();
		}

	}


	/**
	 * @return string
	 */
	public function toString()
	{
		if ($this->isMeal)
		{
			$remove = new \Templates\Html\Tag("span", '', 'icon little remove');

			$anchor = new \Templates\Html\Anchor($this->view->url(array('action'=>'remove', 'format' => 'json', 'id' => 'rec_'.$this->receipt->getId(), 'date' => date('Y-m-d'), 'type' => 'meal')), $remove);
			$anchor->addClass('get-ajax');
			$anchor->append("aus Mahlzeiten entfernen");
			$this->controls->append($anchor);
		}

		if (!$this->isMeal)
		{
			$food = new \Templates\Html\Tag("span", '', 'icon little food');
			$addfood = new \Templates\Html\Anchor(
				$this->view->url(array("action"=>"add", "id"=>$this->receipt->getId())),
				$food,
				"fancybox fancybox.ajax"
			);
			$addfood->append("zu Mahlzeiten hinzufügen");
			$this->controls->append($addfood);
		}

		$list = new \Templates\Myipt\UnsortedList();
		$this->substratBlock->append($list);

		foreach ($this->mengen as $id => $menge)
		{
			$name = $this->nutritions[$id]->getName();
			if (strlen($name) > 30)
			{
				$name = mb_substr($this->nutritions[$id]->getName(), 0, 30, 'UTF-8').' ...';
			}

			$list->append(new \Templates\Html\Tag('span', "<span class='menge'>{$menge}</span> {$name}"));

		}

		$br = new \Templates\Html\Tag("br", '', 'clear');
		$this->append($br);
		return parent::toString();
	}
}