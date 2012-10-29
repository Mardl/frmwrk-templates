<?php

namespace Templates\Srabon;

use Templates\Html\Tag,
	Templates\Html\Div,
	Templates\Exceptions\Layout as LayoutException;

class Grid extends Tag
{
	/**
	 * @var array
	 */
	protected $cols = array();

	public function __construct($preset=null, $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);

		$this->addClass('row-fluid');

		if(is_array($preset))
		{
			foreach($preset as $width)
			{
				$this->initCol($width);
			}
		}
	}

	private function initCol($width)
	{
		$col = new Div();
		$col->addClass('span' . $width);
		$this->cols[] = $col;
		parent::addValue($col);
		return $col;
	}

	public function hasCol($key)
	{
		return array_key_exists($key, $this->cols);
	}

	public function getCol($key)
	{
		if($this->hasCol($key))
		{
			return $this->cols[$key];
		}
		throw new LayoutException("Die Spalte $key existiert nicht.");
	}

	public function addContent($key, $value)
	{
		$col = $this->getCol($key);
		/** @var $col Div */
		$col->addValue($value);
	}

	public function setValue($value)
	{
		$col = $this->initCol(12);
		$col->addValue($value);
	}

	public function addValue($value)
	{
		$this->setValue($value);
	}
}
