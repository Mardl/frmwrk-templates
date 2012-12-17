<?php

namespace Templates\Srabon;

use Templates\Html\Tag;

class PageHeader extends Tag
{
	/**
	 * @var Tag
	 */
	protected $header = null;

	/**
	 * @param string $headerText
	 * @param array $classOrAttributes
	 */
	public function __construct($headerText, $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);
		$this->addClass('page-header');

		$this->header = new Tag('h1', $headerText);

		parent::append($this->header);
	}

	/**
	 * Erstellt den Header-Bereich sowie das H-Tag der Widget-Box
	 *
	 * @param $headerText
	 */
	public function setHeader($headerText)
	{
		$this->header->append($headerText);
	}

	public function toString()
	{
		$strOut = parent::toString();
		$grid = new Grid();
		$grid->append($strOut);

		return $grid->toString();
	}
}
