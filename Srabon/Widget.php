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
		$div = new Tag('div',$this->header,'widget-head');

		parent::addValue($div);
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