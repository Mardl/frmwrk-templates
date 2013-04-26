<?php

namespace Templates\Myipt;

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
	 * @var Tag
	 */
	protected $more = null;

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
		parent::__construct('div', '', $classOrAttributes);

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
		$this->footer = new Tag('div','','footer');
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

	/**
	 * Setter für den Footer-Text der Widget-Box
	 * @param string|mixed $footer
	 */
	public function setFooter($footer)
	{
		$this->footer->append($footer);
		parent::append($this->footer);
	}

	public function setMoreLink($href, $text){
		$this->more = new \Templates\Html\Anchor($href, $text, array());
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
		$this->addClass('widget');

		if ($this->more){
			$this->header->append($this->more);
		}

		return parent::toString();
	}
}
