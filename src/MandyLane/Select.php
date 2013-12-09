<?php

namespace Templates\MandyLane;

class Select extends \Templates\Html\Input\Select
{

	/**
	 * @var string
	 */
	protected $onChange = '';


	/**
	 * @param $url
	 * @return void
	 */
	public function onChange($url)
	{
		$this->onChange = $url;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		if(!empty($this->onChange))
		{
			$this->addJsFile('/static/js/custom/mandy/selectOnChange.js');
			$this->addAttribute('data-on-change-url', $this->onChange);
		}

		return parent::toString();
	}


}