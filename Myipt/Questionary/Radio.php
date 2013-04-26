<?php

namespace Templates\Myipt\Questionary;

class Radio extends \Templates\Html\Tag
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
	public function __construct($id, $name, $value='', $text, $radioid, $checked = false, $classOrAttributes = array())
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

		$radio = new \Templates\Html\Tag('input');
		$radio->addAttribute('type', 'radio');
		$radio->addAttribute('id', $id);
		$radio->addAttribute('name', $name);
		$radio->addAttribute('value', $value);
		$radio->addAttribute('data-group', $radioid);

		if ($checked){
			$radio->addAttribute('checked', 'checked');
		}

		$this->append($radio);



	}


}