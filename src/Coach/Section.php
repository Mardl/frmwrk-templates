<?php

namespace Templates\Coach;

use Templates\Html\Tag;

/**
 * Class Section
 *
 * @category Lifemeter
 * @package  Templates\Coach
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Section extends Tag
{
	/**
	 * @var \Templates\Html\Tag
	 */
	protected $content = null;


	/**
	 * @param string $headerText
	 * @param array  $value
	 * @param array  $classOrAttributes
	 * @param bool   $showhidden
	 * @internal param bool $style2
	 */
	public function __construct($headerText='', $value=array(), $classOrAttributes = array(), $showhidden = false)
	{
		parent::__construct('div', '', 'section');

		if (!empty($headerText))
		{
			$h2 = new Tag('h2');
			$span = new Tag('span', $headerText);
			$h2->append($span);
			parent::append($h2);
			$hr = new Tag('hr');
			$hr->forceClose = false;
			parent::append($hr);
		}

		$this->initContent();

		if (!empty($value))
		{
			$this->append($value);
		}
	}



	/**
	 * Erstellt den Content-Bereich der Widget-Box
	 * @return void
	 */
	protected function initContent()
	{
		$this->content = new Tag('div', '', 'content');
		parent::append($this->content);
	}

	/**
	 * @param mixed $value
	 * @return Tag|void
	 */
	public function append($value)
	{
		$this->content->append($value);
	}

	/**
	 * @param mixed $value
	 * @return Tag|void
	 */
	public function prepend($value)
	{
		$this->content->prepend($value);
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		$br = new \Templates\Html\Tag("br", '', 'clear');
		$br->forceClose = false;

		$this->append($br);
		return parent::toString();
	}

}
