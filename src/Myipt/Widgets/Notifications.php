<?php

namespace Templates\Myipt\Widgets;


class Notifications extends \Templates\Myipt\Widget
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
		parent::__construct($headline, '', "{$size} notifies flow");

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

			$list->append(
				sprintf(
					"%s %s",
					new \Templates\Html\Anchor(
						$this->view->url(array('module'=>'notifications', 'controller'=>'index', 'action'=>'redirect', 'id' => $noti->getId())),
						substr($noti->getPreparedText(), 0, 100)
					),
					new \Templates\Myipt\Iconanchor(
						$this->view->url(array('module'=>'notifications', 'controller'=>'index', 'action'=>'redirect', 'id' => $noti->getId())),
						"next big {$icon}"
					)
				),
				$class
			);
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




}
