<?php

namespace Templates\MandyLane;

use \Templates\Html\Tag;

class Autocompleter extends \Templates\Html\Input
{

	protected $autocompleterSource;
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
	 *
	 * @todo: refactoring $showDataFieldURL
	 */
	public function __construct($name, $label, $valueSearchField, $valueDataValue, $required=false, $classOrAttributes = array(), $showDataFieldUrl = true, $dataValue = 'id', $autocompleterFiles = false)
	{
		parent::__construct($name, $valueSearchField, $label, $required, $classOrAttributes);

		$this->autcompleterFiles = $autocompleterFiles;
		$autocompleterDataField2 = '';


		$this->addClass('autofocus');

		$this->addAttribute($this->getClassTag().'rel', $name);
		$this->addAttribute($this->getClassTag().'data','value');
		$this->addAttribute('autocomplete', 'off');
		$this->addAttribute('role', 'textbox');
		$this->addAttribute('aria-autocomplete', 'list');
		$this->addAttribute('aria-haspopup', 'true');

		if($showDataFieldUrl)
		{
			if ($showDataFieldUrl === true)
			{
				$autocompleterDataField =  new \Templates\Html\Input($name.'_'.$dataValue,  $valueDataValue, $label.' '.strtoupper($dataValue), $required,'text');
			}
			else
			{
				$autocompleterDataField2 = new \Lifemeter\Templates\AnchorObjectQuickinfo($showDataFieldUrl,  $valueDataValue, false);
				$autocompleterDataField =  new \Templates\Html\Input\Hidden($name.'_'.$dataValue,  $valueDataValue, $label.' '.strtoupper($dataValue), $required,'text');
			}
		}
		else
		{
			$autocompleterDataField =  new \Templates\Html\Input\Hidden($name.'_'.$dataValue,  $valueDataValue, $label.' '.strtoupper($dataValue), $required,'text');
		}

		$autocompleterDataField->addAttribute($this->getClassTag().'data',$dataValue);
		$autocompleterDataField->addAttribute($this->getClassTag().'rel', $name);


		$this->append(array($autocompleterDataField,$autocompleterDataField2));

	}

	public function setAutocompleterSource($source)
	{
		$this->autocompleterSource = $source;
	}


	public function toString()
	{
		$this->addAttribute($this->getClassTag(false).'source', $this->autocompleterSource);
		return parent::toString();
	}


	private function getClassTag($files = true)
	{
		if($this->autcompleterFiles)
		{
			if(!$files)
			{
				return 'data-autocomplete-file-';
			}
			return 'data-autocomplete-files-';
		}

		return 'data-autocomplete-';
	}


}