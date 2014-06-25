<?php

namespace Templates\Srabon;

use Templates\Html\Tag;

class Tabs extends \Templates\Srabon\Widget
{

	const ORIENTATION_TOP = 0;
	const ORIENTATION_LEFT = 1;
	const ORIENTATION_RIGHT = 2;
	const ORIENTATION_BOTTOM = 3;

	/**
	 * @var array
	 */
	protected $page = array();
	/**
	 * @var array
	 */
	protected $pageTitles = array();

	/**
	 * @var \Templates\Html\Tag
	 */
	protected $navigation = null;

	/**
	 * @var \Templates\Html\Tag
	 */
	private $container = null;

	private $orientation = self::ORIENTATION_TOP;

	/**
	 * @var int
	 */
	private $activePage = -1;

	public function __construct($headerText='', $flat=false, $classOrAttributes = array())
	{
		parent::__construct($headerText, '', $flat, $classOrAttributes);
	}

	public function append($value)
	{
		$this->addPage(count($this->page)+1,$value);
	}

	protected function makeAnchor($headline,$id)
	{
		$href = new \Templates\Srabon\Anchor('#'.$id,$headline);
		$href->addAttribute('data-toggle','tab');
		return $href;
	}

	/**
	 * @param $index
	 * @return null|\Templates\Html\Tag
	 */
	public function getPage($index)
	{
		if (isset($this->page[$index]))
		{
			return $this->page[$index];
		}
		return null;
	}

	/**
	 * @param $index
	 * @return null|\Templates\Html\Tag
	 */
	public function getPageTitle($index)
	{
		if (isset($this->pageTitles[$index]))
		{
			return $this->pageTitles[$index];
		}
		return null;
	}

	/**
	 *
	 * Setzt die Page mit $index auf active
	 *
	 * @param $index
	 */
	public function setActive($index)
	{
		$page = $this->getPage($index);
		if (!empty($page))
		{
			$page->addClass('active');
			$this->activePage = $index;
		}

		$title = $this->getPageTitle($index);
		if (!empty($page))
		{
			$title->addClass('active');
		}
	}

	public function addPage($headline,$value,$hideIfEmpty=false)
	{
		if ($hideIfEmpty)
		{
			$output = $this->renderToString($value);
			if (empty($output))
			{
				return $this;
			}
		}
		$id = uniqid('tabs-');

		$href = $this->makeAnchor($headline,$id);

		$li = new Tag('li',$href);
		$li->addClass('tabnav'.count($this->page));
		$this->navigation->append( $li );

		$pane = new Tag('div',$value);
		$pane->setId($id);
		$pane->addClass('tab-pane');
		$pane->addClass('pane'.count($this->page));

		if (false) // aktive
		{
			$li->addClass('active');
			$pane->addClass('active');
		}


		$this->pageTitles[] = $li;
		$this->page[] = $pane;

		parent::append($pane);

		return $this;
	}

	protected function initContent()
	{
		$this->navigation = new Tag('ul','','nav-tabs');
		$this->navigation->addClass('nav');


		$this->content = new Tag('div','','tab-content well');
		$this->content->addClass('white-box');

		$wrap0 = array($this->navigation, $this->content);

		$this->container = new Tag('div',$wrap0,'widget-box tabbable');
		$wrap2 = new Tag('div',$this->container,'widget-content');

		Tag::append($wrap2);
	}

	public function setTabsLeft()
	{
		$this->orientation = self::ORIENTATION_LEFT;
	}
	public function setTabsRight()
	{
		$this->orientation = self::ORIENTATION_RIGHT;
	}
	public function setTabsTop()
	{
		$this->orientation = self::ORIENTATION_TOP;
	}
	public function setTabsBottom()
	{
		$this->orientation = self::ORIENTATION_BOTTOM;
	}

	public function toString()
	{
		if (empty($this->page))
		{
			return '';
		}

		if ($this->activePage < 0)
		{
			$this->setActive(0);
		}

		$this->container->removeClass('tabs-left');
		$this->container->removeClass('tabs-right');
		$this->container->removeClass('tabs-below');
		switch ($this->orientation)
		{
			case self::ORIENTATION_LEFT : $this->container->addClass('tabs-left');
				break;
			case self::ORIENTATION_RIGHT : $this->container->addClass('tabs-right');
				break;
			case self::ORIENTATION_BOTTOM : $this->container->addClass('tabs-below');
				$this->container->set(array($this->content, $this->navigation));
				break;
		}

		return parent::toString();
	}
}
