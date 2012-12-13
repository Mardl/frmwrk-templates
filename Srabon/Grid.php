<?php

namespace Templates\Srabon;

use Templates\Html\Tag,
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
		$col = new Tag('div','','span' . $width);
		$this->cols[] = $col;
		parent::append($col);
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
		throw new LayoutException(translate('Die Spalte %s existiert nicht.', $key));
	}

	public function addContent($key, $value)
	{
		$col = $this->getCol($key);
		/** @var $col Div */
		$col->append($value);
	}

	public function append($value)
	{
		$col = $this->initCol(12);
		$col->append($value);
	}
}
