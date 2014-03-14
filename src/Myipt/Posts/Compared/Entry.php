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
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct(array $entry, $active = false, $positionId)
	{
		$class = 'entry makeMeDraggable';
		if (!$active){
			$class .= ' whitened';
		} else {
			$class .= ' active';
		}

		parent::__construct('div', '', $class);

		$this->active = $active;

		$this->toCompare = $entry;

		$last = array_slice($entry, -1, 1);
		$last = array_pop($last);

		$this->type = $last["view"];
		$this->unit = $last['unit'];
		$this->title = $last['title'];

		$this->setId($positionId);

		$this->rel = $this->getDiffValue('rel');
		$this->abs = $this->getDiffValue('abs');

		$this->defineAttributes();

		$this->data = new \Templates\Html\Tag("div", '', 'data');
		$this->append($this->data);
		$this->createEntry();

	}

	/**
	 * Definiert die Attribute für Post
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
		$first = null;
		$last = null;

		foreach ($this->toCompare as $entry)
		{
			if ($entry['zindex'] > 0)
			{
				if ($first == null)
				{
					$first = $entry;
				}

				$last = $entry;
			}
		}

		if ($first == null)
		{
			$first = array($index => 0);
		}

		if ($last == null)
		{
			$last = array($index => 0);
		}

		return ($last[$index] - $first[$index]);
	}

	/**
	 * Erstellt den Eintag
	 */
	protected function createEntry()
	{
		$this->addCell($this->title, null, "title head");

		if (!$this->active)
		{
			$this->addValues();
		}
		else
		{
			$last = array_slice($this->toCompare, -1, 1);
			$last = array_pop($last);
			$this->addCell(sprintf("Datenaktualität: <b>%0.1f%%</b>", $last['zindex']), "284px", 'head');
		}
	}

	/**
	 * Erstellt die Header werte
	 */
	protected function addValues()
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

			$value = sprintf("<span class='".$class."'></span> %0.1f %%", $this->rel);

		} else {
			if ($this->abs < 0)
			{
				$class = "compare down";
			}
			else if ($this->abs > 0)
			{
				$class = "compare up";
			}
			$value = sprintf("<span class='".$class."'></span> %0.1f %s", $this->abs, $this->unit);
		}

		$this->addCell($value, "208px");
	}

	/**
	 * Fügt den Detaillink hinzu
	 */
	public function addDetailLink($uri)
	{
		$span = new \Templates\Html\Tag("span",'','icon info tiny');
		$link = new \Templates\Html\Anchor($uri, $span, "get-ajax");
		$link->append("Details");

		$cell = new \Templates\Html\Tag("div", $link, 'fLeft detailLink');
		$check = new \Templates\Html\Tag("span",'','icon check green hide');
		$cell->append($check);

		$this->append($cell);
	}

	/**
	 * Fügt "Zelle" hinzu
	 *
	 * @param string $value
	 * @param string $size
	 * @param string $class
	 */
	protected function addCell($value, $size = null, $class = '')
	{
		$cell = new \Templates\Html\Tag("div", $value, 'fLeft '.$class);
		if ($size)
		{
			$cell->addStyle("width", $size);
		}
		$this->data->append($cell);
	}

	/**
	 * Fügt Detailinformationen hinzu
	 *
	 * @param \Templates\Myipt\Posts\Compared\Details $details
	 */
	public function addDetails(\Templates\Myipt\Posts\Compared\Details $details)
	{
		$this->data->append($details);
	}

}