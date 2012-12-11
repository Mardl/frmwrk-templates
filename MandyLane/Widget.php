<?php

namespace Templates\MandyLane;

use	Templates\Html\Tag;

class Widget extends Tag
{
	/**
	 * @var Tag
	 */
	protected $header = null;

	/**
	 * @var Tag
	 */
	protected $footer = null;

	/**
	 * @var \Templates\Html\Tag
	 */
	protected $content = null;

	/**
	 * @var bool
	 */
	protected $style2 = true;

	/**
	 * Standartmäßig als geschlossen Anzeigen
	 *
	 * @var bool
	 */
	protected $showhidden = false;


	/**
	 * @param string $headerText
	 * @param bool $flat
	 */
	public function __construct($headerText='', $value=array(), $style2=false, $classOrAttributes = array(), $showhidden = false)
	{
		parent::__construct('div', '', $classOrAttributes);
		$this->style2 = $style2;

		$this->setShowhidden($showhidden);

		$this->initHead();
		$this->initContent();
		$this->initFoot();

		if(!empty($headerText))
		{
			$this->setHeader($headerText);
		}
		if (!empty($value))
		{
			$this->append($value);
		}



	}

	/**
	 * Erstellt den Header-Bereich sowie das H-Tag der Widget-Box
	 * @return void
	 */
	protected function initHead()
	{
		$this->header = new Tag('span');
		$h3 = new Tag('h3',$this->header);
		parent::append($h3);
	}

	protected function initFoot()
	{
		$this->footer = new Tag('div','','well');
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

	/**
	 * Setter für den Header-Text der Widget-Box
	 * @param string|mixed $header
	 */
	public function setHeader($header)
	{
		$this->header->append($header);
	}

	public function setShowhidden($showhidden = false)
	{
		$this->showhidden = $showhidden;
	}

	public function getShowhidden()
	{
		return $this->showhidden;
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
		$type = $this->style2 ? 'widgetbox2' : 'widgetbox';
		$this->addClass($type);

		if($this->getShowhidden())
		{
			$this->content->addStyle('display', 'none');
		}

		return parent::toString();
	}
}
