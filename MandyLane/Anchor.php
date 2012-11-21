<?php

namespace Templates\MandyLane;

class Anchor extends \Templates\Html\Anchor
{

	private $defaultClass = '';
	/**
	 * @param $href
	 * @param array|string $linkText
	 * @param array $classOrAttributes
	 */
	public function __construct($href,$linkText, $asButton = false, $classOrAttributes = array())
	{
		parent::__construct('a',$linkText,$classOrAttributes);
		$this->setHref($href);

		$this->defaultClass = $classOrAttributes;

		if ($asButton)
		{
			$this->asButton();
		}
	}

	public function asButton()
	{
		$this->addClass('iconlink');
	}
}