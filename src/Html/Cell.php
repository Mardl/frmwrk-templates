<?php

namespace Templates\Html;

/**
 * Class Cell
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Cell extends Tag
{

	/**
	 * @var bool
	 */
	private $header = false;
	/**
	 * @var int
	 */
	private $colspan = 1;

	/**
	 * @param string $value
	 * @param bool   $header
	 * @param array  $classOrAttributes
	 */
	public function __construct($value, $header = false, $classOrAttributes = array())
	{
		parent::__construct('td', '', $classOrAttributes);

		$this->append($value);

		if ($header)
		{
			$this->header();
		}
	}

	/**
	 * @return $this
	 */
	public function header()
	{
		$this->header = true;

		return $this;
	}

	/**
	 * @param int $count
	 * @return $this
	 */
	public function setColspan($count)
	{
		$this->colspan = $count;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getColspan()
	{
		return $this->colspan;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		if ($this->header)
		{
			$this->setTagname('th');
		}
		if ($this->getColspan() > 1)
		{
			$this->addAttribute('colspan', $this->getColspan());
		}

		return parent::toString();
	}
}