<?php

namespace Templates\Srabon;

class Image extends \Templates\Html\Image
{

	private $classes = array();

	public function __construct($src,$altText='',$titleText='', $classOrAttributes = array())
	{
		parent::__construct($src, $altText,$titleText ,  $classOrAttributes);
	}

	public function toString()
	{
		$imageDiv = new \Templates\Html\Tag();
		foreach($this->getAttribute('class',array()) as $class)
		{
			$this->classes[] = $class;
		}
		foreach($this->classes as $class)
		{
			$imageDiv->addClass($class);
		}
		$imageDiv->addClass('image');

		$this->removeAttribute('class');
		$strOut = parent::toString();

		$imageDiv->append($strOut);

		return $imageDiv->toString();
	}
}