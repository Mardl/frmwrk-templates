<?php

namespace Templates\Srabon;

class ToggleMenu extends \Templates\Html\Tag
{

	private $right = true;
	private $button;
	private $menu;

	/**
	 * @param $href
	 * @param array|string $linkText
	 * @param array $classOrAttributes
	 */
	public function __construct($title,$menu=array(),$classOrAttributes = array())
	{
		parent::__construct('div','',$classOrAttributes);
		$this->addClass('btn-group');

		$this->button = new \Templates\Html\Tag('button','','btn dropdown-toggle');
		$this->button->append('<i class="icon-cog"></i> '.$title.' <span class="caret">');
		$this->button->addAttribute('data-toggle','dropdown');
		parent::append($this->button);

		$this->menu = new \Templates\Html\Tag('ul','','dropdown-menu');
		if (!empty($menu) && is_array($menu))
		{
			foreach($menu as $values)
			{
				 $this->append($values);
			}
		}
		parent::append($this->menu);

	}

	public function right()
	{
		$this->right = true;
	}
	public function left()
	{
		$this->right = false;
	}

	public function append($value)
	{
		$li = new \Templates\Html\Tag('li',$value);
		$this->menu->append($li);
	}

	public function prepend($value)
	{
		$li = new \Templates\Html\Tag('li',$value);
		$this->menu->append($li);
	}

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

		return parent::toString();
	}
}