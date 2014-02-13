<?php

namespace Templates\Myipt\Posts;

/**
 * Class ListSingled
 *
 * Für die Darstellung der Status-Quo zuständig
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class ListSingled extends \Templates\Html\Tag
{

	/**
	 * Postformular
	 *
	 * @var \Templates\Html\Tag
	 */
	protected $postform;

	/**
	 *
	 * @var array
	 */
	protected $entries = array();

	/**
	 *
	 * @var \App\Models\User
	 */
	protected $user;

	/**
	 *
	 * @var \Core\View
	 */
	protected $view;

	/**
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct(array $entries, $headline, \App\Models\User $user)
	{
		parent::__construct('div', '', 'colThreeQuarter fLeft cornered shadowed box posts');
		$this->setId("postable");
		$this->entries = $entries;

		$this->append(
			new \Templates\Html\Tag("h2", $headline, "whitened")
		);

		$this->user = $user;

		$this->addHeadline();
	}

	/**
	 * Setter für den View, wichtig für die URL
	 *
	 * @param \Core\View $view
	 */
	public function setView(\Core\View  $view)
	{
		$this->view = $view;
	}

	/**
	 * Erstellt die Headline
	 */
	protected function addHeadline()
	{
		$headline = new \Templates\Myipt\Posts\Headline();
		$headline->addCell("Bezeichnung", "300px");
		$headline->addCell("Bewertung", "100px");
		$headline->addCell("Wert", "208px");
		$headline->addCell("", "100px");

		$this->append($headline);
	}

	/**
	 * Erstellt für die vorhandenen Einträg ein Entry und fügt es zur Liste hinzu
	 */
	protected function addEntries()
	{
		foreach ($this->entries as $entryData)
		{
			$entry = new \Templates\Myipt\Posts\StatusQuo\Entry($entryData);
			$entry->addDetailLink(
				$this->view->url(
					array(
						"action" => "getsingledetails",
						"userid" => $this->user->getId(),
						"position" => $entryData["id"],
						"format" => "json"
					)
				)
			);

			$this->append( $entry );

			/*
			if (!empty($entryData['childs']))
			{
				$this->addEntries($entryData['childs']);
			}
			*/
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