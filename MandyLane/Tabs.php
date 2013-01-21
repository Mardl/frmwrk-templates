<?php

namespace Templates\MandyLane;

use Templates\Html\Tag,
	Templates\Exceptions\Layout as LayoutException;

class Tabs extends \Templates\MandyLane\Widget
{
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
		$href = new \Templates\MandyLane\Anchor('#'.$id,$headline);
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
		/*foreach($this->page as $page)
		{
			$page->removeClass('ui-state-active');
			$page->addClass('ui-tabs-hide');
			$title = $this->getPageTitle($index);
			if (!empty($title))
			{
				$title->removeClass('ui-tabs-selected');
				$title->removeClass('ui-state-active');
			}
		}

		$page = $this->getPage($index);
		if (!empty($page))
		{
			$page->addClass('ui-state-active');
			$this->activePage = $index;
		}

		$title = $this->getPageTitle($index);
		if (!empty($title))
		{
			$title->addClass('ui-tabs-selected');
			$title->addClass('ui-state-active');
		}*/
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
			$li->addClass('ui-state-active');
			$pane->addClass('ui-state-active');
		}


		$this->pageTitles[] = $li;
		$this->page[] = $pane;

		parent::append($pane);

		return $this;
	}
	protected function initContent()
	{
		//Navigationsleiste
		$this->navigation = new Tag('ul');
		/*
		$this->navigation->addClass('ui-tabs-nav');
		$this->navigation->addClass('ui-helper-reset');
		$this->navigation->addClass('ui-helper-clearfix');
		$this->navigation->addClass('ui-widget-header');
		$this->navigation->addClass('ui-corner-all');
		*/

		$this->content = new Tag('div',array($this->navigation));
		$this->content->setId(uniqid());
		$this->content->addClass('tabs');
		/*
		$this->content->addClass('ui-tabs');
		$this->content->addClass('ui-widget');
		$this->content->addClass('ui-widget-content');
		$this->content->addClass('ui-corner-all');
		*/


		Tag::append($this->content);
	}

	public function setCookieName($name)
	{
		$this->content->addAttribute('data-cookiename', $name);
		return $this;
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

		return parent::toString();
	}

}
