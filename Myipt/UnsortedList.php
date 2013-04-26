<?php

namespace Templates\Myipt;

use	Templates\Html\Tag;

class UnsortedList extends Tag
{
	/**
	 * @var \Templates\Html\Tag
	 */
	protected $content = null;



	public function __construct($headerText='', $value=array(), $classOrAttributes = array())
	{
		parent::__construct('ul', '', $classOrAttributes);

		foreach ($value as $val){
			$this->append($val);
		}
	}

	public function append($value)
	{
		$tag = new Tag('li', $value);
		parent::append($tag);
		return $tag;
	}

	public function prepend($value)
	{
		$tag = new Tag('li', $value);
		parent::prepend($tag);
		return $tag;
	}

}
