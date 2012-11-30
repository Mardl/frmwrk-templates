<?php

namespace Templates\Html;

class Cell extends Tag
{

	private $header = false;
	private $colspan=1;


	/**
	 * @param bool $header
	 * @param array $classOrAttributes
	 */
	public function __construct($value, $header=false,$classOrAttributes = array())
	{
		parent::__construct('td','',$classOrAttributes);

		$this->append($value);

		if ($header)
		{
			$this->header();
		}
	}

	public function header()
	{
		$this->header = true;
		return $this;
	}

	public function setColspan($count)
	{
		$this->colspan = $count;
		return $this;
	}

	public function getColspan()
	{
		return $this->colspan;
	}

	public function toString()
	{
		if($this->header)
		{
			$this->setTagname('th');
		}
		if ($this->getColspan() > 1)
		{
		  	$this->addAttribute('colspan',$this->getColspan());
		}
		return parent::toString();
	}
}