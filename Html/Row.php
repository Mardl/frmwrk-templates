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
				$this->addCell($column);
			}
		}

		if($header)
		{
			$this->header();
		}

	}

	public function header()
	{
		$this->header = true;
	}

	public function addCell($cell, $classOrAttributes = array())
	{
		if ($cell instanceof \Templates\Html\Cell)
		{
			return parent::append($cell);
		}

		$cellNew = new  \Templates\Html\Cell($cell,$this->header, $classOrAttributes);
		return parent::append($cellNew);
	}

	/**
	 * @param int $pos
	 * @return \Templates\Html\Cell
	 * @throws \UnexpectedValueException
	 */
	public function getCell($pos)
	{
		$allCells = $this->getInner();
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
		$allCells= $this->getInner();
		if (is_array($allCells))
		{
			$allCells[$pos] = $cell;
		}

		return $this;
	}


	public function toString()
	{
		if ($this->header)
		{
			foreach($this->tagInner as $cell)
			{
				if ($cell instanceof \Templates\Html\Cell)
				{
					$cell->header();
				}

			}
		}

		return parent::toString();
	}

}