<?php

namespace Templates\Srabon;

class Image extends \Templates\Html\Image
{

	public function __construct($src,$altText='',$titleText='', $classOrAttributes = array())
	{
		parent::__construct($src, $altText,$titleText ,  $classOrAttributes);
	}

	public function toString()
	{
		$imageDiv = new \Templates\Html\Tag();
		foreach($this->getAttribute('class',array()) as $class)
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