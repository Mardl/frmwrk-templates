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
		//Navigationsleiste
		$this->navigation = new Tag('ul');
		$this->navigation->addClass('ui-tabs-nav');
		$this->navigation->addClass('ui-helper-reset');
		$this->navigation->addClass('ui-helper-clearfix');
		$this->navigation->addClass('ui-widget-header');
		$this->navigation->addClass('ui-corner-all');

		$this->content = new Tag('div',array($this->navigation));
		$this->content->setId('tabs');
		$this->content->addClass('tabs');
		$this->content->addClass('ui-tabs');
		$this->content->addClass('ui-widget');
		$this->content->addClass('ui-widget-content');
		$this->content->addClass('ui-corner-all');


		Tag::append($this->content);
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
