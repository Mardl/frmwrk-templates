<?php

namespace Templates\Srabon;

use Templates\Html\Div,
	Templates\Html\Tag;

class Widget extends Tag
{
	/**
	 * @var Tag
	 */
	protected $header = null;

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

		$this->initHead();
		$this->initContent();

		if(!empty($headerText)) {
			$this->setHeader($headerText);
		}

		$this->flat = $flat;
	}

	/**
	 * Ändern den Widget-Typ von Block auf Nonboxy
	 * @return void
	 */
	public function flat()
	{
		$this->flat = true;
	}

	/**
	 * Ändern den Widget-Typ von Nonboxy auf Block
	 * @return void
	 */
	public function widget()
	{
		$this->flat = false;
	}

	/**
	 * Erstellt den Header-Bereich sowie das H-Tag der Widget-Box
	 * @return void
	 */
	protected function initHead()
	{
		$this->header = new Tag('h5');
		$div = new Div();
		$div->addClass('widget-head')->addValue($this->header);

		parent::addValue($div);
	}

	/**
	 * Erstellt den Content-Bereich der Widget-Box
	 * @return void
	 */
	protected function initContent()
	{
		$this->content = new Div();
		$this->content->addClass('well');

		if(!$this->flat)
		{
			$this->content->addClass('white-box');
		}

		$wrap1 = new Div();
		$wrap1->addClass('widget-box');
		$wrap1->addValue($this->content);

		$wrap2 = new Div();
		$wrap2->addClass('widget-content');
		$wrap2->addValue($wrap1);

		parent::addValue($wrap2);
	}

	/**
	 * Setter für den Header-Text der Widget-Box
	 * @param string|mixed $header
	 */
	public function setHeader($header)
	{
		$this->header->addValue($header);
	}

	/**
	 * Setter für den Inhaltsbereich der Widget-Box
	 * @param mixed $content
	 */
	public function setValue($content)
	{
		$this->content->setValue($content);
	}

	/**
	 * Setter für den Inhaltsbereich der Widget-Box
	 * @param mixed $content
	 */
	public function addValue($content)
	{
		$this->content->addValue($content);
	}

	public function append($value)
	{
		$this->content->append($value);
	}

	public function prepend($value)
	{
		$this->content->prepend($value);
	}

	public function toString() {
		$type = 'nonboxy-widget';
		if(!$this->flat)
		{
			$type = 'widget-block';
		}
		$this->addClass($type);
		return parent::toString();
	}
}