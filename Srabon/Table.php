<?php

namespace Templates\Srabon;

use \Templates\Html\Tag;

class Table extends \Templates\Html\Table
{

	private $flat = true;
	private $tools = false;
	private $datatable = true;
	private $headline = '';



	public function __construct($headline='', $classOrAttributes = array())
	{
		parent::__construct($classOrAttributes);

		$this->addClass('table');
		$this->addClass('dataTable');
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
		$this->datatable=false;
	}

	public function toString()
	{

		$type = 'data-tbl-nosearch table-bordered';
		$typeWidget = 'nonboxy-widget';
		if ($this->datatable)
		{
			$type = 'data-tbl-simple table-bordered';
		}
		if(!$this->flat)
		{
			$type = 'data-tbl-boxy';
			$typeWidget = 'widget-block';

		}
		if ($this->tools)
		{
			$type = 'data-tbl-tools';
			$typeWidget = 'widget-block';
		}
		$this->addClass($type);
		$strOutTable = parent::toString();

		// Widget Bauen
		$divWidget = new Tag('div','',$typeWidget);
		$div = new Tag('div',new Tag('h5',$this->headline),'widget-head');
		$divWidget->addValue($div);

		if(!$this->flat || $this->tools)
		{
			$wrap1 = new Tag('div',$strOutTable,'widget-box');
			$wrap2 = new Tag('div',$wrap1,'widget-content');
			$divWidget->addValue($wrap2);
		}
		else
		{
			$divWidget->addValue($strOutTable);
		}

		return $divWidget->toString();

	}



}