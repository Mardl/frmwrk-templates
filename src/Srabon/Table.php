<?php

namespace Templates\Srabon;

use \Templates\Html\Tag;

class Table extends \Templates\Html\Table
{

	private $flat = true;
	private $tools = false;
	private $nosearch = false;
	private $datatable = true;
	private $headline = '';
	private $inbox = false;
	private $options = array();

	public function __construct($headline='', $classOrAttributes = array())
	{
		parent::__construct($classOrAttributes);

		$this->addClass('table');
		$this->headline = $headline;
	}

	public function toolbox()
	{
		$this->tools = true;
		$this->flat = false;
	}

	public function widget()
	{
		$this->tools = false;
		$this->flat = false;
	}

	public function noSearch()
	{
		$this->tools = false;
		$this->flat = true;
		$this->nosearch=true;
	}
	public function noDatatable()
	{
		$this->datatable=false;
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

	/**
	 * Mehrdimensionales Array
	 *
	 * @param $key
	 * @param $key2
	 * @param $value
	 * @param bool $notOverride
	 * @return Table
	 */
	public function setOptions($key, $key2, $value, $notOverride=false)
	{
		if ($notOverride && isset($this->options[$key][$key2]))
		{
			return $this;
		}
		$this->options[$key][$key2] = $value;
		return $this;
	}

	public function toString()
	{
		$typeWidget = 'nonboxy-widget';
		$type = 'data-tbl-nothing table-bordered';
		if ($this->datatable)
		{
			$this->addClass('dataTable');
			$type = 'data-tbl-simple table-bordered';
			$this->setOption('sPaginationType',"full_numbers",true);
			$this->setOption('iDisplayLength',10,true);
			$this->setOptions('oLanguage','sLengthMenu','<span class="lenghtMenu"> _MENU_</span><span class="lengthLabel">'.translate('Einträge pro Seite:').'</span>',true);
			$this->setOption('sDom','<"table_top clearfix"fl<"clear">>,<"table_content"t>,<"table_bottom"p<"clear">>',true);
		}

		if ($this->inbox && $this->datatable)
		{
			$type = 'data-tbl-inbox table-bordered';
			$this->setOption('aaSorting',array(
				array(1, 'asc'),
				array(2, 'asc'),
			));
			$this->setOption('sPaginationType',"full_numbers",true);
			$this->setOption('iDisplayLength',10,true);
			$this->setOptions('oLanguage','sLengthMenu','<span class="lenghtMenu"> _MENU_</span><span class="lengthLabel">'.translate('Einträge pro Seite:').'</span>',true);
			$this->setOption('sDom','<"table_top clearfix"fl<"clear">>,<"table_content"t>,<"table_bottom"p<"clear">>',true);
		}
		if ($this->nosearch && $this->datatable)
		{
			$type = 'data-tbl-nosearch table-bordered';
			$this->setOption("bPaginate",false,true);
			$this->setOption("bLengthChange",true,true);
			$this->setOption("bFilter",false,true);
			$this->setOption("bInfo",false,true);
			$this->setOption("bSort",true,true);
			$this->setOption("bAutoWidth",true,true);

		}
		if(!$this->flat && $this->datatable)
		{
			$type = 'data-tbl-boxy';
			$typeWidget = 'widget-block';
			$this->setOption('sPaginationType',"full_numbers",true);
			$this->setOption('iDisplayLength',10,true);
			$this->setOptions('oLanguage','sLengthMenu','<span class="lenghtMenu"> _MENU_</span><span class="lengthLabel">'.translate('Einträge pro Seite:').'</span>',true);
			$this->setOption('sDom','<"tbl-searchbox clearfix"fl<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>',true);


		}
		if ($this->tools && $this->datatable)
		{
			$type = 'data-tbl-tools';
			$typeWidget = 'widget-block';
			$this->setOption('sPaginationType',"full_numbers",true);
			$this->setOption('iDisplayLength',10,true);
			$this->setOptions('oLanguage','sLengthMenu','<span class="lenghtMenu"> _MENU_</span><span class="lengthLabel">'.translate('Einträge pro Seite:').'</span>',true);
			$this->setOption('sDom','<"tbl-tools-searchbox"fl<"clear">>,<"tbl_tools"CT<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>',true);
			$this->setOptions('oTableTools','sSwfPath','swf/copy_cvs_xls_pdf.swf',true);
		}
		$this->addClass($type);

		$optionsstring = !empty($this->options) ? base64_encode(json_encode($this->options)) : '';
		$this->addAttribute('data-base64',$optionsstring);


		$strOutTable = parent::toString();

		// Widget Bauen
		$divWidget = new Tag('div','',$typeWidget);
		if (!empty($this->headline))
		{
			$div = new Tag('div',new Tag('h5',$this->headline),'widget-head');
			$divWidget->append($div);
		}

		if(!$this->flat || $this->tools)
		{
			$wrap1 = new Tag('div',$strOutTable,'widget-box');
			$wrap2 = new Tag('div',$wrap1,'widget-content');
			$divWidget->append($wrap2);
		}
		else
		{
			$divWidget->append($strOutTable);
		}

		return $divWidget->toString();

	}



}