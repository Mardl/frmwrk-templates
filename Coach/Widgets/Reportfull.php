<?php

namespace Templates\Coach\Widgets;


class Reportfull extends \Templates\Coach\Widget
{

	protected $text;
	protected $fancy = false;

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($analyseData, $type, $detaillink, $fancy = false, $classOrAttributes = array())
	{
		$this->fancy = $fancy;

		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "colFull";
		} else {
			$classOrAttributes .= " colFull report";
		}

		parent::__construct($analyseData['title'], null, $classOrAttributes);
		parent::addAttribute("id", $analyseData["id"]);
		$div = new \Templates\Html\Tag("div",'','fLeft');

		if ($type != "both"){
			$canvas = $this->getCanvas($analyseData, $type);
			$div->append($canvas);
		} else {
			$canvas = $this->getCanvas($analyseData, "rel");
			$div->append($canvas);
			$canvas = $this->getCanvas($analyseData, "abs");
			$div->append($canvas);
		}

		$this->content->append($div);

		foreach ($analyseData["outputtexts"] as $index => $text){
			if ($index == 0){
				$p = new \Templates\Html\Tag("p", $text[0]);
				$this->initText($p);
			} else {
				if (!empty($text[0])){
					$class = "hide";
					if ($this->fancy){
						$class = null;
					}
					$p = new \Templates\Html\Tag("p", $text[0], $class);
					$this->append($p);
				}

			}
		}


		if (!$this->fancy) {
			$this->setFooter("<a href='".$detaillink."' class='fancybox fancybox.ajax'>mehr Informationen</a>");
		}


	}

	protected function initText($value = null){
		$this->text = new \Templates\Html\Tag("div", $value, 'fLeft info');
		$this->content->append($this->text);
	}

	public function append($value){
		$this->text->append($value);
	}

	public function prepend($value){
		$this->text->prepend($value);
	}

	private function getCanvas($analyseData, $type){
		$canvas = new \Templates\Html\Tag('canvas', '', 'chart');
		$canvas->addAttribute('id', $analyseData['id'].$type.(($this->fancy)?'-fancy':null));
		$canvas->addAttribute('data-rel', $analyseData['id'].$type.(($this->fancy)?'-fancy':null));
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
		$canvas->addAttribute('height',168);
		return $canvas;
	}

}
