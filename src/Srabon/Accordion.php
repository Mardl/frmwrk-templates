<?php

namespace Templates\Srabon;

use Templates\Html\Tag;

/**
 * Class Accordion
 *
 * @category Dreiwerken
 * @package  Templates\Srabon
 * @author   Cindy Paulitz <cindy@dreiwerken.de>
 */
class Accordion extends Tag
{

	/**
	 * @var array
	 */
	private $elements = array();

	/**
	 * @var string
	 */
	private $parent = '';

	/**
	 * @var \Templates\Html\Tag
	 */
	private $widget = true;

	/**
	 * @param array $classOrAttributes
	 */
	public function __construct($classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);
		$this->addClass('accordion-group');
	}

	/**
	 * @return void
	 */
	public function forSiteBar()
	{
		$this->widget = false;
	}

	/**
	 * @param string $selector
	 * @return void
	 */
	public function setParentSelector($selector)
	{
		$this->parent = $selector;
	}

	/**
	 * @param string $title
	 * @param string $content
	 * @param bool   $opened
	 * @return void
	 */
	public function addContent($title, $content, $opened = false)
	{
		mt_srand();
		$i = mt_rand(1, mt_getrandmax());
		$index = count($this->elements) . '-' . $i;
		$this->elements[$index] = array(
			'header' => $title,
			'content' => $content,
			'open' => $opened,
			'index' => $index,
		);
	}

	/**
	 * @return void
	 */
	private function generateOutput()
	{
		foreach ($this->elements as $data)
		{
			if ($this->widget)
			{
				$this->buildWidget($data);
			}
			else
			{
				$this->buildNoWidget($data);
			}
		}

	}

	/**
	 * @param array $data
	 * @return void
	 */
	private function buildWidget(array $data)
	{
		/** Beispiel Akkordeon als Widget */
		/*
		<div class="accordion-group nonboxy-widget">
			<div class="widget-head">
				<h5><a class="accordion-toggle collapsed" data-parent='#foobar' href="#collapseTrhee" data-toggle="collapse">
						<span>testToogle</span>
						<i class="black-icons bended_arrow_down"></i>
					</a>
				</h5>
			</div>

			<div id="collapseTrhee" class="collapse">
				<div class="widget-content">
					<div class="widget-box">
						<div class="well">
							<div class="control-group">
								Warengruppen zuordnen
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		*/

		$opened = $data['open'];
		$id = $data['index'];

		$this->addClass('nonboxy-widget');

		/** Header aufbauen */
		$spanTitle = new Tag('span', $data['header']);
		$icon = new Tag('i', '', 'black-icons');

		$anchor = new Anchor('#block-' . $id, array($spanTitle, $icon), false, array('data-toggle' => 'collapse'));
		$anchor->addClass('accordion-toggle');
		if (!empty($this->parent))
		{
			$anchor->addAttribute('data-parent', $this->parent);
		}

		$h5 = new Tag('h5', $anchor);
		$header = new Tag('div', $h5, 'widget-head');

		/** Content aufbauen */
		$witgetWell = new Tag('div', $data['content'], 'well');
		$witgetBox = new Tag('div', $witgetWell, 'widget-box');
		$witgetContent = new Tag('div', $witgetBox, 'widget-content');

		$contentDiv = new Tag('div', $witgetContent, 'collapse');
		$contentDiv->setId('block-' . $id);


		if (!$opened)
		{
			$anchor->addClass('collapsed');
			$icon->addClass('bended_arrow_down');
		}
		else
		{
			$icon->addClass('bended_arrow_up');
			$contentDiv->addClass('in');
		}

		$this->append($header);
		$this->append($contentDiv);
	}

	/**
	 * @param array $data
	 * @return void
	 */
	private function buildNoWidget(array $data)
	{

		/** Beispiel Akkordeon als Side-Nav */

		/*
		<div class="accordion-group">
			<div class="accordion-header">
				<a class="accordion-toggle" href="#collapseOne" data-parent="#side-accordion" data-toggle="collapse">
					Headline
				</a>
			</div>

			<div id="collapseOne" class="collapse">
				<div class="accordion-content">
					Content
				</div>
			</div>
		</div>

		*/

		$opened = $data['open'];
		$id = $data['index'];

		$this->addClass('nonboxy-widget');

		/** Header aufbauen */
		$anchor = new Anchor('#block-' . $id, $data['header'], false, array('data-toggle' => 'collapse'));
		$anchor->addClass('accordion-toggle');
		if (!empty($this->parent))
		{
			$anchor->addAttribute('data-parent', $this->parent);
		}

		$header = new Tag('div', $anchor, 'accordion-header');

		/** Content aufbauen */
		$witgetContent = new Tag('div', $data['content'], 'accordion-content');

		$contentDiv = new Tag('div', $witgetContent, 'collapse');
		$contentDiv->setId('block-' . $id);


		if (!$opened)
		{
			$anchor->addClass('collapsed');
		}
		else
		{
			$contentDiv->addClass('in');
		}

		$this->append($header);
		$this->append($contentDiv);
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		$this->generateOutput();

		return parent::toString();
	}
}