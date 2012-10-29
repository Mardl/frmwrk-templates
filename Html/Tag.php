<?php

namespace Templates\Html;

class Tag
{
	protected $tagName = null;
	protected $tagValue = array();
	protected $tagAttributes = array();
	protected $tagStyle = array();
	protected $forceClose = true;

	/**
	 * CONSTRUCTOR
	 *
	 * @param $tag
	 * @param array|string $value or array of Tags
	 * @param array|string $classOrAttributes
	 */
	public function __construct($tag, $value=array(), $classOrAttributes = array())
	{
		$this->tagName = $tag;
		$this->tagValue = $value;
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
				$this->addClass($classOrAttributes);
			}
		}
	}

	public function setId($id)
	{
		return $this->addAttribute('id', $id);
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
	 * @deprecated Tagename on consturcor
	 */
	public function setTagname($tag) {
		$this->tagName = $tag;
	}

	/**
	 * Setter für Tag-Wert
	 * @param mixed $value
	 * @return Tag
	 */
	public function setValue($value)
	{
		$this->tagValue = $value;
		return $this;
	}

	/**
	 * Getter für Tag-Wert
	 * @return array|mixed
	 */
	public function getValue()
	{
		return $this->tagValue;
	}

	private function renderToString($value) {
		if(is_string($value) || is_int($value)) {
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
				$string .= $this->renderToString($vals) . "\n";
			}
		}
		return $string;
	}

	public function getValueAsString()
	{
		return $this->renderToString($this->tagValue);
	}

	/**
	 * Fügt den übergebenen Wert zum Tag-Wert hinzu.
	 * Falls ein Wert bereits gesetzt ist, wird ein Array gebildet.
	 *
	 * @param mixed $value
	 * @return Tag
	 */
	public function addValue($value)
	{
		if(!is_array($this->tagValue))
		{
			$preset = array();
			if(!empty($this->tagValue)) {
				$preset = array($this->tagValue);
			}
			$this->tagValue = $preset;
		}
		$this->tagValue[] = $value;
		return $this;
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
	 * Überprüft, ob ein bestimmte Style-Wert gesetzt ist
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

		$this->tagAttributes['class'][] = $class;
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
		if(!empty($this->tagValue) || $this->forceClose) {
			$str .= '>';
		}
		$str .= $this->getValueAsString();
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
		if(!empty($this->tagValue) || $this->forceClose)
		{
			return '</' . $this->tagName . '>';
		}
		return ' />';
	}

	public function append($value)
	{
		$this->addValue($value);
		return $this;
	}

	public function prepend($value)
	{
		if(!is_array($this->tagValue))
		{
			$this->tagValue = array($this->tagValue);
		}
		array_splice($this->tagValue, 0, 0, array($value));
		return $this;
	}

	public function appendTo(Tag $obj)
	{
		$obj->append($this);
		return $this;
	}

	public function prependTo(Tag $obj)
	{
		$obj->prepend($this);
		return $this;
	}
}