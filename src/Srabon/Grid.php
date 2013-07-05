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

	/**
	 * @param null $preset
	 * @param array $classOrAttributes
	 */
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

	/**
	 * @param int $width
	 * @return \Templates\Html\Tag
	 */
	private function initCol($width)
	{
		$col = new Tag('div','','span' . $width);
		$this->cols[] = $col;
		parent::append($col);
		return $col;
	}

	/**
	 * @param int $key
	 * @return bool
	 */
	public function hasCol($key)
	{
		return array_key_exists($key, $this->cols);
	}

	/**
	 * @param int $key
	 * @return mixed
	 * @throws \Templates\Exceptions\Layout
	 */
	public function getCol($key)
	{
		if($this->hasCol($key))
		{
			return $this->cols[$key];
		}
		throw new LayoutException(translate('Die Spalte %s existiert nicht.', $key));
	}

	/**
	 * @param int $key
	 * @param mixed $value
	 */
	public function addContent($key, $value)
	{
		$col = $this->getCol($key);
		/** @var $col Div */
		$col->append($value);
	}

	/**
	 * @param mixed $value
	 * @return \Templates\Html\Tag|void
	 */
	public function append($value)
	{
		$col = $this->initCol(12);
		$col->append($value);
	}
}
