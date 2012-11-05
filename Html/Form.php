<?php

namespace Templates\Html;

use Core\SystemMessages;

class Form extends Tag
{

	protected $values = array();
	protected $validateMessage = array();

	public function __construct($action='', $data=array(), $method='post', $classOrAttributes = array())
	{
		parent::__construct('form', '', $classOrAttributes);
		$this->values = $data;
		$this->method($method);
		if (!empty($action))
		{
			$this->action($action);
		}
	}

	public function getValue($key,$default=null)
	{
		if (array_key_exists($key, $this->values))
		{
			return $this->values[$key];
		}
		return $default;
	}

	public function method($value)
	{
		return $this->addAttribute('method', $value);
	}

	public function action($value)
	{
		return $this->addAttribute('action', $value);
	}

	public function getAction()
	{
		return $this->getAttribute('action','');
	}

	public function validate(Tag $container = null)
	{
		$checkup = true;
		if (empty($container))
		{
			$container = $this;
		}

		if ($container->hasInner())
		{
			foreach($container->getInner() as $tag)
			{
				if ( $tag instanceof \Templates\Html\Input )
				{
					/**
					 * @var $tag \Templates\Html\Input
					 */
					$check = $tag->validate();

					if ($check !== true)
					{
						$this->validateMessage[] = $check;
						$tag->addClass('error required');
						$checkup = false;
					}
				}
				elseif ( $tag instanceof \Templates\Html\Tag )
				{
					$check = self::validate($tag);
					$checkup = $checkup && $check;
				}
				elseif ( is_array($tag) )
				{
					foreach($tag as $moretag)
					{
						if ( $moretag instanceof \Templates\Html\Tag )
						{
							$check = self::validate($moretag);
							$checkup = $checkup && $check;
						}
					}

				}



			}
		}
		elseif ( $container instanceof \Templates\Html\Input )
		{
			$check = $container->validate();

			if ($check !== true)
			{
				$this->validateMessage[] = $check;
				$container->addClass('error required');
				$checkup = false;
			}
		}
		return $checkup;
	}

	public function getValidateErrors()
	{
		return $this->validateMessage;
	}

	public function findTagById($elementId, $container = null)
	{
		$target = null;

		if (is_null($container))
		{
			$container = $this;
		}

		foreach ($container->getInner() as $tag)
		{
			if ( $tag instanceof \Templates\Html\Tag )
			{
				/**
				 * @var $tag \Templates\Html\Tag
				 */
				if ($tag->getId() == $elementId)
				{
					return $tag;
				}

				if ($tag->hasInner() ){
					$target = $this->findTagById($elementId, $tag);
				}
			}

		}

		return $target;

	}

}
