<?php

namespace Templates\Html;

class Cell extends Tag
{

	private $header = false;


	/**
	 * @param bool $header
	 * @param array $classOrAttributes
	 */
	public function __construct($value, $header=false,$classOrAttributes = array())
	{
		parent::__construct('td','',$classOrAttributes);

		$this->addValue($value);

		if ($header)
		{
			$this->header();
		}
	}

	public function header()
	{
		$this->header = true;
	}

	public function toString()
	{
		if($this->header)
		{
			$this->setTagname('th');
		}
		return parent::toString();
	}
}