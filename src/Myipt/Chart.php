<?php

namespace Templates\Myipt;

/**
 * Class Chart
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Chart extends \Templates\Html\Tag
{

	/**
	 * @param string  $chartData
	 * @param array   $type
	 * @param array   $classOrAttributes
	 * @param boolean $landscape
	 */
	public function __construct($chartData, $type, $classOrAttributes = array(), $landscape = false)
	{
		parent::__construct('canvas', '', $classOrAttributes);

		if(empty($chartData))
		{
			return;
		}

		$this->addClass('chart');


		if ($landscape)
		{
			$this->addAttribute('data-landscape', true);
		}

		$this->addAttribute('data-value-rel',       $chartData['value']['rel']);
		$this->addAttribute('data-value-rel-max',   $chartData['max']['rel']);
		$this->addAttribute('data-value-abs',       $chartData['value']['abs']);
		$this->addAttribute('data-value-abs-max',   $chartData['max']['abs']);
		$this->addAttribute('data-zvalue',          ($chartData['value']['zindex'] != null) ? $chartData['value']['zindex'] : 1);
		$this->addAttribute('data-title',           $chartData['title']);
		$this->addAttribute('data-c-red-rel',       $chartData['percent']['rel']['orange']);
		$this->addAttribute('data-c-orange-rel',    $chartData['percent']['rel']['green']);
		$this->addAttribute('data-c-red-abs',       $chartData['percent']['abs']['orange']);
		$this->addAttribute('data-c-orange-abs',    $chartData['percent']['abs']['green']);
		$this->addAttribute('data-stops-red',       $chartData['stops']['red']);
		$this->addAttribute('data-stops-green',     $chartData['stops']['green']);
		$this->addAttribute('data-stops-orange',    $chartData['stops']['orange']);
		$this->addAttribute('data-legend-red',      $chartData['legend']['red']);
		$this->addAttribute('data-legend-orange',   $chartData['legend']['orange']);
		$this->addAttribute('data-legend-green',    $chartData['legend']['green']);
		$this->addAttribute('data-unit-rel',        '%');
		$this->addAttribute('data-unit-abs',        $chartData['unit']);


		$this->setId($chartData['id'].$type);
		$this->setType($type);
		$this->setHeight(168);
		$this->setWidth(228);
	}

	/**
	 * @param int $value
	 * @return \Templates\Html\Tag|void
	 */
	public function setId($value)
	{
		$this->addAttribute('id', $value);
		$this->addAttribute('data-rel', $value);
	}

	/**
	 * @param int $value
	 * @return void
	 */
	public function setWidth($value = 228)
	{
		$this->addAttribute('width', $value);
	}

	/**
	 * @param int $value
	 * @return void
	 */
	public function setHeight($value = 168)
	{
		$this->addAttribute('height', $value);
	}

	/**
	 * @param string $value
	 * @return void
	 */
	public function setType($value = 'rel')
	{
		$this->addAttribute('data-type', $value);
	}

	/**
	 * soll der Value der Chart hinter der Chart angezeigt werden
	 * @param string $value
	 * @return void
	 */
	public function setDataRel($value)
	{
		$this->setId($value);
	}

	/**
	 * soll in der Chart die darüberliegende Beschriftung angezeigt werden
	 * @param bool $value
	 * @return void
	 */
	public function setShowMainValues($value)
	{
		$this->addAttribute('data-show-main-values', $value);
	}

	/**
	 * soll der Value der Chart hinter der Chart angezeigt werden
	 * @param bool $value
	 * @return void
	 */
	public function setHorizontalView($value)
	{
		$this->addAttribute('data-horizontalview', $value);
	}
}