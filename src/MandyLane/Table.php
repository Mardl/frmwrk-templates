<?php

namespace Templates\MandyLane;

/**
 * Class Table
 *
 * @category Lifemeter
 * @package  Templates\MandyLane
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Table extends \Templates\Html\Table
{

	protected $headline = '';

	/**
	 * @param string $headline
	 * @param array  $classOrAttributes
	 *
	 * @return \Templates\MandyLane\Table
	 */
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
		$divWidget = new \Templates\Html\Tag('div', '', $typeWidget);
		if (!empty($this->headline))
		{
			$div = new \Templates\Html\Tag('div', new \Templates\Html\Tag('h5', $this->headline), 'widget-head');
			$divWidget->append($div);
		}

		$divWidget->append($strOutTable);

		return $divWidget->toString();

	}



}