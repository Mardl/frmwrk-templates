<?php

namespace Templates\Srabon;

use \Templates\Html\Input\Textarea;

/**
 * @author Martin Eisenführer
 * @category Templates
 * @package Templates/Srabon
 */
class TextareaMCE extends Textarea
{
	const PRESET_FULL = 'full';
	const PRESET_MINIMAL = 'minimal';
	const PRESET_MEDIUM = 'medium';

	/**
	 * @var array
	 */
	protected $options = array();

	/**
	 * @var string
	 */
	protected $defaultPreset = 'minimal';

	/**
	 * @var array
	 */
	protected $presets = array();

	/**
	 * @param string $name
	 * @param string $value
	 * @param string $placeholder
	 * @param bool $required
	 * @param array $classOrAttributes
	 */
	public function __construct($name, $value='', $placeholder='', $required=false, $classOrAttributes = array())
	{
		parent::__construct($name, $value, $placeholder, $required, $classOrAttributes);
        $this->addClass('tinymce');
		$this->initPresets();
		$this->setPreset($this->defaultPreset);
	}

	/**
	 * @return void
	 */
	protected function initPresets()
	{
		$this->presets = array(
			'full' => array(
				'theme' => "advanced",
				'plugins' => "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
				'theme_advanced_buttons1' => "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
				'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
			),
			'medium' => array(
				'theme' => "advanced",
				'plugins' => "autolink,lists,pagebreak,layer,table,advlink,inlinepopups,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
				'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,undo,redo,|,cleanup,removeformat,visualaid,|,help,code,fullscreen",
				'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image",
				'theme_advanced_buttons3' => "tablecontrols,|,sub,sup,charmap,nonbreaking,hr",
				'theme_advanced_buttons4' => "",
			),
			'minimal' => array(
				'theme' => "advanced",
				'plugins' => "autolink,lists,pagebreak,layer,table,advlink,inlinepopups,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
				'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,bullist,numlist,|,cleanup,removeformat,|,sub,sup,charmap,nonbreaking,hr,|,code,fullscreen",
				'theme_advanced_buttons2' => "tablecontrols,|,pastetext,pasteword,|,link,unlink",
				'theme_advanced_buttons3' => "",
				'theme_advanced_buttons4' => "",
			),
		);
	}

	/**
	 * @param string $name
	 * @throws \InvalidArgumentException
	 * @return void
	 */
	public function setPreset($name)
	{
		if(!array_key_exists($name, $this->presets)) {
			throw new \InvalidArgumentException("Unknown TinyMCE-Preset '$name'");
		}
		foreach($this->presets[$name] as $key => $value) {
			$this->setOption($key, $value);
		}
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param bool $notOverride
	 * @return TextareaMCE
	 */
	public function setOption($key, $value, $notOverride=false)
	{
		if ($notOverride && isset($this->options[$key]))
		{
			return $this;
		}
		$this->options[$key] = $value;
		return $this;
	}

	/**
	 * @return string
	 */
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