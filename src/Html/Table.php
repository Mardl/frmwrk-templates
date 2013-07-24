<?php

namespace Templates\Html;

class Table extends Tag
{

	protected $headerRow = array();
	protected $footerRow = array();
	protected $maxCell = 0;

	/**
	 * @var \Templates\Html\Row
	 */
	private $rowClass;

	/**
	 * @param array  $classOrAttributes
	 * @param string $rowNamespace
	 */
	public function __construct($classOrAttributes = array(), $rowNamespace = '\Templates\Html\Row')
	{
		parent::__construct('table', '', $classOrAttributes);

		$this->rowClass = $rowNamespace;

		if (!$this->hasAttribute('cellpadding'))
		{
			$this->addAttribute('cellpadding', '0');
		}
		if (!$this->hasAttribute('cellspacing'))
		{
			$this->addAttribute('cellspacing', '0');
		}
		if (!$this->hasAttribute('border'))
		{
			$this->addAttribute('border', '0');
		}
	}

	private function countCell()
	{

	}

	private function setMaxCell(Row $row)
	{
		$max = 0;
		foreach ($row->getInner() as $cell)
		{
			$max += $cell->getColspan();
		}

		if ($this->maxCell == 0 || $this->maxCell == $max)
		{
			$this->maxCell = $max;

			return;
		}
		throw new \Templates\Exceptions\Layout('Spaltenanzahl ungültig in (tbody) Row ' . ($max + 1) . '. Erste Definition: ' . $this->maxCell . ' Columns.');
	}

	public function addHeader($row)
	{
		if (is_array($row))
		{
			$newRow = new $this->rowClass($row, true);
		}
		else
		{
			$newRow = $row;
		}

		$this->setMaxCell($newRow);
		$this->headerRow[] = $newRow;
	}

	public function addFooter($row)
	{
		if (is_array($row))
		{
			$newRow = new $this->rowClass($row);
			$row = $newRow;
		}

		$this->setMaxCell($row);

		$this->footerRow[] = $row;
	}

	/**
	 * @param $value
	 * @return Table|Tag
	 * @throws \InvalidArgumentException
	 */
	public function addRow($value)
	{
		if (!is_array($value))
		{
			if ($value instanceof \Templates\Html\Row)
			{
				$this->setMaxCell($value);

				return parent::append($value);
			}
			throw new \InvalidArgumentException('addRow von Table benötigt Instanze von Row');

		}
		$newRow = new $this->rowClass();
		foreach ($value as $rowOrCell)
		{
			if (is_object($rowOrCell))
			{
				if ($rowOrCell instanceof \Templates\Html\Row)
				{
					$this->addRow($rowOrCell);
					continue;
				}
			}
			$newRow->addCell($rowOrCell);
		}

		if (!$newRow->hasInner())
		{
			return $this;
		}

		$this->setMaxCell($newRow);

		return parent::append($newRow);
	}

	/**
	 * @param bool $pos
	 * @return mixed
	 * @throws \UnexpectedValueException
	 * @throws \InvalidArgumentException
	 */
	public function getRow($pos = false)
	{
		$allRows = $this->getInner();
		if (is_array($allRows))
		{
			if (false === $pos)
			{
				return $allRows[count($allRows) - 1];
			}
			if (isset($allRows[$pos]))
			{
				return $allRows[$pos];
			}

			throw new \InvalidArgumentException('Keine Zeile auf Position ' . $pos . ' vorhanden!');
		}

		throw new \UnexpectedValueException('Keine Rows gesetzt!');

	}

	/**
	 * @param int $pos
	 * @param Row $row
	 * @return \Templates\Html\Table
	 */
	public function setRow($pos, Row $row)
	{

		$allRows = $this->getInner();
		if (is_array($allRows))
		{
			$this->removeInner();
			foreach ($allRows as $key => $value)
			{
				if ($key == $pos)
				{
					$this->append($row);
					continue;
				}
				$this->append($value);
			}
		}

		return $this;
	}

	/**
	 * @param int          $column
	 * @param array|string $classOrAttributes
	 * @param bool         $headrows
	 * @return \Templates\Html\Table
	 */
	public function addAttrColumn($column, $classOrAttributes = array(), $headrows = false)
	{
		$dataArray = $headrows ? $this->headerRow : $this->getInner();

		foreach ($dataArray as $row)
		{
			$this->setRowAttributes($column, $row, $classOrAttributes);
		}

		return $this;
	}


	public function formatColumn($column, $sprintfFormat)
	{
		foreach ($this->getInner() as $row)
		{
			/**
			 * @var $row  \Templates\Html\Row
			 * @var $cell \Templates\Html\Cell
			 */
			$cell = $row->getCell($column);
			$cell->setFormat($sprintfFormat);
		}

		return $this;
	}

	public function toString()
	{
		$headerRow = '';
		if (!empty($this->headerRow))
		{
			foreach ($this->headerRow as $row)
			{
				if ($row instanceof Row)
				{
					$row->header();
				}
				$headerRow .= $row;
			}
		}
		$footerRow = '';
		if (!empty($this->footerRow))
		{
			foreach ($this->footerRow as $row)
			{
				$footerRow .= $row;
			}
		}

		$tHead = '';
		if (!empty($headerRow))
		{
			$tHead = '<thead>' . $headerRow . '</thead>';
		}
		$tFoot = '';
		if (!empty($footerRow))
		{
			$tFoot = '<tfoot>' . $footerRow . '</tfoot>';
		}

		$strRow = '<tbody>' . parent::$this->getInnerAsString() . '</tbody>';

		$this->set($tHead . $strRow . $tFoot);

		return parent::toString();
	}

	/**
	 * @param int          $column
	 * @param              $row
	 * @param array|string $classOrAttributes
	 * @return \Templates\Html\Table
	 */
	private function setRowAttributes($column, $row, $classOrAttributes = array())
	{
		/**
		 * @var $row  \Templates\Html\Row
		 * @var $cell \Templates\Html\Cell
		 */
		$cell = $row->getCell($column);
		if (is_array($classOrAttributes))
		{
			foreach ($classOrAttributes as $name => $value)
			{
				$cell->addAttribute($name, $value);
			}
		}
		else
		{
			$cell->addClass($classOrAttributes);
		}

		return $this;
	}
}
