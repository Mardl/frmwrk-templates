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
	 * @param bool $flat
	 */
	public function __construct($headerText, $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);
		$this->addClass('page-header');

		$this->header = new Tag('h1',$headerText);

		parent::addValue($this->header);

	}
	/**
	 * Erstellt den Header-Bereich sowie das H-Tag der Widget-Box
	 * @return void
	 */
	public function setHeader($headerText)
	{
		$this->header->setValue($headerText);
	}

	public function toString()
	{
		$strOut = parent::toString();
		$grid = new Grid();
		$grid->setValue($strOut);

		return $grid->toString();
	}


}