<?php

namespace Templates\MandyLane;

use \Templates\Html\Tag;

class Choosedialog extends \Templates\Html\Input
{

	protected $dataSource;

	public function __construct($name, $label, $dataSource, $valueName, $valueDataValue, $required=false, $classOrAttributes = array(), $showData = true, $dataValue = 'id')
	{
		parent::__construct($name, $valueName, $label, $required, $classOrAttributes);

		$this->addAttribute('data-choosedialog-rel', $name);
		$this->addAttribute('data-choosedialog-datafield','value');
		$this->addAttribute('readonly', 'readonly');

		if($showData)
		{
			$choosenDataField =  new \Templates\Html\Input($name.'_'.$dataValue,  $valueDataValue, $label.' '.strtoupper($dataValue), $required,'text');
		}
		else
		{
			$choosenDataField  =  new \Templates\Html\Input\Hidden($name.'_'.$dataValue,  $valueDataValue, $label.' '.strtoupper($dataValue), $required,'text');
		}

		$choosenDataField->addAttribute('data-choosedialog-rel', $name);
		$choosenDataField->addAttribute('data-choosedialog-datafield',$dataValue);
		$choosenDataField->addAttribute('readonly', 'readonly');

		$button = new Anchor($name.'_chooser','...');
		$button->addClass('iconlink');
		$button->addClass('choosedialog');
		$button->addClass('chooserbutton');
		$button->addAttribute('data-choosedialog-rel', $name);
		$button->addAttribute('data-choosedialog-source', $dataSource);

		$buttonclear = new Anchor($name.'_chooser_clear','X');
		$buttonclear->addClass('iconlink');
		$buttonclear->addClass('chooseclear');
		$buttonclear->addClass('chooserbutton');
		$buttonclear->addAttribute('data-choosedialog-rel', $name);

		$this->append(array($choosenDataField, $button, $buttonclear));
	}

	public function setAutocompleterSource($source)
	{
		$this->dataSource = $source;
	}

	public function toString()
	{
		$this->addAttribute('data-choosedialog-source', $this->dataSource);
		return parent::toString();
	}
}