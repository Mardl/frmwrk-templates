<?php

namespace Templates\Myipt;


/**
 * Class Meal
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Alex Jonser <alex@dreiwerken.de>
 */
class Meal extends \Templates\Html\Tag
{

	protected $content;

	/**
	 * @param \App\Models\Meal $meal
	 * @param string           $view
	 */
	public function __construct($meal, $view)
	{
		if ($meal->getReceipt())
		{
			$this->content = new \Templates\Myipt\Meal\Receipt($meal->getReceipt(), $view, $meal->getId());
			$mealmanager = new \App\Manager\Meals();
			$this->content->setMeals(
				$mealmanager->getMealsByUserAndReceiptAndDatetime(
					$meal->getUser(),
					$meal->getReceipt(),
					$meal->getDatetime()
				)
			);
		}
		else
		{

			$this->content = new \Templates\Myipt\Meal\Nutrition($meal->getNutrition(), $view, $meal->getId());
			$this->content->setMenge($meal->getMenge());
			$this->content->setIsMeal(true);
		}
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->content->toString();
	}

}