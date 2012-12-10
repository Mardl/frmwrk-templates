<?php

namespace Templates\Srabon;

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
		parent::__construct($href,$linkText,$classOrAttributes);
		$this->setHref($href);

		$this->defaultClass = $classOrAttributes;

		if ($asButton)
		{
			$this->asButton();
		}
	}

	public function asButton()
	{
		$this->addClass('btn');
		$this->addClass('btn-inverse');

		if (empty($this->defaultClass))
		{
			$this->addClass('btn-mini');
		}
	}
}