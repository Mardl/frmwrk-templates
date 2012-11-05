<?php

namespace Templates\Html;

class Anchor extends Tag
{
	/**
	 * @param $href
	 * @param array|string $linkText
	 * @param array $classOrAttributes
	 */
	public function __construct($href,$linkText, $classOrAttributes = array())
	{
		parent::__construct('a',$linkText,$classOrAttributes);

		$this->setHref($href);
	}

	/**
	 * @param $value
	 * @return Tag
	 */
	public function setHref($value)
	{
		return $this->addAttribute('href', $value);
	}

	/**
	 * @return string
	 */
	public function getHref()
	{
		return $this->getAttribute('href','');
	}

	/**
	 * @return Tag
	 */
	public function external()
	{
		return $this->addAttribute('target', '_blank');
	}
}