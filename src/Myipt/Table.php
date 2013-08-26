<?php

namespace Templates\Myipt;

/**
 * Class Table
 *
 * @category Templates
 * @package  Templates\Html
 * @author   Martin Eisenführer <martin@dreiwerken.de>
 */
class Table extends \Templates\Html\Table
{


	/**
	 * @param array  $classOrAttributes
	 * @param string $rowNamespace
	 */
	public function __construct($classOrAttributes = array(), $rowNamespace = '\Templates\Html\Row')
	{
		parent::__construct($classOrAttributes, $rowNamespace);
		$this->addClass('widget');
	}

}
