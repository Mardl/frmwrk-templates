<?php

namespace Templates\Myipt\Posts;

/**
 * Class ListCompared
 *
 * Für die Darstellung der Vergleiche zuständig
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class ListCompared extends \Templates\Html\Tag
{

	/**
	 * Darstellung der List
	 *
	 * @var \Templates\Html\Tag
	 */
	protected $list;

	/**
	 * Postformular
	 *
	 * @var \Templates\Html\Tag
	 */
	protected $postform;

	/**
	 * @var array
	 */
	protected $entries = array();

	/**
	 * @var \App\Models\User
	 */
	protected $user;

	/**
	 *
	 * @var \Core\View
	 */
	protected $view;

	/**
	 * @var DateTime
	 */
	protected $from;

	/**
	 * @var DateTime
	 */
	protected $until;


	/**
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct(array $entries, $headline, \App\Models\User $user, \DateTime $from, \DateTime $until)
	{
		parent::__construct('div', '', 'colThreeQuarter fLeft cornered shadowed box posts');
		$this->setId("postable");
		$this->entries = $entries;
		$this->from = $from;
		$this->until = $until;

		$this->append( new \Templates\Html\Tag("h2", $headline, "whitened") );

		$this->user = $user;

		$this->addHeadline();
	}

	/**
	 * Setter für View
	 *
	 * @param \Core\View $view
	 */
	public function setView(\Core\View  $view)
	{
		$this->view = $view;
	}

	/**
	 * Fügt die Headline der Liste hinzu
	 */
	protected function addHeadline()
	{
		$headline = new \Templates\Myipt\Posts\Headline();
		$headline->addCell("Bezeichnung", "300px");
		$headline->addCell("Veränderung", "308px");
		$headline->addCell("", "100px");

		$this->append($headline);
	}

	/**
	 * Erstellt für die vorhandenen Einträg ein Entry und fügt es zur Liste hinzu
	 */
	protected function addEntries()
	{
		foreach ($this->entries as $id => $entryData)
		{
			$entry = new \Templates\Myipt\Posts\Compared\Entry($entryData, false, $id);
			$entry->addDetailLink(
				$this->view->url(
					array(
						"action" => "getcomparedetails",
						"userid" => $this->user->getId(),
						"position" => $id,
						"from" => $this->from->format('Y-m-d'),
						"until" => $this->until->format('Y-m-d'),
						"format" => "json"
					)
				)
			);

			$this->append( $entry );

		}


	}

	/**
	 * (non-PHPdoc)
	 * @see \Templates\Html\Tag::toString()
	 */
	public function toString()
	{
		$this->addEntries();

		return parent::toString();
	}

}