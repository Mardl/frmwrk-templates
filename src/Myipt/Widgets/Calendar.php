<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Calendar
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Calendar extends \Templates\Myipt\Widget
{

	/**
	 * @var
	 */
	protected $calendar;

	/**
	 * @var \DateTime
	 */
	protected $today;

	/**
	 * @var
	 */
	protected $lastday;

	/**
	 * @var
	 */
	protected $first;

	/**
	 * @var
	 */
	protected $last;

	/**
	 * @param string $headerText
	 * @param array  $value
	 * @param bool   $style2
	 * @param array  $classOrAttributes
	 * @param bool   $showhidden
	 * @return void
	 */
	public function __construct($view, $startDate = null)
	{
		parent::__construct("Kalender", '', "colHalf calendar");

		$this->setView($view);

		$this->today = new \DateTime();

		if (!is_null($startDate))
		{
			if (!($startDate instanceof \DateTime))
			{
				$startDate = new \DateTime($startDate);
			}
			$this->today = $startDate;
		}

		$this->initDays();
	}

	/**
	 * @param \DateTime $date
	 * @param int       $count
	 * @return void
	 */
	public function setTerminCount(\DateTime $date, $count)
	{
		$this->calendar[$date->format("W")][$date->format("d")] = $count;
	}

	/**
	 * @return void
	 */
	private function initDays()
	{
		$today = $this->today;
		$first = new \DateTime($today->format("Y-m-1"));
		$this->first = $first;
		$last = clone($today);

		/**
		 * wenn man sich im januar befindet und der tag >= dem 29. ist, darf man nicht einen monat
		 * hinzufügen, weil sonst PHP in den März springt. Daher Workaround mit 10 Tagen
		 */
		if ($last->format('n') == 1 && $last->format('j') > 28){
			$last->add(new \DateInterval("P10D"));
		} else {
			$last->add(new \DateInterval("P1M"));
		}
		$last->setDate($last->format("Y"), $last->format("m"), 1);
		$last->setTime(0, 0, 0);
		$last->sub(new \DateInterval("P0DT1S"));
		$this->lastday = $last->format('j');
		$this->last = $last;

		$cal = array();
		$temp = clone($first);
		//Zuerst die Wochen aufbauen
		for ($w = $first->format("W"); $w <= $last->format("W"); $w++)
		{
			$cal[sprintf("%02d", $w)] = array();
		}

		//dann die Tage in die entsprechende Woche schieben
		for ($d = $temp->format("j"); $d <= $last->format("j"); $d++)
		{
			$cal[$temp->format("W")][($temp->format("N") - 1)] = $temp->format("d");
			$temp->add(new \DateInterval("P1D"));
		}

		if (count($cal[$first->format("W")]) < 7)
		{
			$temp = clone($first);
			$diff = 7 - count($cal[$first->format("W")]);

			$temp->sub(new \DateInterval("P{$diff}D"));

			for ($i = 0; $i < $diff; $i++)
			{
				$cal[$first->format("W")][$i] = $temp->format("d");
				$temp->add(new \DateInterval("P1D"));
			}

			ksort($cal[$first->format("W")]);
		}

		if (count($cal[$last->format("W")]) < 7)
		{
			$temp = clone($last);
			$diff = 7 - count($cal[$last->format("W")]);
			$temp->add(new \DateInterval("P1D"));

			for ($i = $last->format("N"); $i < 7; $i++){
				$cal[$last->format("W")][$i] = $temp->format("d");
				$temp->add(new \DateInterval("P1D"));
			}

			ksort($cal[$last->format("W")]);
		}

		foreach ($cal as $nr => $week)
		{
			$cal[$nr] = array_flip($week);
			$cal[$nr] = array_map(function($el){return 0;}, $cal[$nr]);
		}

		$this->calendar = $cal;
	}

	/**
	 * @return mixed
	 */
	public function firstDayOfMonth()
	{
		return $this->first;
	}

	/**
	 * @return mixed
	 */
	public function lastDayOfMonth()
	{
		return $this->last;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		$currentCount = 0;
		$head = new \Templates\Html\Tag("h2");
		$this->append($head);
		$head->append(new \Templates\Myipt\Iconanchor("#", "prev"));
		$head->append($this->today->format("M"));
		$head->append(new \Templates\Myipt\Iconanchor("#", "next", null, "fRight"));


		$list = new \Templates\Myipt\UnsortedList();
		$this->append($list);

		$counter = 1;
		$count = count($this->calendar);
		$class = 'inactive';

		$weeklist = new \Templates\Myipt\UnsortedList('', array(), 'week');
		$list->append($weeklist, 'header');
		$weeklist->append("Mo");
		$weeklist->append("Di");
		$weeklist->append("Mi");
		$weeklist->append("Do");
		$weeklist->append("Fr");
		$weeklist->append("Sa");
		$weeklist->append("So");

		foreach($this->calendar as $wnr => $week)
		{

			$weeklist = new \Templates\Myipt\UnsortedList('', array(), 'week');
			$list->append($weeklist);

			foreach ($week as $day => $c)
			{
				if (intval($day) == 1 && $class == "inactive")
				{
					$class = "active";
				}
				else if (intval($day) == 1 && $class == "active")
				{
					$class = "inactive";
				}

				$temp = $class;

				if ($c > 0)
				{
					$temp .= ' available';
				}

				if ($currentCount == 0 && intval($day) == intval($this->today->format("j")))
				{
					$temp .= ' current';
					$currentCount++;
				}

				$anchor = new \Templates\Html\Anchor("#", $day);
				$anchor->addAttribute("data-rel", "{$wnr}-{$day}");
				$weeklist->append($anchor, $temp);
			}

			$counter++;
		}



		return parent::toString();
	}
}
