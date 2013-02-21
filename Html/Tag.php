<?php

namespace Templates\Html;

class Tag
{
	protected $tagName = null;
	protected $tagInner = array();
	protected $tagAttributes = array();
	protected $tagStyle = array();
	protected $forceClose = true;
	protected $formatOutput = '';

	/**
	 * @param string $tag Default = div-Tag
	 * @param string $inner
	 * @param array $classOrAttributes array of attributes or string as class or string start with # as ID
	 */
	public function __construct($tag='div', $inner='', $classOrAttributes = array())
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
				foreach($classOrAttributes as $name => $attr)
				{
					$this->addAttribute($name,$attr);
				}
			}
			else
			{
				$classOrAttributes = trim($classOrAttributes);
				if (substr($classOrAttributes,0,1) == '#')
				{
					$this->setId(substr($classOrAttributes,1));
				}
				else
				{
					$this->addClass($classOrAttributes);
				}

			}
		}
	}

	/**
	 *
	 * Setzen von Attribut ID
	 *
	 * @param $id
	 * @return Tag
	 */
	public function setId($id)
	{
		return $this->addAttribute('id', $id);
	}

	public function getId()
	{
		return $this->getAttribute('id');
	}

	/**
	 *
	 * Format für Output-Formatierung im format sprintf
	 *
	 * @param $format
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
	public function __toString() {
		return $this->toString();
	}

	/**
	 * Tagname
	 * @param string $tag
	 */
	public function setTagname($tag) {
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
	 * Getter für Tag-Wert
	 * @return array|mixed
	 */
	public function getInner()
	{
		return $this->tagInner;
	}

	/**
	 * @param $value
	 * @return string
	 * @throws \Templates\Exceptions\Convert
	 */
	protected function renderToString($value)
	{
		if(is_string($value) || is_int($value))
		{
			if (!empty($this->formatOutput))
			{
				return sprintf($this->formatOutput,$value);
			}
			return $value;
		}

		if(is_object($value)) {
			if(method_exists($value, 'toHtml')) {
				return $value->toHtml();
			}
			if(method_exists($value, '__toString')) {
				return $value->__toString();
			}

			throw new \Templates\Exceptions\Convert('Der Wert des Tags ist ein Object ohne "toHtml" bzw. "__toString" implementierung.');
		}

		$string = '';
		if(is_array($value)) {
			foreach($value as $vals) {
				$string .= $this->renderToString($vals);// . "\r\n";
			}
		}
		return $string;
	}

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
	 * @param $name
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
	 * @param $name
	 * @param null $default
	 * @return null|string
	 */
	public function getAttribute($name,$default=null)
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
	 * @param string $name
	 * @return bool
	 */
	public function hasStyle($name)
	{
		return array_key_exists($name, $this->tagStyle);
	}

	/**
	 * Überprüft, ob generell Style-Werte vorhanden sind
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
		if(!$this->hasAttribute('class')) {
			$this->tagAttributes['class'] = array();
		}

		$this->tagAttributes['class'][$class] = $class;
		return $this;
	}

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
	 * @return string
	 */
	protected function renderAttributes()
	{
		$this->renderStyles();

		$attributes = array();
		foreach($this->tagAttributes as $key => $value) {
			if(is_array($value)) {
				$value = implode(' ', $value);
			}
			$attributes[] = $key . '="' . $value . '"';
		}
		return implode(' ', $attributes);
	}

	/**
	 * Rendert alle Style-Anweisungen zu einem style-Attribut
	 */
	private function renderStyles()
	{
		if(!$this->hasStyles())
		{
			return;
		}

		$styles = array();
		foreach($this->tagStyle as $key => $value) {
			if(is_array($value)) {
				$value = implode(' ', $value);
			}
			$styles[] = $key . ':' . $value . ';';
		}

		$this->addAttribute('style', implode(' ', $styles));
	}

	/**
	 * Generiert den Tag als String
	 * @return string
	 */
	public function toString()
	{
		$str = '';
		$str .= '<';
		$str .= $this->tagName . ' ';
		$str .= $this->renderAttributes();
		if(!empty($this->tagInner) || $this->forceClose) {
			$str .= '>';
		}
		$str .= $this->getInnerAsString();
		$str .= $this->getCloseTag();
		return $str;
	}

	/**
	 * Alternativer Aufruf von toString()
	 * @return string
	 */
	public function toHtml()
	{
		return $this->toString();
	}

	/**
	 * Generiert den Close-Tag des Tags
	 * @return string
	 */
	protected function getCloseTag()
	{
		if(!empty($this->tagInner) || $this->forceClose)
		{
			return '</' . $this->tagName . '>';
		}
		return ' />';
	}

	/**
	 * Initialisiert den InnerTag und setzt ihn komplett neu
	 *
	 * @param $value
	 * @return Tag
	 */
	public function set($value)
	{
		$this->tagInner='';
		$this->append($value);
		return $this;
	}


	/**
	 *
	 * Hängt an den InnerTag einen neuen hinzu
	 *
	 * @param $value
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

		if(!is_array($this->tagInner))
		{
			$preset = array();
			if(!empty($this->tagInner)) {
				$preset = array($this->tagInner);
			}
			$this->tagInner = $preset;
		}
		$this->tagInner[] = $value;
		return $this;
	}

	/**
	 *
	 * Hängt vor dem innerTag einen neuen hinzu
	 *
	 * @param $value
	 * @return Tag
	 */
	public function prepend($value)
	{
		if(!is_array($this->tagInner))
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
}