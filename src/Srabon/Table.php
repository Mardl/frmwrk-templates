<?php

namespace Templates\Srabon;

use jamwork\common\Registry;
use \Templates\Html\Tag;

class Table extends \Templates\Html\Table
{

	private $flat = true;
	private $tools = false;
	private $nosearch = false;
	private $datatable = true;
	private $headline = '';
	private $inbox = false;
	private $noNiceScroll = false;
	private $options = array();
	//private $firstColumnFixed = false;

	public function __construct($headline='', $classOrAttributes = array())
	{
		parent::__construct($classOrAttributes);

		$this->addClass('table');
		$this->headline = $headline;
	}

	/**
	 * @param string $headline
	 */
	public function setHeadline($headline)
	{
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

    public function noNiceScroll() {
        $this->noNiceScroll = true;
    }



	/*public function setFirstColumnFixed()
	{
		$this->firstColumnFixed = true;

	}*/

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

		$this->setOption('sPaginationType',"full_numbers",true);
		$this->setOption('iDisplayLength',10,true);
		if ($this->tools)
		{
			$this->setOption('sDom','<"tbl-tools-searchbox"fl<"clear">>,<"tbl_tools"CT<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>',true);
			$this->setOptions('oTableTools','sSwfPath','/static/swf/copy_cvs_xls_pdf.swf',true);
		}
		else
		{
			$this->setOption('sDom','<"table_top clearfix"fl<"clear">>,<"table_content"t>,<"table_bottom"p<"clear">>',true);
		}


		if ($this->datatable)
		{
			$this->addClass('dataTable');
			$type = 'data-tbl-simple table-bordered';
			$this->setInternalisation();
		}

		if ($this->inbox && $this->datatable)
		{
			$type = 'data-tbl-inbox table-bordered';
			$this->setOption('aaSorting',array(
				array(1, 'asc'),
				array(2, 'asc'),
			));
			$this->setInternalisation();
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
			$this->setInternalisation();
		}
		if ($this->tools && $this->datatable)
		{
			$type = 'data-tbl-tools';
			$typeWidget = 'widget-block';
			$this->setInternalisation();
		}

		/*if ($this->firstColumnFixed && $this->datatable)
		{
			$this->setOption("bSort",false,true);
			$this->setOption("paging",false,true);
			$this->setOption("fixedColumns",true,true);
			$this->setOption("scrollCollapse",true,true);
			$this->setOption("scrollX",true,true);
			$this->setOption("scrollY",'800px',true);
		}*/

		$this->addClass($type);

		$optionsstring = !empty($this->options) ? base64_encode(json_encode($this->options)) : '';
		$this->addAttribute('data-base64',$optionsstring);


		$strOutTable = parent::toString();

		// Widget Bauen

		$divWidget = new Tag('div','',$typeWidget);
        if ($this->noNiceScroll) {
            $divWidget->addClass('noNiceScroll');
        }
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

		$this->addAdditionalClassToWidget($divWidget);

		return $divWidget->toString();

	}

	protected function addAdditionalClassToWidget(Tag $divWidget) {
        // Muss abgeleitet werden und gemacht was gemacht werden muss
    }

	private function setInternalisation()
	{
		$registry = Registry::getInstance();
		$session = $registry->getSession();
		$actCountry = $session->get('backendCountry');
		$i18nFileName = $registry->conf->WWW_ROOT.'/static/js/i18n/dataTables.'.$actCountry.'.txt';
		if (file_exists($i18nFileName))
		{
			$this->setOptions('oLanguage','sUrl','static/js/i18n/dataTables.'.$actCountry.'.txt',false);
		}

	}



}