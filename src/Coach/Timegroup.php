<?php

namespace Templates\Coach;

use Core\SystemMessages;

class Timegroup extends \Templates\Coach\Block
{

	public function __construct($parentTag, $label, $datum, $classOrAttributes = array())
	{
		parent::__construct($parentTag, $classOrAttributes);

		if (!($datum instanceof \DateTime)){
			$datum = new \DateTime($datum);
		}

		$hour = $datum->format('H');
		$minute = $datum->format('i');

		$this->append(new \Templates\Html\Tag("label", $label));

		$this->append(new \Templates\Html\Input("hour", $hour,'',false,'text', 'little'));
		$this->append(" : ");
		$this->append(new \Templates\Html\Input("minute", $minute,'',false,'text', 'little'));

	}


}
