<?php

namespace Templates\MandyLane;

class Anchor extends \Templates\Html\Anchor
{

	/**
	 * @var array|string
	 */
	private $defaultClass = '';

	/**
	 * @var bool
	 */
	protected $socketIODataArray = array();

	/**
	 * @param string       $href
	 * @param array|string $linkText
	 * @param bool         $asButton
	 * @param array        $classOrAttributes
	 */
	public function __construct($href, $linkText = '', $asButton = false, $classOrAttributes = array())
	{
		parent::__construct('a', $linkText, $classOrAttributes);
		$this->setHref($href);

		$this->defaultClass = $classOrAttributes;

		if ($asButton)
		{
			$this->asButton();
		}
	}

	/**
	 * @return void
	 */
	public function asButton()
	{
		$this->addClass('iconlink');
	}

	/**
	 * @return void
	 */
	public function setButtonColorRed()
	{
		$this->removeClass('button_green');
		$this->addClass('iconlink');
		$this->addClass('button_red');
	}

	/**
	 * @return void
	 */
	public function setButtonColorGreen()
	{
		$this->removeClass('button_red');
		$this->addClass('iconlink');
		$this->addClass('button_green');
	}

	/**
	 * @param        $operation
	 * @param string $selector
	 * @param array  $options
	 * @return void
	 */
	public function addForceAjax($operation, $selector = '', $options = array())
	{
		$this->addAttribute('data-ajax', 'true');
		$this->addAttribute('data-ajax-operation', $operation);
		$this->addAttribute('data-ajax-options', base64_encode(json_encode($options)));
		$this->addAttribute('data-ajax-selector', $selector);
	}


	/**
	 * @param boolean $socketIOCall
	 * @return void
	 */
	public function setSocketIODataArray($socketIODataArray)
	{
		$this->socketIODataArray = $socketIODataArray;
	}


	/**
	 * @return string
	 */
	public function toString()
	{
		if(!empty($this->socketIODataArray))
		{
			$this->addJsFile('/static/js/custom/mandy/queueMessageOnClick.js');
			$this->addAttribute('data-on-click-socketio', 1);
			$this->addAttribute('data-socket-values', htmlspecialchars(json_encode($this->socketIODataArray)), ENT_QUOTES);
		}

		return parent::toString();
	}
}