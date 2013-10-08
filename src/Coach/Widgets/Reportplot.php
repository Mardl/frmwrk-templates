<?php

namespace Templates\Coach\Widgets;


class Reportplot extends \Templates\Coach\Widget
{

	protected $data;
	protected $title;

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

		$this->data = $analyseData;
		$this->title = $title;

		if (!empty($moreUrl)){
			$this->setMoreLink($moreUrl, "mehr >");
		}


	}

	public function toString()
	{

		$container = new \Templates\Html\Tag('div', '', 'chart');
		if (isset($this->data['class'])){
			$container = new \Templates\Html\Tag('div', '', 'chart '.$this->data['class']);
		}

		$container->addAttribute('id', $this->data['id'].'-plot');
		$container->addAttribute('data-type', "plot");
		$container->addAttribute('data-series-abs', '['.implode(',', $this->data["abs"]).']');
		$container->addAttribute('data-series-rel', '['.implode(',', $this->data["rel"]).']');
		$container->addAttribute('data-abs-title', $this->title);

		$container->addAttribute('width', 468);
		$container->addAttribute('height', 384);


		$this->append($container);

		return parent::toString();
	}
}
