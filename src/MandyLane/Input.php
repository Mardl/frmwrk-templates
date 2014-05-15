<?php

namespace Templates\MandyLane;

/**
 * Class Input
 * @package Templates\MandyLane
 */
class Input extends \Templates\Html\Input
{
	/**
	 * @var string
	 */
	protected $onBlur = '';

	/**
	 * @param bool $value
	 */
	public function setAutofocus($value = true)
	{
		if($value)
		{
			$this->addClass('autofocus');
		}
		else
		{
			$this->removeClass('autofocus');
		}
	}

	/**
	 * @param string $step
	 * @return void
	 */
	public function setStep($step)
	{
		$this->addAttribute('step', $step);
	}

	/**
	 * @param string $url
	 * @return void
	 */
	public function onBlur($url)
	{
		$this->onBlur = $url;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		if(!empty($this->onBlur))
		{
			$this->addJsFile('/static/js/custom/mandy/inputOnBlur.js');
			$this->addAttribute('data-on-blur-url', $this->onBlur);
		}
		return parent::toString();
	}
}