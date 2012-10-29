<?php

namespace Templates\Html;

class Image extends Tag
{
	public function __construct($src,$altText='',$titleText='', $classOrAttributes = array())
	{
		parent::__construct('img', '', $classOrAttributes);
		$this->forceClose = true;

		$this->src($src);
		$this->alt( empty($altText) ? $titleText : $altText );
		$this->title( empty($titleText) ? $altText : $titleText );
	}

	public function src($value)
	{
		return $this->addAttribute('src', $value);
	}

	public function alt($value)
	{
		return $this->addAttribute('alt', $value);
	}

	public function title($value)
	{
		return $this->addAttribute('title', $value);
	}

	public function width($value)
	{
		return $this->addAttribute('width', $value);
	}

	public function heigth($value)
	{
		return $this->addAttribute('height', $value);
	}
}