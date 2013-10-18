<?php

namespace Templates\MandyLane;

use	Templates\Html\Tag;

/**
 * Class Widget
 *
 * @category Lifemeter
 * @package  Templates\MandyLane
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
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
	 * @param array  $value
	 * @param bool   $style2
	 * @param array  $classOrAttributes
	 * @param bool   $showhidden
	 * @return void
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
		$h3 = new Tag('h3', $this->header);
		parent::append($h3);
	}

	/**
	 * @return void
	 */
	protected function initFoot()
	{
		$this->footer = new Tag('div', '', 'well');
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
	 * Setter für den Header-Text der Widget-Box
	 * @param string|mixed $header
	 * @return void
	 */
	public function setHeader($header)
	{
		$this->header->append($header);
	}


	/**
	 * @param string $className
	 * @return void
	 */
	public function addContentClass($className)
	{
		$this->content->addClass($className);
	}

	/**
	 * @param bool $showhidden
	 * @return void
	 */
	public function setShowhidden($showhidden = false)
	{
		$this->showhidden = $showhidden;
	}

	/**
	 * @return bool
	 */
	public function getShowhidden()
	{
		return $this->showhidden;
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
	 * @return string
	 */
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
