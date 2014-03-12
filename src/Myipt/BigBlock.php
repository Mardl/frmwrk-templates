<?php

namespace Templates\Myipt;

/**
 * Class Block
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class BigBlock extends \Templates\Html\Tag
{

	protected $headline = null;
	protected $closeButton = null;

	/**
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct($headline = null, $classOrAttributes = array())
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = ' colFull box';
		} else {
			$classOrAttributes .= ' colFull box';
		}

		parent::__construct('div', '', $classOrAttributes);
		$this->setId("bigBlock");

		if ($headline != null)
		{
			$this->headline = new \Templates\Html\Tag("h2", $headline, 'headline');
		}
	}

	/**
	 * Setzt von außen die Headline
	 *
	 * @param string $headline
	 */
	public function setHeadline($headline)
	{
		$this->headline = new \Templates\Html\Tag("h2", $headline, 'headline');
	}

	public function setCloseButton($button)
	{
		$this->closeButton = $button;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Templates\Html\Tag::toString()
	 */
	public function toString()
	{
		if ($this->headline != null)
		{
			$this->prepend($this->headline);
		}

		if ($this->closeButton != null)
		{
			$this->prepend($this->closeButton);
		}



		return parent::toString();
	}
}
