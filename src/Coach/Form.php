<?php

namespace Templates\Coach;

use Core\SystemMessages;

class Form extends \Templates\Html\Form
{

	/**
	 *
	 * @var \App\Models\User
	 */
	protected $user;

	public function __construct($action='', $data=array(), $method='post', $classOrAttributes = array())
	{
		parent::__construct($action, $data, $method, $classOrAttributes);
	}


	/**
	 *
	 * @param unknown_type $legend
	 * @return \Templates\Myipt\Block
	 */
	public function newFieldset($legend = null)
	{
		$fieldset = new \Templates\Coach\Block("fieldset");
		if ($legend != null){
			if (!($legend instanceof \Templates\Html\Tag)){
				$legend = new \Templates\Html\Tag('legend', $legend);
			}
			$fieldset->append($legend);
		}
		$this->append($fieldset);
		return $fieldset;
	}

	/**
	 *
	 * @param unknown_type $legend
	 * @return \Templates\Myipt\Block
	 */
	public function newDivset($legend = null, $legendTag = 'h3')
	{
		$fieldset = new \Templates\Coach\Block("div");
		if ($legend != null){
			if (!($legend instanceof \Templates\Html\Tag)){
				$legend = new \Templates\Html\Tag($legendTag, $legend);
			}
			$fieldset->append($legend);
		}
		$this->append($fieldset);
		return $fieldset;
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
