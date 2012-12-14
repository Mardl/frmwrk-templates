<?php

namespace Templates\MandyLane;

class Row extends \Templates\Html\Row
{

	private $header = false;

	/**
	 * @param array $values
	 * @param bool $header
	 * @param array $classOrAttributes
	 */
	public function __construct(array $values=array(), $header=false,$classOrAttributes = array())
	{
		\Templates\Html\Tag::__construct('tr','',$classOrAttributes);

		if (!empty($values))
		{
			$evenodd = false;
			foreach ($values as $column)
			{
				$class =  ($evenodd == true) ? '1' : '0';
				$this->addCell($column, array('class' => 'head'.$class));
				$evenodd = !$evenodd;
			}
		}

		if($header)
		{
			$this->header();
		}

	}
}