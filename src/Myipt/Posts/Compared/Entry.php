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
class Entry extends \Templates\Html\Tag
{
	/**
	 * @var array
	 */
	protected $data;

	/**
	 * Rohdaten
	 *
	 * @var array
	 */
	protected $toCompare;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * Anzeige von Rel / Abs / beides
	 *
	 * @var integer
	 */
	protected $type;

	/**
	 * Einheit z.B. kg
	 * @var string
	 */
	protected $unit;

	/**
	 * Relativer Wert
	 * @var float
	 */
	protected $rel = 0;

	/**
	 * Absoluter Wert
	 * @var float
	 */
	protected $abs = 0;

	/**
	 * @var boolean
	 */
	protected $active = false;

	/**
	 * @var array
	 */
	protected $first;

	/**
	 * @var array
	 */
	protected $last;

	/**
	 * @var boolean
	 */
	protected $disableValues = false;

	/**
	 * Konstruktor
	 *
	 * @param array   $entry
	 * @param boolean $active
	 * @param integer $positionId
	 */
	public function __construct(array $entry, $active = false, $positionId = 0)
	{
		$class = 'entry makeMeDraggable';
		if (!$active)
		{
			$class .= ' whitened';
		}
		else
		{
			$class .= ' active';
		}

		parent::__construct('div', '', $class);

		$this->active = $active;
		$this->toCompare = $entry;
		$this->prepare();

		$this->setId($positionId);

		$this->rel = $this->getDiffValue('rel');
		$this->abs = $this->getDiffValue('abs');

		$this->defineAttributes();

		$this->data = new \Templates\Html\Tag("div", '', 'data');
		$this->append($this->data);
		$this->createEntry();

	}

	/**
	 * Aufbereitung der daten
	 *
	 * @return void
	 */
	private function prepare()
	{
		foreach ($this->toCompare as $entry)
		{
			if ($entry['zindex'] > 0)
			{
				if ($this->first == null)
				{
					$this->first = $entry;
				}

				$this->last = $entry;
			}

			$this->title = $entry['title'];
		}

		$dummyArray = array(
			"rel" => 0,
			"abs" => 0,
			"view" => $this->toCompare[0]["view"],
			"unit" => $this->toCompare[0]["unit"],
			"title" => $this->toCompare[0]["title"],
			"datum" => $this->toCompare[0]["datum"]
		);

		if ($this->first == null && $this->last == null)
		{
			$this->disableValues = true;
		}

		if ($this->first == null)
		{
			$this->first = $dummyArray;
		}

		if ($this->last == null)
		{
			$this->last = $dummyArray;
		}

		$this->type = $this->last["view"];
		$this->unit = $this->last['unit'];



	}

	/**
	 * Definiert die Attribute für Post
	 * @return void
	 */
	private function defineAttributes()
	{
		$this->addAttribute("data-type", "compared");
		$this->addAttribute("data-val-type", $this->type);
		$this->addAttribute("data-title", $this->title);

		if ($this->type == "0")
		{
			$this->addAttribute("data-unit", "%");
		}
		else
		{
			$this->addAttribute("data-unit", $this->unit);
		}

		$this->vzRel = $this->vzAbs = "-";

		//Wenn Rel-Differenz kleiner 0, dann verschlechtert
		if ($this->rel >= 0)
		{
			$this->addAttribute("data-val-rel", sprintf("+%0.1f", $this->rel));
		}
		else
		{
			$this->addAttribute("data-val-rel", sprintf("%0.1f", $this->rel));
		}


		//Wenn Abs Differenz größer 0, dann verbessert
		if ($this->abs >= 0)
		{
			$this->addAttribute("data-val-abs", sprintf("+%0.1f", $this->abs));
		}
		else
		{
			$this->addAttribute("data-val-abs", sprintf("%0.1f", $this->abs));
		}

	}

	/**
	 * Liefert Rohdaten
	 *
	 * @return array
	 */
	public function getData()
	{
		return $this->toCompare;
	}

