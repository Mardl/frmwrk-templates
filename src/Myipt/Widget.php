<?php

namespace Templates\Myipt;


/**
 * Base class Widget
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Alexander Jonser <aj@whm-gmbh.net>
 */
class Widget extends \Templates\Html\Tag
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

	protected $view;

	/**
	 * Konstruktor
	 *
	 * @param string $headerText
	 * @param array  $value
	 * @param array  $classOrAttributes
	 * @param bool   $showhidden
	 */
	public function __construct($headerText='', $value=array(), $classOrAttributes = array(), $showhidden = false)
	{
		parent::__construct('div', '', $classOrAttributes);

		$this->initHead();
		$this->initContent();
		$this->initFoot();

		if(!empty($headerText))
		{
			$this->addHeader($headerText);
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
		$this->header = new \Templates\Html\Tag('span');
		$h3 = new \Templates\Html\Tag('h3', $this->header);
		parent::append($h3);
	}

	/**
	 * Erstellt den FooterBereich
	 *
	 * @return void
	 */
	protected function initFoot()
	{
		$this->footer = new \Templates\Html\Tag('div', '', 'footer');
	}

	/**
	 * Erstellt den Content-Bereich der Widget-Box
	 * @return void
	 */
	protected function initContent()
	{
		$this->content = new \Templates\Html\Tag('div', '', 'content');
		parent::append($this->content);
	}

	/**
	 * Setter für den Header-Text der Widget-Box
	 * @param string|mixed $header
	 * @return void
	 */
	public function addHeader($header)
	{
		$this->header->append($header);
	}

	/**
	 * Setter für den Footer-Text der Widget-Box
	 * @param string|mixed $footer
	 * @param string       $class
	 * @return void
	 */
	public function setFooter($footer, $class = '')
	{
		$this->footer->append($footer);
		$this->footer->addClass($class);
		parent::append($this->footer);
	}

	/**
	 * Setzt den Tag für den "mehr" Link
	 *
	 * @param string $href
	 * @param string $text
	 * @param string $class
	 *
	 * @return void
	 */
	public function setMoreLink($href, $text, $class = '')
	{
		$this->more = new \Templates\Html\Anchor($href, $text, $class);
	}

	/**
	 * (non-PHPdoc)
	 * @param string|\Templates\Html\Tag $value
	 * @return void
	 * @see \Templates\Html\Tag::append()
	 */
	public function append($value)
	{
		$this->content->append($value);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @param string|\Templates\Html\Tag $value
	 * @return void
	 * @see \Templates\Html\Tag::prepend()
	 */
	public function prepend($value)
	{
		$this->content->prepend($value);
	}

	/**
	 * setzt den View
	 *
	 * @param \Core\View $view
	 *
	 * @return void
	 */
	public function setView($view)
	{
		$this->view = $view;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Templates\Html\Tag::toString()
	 *
	 * @return void
	 */
	public function toString()
	{
		$this->addClass('widget');

		if ($this->more)
		{
			$this->header->append($this->more);
		}

		return parent::toString();
	}

	/**
	 * @param string $class
	 * @return void
	 */
	public function addContentClass($class)
	{
		$this->content->addClass($class);
	}
}
