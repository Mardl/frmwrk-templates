<?php

namespace Templates\Html;

/**
 * Class Image
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Image extends Tag
{

	/**
	 * @param string $src
	 * @param string $altText
	 * @param string $titleText
	 * @param array  $classOrAttributes
	 */
	public function __construct($src, $altText = '', $titleText = '', $classOrAttributes = array())
	{
		parent::__construct('img', '', $classOrAttributes);
		$this->forceClose = false;

		$this->src($src);
		$alt = empty($altText) ? $titleText : $altText;
		$this->alt($alt);

		$title = empty($titleText) ? $altText : $titleText;
		if (!empty($title))
		{
			$this->title($title);
		}
	}

	/**
	 * @param string $value
	 * @return Tag
	 */
	public function src($value)
	{
		return $this->addAttribute('src', $value);
	}

	/**
	 * @param string $value
	 * @return Tag
	 */
	public function alt($value)
	{
		return $this->addAttribute('alt', $value);
	}

	/**
	 * @param string $value
	 * @return Tag
	 */
	public function title($value)
	{
		return $this->addAttribute('title', $value);
	}

	/**
	 * @param int $value
	 * @return Tag
	 */
	public function width($value)
	{
		return $this->addAttribute('width', $value);
	}

	/**
	 * @param int $value
	 * @return Tag
	 */
	public function heigth($value)
	{
		return $this->addAttribute('height', $value);
	}
}