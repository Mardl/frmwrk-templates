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

	private $content = '';

	/**
	 * @param string $title
	 * @param string $href
	 * @param array $classOrAttributes
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
		$anchor = $this->createAnchor($href,array($this->inlineIcons,$span));

		$this->content = new Tag('div','','dashboard-wid-content');
		$this->content->append($anchor);

		parent::append($this->content);
	}

	public function hasAnchor()
	{
		$link = trim($this->content->getInnerAsString());
		return !empty($link);
	}

	protected function createAnchor($href,$linktext)
	{
		$href = new \Templates\Srabon\Anchor($href,$linktext);
		return $href;
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
	public function toString()
	{
		$type = 'dashboard-icons-colors';
		if(!$this->colorIcon)
		{
			$type = 'dashboard-icons';
		}
		$this->inlineIcons->addClass($type);
		return parent::toString();
	}
}