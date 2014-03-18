<?php

namespace Templates\Myipt\Widgets;


class Jobs extends \Templates\Myipt\Widget
{

	/**
	 * @param string $headerText
	 * @param array $value
	 * @param bool $style2
	 * @param array $classOrAttributes
	 * @param bool $showhidden
	 */
	public function __construct($view, $headline = null, $notifications = array(), $limit = false, $moreUrl = null, $size = 'colThreeQuarter')
	{
		parent::__construct($headline, '', "{$size} jobs flow");

		$this->setView($view);

		$list = new \Templates\Myipt\UnsortedList();

		$counter = 0;
		foreach ($notifications as $noti){
			if ($limit && $counter >= $limit){
				break;
			}

			$class = '';
			$icon = '';
			if ($noti->getNotificationposition() && $noti->getNotificationposition()->getAlert() == 1){
				$class = 'alert';
				$icon = 'white';
			}

			if ($noti->getType() == \App\Models\Notification::TYPE_MCTCTERAUG)
			{
				$class .= ' makeMeDraggable';
			}

			$item = $list->append(
				$this->getListItem($noti),
				$class
			);

			$item->addAttribute("data-id", $noti->getId());
			$item->addAttribute("data-title", $noti->getPreparedText());
			$item->addAttribute("data-userid", $noti->getReceiver()->getId());

			$counter++;
		}


		if ($limit && count($notifications) > $limit){
			$url = $this->view->url(array('module'=>'notifications', 'controller'=>'index', 'action'=>'index'));
			if (!is_null($moreUrl)){
				$url = $moreUrl;
			}

			$anchor = new \Templates\Html\Anchor($url, "mehr");
			$this->setFooter($anchor, 'notifi');
		}

		$this->append($list);

	}

	private function getListItem($noti)
	{
		if (!$noti->linkDisabled())
		{
			$item = sprintf(
				"%s %s",
				new \Templates\Html\Anchor(
					$this->view->url(array('module'=>'notifications', 'controller'=>'index', 'action'=>'redirect', 'id' => $noti->getId()), true),
					substr($noti->getPreparedText(), 0, 100)
				),
				new \Templates\Html\Anchor(
					$this->view->url(array('module'=>'notifications', 'controller'=>'index', 'action'=>'redirect', 'id' => $noti->getId()), true),
					substr($noti->getFaelligkeit(), 0, 100)
				)
			);
		}
		else
		{
			$item = sprintf(
				"%s %s",
				new \Templates\Html\Anchor("#", substr($noti->getPreparedText(), 0, 100)),
				new \Templates\Html\Anchor("#", substr($noti->getFaelligkeit(), 0, 100))
			);
		}


		return $item;
	}


}
