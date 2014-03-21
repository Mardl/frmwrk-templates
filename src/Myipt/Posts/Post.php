<?php

namespace Templates\Myipt\Posts;

/**
 * Class Headline
 *
 * Liefert die Headline für die PostsListen
 *
 * @category Lifemeter
 * @package  Templates\Myipt
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Post extends \Templates\Html\Tag
{

	/**
	 * @var \App\Models\Post
	 */
	protected $post;

	/**
	 * @var \Core\View
	 */
	protected $view;

	/**
	 * @var \App\Manager\Services
	 */
	protected $servicemanager;

	/**
	 * Hilfsvariable für den InformationenBlock des Posts
	 * @var \Templates\Html\Tag
	 */
	protected $infos;

	/**
	 * Konstruktor
	 *
	 * @param \App\Models\Post $post
	 */
	public function __construct($post)
	{
		parent::__construct('div', '', 'availPost');
		$this->setId("post".$post->getId());
		$this->post = $post;
	}

	/**
	 * Setzt den View
	 *
	 * @param \Core\View &$view
	 *
	 * @return void
	 */
	public function setView(&$view)
	{
		$this->view = $view;
	}

	/**
	 * Setzt den Servicemanager
	 *
	 * @param \App\Manager\Services &$manager
	 * @return void
	 */
	public function setServicemanager(&$manager)
	{
		$this->servicemanager = $manager;
	}

	/**
	 * Fügt dem Post das Thumbnail des Statusfoto hinzu
	 *
	 * @return void
	 */
	private function addThumbnail()
	{
		/**
		 * @var $file \App\Models\Directory\Files
		 */
		$file = $this->post->getFile();
		$img = $file->getThumbnail(200, 200, '', '', null, true, true);

		$anchor = new \Templates\Html\Anchor(
			$this->view->url(
				array(
					'action' => 'urkunde',
					'format' => 'html',
					'id' => $this->post->getUser()->getId(),
					'post' => $this->post->getId()
				)
			),
			$img
		);
		$anchor->addAttribute("target", "_blank");
		$anchor->addClass("profileImage");
		$this->append($anchor);
	}

	/**
	 * Fügt die Dauer dem Post hinzu
	 *
	 * @return void
	 */
	private function addDuration()
	{
		$duration = new \Templates\Html\Tag("h4", $this->post->getDurationAsString());
		$duration->addStyle("margin-top", "8px");
		$this->append($duration);
	}

	/**
	 * Erstellt den Infoblock
	 *
	 * @return void
	 */
	private function addInfos()
	{
		$this->infos = new \Templates\Html\Tag("div", '', 'tLeft infos');
		$this->append($this->infos);

		$this->addInfosEntries();
		$this->addInfosComment();
		$this->addInfosPages();


	}

	/**
	 * Fügt die Einträge zu dem InfoBlock
	 *
	 * @return void
	 */
	private function addInfosEntries()
	{
		$entries = $this->post->getEntries();
		foreach($entries as &$entry)
		{
			$title = new \Templates\Html\Tag("h4", $entry->getTitle());
			$this->infos->append($title);
			$this->infos->append(new \Templates\Html\Tag("div", sprintf("%s%s", $entry->getDiff(), $entry->getEntity())));
		}
		unset($entry);
	}

	/**
	 * Fügt den Kommentar dem InfoBlock hinzu
	 *
	 * @return void
	 */
	private function addInfosComment()
	{
		$comment = new \Templates\Html\Tag("div", $this->post->getComment());
		$comment->addStyle("margin-top", "8px");
		$this->infos->append($comment);
	}

	/**
	 * Fügt die ausgewählten Services dem InfoBlock hinzu
	 *
	 * @return void
	 */
	private function addInfosPages()
	{
		$pages = $this->post->getPages();
		foreach($pages as &$page)
		{
			if ($page->getPageid() > 0)
			{
				$service = $this->servicemanager->getById($page->getPageid());
				$p = $service->getFile();
				$span = new \Templates\Html\Tag("span", $p->getThumbnail(60, 60, '', '', null, false, true), 'img');
				$this->infos->append($span);
			}
		}
		unset($entry);
	}

	/**
	 * Fügt dem Post die ControlButtons hinzu
	 *
	 * @return void
	 */
	private function addControls()
	{
		$anchorDelete = new \Templates\Html\Anchor($this->view->url(array('action'=>'deletePost', 'format' => 'json','id'=>$this->post->getId())), "x");
		$anchorDelete->addClass("deletePost");
		$anchorDelete->addClass("get-ajax");
		$this->append($anchorDelete);


		$anchorEdit = new \Templates\Html\Anchor(
			$this->view->url(
				array(
					"action" => "editPost",
					"format" => "html",
					"userid" => $this->post->getUser()->getId(),
					"postid" => $this->post->getId(),
					"ajax" => 'true'
				)
			),
			"+",
			'fancybox fancybox.ajax'
		);

		$anchorEdit->addClass("editPost");
		$this->append($anchorEdit);
	}

	/**
	 * (non-PHPdoc)
	 * @see \Templates\Html\Tag::toString()
	 *
	 * @return string
	 */
	public function toString()
	{
		$this->addThumbnail();
		$this->addDuration();
		$this->addInfos();
		$this->addControls();

		return parent::toString();

	}


}