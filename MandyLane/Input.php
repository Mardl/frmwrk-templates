<?php

namespace Templates\MandyLane;

class Input extends \Templates\Html\Input
{

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