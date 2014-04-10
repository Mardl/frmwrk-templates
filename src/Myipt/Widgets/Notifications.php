<?php

namespace Templates\Myipt\Widgets;

/**
 * Class Notificationswidget
 *
 * @category Lifemeter
 * @package  Templates\Myipt\Widgets
 * @author   Alexander Jonser <aj@whm-gmbh.net>
 */
class Notifications extends \Templates\Myipt\Widget
{

	/**
	 * @var boolean
	 */
	protected $coach = false;

	/**
	 * @var array
	 */
	protected $notifications = array();

	/**
	 * @var boolean
	 */
	protected $limit = false;

	/**
	 * @var string|null
	 */
	protected $moreUrl = null;


	/**
	 * Konstruktor
	 *
	 * @param \Core\View   $view
	 * @param string       $headline
	 * @param array        $notifications
	 * @param bool|integer $limit
	 * @param string       $moreUrl
	 * @param string       $size
	 */
	public function __construct($view, $headline = null, $notifications = array(), $limit = false, $moreUrl = null, $size = 'colThreeQuarter')
	{
		parent::__construct($headline, '', "{$size} notifies flow");

		$this->setView($view);

		$this->notifications = $notifications;
		$this->limit = $limit;
		$this->moreUrl = $moreUrl;
	}

	/**
	 * @param boolean $bool
	 * @return void
	 */
	public function setCoach($bool)
	{
		$this->coach = $bool;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Templates\Myipt\Widget::toString()
	 * @return string
	 */
	public function toString()
	{
		$list = new \Templates\Myipt\UnsortedList();

		$counter = 0;
		foreach ($this->notifications as $noti)
		{
			if ($this->limit && $counter >= $this->limit)
			{
				break;
			}

			$class = '';
			$icon = '';
			if ($noti->getNotificationposition() && $noti->getNotificationposition()->getAlert() == 1)
			{
				$class = 'alert';
				$icon = 'white';
			}

			$urlArray = array('module'=>'notifications', 'controller'=>'index', 'action'=>'redirect', 'id' => $noti->getId());
			$url = $this->view->url($urlArray);

			if (!$this->coach && ($noti->getNotificationposition() && $noti->getNotificationposition()->isCoachassistet()))
			{
				$url = '#';
			}

			$list->append(
				sprintf("%s %s", new \Templates\Html\Anchor($url, $noti->getPreparedText()), new \Templates\Myipt\Iconanchor($url, "next big {$icon}")),
				$class
			);
			$counter++;
		}


		if ($this->limit && count($this->notifications) > $this->limit)
		{
			$url = $this->view->url(array('module'=>'notifications', 'controller'=>'index', 'action'=>'index'));
			if (!is_null($this->moreUrl))
			{
				$url = $this->moreUrl;
			}

			$anchor = new \Templates\Html\Anchor($url, "mehr");
			$this->setFooter($anchor, 'notifi');
		}

		$this->append($list);

		return parent::toString();
	}


}
