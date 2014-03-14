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
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct(array $data)
	{
		parent::__construct('div', '', 'details');
		$this->data = $data;

	//	$this->addUpdate();
		$this->createCharts();
		$this->addTexts();
	}

	/**
	 * Box für Referenzdatum
	 *
	 * @deprecated
	 */
	protected function addUpdate()
	{
		$span = new \Templates\Html\Tag("span", "Stand vom ".$this->data['created']);
		$div = new \Templates\Html\Tag("div",$span,'upToDate');
		$this->append($div);

	}

	/**
	 * Erstellt die Graphen
	 */
	protected function createCharts()
	{
		if (!$this->data["noChart"] && $this->data['value']['zindex'] > 0)
		{
			//Wenn Rel angezeigt werden darf oder beide Werte, dann adden den Tacho
			if ($this->data["chart"] == "0" || $this->data["chart"] == "2")
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
	 */
	private function addChartRel()
	{
		$div = new \Templates\Html\Tag("div",'','chartRel');
		$chartRel = new \Templates\Myipt\Chart($this->data, "rel");
		$chartRel->setWidth(214);
		$chartRel->setHeight(150);
		$div->append($chartRel);
		$this->append($div);
	}

	/**
	 * Balken Box mit Abs Wert
	 */
	private function addChartAbs()
	{
		$div = new \Templates\Html\Tag("div",'','chartAbs');
		$chartRel = new \Templates\Myipt\Chart($this->data, "abs");
		$chartRel->setWidth(214);
		$chartRel->setHeight(160);
		$div->append($chartRel);
		$this->append($div);
	}

	/**
	 * Verlaufdaten
	 */
	private function addVerlauf()
	{
		$container = new \Templates\Html\Tag('div', '', 'chart');
		if (isset($this->data['class'])){
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
	 */
	protected function addTexts()
	{
		$div = new \Templates\Html\Tag("div",'','texts');

		$count = 0;
		foreach ($this->data['outputtexts'] as $text)
		{
			if ($text[2] != "1"){
				$div->append(
					new \Templates\Html\Tag("p", $text[0])
				);
				$count++;
			}
		}

		//Wenn persönliche Bewertung vorhanden
		if ($count > 0)
		{
			$this->append($div);
		}

	}

}