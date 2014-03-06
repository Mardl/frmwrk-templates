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
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct(array $entry, $active = false)
	{
		$class = 'entry makeMeDraggable';
		if (!$active){
			$class .= ' whitened';
		} else {
			$class .= ' active';
		}

		parent::__construct('div', '', $class);

		$this->rawData = $entry;
		$this->defineAttributes();

		$this->active = $active;

		$this->data = new \Templates\Html\Tag("div", '', 'data');
		$this->append($this->data);
		$this->createEntry($entry);
	}

	/**
	 * Definiert die Attribute des Entry, wichtig für Drag 'n' Drop Funktion
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
	 */
	protected function createEntry(array $entry)
	{
		$this->addCell($entry['title'], null, "title");

		if (!$this->active)
		{
			$this->addValues($entry);
		}
		else
		{
			$this->addCell(sprintf("Datenaktualität: <b>%0.1f%%</b>", $entry['value']['zindex']), "308px");
		}

	}

	protected function addValues(array $entry)
	{
		if ($entry["chart"] == "0" || $entry["chart"] == "2" )
		{
			$value = sprintf("%0.1f%%", $entry['value']['rel']);
		} else {
			$value = '&nbsp;';
		}
		$this->addCell($value, "100px");


		if ($entry["chart"] == "1" || $entry["chart"] == "2" )
		{
			$value = sprintf("%0.1f %s", $entry['value']['abs'], $entry['unit']);
		} else {
			$value = '&nbsp;';
		}
		$this->addCell($value, "208px");
	}

	/**
	 * Url für Detail link
	 *
	 * @param string $uri
	 */
	public function addDetailLink($uri)
	{
		$link = new \Templates\Html\Anchor($uri, "Details", "get-ajax");
		$cell = new \Templates\Html\Tag("div", $link, 'fLeft detailLink');
		$this->append($cell);
	}

	/**
	 * Fügt eine "Zelle" dem Eintrag hinzu
	 *
	 * @param string $value
	 * @param string $size
	 * @param string $class
	 */
	protected function addCell($value, $size = null, $class = '')
	{
		$cell = new \Templates\Html\Tag("div", $value, 'fLeft '.$class);
		if ($size){
			$cell->addStyle("width", $size);
		}
		$this->data->append($cell);
	}

	/**
	 * Fügt dem Eintrag die Detailinfos hinzu
	 *
	 * @param \Templates\Myipt\Posts\StatusQuo\Details $details
	 */
	public function addDetails(\Templates\Myipt\Posts\StatusQuo\Details $details)
	{
		$this->data->append($details);
	}

}