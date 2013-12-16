<?php

namespace Templates\MandyLane;

use Core\SystemMessages;

class Form extends \Templates\Html\Form
{
	protected $content = null;

	public function __construct($action='', $data=array(), $method='post', $classOrAttributes = array())
	{
		parent::__construct($action, $data, $method, $classOrAttributes);

		$this->initContent();

		//parent::append($this->content);
	}

	protected function initContent()
	{
		$this->content = new \Templates\Html\Tag('div','', 'form_default');
		parent::append($this->content);
	}

	/**
	 * @param string $url
	 * @return void
	 */
	public function setAction($url)
	{
		$this->action($url);
	}

	public function append($value)
	{
		$this->content->append($value);
	}

	public function prepend($value)
	{
		$this->content->prepend($value);
	}

	public function setPostWithAjax($value = true)
	{
		if(!$value)
		{
			$this->removeClass('post-ajax');
			return;
		}

		$this->addClass('post-ajax');
	}
}
