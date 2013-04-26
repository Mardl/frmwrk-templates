<?php

namespace Templates\Myipt;


class Meal extends \Templates\Html\Tag
{

	protected $content;

	public function __construct($meal, $view)
	{
		if ($meal->getReceipt()){

			$this->content = new \Templates\Myipt\Meal\Receipt($meal->getReceipt(), $view);
			$mealmanager = new \App\Manager\Meals();
			$this->content->setMeals(
				$mealmanager->getMealsByUserAndReceiptAndDatetime(
					$meal->getUser(),
					$meal->getReceipt(),
					$meal->getDatetime()
				)
			);

		} else {

			$this->content = new \Templates\Myipt\Meal\Nutrition($meal->getNutrition(), $view);
			$this->content->setMenge($meal->getMenge());
			$this->content->setIsMeal(true);
		}





	}

	public function toString(){
		return $this->content->toString();
	}

}