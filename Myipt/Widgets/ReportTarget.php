<?php

namespace Templates\Myipt\Widgets;


class ReportTarget extends \Templates\Myipt\Widget
{

	protected $text;

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($analyseData, $classOrAttributes = array())
	{

		if (is_array($classOrAttributes)){
			$classOrAttributes[] = "colFull";
		} else {
			$classOrAttributes .= " colFull report";
		}

		parent::__construct($analyseData['reportPosition']->getName(), null, $classOrAttributes);
		parent::addAttribute("id", $analyseData["reportPosition"]->getId());
		$div = new \Templates\Html\Tag("div",'','fLeft');

		$canvas = $this->getCanvas($analyseData);
		$div->append($canvas);
		$this->content->append($div);

	}

	private function getCanvas($analyseData){
		$container = new \Templates\Html\Tag('div', '', 'chart');
		$container->addAttribute('data-type', "plot-target");
		$container->addAttribute('data-title', $analyseData['reportPosition']->getName());
		$container->addAttribute('width', 468);
		$container->addAttribute('height', 384);

		$statusQuo = array();
		$wunsch = array();
		$calced = array();
		$agree = array();

		foreach ($analyseData["trend"] as $analyse){
			$datum = 'Date.UTC('.$analyse->getCreated()->format('Y').','.($analyse->getCreated()->format('n')-1).','.$analyse->getCreated()->format('j').')';
			$statusQuo[] = '['.$datum.','.$analyse->getAbs().']';
 		}

 		$started = $analyseData["started"];

 		$wunsch[] = $statusQuo[0];
 		$wunschEnd = clone $started;
 		$wunschEnd->add(new \DateInterval("P".$analyseData["wish"]["range"]."D"));
 		$datum = 'Date.UTC('.$wunschEnd->format('Y').','.($wunschEnd->format('n')-1).','.$wunschEnd->format('j').')';
 		$wunsch[] = '['.$datum.','.$analyseData["wish"]["value"].']';

 		$calced[] = $statusQuo[0];
 		$calcedEnd = clone $started;
 		$calcedEnd->add(new \DateInterval("P".$analyseData["calc"]["range"]."D"));
 		$datum = 'Date.UTC('.$calcedEnd->format('Y').','.($calcedEnd->format('n')-1).','.$calcedEnd->format('j').')';
 		$calced[] = '['.$datum.','.$analyseData["calc"]["value"].']';

 		$agree[] = $statusQuo[0];
 		$agreeEnd = clone $started;
 		$agreeEnd->add(new \DateInterval("P".$analyseData["agreement"]["range"]."D"));
 		$datum = 'Date.UTC('.$agreeEnd->format('Y').','.($agreeEnd->format('n')-1).','.$agreeEnd->format('j').')';
 		$agree[] = '['.$datum.','.$analyseData["agreement"]["value"].']';


		$container->addAttribute('data-series-sq', '['.implode(',', $statusQuo).']');
		$container->addAttribute('data-series-w', '['.implode(',', $wunsch).']');
		$container->addAttribute('data-series-c', '['.implode(',', $calced).']');
		$container->addAttribute('data-series-a', '['.implode(',', $agree).']');

		return $container;
	}

}
