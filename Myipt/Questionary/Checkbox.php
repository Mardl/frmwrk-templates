<?php

namespace Templates\Myipt\Questionary;

class Checkbox extends \Templates\Html\Tag
{

	protected $showLabel;

	/**
	 * @param string $name
	 * @param string $value
	 * @param array $opt
	 * @param bool $required
	 * @param string $placeholder
	 * @param array $classOrAttributes
	 * @param bool $showLabel
	 */
	public function __construct($id, $name, $value='', $text, $checked = false, $classOrAttributes = array())
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "questRadio";
		} else {
			$classOrAttributes .= " questRadio";
		}

		parent::__construct('label', '', $classOrAttributes);
		$this->addAttribute('data-rel', $id);
		$this->addAttribute('for', $id);

		$table = new \Templates\Html\Tag("table", "<tr><td>{$text}</td></tr>");
		$this->append($table);

		$checkbox = new \Templates\Html\Tag('input');
		$checkbox->addAttribute('type', 'checkbox');
		$checkbox->addAttribute('id', $id);
		$checkbox->addAttribute('name', $name);
		$checkbox->addAttribute('value', $value);

		if ($checked){
			$checkbox->addAttribute('checked', 'checked');
		}

		$this->append($checkbox);



	}


}