<?php

namespace Templates\MandyLane;

use \Templates\Html\Tag;

class Table extends \Templates\Html\Table
{

	private $headline = '';

	public function __construct($headline='', $classOrAttributes = array())
	{
		parent::__construct($classOrAttributes,'\Templates\MandyLane\Row');

		$this->addClass('dyntable');
		$this->addClass('dataTable');
		$this->headline = $headline;
	}

	public function setColumnEvenOdd()
	{
		for ($i = 0; $i < $this->maxCell; $i++)
		{
			if ($i % 2 == false)
			{
				$this->addAttrColumn($i,'con0');
			}
			else
			{
				$this->addAttrColumn($i,'con1');
			}
		}
	}


	public function toString()
	{
		$typeWidget = 'nonboxy-widget';
		$type = 'data-tbl-nothing table-bordered';

		$this->addClass($type);
		$strOutTable = parent::toString();

		// Widget Bauen
		$divWidget = new Tag('div','',$typeWidget);
		if (!empty($this->headline))
		{
			$div = new Tag('div',new Tag('h5',$this->headline),'widget-head');
			$divWidget->append($div);
		}

		$divWidget->append($strOutTable);

		return $divWidget->toString();

	}



}