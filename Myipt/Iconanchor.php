<?php

namespace Templates\Myipt;


class Iconanchor extends \Templates\Html\Anchor
{

	public function __construct($href, $iconclass, $text = null, $classOrAttributes = ''){
		$icon = new \Templates\Html\Tag("span",'', "icon {$iconclass}");

		$linktext = $icon.' '.$text;

		parent::__construct($href, $linktext, $classOrAttributes);
	}

}

?>