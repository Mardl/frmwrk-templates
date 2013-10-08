<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Reportsmall
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Reportsmall extends \Templates\Myipt\Widget
{
	/**
	 * @param string $analyseData
	 * @param array  $type
	 * @param array  $moreUrl
	 * @param array  $classOrAttributes
	 */
	public function __construct($analyseData, $type, $moreUrl, $classOrAttributes = array())
	{
		if (is_array($classOrAttributes))
		{
			$classOrAttributes[] = "colQuarter";
		}
		else
		{
			$classOrAttributes .= " colQuarter";
		}

		parent::__construct($analyseData['title'], null, $classOrAttributes);
		$this->content->addStyle('text-align', 'center');

		$this->setMoreLink($moreUrl, "mehr >");

		if (!$analyseData['noChart'])
		{
			$canvas = new \Templates\Myipt\Chart($analyseData, $type);
			$this->append($canvas);

			/*$canvas = new \Templates\Html\Tag('canvas', '', 'chart');

			$canvas->addAttribute('id', $analyseData['id'].$type);
			$canvas->addAttribute('data-rel', $analyseData['id'].$type);
			$canvas->addAttribute('data-value-rel', $analyseData['value']['rel']);
			$canvas->addAttribute('data-value-rel-max', $analyseData['max']['rel']);
			$canvas->addAttribute('data-value-abs', $analyseData['value']['abs']);
			$canvas->addAttribute('data-value-abs-max', $analyseData['max']['abs']);
			$canvas->addAttribute('data-zvalue', $analyseData['value']['zindex']);
			$canvas->addAttribute('data-title', $analyseData['title']);
			$canvas->addAttribute('data-c-red-rel', $analyseData['percent']['rel']['orange']);
			$canvas->addAttribute('data-c-orange-rel', $analyseData['percent']['rel']['green']);
			$canvas->addAttribute('data-c-red-abs', $analyseData['percent']['abs']['orange']);
			$canvas->addAttribute('data-c-orange-abs', $analyseData['percent']['abs']['green']);
			$canvas->addAttribute('data-type', $type);
			$canvas->addAttribute('data-stops-red', $analyseData['stops']['red']);
			$canvas->addAttribute('data-stops-green', $analyseData['stops']['green']);
			$canvas->addAttribute('data-stops-orange', $analyseData['stops']['orange']);
			$canvas->addAttribute('data-legend-red', $analyseData['legend']['red']);
			$canvas->addAttribute('data-legend-orange', $analyseData['legend']['orange']);
			$canvas->addAttribute('data-legend-green', $analyseData['legend']['green']);
			$canvas->addAttribute('data-unit-rel', '%');
			$canvas->addAttribute('data-unit-abs', $analyseData['unit']);
			$canvas->addAttribute('width',228);
			$canvas->addAttribute('height',168);*/
		}
	}
}
