<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Reportfull
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Stefan Orthofer <stefan@dreiwerken.de>
 */
class Reportfull extends \Templates\Myipt\Widget
{

	/**
	 * @var
	 */
	protected $text;
	/**
	 * @var bool
	 */
	protected $fancy = false;

	/**
	 * @param string $analyseData
	 * @param array  $type
	 * @param array  $detaillink
	 * @param bool   $fancy
	 * @param array  $classOrAttributes
	 */
	public function __construct($analyseData, $type, $detaillink, $fancy = false, $classOrAttributes = array())
	{
		$this->fancy = $fancy;

		if (is_array($classOrAttributes))
		{
			$classOrAttributes[] = "colFull";
		}
		else
		{
			$classOrAttributes .= " colFull report";
		}

		parent::__construct($analyseData['title'], null, $classOrAttributes);
		parent::addAttribute("id", $analyseData["id"]);
		$div = new \Templates\Html\Tag("div", '', 'fLeft');

		if (!$analyseData["noChart"])
		{
			if ($type != "both")
			{
				$chart = new \Templates\Myipt\Chart($analyseData, $type);
				$div->append($chart);
			}
			else
			{
				$chartRel = new \Templates\Myipt\Chart($analyseData, 'rel');
				$div->append($chartRel);

				$chartAbs = new \Templates\Myipt\Chart($analyseData, 'abs');
				$div->append($chartAbs);

			}
		}

		$this->content->append($div);

		foreach ($analyseData["outputtexts"] as $index => $text)
		{
			if ($index == 0)
			{
				$p = new \Templates\Html\Tag("p", $text[0]);
				$this->initText($p, $analyseData["noChart"]);
			}
			else
			{
				if (!empty($text[0]))
				{
					$class = ""; //hide";
					if ($this->fancy)
					{
						$class = null;
					}
					$p = new \Templates\Html\Tag("p", $text[0], $class);
					$this->append($p);
				}

			}
		}

		if (!$this->fancy)
		{
			if ($analyseData['value']['zindex'] > 0){
				$this->setFooter("<a href='".$detaillink."' class='fancybox fancybox.ajax'>mehr Informationen</a>");
			}
		}
	}

	/**
	 * @param null $value
	 * @param bool $noChart
	 * @return void
	 */
	protected function initText($value = null, $noChart)
	{
		$this->text = new \Templates\Html\Tag("div", $value, 'fLeft info '.($noChart?'noChart':null));
		$this->content->append($this->text);
	}

	/**
	 * @param mixed $value
	 * @return void
	 */
	public function append($value)
	{
		$this->text->append($value);
	}

	/**
	 * @param mixed $value
	 * @return void
	 */
	public function prepend($value)
	{
		$this->text->prepend($value);
	}
}
