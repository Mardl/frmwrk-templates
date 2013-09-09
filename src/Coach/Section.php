<?php

namespace Templates\Coach;

use	Templates\Html\Tag;

class Section extends Tag
{
	/**
	 * @var \Templates\Html\Tag
	 */
	protected $content = null;


	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($headerText='', $value=array(), $classOrAttributes = array(), $showhidden = false)
	{
		parent::__construct('div', '', 'section');

		if (!empty($headerText)){
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
		$this->content = new Tag('div','','content');
		parent::append($this->content);
	}

	public function append($value)
	{
		$this->content->append($value);
	}

	public function prepend($value)
	{
		$this->content->prepend($value);
	}


	public function toString()
	{
		$br = new \Templates\Html\Tag("br",'','clear');
		$br->forceClose = false;

		$this->append($br);
		return parent::toString();
	}

}