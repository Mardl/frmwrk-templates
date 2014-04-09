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
	 * @var \DateTime
	 */
	protected $enddatum;

	/**
	 * @var \DateTime
	 */
	protected $startDatum;

	/**
	 * @var \DateTime
	 */
	protected $now;

	/**
	 * @var \App\Models\Objects\Position
	 */
	protected $position;

	/**
	 * Konstruktor
	 *
	 * @param \App\Models\User $user
	 * @param int              $id
	 * @param array            $data
	 * @param \DateTime        $von
	 * @param \DateTime        $bis
	 */
	public function __construct($user, $id, array $data, \DateTime $von, \DateTime $bis)
	{
		parent::__construct('div', '', 'details');
		$this->rawData = $data;
		$this->user = $user;
		$this->von = $von;
		$this->bis = $bis;
		$this->id = $id;
		$this->now = new \DateTime();

		$this->position = \Lifemeter\ObjectFactory::getById($id, false);

		$this->viewType = $this->rawData[0]['view'];
		$this->unit = $this->rawData[0]['unit'];

		$this->generate();

		$this->addPersonalMessage();

		$this->addChartRel();
		$this->addChartAbs();

		$this->createChartRel();
		$this->createChartAbs();
		$this->addDiffTexts();
		$this->addCommonMessage();
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

		$this->viewType = $this->rawData[0]['view'];
		$this->title = $this->rawData[0]['title'];
		$this->unit = $this->rawData[0]['unit'];
		$this->outputtexts = $this->rawData[0]['outputtexts'];
		$this->serialized = $this->rawData[0]['serialized'];

		foreach ($this->rawData as $index => $a)
		{
			//nur Werte deren Z-Index > 0 hinzufügen
			if ($a["zindex"] > 0)
			{
				$created = new \DateTime($a['datum']);

				//Ersten gültigen Wert übernehmen
				if ($startRel == null)
				{
					$startRel = $a['rel'];
					$startAbs = $a['abs'];

					$endRel = $startRel;
					$endAbs = $startAbs;

					$this->startDatum = $created;
				}

				$this->endDatum = $created;

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
				$this->title = $a['title'];
				$this->unit = $a['unit'];
				$this->outputtexts = $a['outputtexts'];
				$this->serialized = $a['serialized'];
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
	 * Erstellt die persönliche Bewertung
	 *
	 * @return void
	 */
	protected function addPersonalMessage()
	{
		$div = new \Templates\Html\Tag("div", null, 'texts compared');

		foreach ($this->outputtexts as $textArray)
		{
			if ($textArray[2] != "1")
			{
				$div->append(new \Templates\Html\Tag("p", $textArray[0]));
			}
		}

		$this->append($div);
	}

	/**
	 * Erstellt die allgemeine Bewertung
	 *
	 * @return void
	 */
	protected function addCommonMessage()
	{
		$div = new \Templates\Html\Tag("div", null, 'texts compared common');
		$span = new \Templates\Html\Tag("span", "Allgmeine Informationen", 'bold head');
		$span->append(new \Templates\Html\Tag("span", "öffnen", 'fRight pleaseOpenNext'));
		$div->append($span);

		$commonTag = new \Templates\Html\Tag("p", '', 'hide');
		foreach ($this->outputtexts as $textArray)
		{
			if ($textArray[2] == "1")
			{
				$commonTag->append($textArray[0]);
			}
		}
		$div->append($commonTag);
		$this->append($div);
	}

	/**
	 * Tacho Box mit Rel Wert
	 *
	 * @return void
	 */
	private function addChartRel()
	{
		if ($this->viewType == 2 || $this->viewType == 0)
		{
			$div = new \Templates\Html\Tag("div", '', 'chartRel');
			$div->append(new \Templates\Html\Tag("p", "Aktuelle Bewertung von: " . $this->title, 'bold'));

			$divC = new \Templates\Html\Tag("div", '', 'chartContainer');
			$chartRel = new \Templates\Myipt\Chart($this->serialized, "rel", array(), true);
			$chartRel->setWidth(200);
			$chartRel->setHeight(160);
			$divC->append($chartRel);
			$div->append($divC);
			$div->append(new \Templates\Html\Tag("div", new \Templates\Html\Tag("span", $this->endRel .' %'), 'upToDate'));
			$this->append($div);
		}

	}

	/**
	 * Balken Box mit Abs Wert
	 *
	 * @return void
	 */
	private function addChartAbs()
	{
		if ($this->viewType > 0)
		{
			$div = new \Templates\Html\Tag("div", '', 'chartAbs');
			$div->append(new \Templates\Html\Tag("p", "Aktueller Wert von: " . $this->title, 'bold'));

			$divC = new \Templates\Html\Tag("div", '', 'chartContainer');
			$chartRel = new \Templates\Myipt\Chart($this->serialized, "abs", array(), true);
			$chartRel->setWidth(200);
			$chartRel->setHeight(160);
			$divC->append($chartRel);
			$div->append($divC);
			$div->append(new \Templates\Html\Tag("div", new \Templates\Html\Tag("span", $this->endAbs .' '.$this->unit), 'upToDate'));
			$this->append($div);
		}
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
			$div = new \Templates\Html\Tag("div", new \Templates\Html\Tag("p", "Entwicklung und Zielplanung", 'bold'), 'chartPlot');
			$div->append($container);
			$div->append($this->getZeitraum());
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
			$div = new \Templates\Html\Tag("div", new \Templates\Html\Tag("p", "Entwicklung und Zielplanung", 'bold'), 'chartPlot');
			$div->append($container);
			$div->append($this->getZeitraum());
			$this->append($div);
		}
	}

	/**
	 * Liefert den Zeitraum Tag
	 *
	 * @return \Templates\Html\Tag
	 */
	private function getZeitraum()
	{
		$timeInterval = $this->endDatum->diff($this->startDatum);
		$span = new \Templates\Html\Tag("span", "Zeitraum " . $timeInterval->format("%m Monate %d Tage"), 'timeframe');
		$span->append("<br/>");
		$span->append("vom ".$this->startDatum->format('d.m.Y').' bis '.$this->endDatum->format('d.m.Y'));
		return $span;
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
		$container->addAttribute('data-series-target', '['.implode(',', $this->getZieldata()).']');
		$container->addAttribute('data-abs-title', $unit);
		$container->addAttribute('width', 608);
		$container->addAttribute('height', 384);
		$container->addAttribute('data-plot-background', '#ffffff');
		$container->addAttribute('data-plot-grid', '#dddddd');
		$container->addAttribute('data-plot-container-background', '#f7f7f7');

		return $container;

	}

	/**
	 * fügt veränderungne hinzu
	 *
	 * @return void
	 */
	protected function addDiffTexts()
	{
		$div = new \Templates\Html\Tag("div", '', 'diffs');

		if ($this->viewType >= 1)
		{
			$unit = $this->unit;
			$startWert = $this->startAbs;
			$endWert = $this->endAbs;
		}
		else
		{
			$unit = "%";
			$startWert = $this->startRel;
			$endWert = $this->endRel;
		}

		$p = new \Templates\Html\Tag("p", sprintf("Startwert: %0.1f %s | Endwert: %0.1f %s", $startWert, $unit, $endWert, $unit));
		$div->append($p);

		if ($this->viewType >= 1)
		{
			$div->append(new \Templates\Html\Tag("span", (($this->diffAbs > 0)?'+':'') . $this->diffAbs, 'big'));
			$div->append(new \Templates\Html\Tag("span", ' ' . $this->unit, 'small'));
		}

		if ($this->viewType == 0)
		{
			$div->append(new \Templates\Html\Tag("span", (($this->diffRel > 0)?'+':'') . $this->diffRel, 'big'));
			$div->append(new \Templates\Html\Tag("span", ' %', 'small'));
		}


		$this->append($div);
	}


	/**
	 * @return array
	 */
	protected function getZieldata()
	{
		$startdatum = $this->position->getZp10($this->user, $this->now);
		if ($startdatum <= 0)
		{
			return array();
		}

		if (is_numeric($startdatum))
		{
			$startdate = new \DateTime();
			$startdate->setTimestamp($startdatum);
		}
		else
		{
			$startdate = new \DateTime($startdatum);
		}


		$analyseManager = new \App\Manager\Analyses();
		$analyse = $analyseManager->getLastetAnalysesByUserAndObjectAndDate($this->user, $this->position, $startdate);
		if ($analyse)
		{
			$startwert = $analyse->getAbs();
		}
		else
		{
			$startwert = $this->startAbs;
			$startdate = $this->startDatum;
		}


		$enddatum = $this->position->getZp6($this->user, $this->now);
		if ($enddatum <= 0)
		{
			return array();
		}

		if (is_numeric($enddatum))
		{
			$enddate = new \DateTime();
			$enddate->setTimestamp($enddatum);
		}
		else
		{
			$enddate = new \DateTime($enddatum);
		}

		$endwert = $this->position->getZp7($this->user, $this->now);

		$diffInterval = $enddate->diff($startdate);
		$diff = $diffInterval->format("%a");
		$m = 0;
		if ($diff > 0)
		{
			$m = ($endwert - $startwert) / $diff;
		}
		else
		{
			return array();
		}

		$t = $endwert - ($m * $diff);
		$calc = create_function('$x', 'return $x * ' . $m . ' + ' . $t . ';');

		$x1 = $this->startDatum;
		$x2 = $this->endDatum;
		$x3 = null;

		$y1 = $startwert;
		$y2 = $endwert;
		$y3 = $endwert;

		$diffX1Interval = $x1->diff($startdate);
		$diffX1 = $diffX1Interval->format("%a");

		$diffX2Interval = $x2->diff($enddate);
		$diffX2 = $diffX2Interval->format("%a");


		if ($diffX1 != 0)
		{
			if ($diffX1Interval->invert == 1)
			{
				$y1 = $calc($diffX1);
			}
			else
			{
				$x1 = $startdate;
			}
		}

		if ($diffX2 != 0)
		{
			if ($diffX2Interval->invert == 1)
			{
				$x2 = $enddate;
				$x3 = $this->endDatum;
			}
			else
			{
				$diff = $startdate->diff($this->endDatum)->format("%a");
				$y2 = $calc($diff);
			}
		}



		$series = array(
			sprintf("[%s,%s]", '['.$x1->format('Y').','.($x1->format('n')-1).','.$x1->format('j').']', $y1),
			sprintf("[%s,%s]", '['.$x2->format('Y').','.($x2->format('n')-1).','.$x2->format('j').']', $y2)
		);

		if ($x3 != null)
		{
			$series[] = sprintf("[%s,%s]", '['.$x3->format('Y').','.($x3->format('n')-1).','.$x3->format('j').']', $y3);
		}

		return $series;
	}

}