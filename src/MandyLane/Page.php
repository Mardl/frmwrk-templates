<?php

namespace Templates\MandyLane;

/**
 * Class Page
 *
 * @category Lifemeter
 * @package  Templates\MandyLane
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Page extends \Templates\Html\Tag
{

	/**
	 * @var \Core\View|null
	 */
	protected $view = null;

	/**
	 * @var string
	 */
	protected $headertext = '';

	/**
	 * @var array
	 */
	protected $dataContent = array();

	/**
	 * @param string     $headerText
	 * @param \Core\View $view
	 * @param array      $dataContent
	 * @param array      $classOrAttributes
	 */
	public function __construct($headerText, $view, $dataContent = array(), $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);

		$this->setHeadertext($headerText);
		$this->setDataContent($dataContent);
		$this->setView($view);
	}

	/**
	 * @param null $view
	 */
	public function setView($view)
	{
		$this->view = $view;
	}

	/**
	 * @return null
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * @param string $headertext
	 */
	public function setHeadertext($headertext)
	{
		$this->headertext = $headertext;
	}

	/**
	 * @return string
	 */
	public function getHeadertext()
	{
		return $this->headertext;
	}

	/**
	 * @param null $dataContent
	 */
	public function setDataContent($dataContent)
	{
		$this->dataContent = $dataContent;
	}

	/**
	 * @return null
	 */
	public function getDataContent()
	{
		return $this->dataContent;
	}


	/**
	 * @return string
	 */
	public function toString()
	{
		$view = $this->getView();

		$this->addClass('maincontent');

		$header = new \Templates\Html\Tag('h1', array($this->getHeadertext()));
		$header->addClass('pageTitle');

		$contentContainer = new \Templates\Html\Tag('div');
		$contentContainer->addClass('left');
		$contentContainer->append(array($header, $this->getDataContent()));

		$this->append(array($view->html->viewBreadcrumbs(), $contentContainer));

		return parent::toString();
	}

}
