<?php

namespace Templates\Myipt\Posts;

/**
 * Class Headline
 *
 * Liefert die Headline für die PostsListen
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Headline extends \Templates\Html\Tag
{

	protected $cells = array();

	/**
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct(array $cells = array())
	{
		parent::__construct('div', '', 'headline');
		$this->cells = $cells;
	}

	/**
	 * Fügt eine "Zelle" der Überschrift hinzu
	 *
	 * @param string $name
	 * @param string $width
	 */
	public function addCell($name, $width)
	{
		$this->cells[] = array($name, $width);
	}

	/**
	 * (non-PHPdoc)
	 * @see \Templates\Html\Tag::toString()
	 */
	public function toString()
	{
		foreach ($this->cells as &$cellData)
		{
			$cell = new \Templates\Html\Tag("div", $cellData[0], 'fLeft');
			$cell->addStyle("width", $cellData[1]);
			$this->append($cell);
		}
		unset($cellData);

		return parent::toString();
	}

}