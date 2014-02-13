<?php

namespace Templates\Myipt\Posts\Compared;

/**
 * Class Headline
 *
 * Liefert die Headline für die PostsListen
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Details extends \Templates\Html\Tag
{

	protected $rawData = array();

	/**
	 * Konstruktor
	 *
	 * @param int $id
	 * @param array $data
	 * @param \DateTime $von
	 * @param \DateTime $bis
	 */
	public function __construct($id, array $data, \DateTime $von, \DateTime $bis)
	{
		parent::__construct('div', '', 'details');
		$this->rawData = $data;
		$this->von = $von;
		$this->bis = $bis;
		$this->id = $id;

		$this->viewType = $this->rawData[0]['view'];
		$this->unit = $this->rawData[0]['unit'];

		$this->generate();

		$this->addTimeframe();
		$this->addDifference();
		$this->createChartRel();
		$this->createChartAbs();
	}

	/**
	 * Erstellt Verlaufsgraphen
	 */
	protected function generate()
	{

		$startRel = $this->rawData[0]['rel'];
		$startAbs = $this->rawData[0]['abs'];

		$absArray = array();
		$relArray = array();

		$lastRel = -99999999;
		$lastAbs = -99999999;

		$counter = count($this->rawData) - 1;

		foreach ($this->rawData as $index => $a)
		{
			$created = new \DateTime($a['datum']);
			$datum = '['.$created->format('Y').','.($created->format('n')-1).','.$created->format('j').']';

			if (($lastRel != $a['rel']) || $index == $counter)
			{
				$relArray[] = '['.$datum.','.$a['rel'].']';
				$lastrel = $a['rel'];
			}

			if (($lastAbs != $a['abs']) || $index == $counter)
			{
				$absArray[] = '['.$datum.','.$a['abs'].']';
				$lastAbs = $a['abs'];
			}

			$endRel = $a['rel'];
			$endAbs = $a['abs'];
		}

		/**
		 * Start- und Endwert Rel
		 **/
		$this->startRel = $startRel;
		$this->endRel = $endRel;

		/**
		 * Start- und Endwert Abs
		 **/
		$this->startAbs = $startAbs;
		$this->endAbs = $endAbs;

		/**
		 * Differenz Rel / Abs
		 **/
		$this->diffRel = $endRel - $startRel;
		$this->diffAbs = $endAbs - $startAbs;

		/**
		 * Verlaufsdaten Rel / Abs
		 **/
		$this->arrRel = $relArray;
		$this->arrAbs = $absArray;

	}

	/**
	 * Box für Vergleichszeitraum
	 */
	protected function addTimeframe()
	{

		$diffDuration = round(($this->bis->getTimestamp() - $this->von->getTimestamp()) / 604800, 0, PHP_ROUND_HALF_DOWN);
		$diffDurationType = 0;
		$durationText = sprintf("%d Woche(n)", $diffDuration);

		if ($diffDuration > 8)
		{
			$diffDuration = round(($diffDuration / 4), 0, PHP_ROUND_HALF_DOWN);
			$diffDurationType = 1;
			$durationText = sprintf("%d Monat(e)", $diffDuration);
			if ($diffDuration > 18)
			{
				$diffDuration = round(($diffDuration / 12), 1, PHP_ROUND_HALF_DOWN);
				$diffDurationType = 2;
				$durationText = sprintf("%d Jahr(e)", $diffDuration);
			}
		}

		$span = new \Templates\Html\Tag("span", "Zeitraum<br/>".$durationText.'<br/>');
		$div = new \Templates\Html\Tag("div", $span, 'upToDate');
		$this->append($div);

	}

	/**
	 * Boxen mit den Vergleichsdaten (Start / Ende)
	 */
	protected function addDifference()
	{
		if ($this->viewType == 0 || $this->viewType == 2)
		{
			$this->addDiffRel();
		}


		if ($this->viewType == 1 || $this->viewType == 2)
		{
			$this->addDiffAbs();
		}

	}

	/**
	 * Rel Box
	 */
	private function addDiffRel()
	{
		$class = "compareB none";
		if ($this->diffRel < 0)
		{
			$class = "compareB down";
		}
		else if ($this->diffRel > 0)
		{
			$class = "compareB up";
		}

		$span = new \Templates\Html\Tag("span", '', $class);
		$span->append(new \Templates\Html\Tag("span", sprintf("%0.1f %%", $this->startRel), 'von'));
		$span->append(new \Templates\Html\Tag("span", sprintf("%0.1f %%", $this->endRel), 'bis'));

		$div = new \Templates\Html\Tag("div", $span, 'fromuntil');
		$this->append($div);

		/*
		 $span = new \Templates\Html\Tag("span", sprintf("Difference<br/>%0.1f %%", $this->diffRel));
		$div = new \Templates\Html\Tag("div", $span, 'upToDate');
		$this->append($div);
		*/
	}

	/**
	 * Abs Box
	 */
	private function addDiffAbs()
	{
		$class = "compareB none";
		if ($this->diffAbs < 0)
		{
			$class = "compareB down";
		}
		else if ($this->diffAbs > 0)
		{
			$class = "compareB up";
		}

		$span = new \Templates\Html\Tag("span", '', $class);
		$span->append(new \Templates\Html\Tag("span", sprintf("%0.1f", $this->startAbs), 'von'));
		$span->append(new \Templates\Html\Tag("span", sprintf("%0.1f", $this->endAbs), 'bis'));
		$span->append(new \Templates\Html\Tag("span", $this->unit, 'unit'));

		$div = new \Templates\Html\Tag("div", $span, 'fromuntil');
		$this->append($div);

		/*
		 $span = new \Templates\Html\Tag("span", sprintf("Difference<br/>%0.1f %s", $this->diffAbs, $this->unit));
		$div = new \Templates\Html\Tag("div", $span, 'upToDate');
		$this->append($div);
		*/
	}

	/**
	 * Verlauf Rel-Werte
	 */
	protected function createChartRel()
	{
		if ($this->viewType == 0 || $this->viewType == 2)
		{
			$container = new \Templates\Html\Tag('div', '', 'chart');

			$container->addAttribute('id', $this->id.'-plot-rel');
			$container->addAttribute('data-type', "plot");
			$container->addAttribute('data-series-rel', '['.implode(',', $this->arrRel).']');
			$container->addAttribute('data-series-abs', '[]');
			$container->addAttribute('data-abs-title', "");

			$container->addAttribute('width', 588);
			$container->addAttribute('height', 384);

			$div = new \Templates\Html\Tag("div", $container, 'chartPlot');
			$this->append($div);
		}
	}

	/**
	 * Verlauf Abs-Werte
	 */
	protected function createChartAbs()
	{
		if ($this->viewType == 1 || $this->viewType == 2)
		{
			$container = new \Templates\Html\Tag('div', '', 'chart');

			$container->addAttribute('id', $this->id.'-plot-abs');
			$container->addAttribute('data-type', "plot");
			$container->addAttribute('data-series-rel', '[]');
			$container->addAttribute('data-series-abs', '['.implode(',', $this->arrAbs).']');
			$container->addAttribute('data-abs-title', $this->unit);

			$container->addAttribute('width', 588);
			$container->addAttribute('height', 384);

			$div = new \Templates\Html\Tag("div", $container, 'chartPlot');
			$this->append($div);
		}
	}

}