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
class Targets extends \Templates\Html\Tag
{

	/**
	 * @var \App\Manager\Services
	 */
	protected $servicemanager;

	/**
	 * @var \App\Models\User
	 */
	protected $user;

	/**
	 * @var array
	 */
	protected $selectedIds;

	/**
	 * @param \App\Models\User $user
	 * @param array            $selectedIds
	 */
	public function __construct(\App\Models\User $user, $selectedIds = array())
	{
		parent::__construct('div', '', 'targets');

		$this->servicemanager = new \App\Manager\Services();
		$this->user = $user;
		$this->selectedIds = $selectedIds;

		$this->addUserServices();
		$this->addSpecialServices();

		$input = $this->createHiddenInput('target', implode(', ', $selectedIds));
		$this->append($input);

	}


	/**
	 * Erstellt die Auswahl für die User Services
	 *
	 * @return void
	 */
	private function addUserServices()
	{
		$services = $this->servicemanager->getServicesByUser($this->user->getId());

		//servicepages
		foreach ($services as $service)
		{
			if ($service->getHidden() == true)
			{
				continue;
			}

			$span = $this->getServiceTag($service);
			$this->append($span);
		}
	}

	/**
	 * Erstellt die Auswahl für die Special Services (Print / Studioaushang)
	 *
	 * @return void
	 */
	private function addSpecialServices()
	{
		$services = $this->servicemanager->getServices();
		//specials
		foreach ($services as $service)
		{
			if ($service->getSpecial() == false)
			{
				continue;
			}

			$span = $this->getServiceTag($service);
			$this->append($span);
		}
	}

	/**
	 * Liefert das TagElement für den Service
	 *
	 * @param App\Models\Service $service
	 *
	 * @return Templates\Html\Tag
	 */
	private function getServiceTag($service)
	{
		$p = $service->getFile();
		$span = new \Templates\Html\Tag("span", $p->getThumbnail(60, 60, '', '', null, false, true), 'img');
		$span->addAttribute("data-id", $service->getId());
		$span->append(new \Templates\Html\Tag("span", '', 'check'));

		if (in_array($service->getId(), $this->selectedIds))
		{
			$span->addClass("active");
		}


		return $span;
	}

	/**
	 * Erstellt ein Input-Hidden
	 *
	 * @param string $id
	 * @param string $value
	 *
	 * @return Templates\Html\Tag
	 */
	private function createHiddenInput($id, $value)
	{
		$input = new \Templates\Html\Tag("input");
		$input->setId($id);
		$input->addAttribute("type", "hidden");
		$input->addAttribute("name", $id);
		$input->addAttribute("value", $value);

		return $input;
	}

}