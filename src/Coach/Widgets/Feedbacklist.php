<?php

namespace Templates\Coach\Widgets;


class Feedbacklist extends \Templates\Html\Tag
{

	protected $header;
	protected $content;
	protected $view;

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct(array $feedbacks, $view)
	{
		parent::__construct("table", '', "colFull feedbacklist widget");
		$this->view = $view;
		$this->initHeader();
		$this->initContent($feedbacks);



	}

	public function initHeader(){
		$this->header = new \Templates\Html\Tag("thead");
		$row = new \Templates\Html\Tag('tr');
		$this->header->append($row);

		$row->append( new \Templates\Html\Tag("th", "Benutzer") );
		$row->append( new \Templates\Html\Tag("th", "Kategorie", "medium") );
		$row->append( new \Templates\Html\Tag("th", "Service") );
		$row->append( new \Templates\Html\Tag("th", "Trainer") );
		$row->append( new \Templates\Html\Tag("th", "Betreff") );
		$row->append( new \Templates\Html\Tag("th", "Datum") );
		$row->append( new \Templates\Html\Tag("th", "neu", "short") );

		$this->append($this->header);
	}

	public function initContent($feedbacks){
		$this->content = new \Templates\Html\Tag("tbody");
		$this->append($this->content);

		foreach ($feedbacks as $feedback){
			$row = new \Templates\Html\Tag('tr');
			$row->append( $this->anchor($feedback->getId(), $feedback->getUserName()) );
			$row->append( $this->anchor($feedback->getId(), $feedback->getCategoryTitle(), "medium"));
			$row->append( $this->anchor($feedback->getId(), $feedback->getServiceName()) );
			$row->append( $this->anchor($feedback->getId(), $feedback->getTrainerName()) );
			$row->append( $this->anchor($feedback->getId(), $feedback->getSubject()) );
			$row->append( $this->anchor($feedback->getId(), $feedback->getCreated()->format('d.m.Y, H:i')) );

			$checkbox = new \Templates\Coach\Questionary\Checkbox('f_'.$feedback->getId(),'feedback',$feedback->getId(),'', ($feedback->getStatus() == 1));
			$checkbox->addAttribute("disabled", "disabled");
			$row->append( new \Templates\Html\Tag("td", $checkbox, "short") );

			$this->content->append($row);

		}

	}

	private function anchor($id, $text, $class = ''){
		$anchor = new \Templates\Html\Anchor( $this->view->url(array('id'=>$id,'action'=>'details')), $text);
		$anchor->addClass('get-ajax');
		return new \Templates\Html\Tag("td", $anchor, $class);
	}

}
