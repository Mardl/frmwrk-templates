<?php

namespace Templates\Coach;

use Core\SystemMessages;

class Dategroup extends \Templates\Coach\Block
{
	public function __construct($parentTag, $label, $datum, $enableYear = true, $enableMonth = true, $enableDay = true, $classOrAttributes = array())
	{
		parent::__construct($parentTag, $classOrAttributes);

		if (!($datum instanceof \DateTime)){
			$datum = new \DateTime($datum);
		}

		$day = $datum->format('d');
		$month = $datum->format('m');
		$year = $datum->format('Y');

		$selectGroup = array();

		if ($enableDay){
			$selectGroup[] = array(
				"name"		=> "day",
				"class" 	=> $classOrAttributes,
				"required"	=> true,
				"options"	=> $this->getDaysArray($day, array("value" => "0", "tag" => "Tag"))
			);
		}

		if ($enableMonth){
			$selectGroup[] = array(
				"name"		=> "month",
				"class" 	=> $classOrAttributes,
				"required"	=> true,
				"options"	=> $this->getMonthsArray($month, array("value" => "0", "tag" => "Monat"))
			);
		}

		if ($enableYear){
			$selectGroup[] = array(
				"name"		=> "year",
				"class" 	=> $classOrAttributes,
				"required"	=> true,
				"options"	=> $this->getYearsArray($year, array("value" => "0", "tag" => "Jahr"))
			);
		}

		$this->addSelects($label, $selectGroup);

	}

	public function getDaysArray($day = false, $default = array()){
		$days = array();

		if (!empty($default)){
			$days[] = $default;
		}

		for ($i = 1; $i <= 31; $i++){
			$days[] = array(
				"value" => $i,
				"tag" => sprintf("%02d", $i),
				"selected" => (sprintf("%02d", $i) == $day)?true:false
			);
		}
		return $days;
	}

	public function getMonthsArray($month = false, $default = array()){
		$months = array();

		if (!empty($default)){
			$months[] = $default;
		}

		$months[] = array("value" => 1, "tag" => "Januar", "selected" => ($month == "01")?true:false );
		$months[] = array("value" => 2, "tag" => "Februar", "selected" => ($month == "02")?true:false );
		$months[] = array("value" => 3, "tag" => "März", "selected" => ($month == "03")?true:false );
		$months[] = array("value" => 4, "tag" => "April", "selected" => ($month == "04")?true:false );
		$months[] = array("value" => 5, "tag" => "Mai", "selected" => ($month == "05")?true:false );
		$months[] = array("value" => 6, "tag" => "Juni", "selected" => ($month == "06")?true:false );
		$months[] = array("value" => 7, "tag" => "Juli", "selected" => ($month == "07")?true:false );
		$months[] = array("value" => 8, "tag" => "August", "selected" => ($month == "08")?true:false );
		$months[] = array("value" => 9, "tag" => "September", "selected" => ($month == "09")?true:false );
		$months[] = array("value" => 10, "tag" => "Oktober", "selected" => ($month == "10")?true:false );
		$months[] = array("value" => 11, "tag" => "November", "selected" => ($month == "11")?true:false );
		$months[] = array("value" => 12, "tag" => "Dezember", "selected" => ($month == "12")?true:false );
		return $months;
	}

	public function getYearsArray($year = false, $default = array(), $limit = 100){
		$today = new \DateTime();
		$thisYear = intval($today->format("Y"));

		$years = array();

		if (!empty($default)){
			$years[] = $default;
		}

		for ($i = $thisYear; $i >= ($thisYear - $limit); $i--){
			$years[] = array(
				"value" => $i,
				"tag" => sprintf("%02d", $i),
				"selected" => (sprintf("%04d", $i) == $year)?true:false
			);
		}
		return $years;
	}

}
