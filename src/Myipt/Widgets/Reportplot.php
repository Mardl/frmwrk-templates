<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Reportplot
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Stefan Orthofer <stefan@dreiwerken.de>
 */
class Reportplot extends \Templates\Myipt\Widget
{

	/**
	 * @param string $title
	 * @param array  $analyseData
	 * @param array  $moreUrl
	 * @param string $classOrAttributes
	 */
	public function __construct($title, $analyseData, $moreUrl, $classOrAttributes = '')
	{
		if (is_array($classOrAttributes))
		{
			$classOrAttributes[] = "colHalf";
		} else {
			$classOrAttributes .= " colHalf";
		}

		parent::__construct($title, null, $classOrAttributes);
		$this->content->addStyle('text-align', 'center');

		if (!empty($moreUrl))
		{
			$this->setMoreLink($moreUrl, "mehr >");
		}

		$container = new \Templates\Html\Tag('div', '', 'chart');
		if (isset($analyseData['class']))
		{
			$container = new \Templates\Html\Tag('div', '', 'chart '.$analyseData['class']);
		}

		$container->addAttribute('id', $analyseData['id'].'-plot');
		$container->addAttribute('data-type', "plot");
		$container->addAttribute('data-series-abs', '['.implode(',', $analyseData["abs"]).']');
		$container->addAttribute('data-series-rel', '['.implode(',', $analyseData["rel"]).']');
		$container->addAttribute('data-abs-title', $title);

		$container->addAttribute('width', 468);
		$container->addAttribute('height', 384);

		$this->append($container);
	}
}
