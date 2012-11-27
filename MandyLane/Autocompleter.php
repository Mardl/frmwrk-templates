<?php

namespace Templates\MandyLane;

use \Templates\Html\Tag;

class Autocompleter extends \Templates\Html\Input
{

	protected $autocompleterSource;

	/**
	 * @param $label
	 * @param array $value
	 * @param bool $required
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $label, $value, $value2, $required=false, $classOrAttributes = array(), $showSecondField = true, $dataValue = 'id')
	{
		parent::__construct($name, $value, $label, $required, $classOrAttributes);

		$this->addClass('autofocus');
		$this->addAttribute('data-autocomplete-rel', $name);
		$this->addAttribute('data-autocomplete-data','value');
		$this->addAttribute('autocomplete', 'off');
		$this->addAttribute('role', 'textbox');
		$this->addAttribute('aria-autocomplete', 'list');
		$this->addAttribute('aria-haspopup', 'true');

		if($showSecondField)
		{
			$autocompleterField2 =  new \Templates\Html\Input($name.'_'.$dataValue,  $value2, $label.' '.strtoupper($dataValue), $required,'text');
		}
		else
		{
			$autocompleterField2 =  new \Templates\Html\Input\Hidden($name.'_'.$dataValue,  $value2, $label.' '.strtoupper($dataValue), $required,'text');
		}

		$autocompleterField2->addAttribute('data-autocomplete-rel', $name);
		$autocompleterField2->addAttribute('data-autocomplete-data',$dataValue);

		$this->append($autocompleterField2);

	}

	public function setAutocompleterSource($source)
	{
		$this->autocompleterSource = $source;
	}


	public function toString()
	{
		$this->addAttribute('data-autocomplete-source', $this->autocompleterSource);
		return parent::toString();
	}

}