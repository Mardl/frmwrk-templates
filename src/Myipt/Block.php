<?php

namespace Templates\Myipt;

/**
 * Class Block
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Block extends \Templates\Html\Tag
{

	/**
	 * @param string $typ
	 * @param array  $classOrAttributes
	 */
	public function __construct($typ, $classOrAttributes = array())
	{
		parent::__construct($typ, '', $classOrAttributes);
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @param string $label
	 * @param array  $classOrAttributes
	 * @param string $placeholder
	 * @param bool   $required
	 * @param string $type
	 * @return void
	 */
	public function addLabeldInput($name, $value, $label, $classOrAttributes = array(), $placeholder = '', $required = false, $type = 'text')
	{
		$label = new \Templates\Html\Tag('label', $label);
		$label->addAttribute('for', $name);

		$input = new \Templates\Html\Input($name, $value, $placeholder, $required, $type, $classOrAttributes);
		$input->addAttribute('id', $name);

		$this->append($label);
		$this->append($input);
	}

	/**
	 * Aufbau des Selects-Array
	 * array
	 * (
	 * 		array
	 * 		(
	 * 			"name"		=> string,
	 * 			"class" 	=> string,
	 * 			"required"	=> boolean,
	 * 			"options"	=> array
	 * 			(
	 * 				array(
	 * 					"value" => string,
	 * 					"tag" => string,
	 * 					"selected" => boolean | null,
	 * 					"optgroup" => string | null
	 * 				)
	 * 				...
	 * 			)
	 * 		)
	 * 		...
	 * )
	 *
	 *
	 * @param \Templates\Html\Tag $container
	 * @param String $label
	 * @param array $selects
	 *
	 * @return array
	 */
	public function addSelects($label, array $selects)
	{
		if (!empty($label))
		{
			$label = new \Templates\Html\Tag('label', $label);
			$this->append($label);
		}

		$selectBoxes = array();

		foreach ($selects as $box)
		{
			$value = '';
			foreach ($box['options'] as $opt)
			{
				if(isset($opt["selected"]) && $opt["selected"]==true)
				{
					$value = $opt["value"];
				}
			}

			$select = new \Templates\Html\Input\Select($box['name'], $value, array(), $box['required'], '', $box['class']);

			if (isset($box["id"]))
			{
				$select->addAttribute("id", $box["id"]);
			}

			foreach ($box['options'] as $opt)
			{
				if(isset($opt['optgroup']) && ($opt['optgroup'] != null))
				{
					$select->addOptionGrouped($opt["value"], $opt["tag"], $opt["optgroup"], (isset($opt["selected"]))?$opt["selected"]:false);
				}
				else
				{
					$select->addOption($opt["value"], $opt["tag"], (isset($opt["selected"]))?$opt["selected"]:false);
				}
			}
			$this->append($select);
			$selectBoxes[] = $select;
		}

		return $selectBoxes;
	}
}
