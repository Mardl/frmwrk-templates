<?php

namespace Templates\Srabon;

use Templates\Html\Input;
use Templates\Html\Tag;

/**
 * Class Progress
 *
 * @category Dreiwerken
 * @package  Templates\Srabon
 * @author   Mahmood Dhia <mahmood@dreiwerken.de>
 */
class Progress extends Tag {

    private $objBar = null;

    /**
     * @param string $name
     * @param array  $classOrAttributes
     */
    public function __construct($name = "", $classOrAttributes = array()) {

        $classOrAttributes = 'progress' . (is_string($classOrAttributes) ? " $classOrAttributes" : '');
        parent::__construct('div', '', $classOrAttributes);

        if (!empty($name)) {
            $this->setId($name);
        }

        $this->objBar = new Tag('div', '', 'bar');
        $this->append($this->objBar);
    }

    /**
     * @return null|Tag
     */
    public function getBar() {
        return $this->objBar;
    }

    /**
     * Setzt den Fortschritt des Balkens
     * @param float $progress
     */
    public function setProgress($progress)
    {
        $this->getBar()->addStyle('width', $progress.'%');
    }
}