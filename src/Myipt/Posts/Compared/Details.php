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

	/**
	 * Speichert die Rohdaten
	 * @var array
	 */
	protected $rawData = array();

	/**
	 * Konstruktor
	 *
	 * @param int       $id
	 * @param array     $data
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

		$this->generate();

		$this->addTimeframe();
		$this->addDifference();
		$this->createChartRel();
		$this->createChartAbs();
	}

	/**
	 * Erstellt Verlaufsgraphen
	 *
	 * @return void
	 */
	protected function generate()
	{
		//Startwerte
		$startRel = null;
		$startAbs = null;

		//Endwerte
		$endRel = $startRel;
		$endAbs = $startAbs;

		//Array für die Plot Daten
		$absArray = array();
		$relArray = array();

		//Vordefinierter Vergleichswert, da nur Werteänderungen dargestellt werden sollen
		$lastRel = -99999999;
		$lastAbs = -99999999;

		$counter = count($this->rawData) - 1;

		foreach ($this->rawData as $index => $a)
		{
			//nur Werte deren Z-Index > 0 hinzufügen
			if ($a["zindex"] > 0)
			{
				//Ersten gültigen Wert übernehmen
				if ($startRel == null)
				{
					$startRel = $a['rel'];
					$startAbs = $a['abs'];

					$endRel = $startRel;
					$endAbs = $startAbs;
				}

				$created = new \DateTime($a['datum']);
				//Datumsformat für Highcharts
				$datum = '['.$created->format('Y').','.($created->format('n')-1).','.$created->format('j').']';

				if ((($lastRel != $a['rel']) || $index == $counter))
				{
					$relArray[] = sprintf("[%s,%s]", $datum, $a['rel']);
					$lastRel = $a['rel'];
				}

				if (($lastAbs != $a['abs']) || $index == $counter)
				{
					$absArray[] = sprintf("[%s,%s]", $datum, $a['abs']);
					$lastAbs = $a['abs'];
				}

				//Letzten Wert übernehmen
				$endRel = $a['rel'];
				$endAbs = $a['abs'];

				$this->viewType = $a['view'];
				$this->unit = $a['unit'];
			}

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
	 *
	 * @return void
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
	 *
	 * @return void
	 */
	protected function addDifference()
	{
		if ($this->viewType == 0 || $this->viewType == 2)
		{
			$this->addDiffRel();
		}


		if ($this->viewType > 0)
		{
			$this->addDiffAbs();
		}

	}

	/**
	 * Rel Box
	 *
	 * @return void
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

		$this->addKacheln($class, $this->startRel, $this->endRel, $this->diffRel, "%");
	}

	/**
	 * Abs Box
	 *
	 * @return void
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

		$this->addKacheln($class, $this->startAbs, $this->endAbs, $this->diffRel, $this->unit);
	}

	/**
	 * Erstellt die Kacheln
	 *
	 * @param string $class
	 * @param string $start
	 * @param string $ende
	 * @param string $diff
	 * @param string $unit
	 *
	 * @return void
	 */
	private function addKacheln($class, $start, $ende, $diff, $unit = null)
	{
		$span = new \Templates\Html\Tag("span", '', $class);
		$span->append(new \Templates\Html\Tag("span", sprintf("%0.1f", $start), 'von'));
		$span->append(new \Templates\Html\Tag("span", sprintf("%0.1f", $ende), 'bis'));

		if ($unit)
		{
			$span->append(new \Templates\Html\Tag("span", $unit, 'unit'));
		}

		$div = new \Templates\Html\Tag("div", $span, 'fromuntil');
		$this->append($div);

		$span = new \Templates\Html\Tag("span", sprintf("Veränderung<br/>%0.1f %s", $diff, $unit));
		$div = new \Templates\Html\Tag("div", $span, 'upToDate');
		$this->append($div);
	}

	/**
	 * Verlauf Rel-Werte
	 *
	 * @return void
	 */
	protected function createChartRel()
	{
		if ($this->viewType == 0 && !empty($this->arrRel))
		{
			$container = $this->createContainer($this->id.'-plot-rel', implode(',', $this->arrRel), '', '');
			$div = new \Templates\Html\Tag("div", $container, 'chartPlot');
			$this->append($div);
		}
	}

	/**
	 * Verlauf Abs-Werte
	 *
	 * @return void
	 */
	protected function createChartAbs()
	{
		if ($this->viewType >= 1 && !empty($this->arrAbs))
		{
			$container = $this->createContainer($this->id.'-plot-abs', '', implode(',', $this->arrAbs), $this->unit);
			$div = new \Templates\Html\Tag("div", $container, 'chartPlot');
			$this->append($div);
		}
	}

	/**
	 * Erstellt den Plot-Container
	 *
	 * @param string $id
	 * @param string $seriesRel
	 * @param string $seriesAbs
	 * @param string $unit
	 *
	 * @return \Templates\Html\Tag
	 */
	protected function createContainer($id, $seriesRel, $seriesAbs, $unit)
	{

		$container = new \Templates\Html\Tag('div', '', 'chart');
		$container->addAttribute('id', $id);
		$container->addAttribute('data-type', "plot");
		$container->addAttribute('data-series-rel', '['.$seriesRel.']');
		$container->addAttribute('data-series-abs', '['.$seriesAbs.']');
		$container->addAttribute('data-abs-title', $unit);
		$container->addAttribute('width', 608);
		$container->addAttribute('height', 384);
		$container->addAttribute('data-plot-background', '#ffffff');
		$container->addAttribute('data-plot-grid', '#dddddd');
		$container->addAttribute('data-plot-container-background', '#f7f7f7');

		return $container;

	}

}