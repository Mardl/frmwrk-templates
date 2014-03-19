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
class Entry extends \Templates\Html\Tag
{

	/**
	 * @var array
	 */
	protected $rawData;

	/**
	 * @var Templates\Html\Tag
	 */
	protected $data;

	/**
	 * @var boolean
	 */
	protected $active = false;

	/**
	 * @param array   $entry
	 * @param boolean $active
	 */
	public function __construct(array $entry, $active = false)
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

		$this->rawData = $entry;
		$this->active = $active;

		$this->defineAttributes();

		$this->data = new \Templates\Html\Tag("div", '', 'data');
		$this->append($this->data);
		$this->createEntry($entry);
	}

	/**
	 * Definiert die Attribute des Entry, wichtig für Drag 'n' Drop Funktion
	 *
	 * @return void
	 */
	private function defineAttributes()
	{
		$this->setId($this->rawData["id"]);
		$this->addAttribute("data-type", "single");
		$this->addAttribute("data-val-rel", sprintf("%0.1f", $this->rawData['value']['rel']));
		$this->addAttribute("data-val-abs", sprintf("%0.1f", $this->rawData['value']['abs']));
		$this->addAttribute("data-val-type", $this->rawData["chart"]);
		$this->addAttribute("data-title", $this->rawData['title']);

		//Wenn die Position nur die Rel-Werte anzeigen soll, dann ist die Einheit %
		if ($this->rawData["chart"] == "0")
		{
			$this->addAttribute("data-unit", "%");
		}
		else
		{
			$this->addAttribute("data-unit", $this->rawData['unit']);
		}
	}

	/**
	 * Liefert die Rohdaten
	 *
	 * @return array
	 */
	public function getData()
	{
		return $this->rawData;
	}

	/**
	 * Bereitet die Werte auf
	 *
	 * @param array $entry
	 *
	 * @return void
	 */
	protected function createEntry(array $entry)
	{
		//Titel
		$this->addCell($entry['title'], null, "title head");

		if (!$this->active)
		{
			//wenn der Eintrag nicht aktiv ist, dann nur die Werte anzeigen
			$this->addValues($entry);
		}
		else
		{
			//Ansonsten nur die Datenaktualität und das Datum des letzten Standes ausgeben
			$this->addCell(
				sprintf("Datenaktualität: <b>%0.1f%%</b><br/> Stand vom: <b>%s</b>", $entry['value']['zindex'], $entry['created']),
				"266px",
				"head"
			);
		}

	}

	/**
	 * Anzeige der Werte
	 *
	 * @param array $entry
	 *
	 * @return void
	 */
	protected function addValues(array $entry)
	{
		//Wenn der rel-Wert ausgegeben werden muss
		if ($entry["chart"] == "0" || $entry["chart"] == "2" )
		{
			$value = sprintf("%0.1f%%", $entry['value']['rel']);
		} else {
			$value = '&nbsp;';
		}
		$this->addCell($value, "114px");

		//Wenn der abs-Wert ausgegeben werden muss
		if ($entry["chart"] > 0)
		{
			$value = sprintf("%0.1f %s", $entry['value']['abs'], $entry['unit']);
		} else {
			$value = '&nbsp;';
		}
		$this->addCell($value, "150px");
	}

	/**
	 * Detaillink anfügen
	 *
	 * @param string $uri
	 *
	 * @return void
	 */
	public function addDetailLink($uri)
	{
		//Detaillink
		$span = new \Templates\Html\Tag("span", '', 'icon info tiny');
		$link = new \Templates\Html\Anchor($uri, $span, "get-ajax");
		$link->append("Details");

		//grüner Haken versteckt
		$cell = new \Templates\Html\Tag("div", $link, 'fLeft detailLink');
		$check = new \Templates\Html\Tag("span", '', 'icon check green hide');
		$cell->append($check);

		$this->append($cell);
	}

	/**
	 * Fügt eine "Zelle" dem Eintrag hinzu
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
	}

	/**
	 * Fügt dem Eintrag die Detailinfos hinzu
	 *
	 * @param \Templates\Myipt\Posts\StatusQuo\Details $details
	 *
	 * @return void
	 */
	public function addDetails(\Templates\Myipt\Posts\StatusQuo\Details $details)
	{
		$this->data->append($details);
	}

}