	/**
	 * Liefert die Differenz des Start und Endwerts
	 *
	 * @param string $index
	 *
	 * @return number
	 */
	protected function getDiffValue($index)
	{
		return ($this->last[$index] - $this->first[$index]);
	}

	/**
	 * Liefert den span für den Main diff
	 *
	 * @return \Templates\Html\Tag
	 */
	protected function getMainDiffCell()
	{
		if (!$this->active)
		{
			$val = sprintf("%1.1f %s", $this->abs, $this->unit);
			if ($this->type == 0)
			{
				$val = sprintf("%1.1f %%", $this->rel);
			}
		}
		else
		{
			$datum = new \DateTime($this->last['datum']);
			$val = "Stand vom " . $datum->format('d.m.Y');
		}

		return new \Templates\Html\Tag("span", $val);


	}

	/**
	 * Erstellt den Eintrag
	 * @return void
	 */
	protected function createEntry()
	{
		$titleCell = $this->addCell(new \Templates\Html\Tag("h2", $this->title), null, "title head");
		$titleCell->append($this->getMainDiffCell());

		if (!$this->active)
		{
			$this->addValues();
		}
		else
		{
			$last = array_slice($this->toCompare, -1, 1);
			$last = array_pop($last);
			$this->addCell(sprintf("Datenaktualität: <b>%0.1f%%</b>", $last['zindex']), "233px", 'head');
		}
	}

	/**
	 * Erstellt die Header werte
	 * @return void
	 */
	protected function addValues()
	{
		$cell = $this->addCell('', "208px", 'verlauf');

		if (!$this->disableValues)
		{
			$class = "compare none";
			if ($this->type == "0")
			{
				if ($this->rel < 0)
				{
					$class = "compare down";
				}
				else if ($this->rel > 0)
				{
					$class = "compare up";
				}

				$spanFrom = new \Templates\Html\Tag("span", sprintf("%0.1f %%", $this->first['rel']), "fLeft");
				$spanTil = new \Templates\Html\Tag("span", sprintf("%0.1f %%", $this->last['rel']), "fLeft");
				$spanIcon = new \Templates\Html\Tag("span", '', $class);

			} else {
				if ($this->abs < 0)
				{
					$class = "compare down";
				}
				else if ($this->abs > 0)
				{
					$class = "compare up";
				}

				$spanFrom = new \Templates\Html\Tag("span", sprintf("%0.1f", $this->first['abs']), "fLeft");
				$spanTil = new \Templates\Html\Tag("span", sprintf("%0.1f %s", $this->last['abs'], $this->unit), "fLeft");
				$spanIcon = new \Templates\Html\Tag("span", '', $class);



			}

			$cell->append($spanFrom);
			$cell->append($spanIcon);
			$cell->append($spanTil);
		}
		else
		{
			$cell->append("keine Daten vorhanden");
		}
	}

	/**
	 * Fügt den Detaillink hinzu
	 *
	 * @param string $uri
	 *
	 * @return void
	 */
	public function addDetailLink($uri)
	{
		$span = new \Templates\Html\Tag("span", '', 'icon info tiny');
		$link = new \Templates\Html\Anchor($uri, $span, "get-ajax");
		$link->append("Details");

		$cell = new \Templates\Html\Tag("div", $link, 'fLeft detailLink');
		$check = new \Templates\Html\Tag("span", '', 'icon check green hide');
		$cell->append($check);

		$this->append($cell);
	}

	/**
	 * Fügt "Zelle" hinzu
	 *
	 * @param string $value
	 * @param string $size
	 * @param string $class
	 *
	 * @return void
	 */
	protected function addCell($value, $size = null, $class = '')
	{
		$cell = new \Templates\Html\Tag("div", $value, 'fLeft '.$class);
		if ($size)
		{
			$cell->addStyle("width", $size);
		}
		$this->data->append($cell);
		return $cell;
	}

	/**
	 * Fügt Detailinformationen hinzu
	 *
	 * @param \Templates\Myipt\Posts\Compared\Details $details
	 *
	 * @return void
	 */
	public function addDetails(\Templates\Myipt\Posts\Compared\Details $details)
	{
		$this->data->append($details);
	}

}