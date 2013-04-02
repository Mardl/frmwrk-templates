<?php

namespace Templates\MandyLane;

/**
 * Class Input
 * @package Templates\MandyLane
 */
class Input extends \Templates\Html\Input
{
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

}