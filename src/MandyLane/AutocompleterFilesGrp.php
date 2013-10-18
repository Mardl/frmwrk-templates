<?php

namespace Templates\MandyLane;


class AutocompleterFilesGrp extends \Templates\MandyLane\ControlGroup
{

	protected $autcompleterFiles = false;

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
	public function __construct($name, $label, $valueSearchField, $valueDataValue, $required=false, $classOrAttributes = array(), $showDataField = true, $dataValue = 'id', $file_path = '')
	{
		$this->autcompleterFiles =  new Autocompleter($name, $label, $valueSearchField, $valueDataValue, $required, $classOrAttributes, $showDataField, $dataValue,true);

		$image = '';
		$imageGrp = '';
		if($valueDataValue > 0 && !empty($file_path))
		{
			$image = new \Templates\Html\Image($file_path, $valueSearchField);
			$imageGrp = new \Templates\MandyLane\ControlGroup(' ', $image);
		}

		if($valueDataValue > 0 && empty($file_path))
		{
			$image = new \Templates\Html\Tag('span', 'keine Vorschau vorhanden!');
			$imageGrp = new \Templates\MandyLane\ControlGroup(' ', $image);
		}

		parent::__construct($label, array($this->autcompleterFiles, $imageGrp));


	}

	public function setAutocompleterSource($autocompleterSource)
	{
		$this->autcompleterFiles->setAutocompleterSource($autocompleterSource);
	}

}