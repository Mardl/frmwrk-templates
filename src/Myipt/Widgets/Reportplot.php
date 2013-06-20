<?php

namespace Templates\Myipt\Widgets;


class Reportplot extends \Templates\Myipt\Widget
{

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($title, $analyseData, $moreUrl, $classOrAttributes = '')
	{
		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "colHalf";
		} else {
			$classOrAttributes .= " colHalf";
		}

		parent::__construct($title, null, $classOrAttributes);
		$this->content->addStyle('text-align', 'center');

		if (!empty($moreUrl)){
			$this->setMoreLink($moreUrl, "mehr >");
		}

		$container = new \Templates\Html\Tag('div', '', 'chart');
		if (isset($analyseData['class'])){
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
