<?php

namespace Templates\MandyLane;

use Core\SystemMessages;

class Page extends \Templates\Html\Tag
{
	/**
	 * @var Tag
	 */
	protected $header = null;

	/**
	 * @var Tag
	 */
	protected $contentContainer = null;

	/**
	 * @var null
	 */
	protected $content = null;

	/**
	 * @var \Core\HTMLHelper|null
	 */
	protected $htmlHelper = null;

	/**
	 * @param string $headerText
	 * @param array $classOrAttributes
	 */
	public function __construct($headerText, $dataContent = array(), $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);

		$this->htmlHelper = new \Core\HTMLHelper();

		$this->addClass('maincontent');


		$header = new \Templates\Html\Tag('h1', array($headerText), array('class' => 'pageTitle'));
		$header->addClass('pageTitle');
		$this->contentContainer = new \Templates\Html\Tag('div');
		$this->contentContainer->addClass('left');
		$this->contentContainer->append(array($header, $dataContent));
		$this->append(array($this->htmlHelper->viewBreadcrumbs(), $this->contentContainer));
	}

}
