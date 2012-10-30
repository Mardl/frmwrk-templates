<?php

namespace Templates\Html;

class Table extends Tag
{

	private $headerRow = array();
	private $footerRow = array();
	private $maxCell = 0;


	/**
	 * @param bool $header
	 * @param array $classOrAttributes
	 */
	public function __construct($classOrAttributes = array())
	{
		parent::__construct('table','',$classOrAttributes);

		if (!$this->hasAttribute('cellpadding'))
		{
			$this->addAttribute('cellpadding','0');
		}
		if (!$this->hasAttribute('cellspacing'))
		{
			$this->addAttribute('cellspacing','0');
		}
		if (!$this->hasAttribute('border'))
		{
			$this->addAttribute('border','0');
		}
	}

	private function setMaxCell(Row $row)
	{
		$max = $row->countValues();

		if ($this->maxCell == 0 || $this->maxCell == $max)
		{
			$this->maxCell = $max;
			return;
		}
		$line = $this->countValues();
		throw new \Templates\Exceptions\Layout('Spaltenanzahl ungültig in (tbody) Row '.($line+1).'. Erste Definition: '.$this->maxCell.' Columns.');
	}

	public function addHeader($row)
	{
		if (is_array($row))
		{
			$newRow = new Row($row);
			$row = $newRow;
		}

		$this->setMaxCell($row);

		$this->headerRow[] = $row;
	}

	public function addFooter($row)
	{
		if (is_array($row))
		{
			$newRow = new Row($row);
			$row = $newRow;
		}

		$this->setMaxCell($row);

		$this->footerRow[] = $row;
	}

	public function addValue($value)
	{
		if (!is_array($value))
		{
			if ($value instanceof Row)
			{
				$this->setMaxCell($value);
				return parent::addValue($value);
			}
			throw new \InvalidArgumentException('AddValue von Table benötigt Instanze von Row');

		}
		$newRow = new Row();
		foreach($value as $row)
		{
			if (is_object($row))
			{
				if ($row instanceof Row)
				{
					$this->setMaxCell($row);
					parent::addValue($row);
					continue;
				}
			}
			$newRow->addValue($row);
		}

		if (!$newRow->hasValue())
		{
			return $this;
		}

		$this->setMaxCell($newRow);
		return parent::addValue($newRow);
	}

	/**
	 * @param int $pos
	 * @return \Templates\Html\Row
	 * @throws \UnexpectedValueException
	 */
	public function getRow($pos = false)
	{
		$allRows = $this->getValue();
		if (is_array($allRows))
		{
			if (false === $pos )
			{
				return $allRows[ count($allRows)-1 ];
			}
			if (isset($allRows[$pos]))
			{
				return $allRows[$pos];
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
	public function setRow($pos,Row $row)
	{
		$allRows= $this->getValue();
		if (is_array($allRows))
		{
			$allRows[$pos] = $row;
			$this->setValue($allRows);
		}

		return $this;
	}

	/**
	 * @param int $column
	 * @param array|string $classOrAttributes
	 */
	public function addAttrColumn($column, $classOrAttributes = array())
	{
		foreach($this->getValue() as $row)
		{
			/**
			 * @var $row \Templates\Html\Row
			 * @var $cell \Templates\Html\Cell
			 */
			$cell = $row->getCell($column);
			if (is_array($classOrAttributes))
			{
				foreach($classOrAttributes as $name => $value)
				{
					$cell->addAttribute($name,$value);
				}
			}
			else
			{
				$cell->addClass($classOrAttributes);
			}
		}
		return $this;
	}

	public function setFormatColumn($column, $sprintfFormat)
	{
		foreach($this->getValue() as $row)
		{
			/**
			 * @var $row \Templates\Html\Row
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
			foreach($this->headerRow as $row)
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
			foreach($this->footerRow as $row)
			{
				$footerRow .= $row;
			}
		}

		$tHead = '';
		if (!empty($headerRow))
		{
			$tHead = '<thead>'.$headerRow.'</thead>';
		}
		$tFoot = '';
		if (!empty($footerRow))
		{
			$tFoot = '<tfoot>'.$footerRow.'</tfoot>';
		}

		$strRow = '<tbody>'.parent::$this->getValueAsString().'</tbody>';

		$this->setValue($tHead.$strRow.$tFoot);

		return parent::toString();
	}



}