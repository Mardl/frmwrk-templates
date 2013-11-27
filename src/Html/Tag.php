<?php

namespace Templates\Html;

/**
 * Class Tag
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Vadim Justus <vadim@dreiwerken.de>
 */
class Tag
{

	/**
	 * @var null|string
	 */
	protected $tagName = null;
	/**
	 * @var array
	 */
	protected $tagInner = array();
	/**
	 * @var array
	 */
	protected $javascript = array();
	/**
	 * @var array
	 */
	protected $tagAttributes = array();
	/**
	 * @var array
	 */
	protected $tagStyle = array();
	/**
	 * @var bool
	 */
	protected $forceClose = true;
	/**
	 * @var string
	 */
	protected $formatOutput = '';

	/**
	 * @param string $tag               Default = div-Tag
	 * @param string $inner             default = ''
	 * @param array  $classOrAttributes array of attributes or string as class or string start with # as ID
	 */
	public function __construct($tag = 'div', $inner = '', $classOrAttributes = array())
	{
		if (empty($tag))
		{
			$tag = 'div';
		}
		$this->tagName = strtolower($tag);
		if (!empty($inner))
		{
			$this->set($inner);
		}
		if (!empty($classOrAttributes))
		{
			if (is_array($classOrAttributes))
			{
				foreach ($classOrAttributes as $name => $attr)
				{
					$this->addAttribute($name, $attr);
				}
			}
			else
			{
				$classOrAttributes = trim($classOrAttributes);
				if (substr($classOrAttributes, 0, 1) == '#')
				{
					$this->setId(substr($classOrAttributes, 1));
				}
				else
				{
					$this->addClass($classOrAttributes);
				}

			}
		}
	}

	/**
	 * Setzen von Attribut ID
	 *
	 * @param int $id
	 * @return Tag
	 */
	public function setId($id)
	{
		return $this->addAttribute('id', $id);
	}

	/**
	 * @return null|string
	 */
	public function getId()
	{
		return $this->getAttribute('id');
	}

	/**
	 * Format für Output-Formatierung im format sprintf
	 *
	 * @param string $format
	 * @return void
	 */
	public function setFormat($format)
	{
		$this->formatOutput = $format;
	}

	/**
	 * TO-STRING
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->toString();
	}

	/**
	 * Tagname
	 *
	 * @param string $tag
	 * @return void
	 */
	public function setTagname($tag)
	{
		$this->tagName = $tag;
	}

	/**
	 * @return bool
	 */
	public function hasInner()
	{
		return !empty($this->tagInner);
	}

	/**
	 * @return bool
	 */
	public function removeInner()
	{
		$this->tagInner = array();
	}

	/**
	 * Getter für Tag-Wert
	 *
	 * @return array|mixed
	 */
	public function getInner()
	{
		return $this->tagInner;
	}

	/**
	 * @param mixed $value
	 * @return mixed
	 * @throws \Templates\Exceptions\Convert
	 */
	private function renderObject($value)
	{
		if (method_exists($value, 'toHtml'))
		{
			return $value->toHtml();
		}
		if (method_exists($value, '__toString'))
		{
			return $value->__toString();
		}

		throw new \Templates\Exceptions\Convert('Der Wert des Tags ist ein Object ohne "toHtml" bzw. "__toString" Implementierung.');
	}

	/**
	 * @param mixed $value
	 * @return string
	 * @throws \Templates\Exceptions\Convert
	 */
	protected function renderToString($value)
	{
		if (is_string($value) || is_int($value))
		{
			if (!empty($this->formatOutput))
			{
				return sprintf($this->formatOutput, $value);
			}

			return $value;
		}

		if (is_object($value))
		{
			return $this->renderObject($value);
		}

		$string = '';
		if (is_array($value))
		{
			foreach ($value as $vals)
			{
				$string .= $this->renderToString($vals); // . "\r\n";
			}
		}

		return $string;
	}

