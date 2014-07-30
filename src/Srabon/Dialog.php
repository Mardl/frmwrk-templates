<?php

namespace Templates\Srabon;

use	Templates\Html\Tag;

/**
 * Class Dialog
 *
 * @category Dreiwerken
 * @package  Templates\Srabon
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
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
	 * @var Tag
	 */
	protected $content = null;

	/**
	 * @var Tag
	 */
	protected $closeButton = '';


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
		$this->closeButton = new Tag('button','×',array('class'=>'close','data-dismiss'=>'modal','type'=>'button'));
		$div = new Tag('div',array($this->closeButton,$this->header),'modal-header');

		parent::append($div);
	}

	public function noCloseButton()
	{
		$this->closeButton->removeInner();
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
