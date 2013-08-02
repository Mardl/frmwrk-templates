<?php

namespace Templates\Html;

use Core\SystemMessages;

/**
 * Class Form
 *
 * @category Jamwork
 * @package  Templates\Html
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Form extends Tag
{

	/**
	 * @var array
	 */
	protected $values = array();
	/**
	 * @var array
	 */
	protected $validateMessage = array();

	/**
	 * @param string $action
	 * @param array  $data
	 * @param string $method
	 * @param array  $classOrAttributes
	 */
	public function __construct($action = '', $data = array(), $method = 'post', $classOrAttributes = array())
	{
		parent::__construct('form', '', $classOrAttributes);
		$this->setData($data);
		$this->method($method);
		if (!empty($action))
		{
			$this->action($action);
		}
	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function setData($data)
	{
		$this->values = $data;
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function setDataValue($key, $value)
	{
		$this->values[$key] = $value;
	}

	/**
	 * @param string $key
	 * @param mixed  $default
	 * @return null
	 */
	public function getValue($key, $default = null)
	{
		if (array_key_exists($key, $this->values))
		{
			return $this->values[$key];
		}

		return $default;
	}

	/**
	 * @param string $value
	 * @return Tag
	 */
	public function method($value)
	{
		return $this->addAttribute('method', $value);
	}

	/**
	 * @param string $value
	 * @return Tag
	 */
	public function action($value)
	{
		return $this->addAttribute('action', $value);
	}

	/**
	 * @return null|string
	 */
	public function getAction()
	{
		return $this->getAttribute('action', '');
	}

	/**
	 * @param Tag $container
	 * @return bool
	 */
	public function validate(Tag $container = null)
	{
		$checkup = true;
		if (empty($container))
		{
			$container = $this;
		}

		if ($container->hasInner())
		{
			foreach ($container->getInner() as $tag)
			{
				$checkup = $checkup && $this->validateInner($tag);
			}
		}
		elseif ($container instanceof \Templates\Html\Input)
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

	/**
	 * @param mixed $tag
	 * @return bool
	 */
	private function validateInner($tag)
	{
		$checkup = true;
		if ($tag instanceof \Templates\Html\Input)
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
		elseif ($tag instanceof \Templates\Html\Tag)
		{
			$check = self::validate($tag);
			$checkup = $checkup && $check;
		}
		elseif (is_array($tag))
		{
			foreach ($tag as $moretag)
			{
				if ($moretag instanceof \Templates\Html\Tag)
				{
					$check = self::validate($moretag);
					$checkup = $checkup && $check;
				}
			}
		}

		return $checkup;
	}

	/**
	 * @return array
	 */
	public function getValidateErrors()
	{
		return $this->validateMessage;
	}

	/**
	 * Sucht Formfeld anhand des Namens und liefert das erste vorkommen zurück.
	 *
	 * @param string $elementName
	 * @param mixed  $container
	 * @return Tag
	 */
	public function findByName($elementName, $container = null)
	{
		$target = null;

		if (is_null($container))
		{
			$container = $this;
		}

		foreach ($container->getInner() as $tag)
		{
			if ($tag instanceof \Templates\Html\Input)
			{
				/**
				 * @var $tag \Templates\Html\Tag
				 */
				if ($tag->getName() == $elementName)
				{
					return $tag;
				}

				if ($tag->hasInner())
				{
					$target = $this->findByName($elementName, $tag);
					if ($target)
					{
						return $target;
					}
				}
			}
			elseif ($tag instanceof \Templates\Html\Tag)
			{
				$target = $this->findByName($elementName, $tag);
				if ($target)
				{
					return $target;
				}
			}
			elseif (is_array($tag))
			{
				foreach ($tag as $moretag)
				{
					$target = $this->findByName($elementName, $moretag);
					if ($target)
					{
						return $target;
					}
				}

			}

		}

		return $target;

	}

}
