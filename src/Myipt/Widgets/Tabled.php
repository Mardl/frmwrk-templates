<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Mahlzeiten
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Tabled extends \Templates\Myipt\Widget
{

	/**
	 * @var array
	 */
	protected $sections = array();

	/**
	 * @var string
	 */
	protected $noHeaderSectionTitle = 'noheader';

	/**
	 * Konstruktor
	 *
	 * @param string $title
	 * @param array  $classOrAttributes
	 */
	public function __construct($title, $classOrAttributes = '')
	{
		parent::__construct($title, null, $classOrAttributes);

	}

	/**
	 * Fügt eine neue Headline Column hinzu
	 *
	 * @param string $value
	 * @param string $class
	 *
	 * @return \Templates\Html\Tag
	 */
	public function addHeaderRow($value, $class = "")
	{
		$class .= " column";

		$span = new \Templates\Html\Tag("span", $value, $class);
		$this->addHeader($span);

		return $span;
	}


	/**
	 * Erstellt eine Headline im Contentbereich
	 *
	 * @param string $title
	 *
	 * @return \Templates\Html\Tag
	 */
	public function addContentHeadline($title)
	{
		$div = new \Templates\Html\Tag("div", $title, "headline");
		$this->append($div);
		return $div;
	}

	/**
	 * Erstellt eine neue Zeile
	 *
	 * @param string $title
	 *
	 * @return \Templates\Html\Tag
	 */
	public function addContentRow($title)
	{
		$div = new \Templates\Html\Tag("div", $title, "blank");
		$this->append($div);
		return $div;
	}



	/**
	 * Erstellt einen neuen Bereich
	 *
	 * @param string $title
	 *
	 * @throws \ErrorException
	 *
	 * @return void
	 */
	public function addSection($title)
	{
		if (array_key_exists($title, $this->sections))
		{
			throw new \ErrorException("Der Bereich '".$title."' existiert bereits");
		}

		$this->sections[$title] = array();
	}

	/**
	 * Fügt eine neue Zeile dem Array hinzu
	 *
	 * @param string $section
	 * @param string $title
	 * @param array  $values
	 *
	 * @return void
	 */
	public function addRow($section, $title, array $values = array())
	{
		if (empty($section))
		{
			$section = $this->noHeaderSectionTitle;
		}
		$this->sections[$section][$title] = $values;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Templates\Myipt\Widget::toString()
	 *
	 * @return string
	 */
	public function toString()
	{
		foreach ($this->sections as $sectionTitle => $sectionContents)
		{
			if ($sectionTitle != $this->noHeaderSectionTitle)
			{
				$section = $this->addContentHeadline($sectionTitle);
			}


			foreach ($sectionContents as $title => $columns)
			{
				if ($title != "addSectionColumn")
				{
					$div = $this->addContentRow($title);
				}


				foreach ($columns as $column)
				{
					if ($title != "addSectionColumn")
					{
						$span = new \Templates\Html\Tag("span", $column, "column");
						$div->append($span);
					}
					else
					{
						if (is_array($column))
						{
							foreach ($column as $sub)
							{
								$span = new \Templates\Html\Tag("span", $sub, "column");
								$section->append($span);
							}
						}
						else
						{
							$span = new \Templates\Html\Tag("span", $column, "column");
							$section->append($span);
						}
					}
				}

			}

		}

		return parent::toString();
	}


}
