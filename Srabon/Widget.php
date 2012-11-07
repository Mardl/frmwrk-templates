<?php

namespace Templates\Srabon;

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
	 * @var Div
	 */
	protected $content = null;

	/**
	 * @var bool
	 */
	protected $flat = true;

	/**
	 * @param string $headerText
	 * @param bool $flat
	 */
	public function __construct($headerText='', $flat=true, $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);
		$this->flat = $flat;

		$this->initHead();
		$this->initContent();
		$this->initFoot();

		if(!empty($headerText))
		{
			$this->setHeader($headerText);
		}


	}

	/**
	 * Erstellt den Header-Bereich sowie das H-Tag der Widget-Box
	 * @return void
	 */
	protected function initHead()
	{
		$this->header = new Tag('h5');
		$div = new Tag('div',$this->header,'widget-head');

		parent::append($div);
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
		$this->content = new Tag('div','','well');
		if(!$this->flat)
		{
			$this->content->addClass('white-box');
		}
		$wrap1 = new Tag('div',$this->content,'widget-box');
		$wrap2 = new Tag('div',$wrap1,'widget-content');

		parent::append($wrap2);
	}

	/**
	 * Setter für den Header-Text der Widget-Box
	 * @param string|mixed $header
	 */
	public function setHeader($header)
	{
		$this->header->append($header);
	}

	/**
	 * Setter für den Header-Text der Widget-Box
	 * @param string|mixed $header
	 */
	public function setFooter($footer)
	{
		$this->footer->append($footer);
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
		$type = !$this->flat ? 'widget-block' : 'nonboxy-widget';
		$this->addClass($type);

		if ($this->footer->countInners() > 0)
		{
			$div = new Tag('div',$this->footer,'widget-bottom');
			parent::append($div);
		}
		return parent::toString();
	}
}