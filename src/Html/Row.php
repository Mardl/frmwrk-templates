<?php

namespace Templates\Html;

/**
 * Class Row
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Row extends Tag
{

	/**
	 * @var bool
	 */
	private $header = false;

	/**
	 * @param array $values
	 * @param bool  $header
	 * @param array $classOrAttributes
	 */
	public function __construct(array $values = array(), $header = false, $classOrAttributes = array())
	{
		parent::__construct('tr', '', $classOrAttributes);

		if (!empty($values))
		{
			foreach ($values as $column)
			{
				$this->addCell($column);
			}
		}

		if ($header)
		{
			$this->header();
		}
	}

	/**
	 * @return void
	 */
	public function header()
	{
		$this->header = true;
	}

	/**
	 * @param Cell|string $cell
	 * @param array       $classOrAttributes
	 * @return Tag
	 */
	public function addCell($cell, $classOrAttributes = array())
	{
		if ($cell instanceof \Templates\Html\Cell)
		{
			return parent::append($cell);
		}

		$cellNew = new  \Templates\Html\Cell($cell, $this->header, $classOrAttributes);

		return parent::append($cellNew);
	}

	/**
	 * @param int $pos
	 * @return mixed
	 * @throws \UnexpectedValueException
	 * @throws \InvalidArgumentException
	 */
	public function getCell($pos)
	{
		$allCells = $this->getInner();
		if (isset($allCells[$pos]))
		{
			return $allCells[$pos];
		}

		throw new \InvalidArgumentException('Keine Zeile auf Position ' . $pos . ' vorhanden!');
	}

	/**
	 * @param int  $pos
	 * @param Cell $cell
	 * @return Row
	 */
	public function setCell($pos, Cell $cell)
	{
		$allCells = $this->getInner();
		if (is_array($allCells))
		{
			$this->removeInner();
			foreach ($allCells as $key => $value)
			{
				if ($key == $pos)
				{
					$this->append($cell);
					continue;
				}
				$this->append($value);
			}
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		if ($this->header)
		{
			foreach ($this->tagInner as $cell)
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