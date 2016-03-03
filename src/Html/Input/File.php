<?php

namespace Templates\Html\Input;

class File extends \Templates\Html\Input {
    /**
     * @param string $name
     * @param string $value
     * @param array  $opt
     * @param bool   $required
     * @param string $placeholder
     * @param array  $classOrAttributes
     */
    public function __construct($name, $value = '', $opt = [], $required = false, $placeholder = '', $classOrAttributes = []) {
        parent::__construct($name, $value, $opt, $required, $placeholder = '', $classOrAttributes);
        $this->setType("file");
        $this->addClass('file');
    }

    /**
     * Erlaubt die auswahl von mehr als nur einer Datei
     *
     * @param bool $status
     */
    public function multiple($status = false) {
        if ($status) {
            if (!$this->hasAttribute("multiple")) {
                $this->addAttribute("multiple", "");
            }
        }
        else {
            if ($this->hasAttribute("multiple")) {
                $this->removeAttribute("multiple");
            }
        }
    }
}
