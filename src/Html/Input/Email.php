<?php
namespace Templates\Html\Input;

/**
 * Class Email
 *
 * @category Templates
 * @package  Templates\Html\Input
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Email extends \Templates\Html\Input
{

	/**
	 * @return bool|string
	 */
	public function validate()
	{
		$val = $this->getValue();

		if ($this->isRequired() && empty($val))
		{
			return "Fehlende Eingabe für " . $this->getErrorLabel();
		}
		else
		{
			if (!empty($val))
			{
				if (!filter_var($val, FILTER_VALIDATE_EMAIL))
				{
					return "Die Emailadresse wird als ungültig angesehen";
				}
			}
		}

		return true;
	}

}