<?php

namespace Templates\MandyLane;

class Anchor extends \Templates\Html\Anchor
{

	private $defaultClass = '';

	/**
	 * @param string $href
	 * @param array|string $linkText
	 * @param bool $asButton
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

	public function addForceAjax($operation, $selector='', $options=array()) {
		$this->addAttribute('data-ajax', 'true');
		$this->addAttribute('data-ajax-operation', $operation);
		$this->addAttribute('data-ajax-options', base64_encode(json_encode($options)));
		$this->addAttribute('data-ajax-selector', $selector);
	}
}