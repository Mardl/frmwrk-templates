<?php

namespace Templates\Myipt;


class Meallist extends \Templates\Html\Tag
{

	protected $content;
	protected $data;
	protected $view;
	protected $category;
	protected $search;


	public function __construct($title, array $infos, array $meals, $view, $cat, $searchphrase) {
		$this->content = new \Templates\Html\Tag("div", '', 'mahlzeiten');
		$this->initHeadline($title, $infos);
		$this->data = $meals;
		$this->view = $view;
		$this->category = $cat;
		$this->search = $searchphrase;
	}

	public function initHeadline($title, $infos){
		$headline = $title;
		$headline.= implode('', array_map(function($el){ return "<span class='column'>{$el}</span>";}, $infos));
		$this->content->append( new \Templates\Html\Tag("h3", $headline, "headline"));
	}


	public function toString(){
		return $this->content->toString();
	}

}