	/**
	 * @return string
	 */
	public function getInnerAsString()
	{
		return $this->renderToString($this->tagInner);
	}

	/**
	 * Fügt den übergebenen Wert zum Tag-Wert hinzu.
	 * Falls ein Wert bereits gesetzt ist, wird ein Array gebildet.
	 *
	 * @param mixed $value
	 * @return Tag
	 *
	 * @deprecated Bitte append direkt verwende!
	 */
	public function addInner($value)
	{
		return $this->append($value);
	}

	/**
	 * Liefert die Anzahl der Values zurück
	 *
	 * @return int
	 */
	public function countInners()
	{
		if (is_array($this->tagInner))
		{
			return count($this->tagInner);
		}

		return empty($this->tagInner) ? 0 : 1;
	}

	/**
	 * Attribut hinzufügen
	 *
	 * @param string $name
	 * @param string $value
	 * @return Tag
	 */
	public function addAttribute($name, $value)
	{
		$this->tagAttributes[$name] = $value;

		return $this;
	}

	/**
	 * @param string $name
	 * @return Tag
	 */
	public function removeAttribute($name)
	{
		if ($this->hasAttribute($name))
		{
			unset($this->tagAttributes[$name]);
		}

		return $this;
	}

	/**
	 * @param string      $name
	 * @param string|null $default
	 * @return null|string
	 */
	public function getAttribute($name, $default = null)
	{
		if ($this->hasAttribute($name))
		{
			return $this->tagAttributes[$name];
		}

		return $default;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasAttribute($name)
	{
		return array_key_exists($name, $this->tagAttributes);
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @return Tag
	 */
	public function addStyle($name, $value)
	{
		$this->tagStyle[$name] = $value;

		return $this;
	}

	/**
	 * Überprüft, ob ein bestimmter Style-Wert gesetzt ist
	 *
	 * @param string $name
	 * @return bool
	 */
	public function hasStyle($name)
	{
		return array_key_exists($name, $this->tagStyle);
	}

	/**
	 * Überprüft, ob generell Style-Werte vorhanden sind
	 *
	 * @return bool
	 */
	public function hasStyles()
	{
		return !empty($this->tagStyle);
	}

	/**
	 * @param string $class
	 * @return Tag
	 */
	public function addClass($class)
	{
		if (!$this->hasAttribute('class'))
		{
			$this->tagAttributes['class'] = array();
		}

		$this->tagAttributes['class'][$class] = $class;

		return $this;
	}

	/**
	 * @param string $class
	 * @return $this
	 */
	public function removeClass($class)
	{
		if (isset($this->tagAttributes['class'][$class]))
		{
			unset($this->tagAttributes['class'][$class]);
		}

		return $this;
	}

	/**
	 * Rendert alle Attribute zu einem HTML-String
	 *
	 * @return string
	 */
	protected function renderAttributes()
	{
		$this->renderStyles();

		$attributes = array();
		foreach ($this->tagAttributes as $key => $value)
		{
			if (is_array($value))
			{
				$value = implode(' ', $value);
			}
			//if(!empty($value))
			//{
				$attributes[] = $key . '="' . $value . '"';
			//}
		}

		return implode(' ', $attributes);
	}

	/**
	 * Rendert alle Style-Anweisungen zu einem style-Attribut
	 *
	 * @return void
	 */
	private function renderStyles()
	{
		if (!$this->hasStyles())
		{
			return;
		}

		$styles = array();
		foreach ($this->tagStyle as $key => $value)
		{
			if (is_array($value))
			{
				$value = implode(' ', $value);
			}
			$styles[] = $key . ':' . $value . ';';
		}

		$this->addAttribute('style', implode(' ', $styles));
	}

	/**
	 * @return array
	 */
	protected function getJsFile()
	{
		return $this->javascript;
	}

	/**
	 * @param string $value
	 * @return void
	 */
	public function addJsFile($value)
	{
		$this->javascript[] = $value;
	}

	/**
	 * @return string
	 */
	private function createScripts()
	{
		$script = '';
		$src = $this->getJsFile();
		if (!empty($src))
		{
			foreach ($src as $source)
			{
				$tag = new Tag(
					'script',
					'',
					array(
						'src' => $source,
						'type' => 'text/javascript'
					)
				);

				$script .= $tag;
			}
		}

		return $script;
	}

	/**
	 * Generiert den Tag als String
	 *
	 * @return string
	 */
	public function toString()
	{
		$str = '';
		$str .= '<';
		$str .= $this->tagName . ' ';
		$str .= $this->renderAttributes();
		if (!empty($this->tagInner) || $this->forceClose)
		{
			$str .= '>';
		}
		$str .= $this->getInnerAsString();
		$str .= $this->getCloseTag();
		$str .= $this->createScripts();

		return $str;
	}

	/**
	 * Alternativer Aufruf von toString()
	 *
	 * @return string
	 */
	public function toHtml()
	{
		return $this->toString();
	}

	/**
	 * Generiert den Close-Tag des Tags
	 *
	 * @return string
	 */
	protected function getCloseTag()
	{
		if (!empty($this->tagInner) || $this->forceClose)
		{
			return '</' . $this->tagName . '>';
		}

		return ' />';
	}

	/**
	 * Initialisiert den InnerTag und setzt ihn komplett neu
	 *
	 * @param string $value
	 * @return Tag
	 */
	public function set($value)
	{
		$this->tagInner = '';
		$this->append($value);

		return $this;
	}


	/**
	 * Hängt an den InnerTag einen neuen hinzu
	 *
	 * @param mixed $value
	 * @return Tag
	 */
	public function append($value)
	{
		if (is_string($value) && trim($value) == '')
		{
			return $this;
		}

		if (is_array($value) && empty($value))
		{
			return $this;
		}

		if (!is_array($this->tagInner))
		{
			$preset = array();
			if (!empty($this->tagInner))
			{
				$preset = array($this->tagInner);
			}
			$this->tagInner = $preset;
		}
		$this->tagInner[] = $value;

		return $this;
	}

	/**
	 * Hängt vor dem innerTag einen neuen hinzu
	 *
	 * @param mixed $value
	 * @return Tag
	 */
	public function prepend($value)
	{
		if (!is_array($this->tagInner))
		{
			$this->tagInner = array($this->tagInner);
		}
		array_splice($this->tagInner, 0, 0, array($value));

		return $this;
	}

	/**
	 * @param Tag $obj
	 * @return Tag
	 */
	public function appendTo(Tag $obj)
	{
		$obj->append($this);

		return $this;
	}

	/**
	 * @param Tag $obj
	 * @return Tag
	 */
	public function prependTo(Tag $obj)
	{
		$obj->prepend($this);

		return $this;
	}

	/**
	 * Sucht Tag mit ID $elementId
	 *
	 * @param string      $elementId
	 * @param string|null $container
	 * @return null|Tag
	 */
	public function findTagById($elementId, $container = null)
	{
		if (is_null($container))
		{
			$container = $this;
		}

		foreach ($container->getInner() as $tag)
		{

			$target = $this->searchTag($tag, $elementId);
			if ($target)
			{
				return $target;
			}
		}

		return null;
	}

	/**
	 * @param string $haystack
	 * @param string $needle
	 * @return null|Tag
	 */
	private function searchTag($haystack, $needle)
	{
		if ($haystack instanceof \Templates\Html\Tag)
		{
			/**
			 * @var $tag \Templates\Html\Tag
			 */
			if ($haystack->getId() == $needle)
			{
				return $haystack;
			}
			elseif ($haystack->hasInner())
			{
				$target = $this->findTagById($needle, $haystack);
				if ($target)
				{
					return $target;
				}
			}
		}
		elseif (is_array($haystack))
		{
			foreach ($haystack as $moretag)
			{
				$target = $this->findTagById($needle, $moretag);
				if ($target)
				{
					return $target;
				}
			}
		}

		return null;
	}
}