<?php

namespace Templates\Html;

class Row extends Tag
{

	private $header = false;

	/**
	 * @param bool $header
	 * @param array $classOrAttributes
	 */
	public function __construct(array $values=array(), $header=false,$classOrAttributes = array())
	{
		parent::__construct('tr','',$classOrAttributes);

		if (!empty($values))
		{
			foreach ($values as $column)
			{
				$this->addValue($column);
			}
		}

	}


	public function header()
	{
		$this->header = true;
	}

	public function addValue($cell)
	{
		if ($cell instanceof Cell)
		{
			return parent::addValue($cell);
		}

		$cellNew = new Cell($cell,$this->header);

		return parent::addValue($cellNew);
	}

	/**
	 * @param int $pos
	 * @return \Templates\Html\Cell
	 * @throws \UnexpectedValueException
	 */
	public function getCell($pos)
	{
		$allCells = $this->getValue();
		if (is_array($allCells))
		{
			if (isset($allCells[$pos]))
			{
				return $allCells[$pos];
			}

			throw new \InvalidArgumentException('Keine Zeile auf Position '.$pos.' vorhanden!');
		}

		throw new \UnexpectedValueException('Keine Rows gesetzt!');

	}

	/**
	 * @param int $pos
	 * @param Row $row
	 * @return Table
	 */
	public function setCell($pos,Cell $cell)
	{
		$allCells= $this->getValue();
		if (is_array($allCells))
		{
			$allCells[$pos] = $cell;
			$this->setValue($allCells);
		}

		return $this;
	}


	public function toString()
	{
		if ($this->header)
		{
			foreach($this->tagValue as $cell)
			{
				if ($cell instanceof Cell)
				{
					$cell->header();
				}

			}
		}

		return parent::toString();
	}

}