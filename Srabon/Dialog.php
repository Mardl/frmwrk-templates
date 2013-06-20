<?php

namespace Templates\Srabon;

use	Templates\Html\Tag;

class Dialog extends Tag
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
	 * @param string $headerText
	 * @param array $value
	 * @param array $classOrAttributes
	 */
	public function __construct($headerText='', $value=array(), $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);
		$this->addClass('modal');
		$this->addClass('hide');
		$this->addClass('fade');

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
		$this->header = new Tag('h3');
		$button = new Tag('button','×',array('class'=>'close','data-dismiss'=>'modal','type'=>'button'));
		$div = new Tag('div',array($button,$this->header),'modal-header');

		parent::append($div);
	}

	protected function initFoot()
	{
		$this->footer = new Tag();
	}

	/**
	 * Erstellt den Content-Bereich der Widget-Box
	 * @return void
	 */
	protected function initContent()
	{
		$this->content = new Tag('div','','modal-body');

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

	/**
	 * Setter für den Footer der Widget-Box
	 * @param $footer
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
		if ($this->footer->countInners() > 0)
		{
			$div = new Tag('div',$this->footer,'modal-footer');
			parent::append($div);
		}
		return parent::toString();
	}
}
