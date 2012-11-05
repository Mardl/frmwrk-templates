<?php

namespace Templates\Srabon;

use Templates\Html\Tag;
use Templates\Html\Anchor;

class DashboardWidget extends Tag
{

	/**
	 * @var bool
	 */
	private $colorIcon = true;

	/**
	 * @var string|\Templates\Html\Tag
	 */
	private $inlineIcons = '';


	/**
	 * @param string $headerText
	 * @param bool $flat
	 */
	public function __construct($title, $href='', $classOrAttributes = array())
	{
		parent::__construct('div', '', 'dashboard-wid-wrap');

		if (empty($href))
		{
			$href = '#';
		}
		$this->inlineIcons = new Tag('i','',$classOrAttributes);
		$span = new Tag('span',$title,'dasboard-icon-title');
		$anchor = new Anchor($href,array($this->inlineIcons,$span));

		$content = new Tag('div','','dashboard-wid-content');
		$content->append($anchor);

		parent::append($content);
	}

	/**
	 * Set Icon from black Layout
	 */
	public function iconBlack()
	{
		$this->colorIcon = false;
	}


	/**
	 * DEFAULT: Set Icon from color Layout
	 */
	public function iconColor()
	{
		$this->colorIcon = true;
	}

	/**
	 * @return string
	 */
	public function toString() {
		$type = 'dashboard-icons-colors';
		if(!$this->colorIcon)
		{
			$type = 'dashboard-icons';
		}
		$this->inlineIcons->addClass($type);
		return parent::toString();
	}



}