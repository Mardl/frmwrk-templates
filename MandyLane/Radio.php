<?php

namespace Templates\MandyLane;

class Radio extends \Templates\Html\Input\Radio
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
	public function __construct($name, $value='', $opt= array(),$required=false, $placeholder='',  $classOrAttributes = array(), $showLabel = true)
	{
		parent::__construct($name, $value, $opt,$required, $placeholder='',  $classOrAttributes);
		$this->setShowLabel($showLabel);

	}

	public function toString()
	{
		parent::set('');
		$count=0;
		$arRadios = array();
		$options = parent::getOptions();

		foreach ($options as $option)
		{
			$count++;
			$radio = new \Templates\Html\Input( $this->getName(), $option[0], $option[1], $this->isRequired(), 'radio' );
			$radio->setId( $this->getName().'-'.$count );
			$radio->addClass('radio-label'.'-'.$option[0]);
			$radio->addAttribute('title',ucfirst($option[0]));
			if ($option[2])
			{
				$radio->addAttribute('checked','checked');
			}

			$label = '';
			if($this->getShowLabel())
			{
				$label = $radio->getAttribute('placeholder','');
			}

			$span = new \Templates\Html\Tag('span', $label);
			$span->addClass('radio-label');
			$span->addClass('radio-label'.'-'.$option[0]);

			if(empty($label))
			{
				$span->addClass('radio-label-notext');
			}

			$radio->append($span);

			$arRadios[] = $radio;
		}

		$strOut = '';
		foreach($arRadios as $radio)
		{
			$strOut .= $radio->toString();
		}
		return $strOut;
	}

	public function setShowLabel($showLabel)
	{
		$this->showLabel = $showLabel;
	}

	public function getShowLabel()
	{
		return $this->showLabel;
	}

}