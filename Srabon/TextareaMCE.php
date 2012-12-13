<?php

namespace Templates\Srabon;

use \Templates\Html\Tag;

class TextareaMCE extends \Templates\Html\Input\Textarea
{

	protected $options = array();

	public function __construct($name, $value='', $placeholder='', $required=false, $classOrAttributes = array())
	{
		parent::__construct($name, $value, $placeholder, $required, $classOrAttributes);

        $this->addClass('tinymce');
	}

    public function setOption($key, $value, $notOverride=false)
    {
        if ($notOverride && isset($this->options[$key]))
        {
            return $this;
        }
        $this->options[$key] = $value;
        return $this;
    }

    public function toString()
    {
        $optionsstring = !empty($this->options) ? base64_encode(json_encode($this->options)) : '';
        if (!empty($optionsstring))
        {
            $this->addAttribute('data-base64',$optionsstring);
        }

        return parent::toString();
    }



}