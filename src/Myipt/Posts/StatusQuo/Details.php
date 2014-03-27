<?php

namespace Templates\Myipt\Posts\StatusQuo;

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
	 * @var array
	 */
	protected $data = array();

	/**
	 * Konstruktor
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		parent::__construct('div', '', 'details');
		$this->data = $data;

		//$this->addUpdate();
		$this->createCharts();
		$this->addTexts();
	}

	/**
	 * Box für Referenzdatum
	 *
	 * @deprecated
	 * @return void
	 */
	protected function addUpdate()
	{
		$span = new \Templates\Html\Tag("span", "Stand vom ".$this->data['created']);
		$div = new \Templates\Html\Tag("div", $span, 'upToDate');
		$this->append($div);

	}

	/**
	 * Erstellt die Graphen
	 *
	 * @return void
	 */
	protected function createCharts()
	{
		if (!$this->data["noChart"] && $this->data['value']['zindex'] > 0)
		{
			//Wenn Rel angezeigt werden darf dann adde den Tacho
			if ($this->data["chart"] == "0")
			{
				$this->addChartRel();
			}

			//Wenn Abs angezeigt werden darf oder beide Werte, dann adden den Balken
			if ($this->data["chart"] == "1" || $this->data["chart"] == "2")
			{
				$this->addChartAbs();
			}

			//Verlauf anzeigen
			$this->addVerlauf();
		}

	}

	/**
	 * Tacho Box mit Rel Wert
	 *
	 * @return void
	 */
	private function addChartRel()
	{
		$div = new \Templates\Html\Tag("div", '', 'chartRel');
		$div->append(new \Templates\Html\Tag("p", "Aktuelle Bewertung von: " .  $this->data['title'], 'bold'));

		$divC = new \Templates\Html\Tag("div", '', 'chartContainer');
		$chartRel = new \Templates\Myipt\Chart($this->data, "rel", array(), true);
		$chartRel->setWidth(200);
		$chartRel->setHeight(160);
		$divC->append($chartRel);
		$div->append($divC);
		$div->append(new \Templates\Html\Tag("div", new \Templates\Html\Tag("span", $this->data['value']['rel'] .' %'), 'upToDate'));
		$this->append($div);
	}

	/**
	 * Balken Box mit Abs Wert
	 *
	 * @return void
	 */
	private function addChartAbs()
	{
		$div = new \Templates\Html\Tag("div", '', 'chartAbs');
		$div->append(new \Templates\Html\Tag("p", "Aktueller Wert von: " .  $this->data['title'], 'bold'));

		$divC = new \Templates\Html\Tag("div", '', 'chartContainer');
		$chartRel = new \Templates\Myipt\Chart($this->data, "abs", array(), true);
		$chartRel->setWidth(200);
		$chartRel->setHeight(160);
		$divC->append($chartRel);
		$div->append($divC);
		$div->append(new \Templates\Html\Tag("div", new \Templates\Html\Tag("span", $this->data['value']['abs'] .' '.$this->data['unit']), 'upToDate'));
		$this->append($div);
	}

	/**
	 * Verlaufdaten
	 *
	 * @return void
	 */
	private function addVerlauf()
	{
		$container = new \Templates\Html\Tag('div', '', 'chart');
		if (isset($this->data['class']))
		{
			$container = new \Templates\Html\Tag('div', '', 'chart '.$this->data['verlauf']['class']);
		}

		$container->addAttribute('id', $this->data['id'].'-plot');
		$container->addAttribute('data-type', "plot");
		$container->addAttribute('data-series-abs', '['.implode(',', $this->data['verlauf']["abs"]).']');
		$container->addAttribute('data-series-rel', '['.implode(',', $this->data['verlauf']["rel"]).']');
		$container->addAttribute('data-abs-title', $this->data['title']);
		$container->addAttribute('width', 608);
		$container->addAttribute('height', 384);
		$container->addAttribute('data-plot-background', '#ffffff');
		$container->addAttribute('data-plot-grid', '#dddddd');
		$container->addAttribute('data-plot-container-background', '#f7f7f7');

		$div = new \Templates\Html\Tag("div", $container, 'chartPlot');
		$this->append($div);
	}

	/**
	 * Persönliche Bewertung hinzufügen
	 *
	 * @return void
	 */
	protected function addTexts()
	{
		$div = new \Templates\Html\Tag("div", '', 'texts');

		$count = 0;

		$texts = array(
			0 => array(), //mine
			1 => array()  //common
		);

		foreach ($this->data['outputtexts'] as $text)
		{
			if ($text[2] != "1")
			{
				$texts[0][] = new \Templates\Html\Tag("p", $text[0]);
			}
			else
			{
				$texts[1][] = new \Templates\Html\Tag("p", $text[0]);
			}
			$count++;
		}

		foreach ($texts as $parts)
		{
			foreach ($parts as $text)
			{
				$div->append($text);
			}
			$div->append(new \Templates\Html\Tag("p", '<br/>'));
		}

		/**/

		//Wenn persönliche Bewertung vorhanden
		if ($count > 0)
		{
			$this->append($div);
		}

	}

}