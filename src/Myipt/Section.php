<?php

namespace Templates\Myipt;

use	Templates\Html\Tag;

/**
 * Class Section
 *
 * @category Lifemeter
 * @package  Templates\Myipt
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
	 * @return \Templates\Myipt\Section
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
	 * @return void
	 */
	public function append($value)
	{
		$this->content->append($value);
	}

	/**
	 * @param mixed $value
	 * @return void
	 */
	public function prepend($value)
	{
		$this->content->prepend($value);
	}

	/**
	 * @param bool $sortable
	 * @return void
	 */
	public function setContentSortable($sortable = true)
	{
		if($sortable)
		{
			$this->content->addClass('sortable');
			return;
		}

		$this->content->removeClass('sortable');
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
