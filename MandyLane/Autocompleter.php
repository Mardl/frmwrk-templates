<?php

namespace Templates\MandyLane;

use \Templates\Html\Tag;

class Autocompleter extends \Templates\Html\Input
{

	protected $autocompleterSource;

	/**
	 * @param string $name
	 * @param string $label
	 * @param string $valueSearchField
	 * @param bool $valueDataValue
	 * @param bool $required
	 * @param array $classOrAttributes
	 * @param bool $showDataField
	 * @param string $dataValue
	 */
	public function __construct($name, $label, $valueSearchField, $valueDataValue, $required=false, $classOrAttributes = array(), $showDataField = true, $dataValue = 'id')
	{
		parent::__construct($name, $valueSearchField, $label, $required, $classOrAttributes);

		$this->addClass('autofocus');
		$this->addAttribute('data-autocomplete-rel', $name);
		$this->addAttribute('data-autocomplete-data','value');
		$this->addAttribute('autocomplete', 'off');
		$this->addAttribute('role', 'textbox');
		$this->addAttribute('aria-autocomplete', 'list');
		$this->addAttribute('aria-haspopup', 'true');

		if($showDataField)
		{
			$autocompleterDataField =  new \Templates\Html\Input($name.'_'.$dataValue,  $valueDataValue, $label.' '.strtoupper($dataValue), $required,'text');
		}
		else
		{
			$autocompleterDataField =  new \Templates\Html\Input\Hidden($name.'_'.$dataValue,  $valueDataValue, $label.' '.strtoupper($dataValue), $required,'text');
		}

		$autocompleterDataField->addAttribute('data-autocomplete-rel', $name);
		$autocompleterDataField->addAttribute('data-autocomplete-data',$dataValue);

		$this->append($autocompleterDataField);

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