<?php

namespace Templates\Srabon;

use    Templates\Html\Tag;

/**
 * Class ToggleMenu
 *
 * @category Thomann
 * @package  Templates\Srabon
 * @author   Cindy Paulitz <cindy@dreiwerken.de>
 */
class ToggleMenu extends Tag
{

	/**
	 * @var bool
	 */
	private $right = true;
	/**
	 * @var \Templates\Html\Tag
	 */
	private $button;
	/**
	 * @var \Templates\Html\Tag
	 */
	private $menu;

	/**
	 * @param string $title
	 * @param array  $menu
	 * @param array  $classOrAttributes
	 */
	public function __construct($title, $menu = array(), $classOrAttributes = array())
	{
		parent::__construct('div', '', $classOrAttributes);
		$this->addClass('btn-group');

		$this->button = new Tag('button', '', 'btn dropdown-toggle');
		$this->setButton($title);
		$this->button->addAttribute('data-toggle', 'dropdown');
		parent::append($this->button);

		$this->menu = new Tag('ul', '', 'dropdown-menu');
		if (!empty($menu) && is_array($menu))
		{
			foreach ($menu as $values)
			{
				$this->append($values);
			}
		}

		parent::append($this->menu);
	}

	/**
	 * @param string $title
	 * @param string $iconclass
	 * @return void
	 */
	public function setButton($title, $iconclass = "icon-cog")
	{
		$this->button->set('<i class="' . $iconclass . '"></i> ' . $title . ' <span class="caret"></span>');
	}

	/**
	 * @return void
	 */
	public function right()
	{
		$this->right = true;
	}

	/**
	 * @return void
	 */
	public function left()
	{
		$this->right = false;
	}

	/**
	 * @param mixed $value
	 * @return void
	 */
	public function append($value)
	{
		if ($value != '')
		{
			$li = new Tag('li', $value);
			$this->menu->append($li);
		}
	}

	/**
	 * @param mixed $value
	 * @return void
	 */
	public function prepend($value)
	{
		if ($value != '')
		{
			$li = new Tag('li', $value);
			$this->menu->append($li);
		}
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		$this->right ? $this->addClass('pull-right') : $this->addClass('pull-left');
		/*

		<div class="btn-group pull-right">
                        <button class="btn dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li>'.$details.'</li>
                          <li>'.$save.'</li>
                        </ul>
                      </div>
		';
		*/

		if (empty($this->menu->tagInner))
		{
			return '';
		}

		return parent::toString();
	}
}
