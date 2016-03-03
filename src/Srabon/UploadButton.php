<?php

namespace Templates\Srabon;

use Templates\Html\Tag;
use Templates\Html\Input;
use Templates\Html\Input\File;

/**
 * Class UploadButton
 *
 * @category Dreiwerken
 * @package  Templates\Srabon
 * @author   Mahmood Dhia <mahmood@dreiwerken.de>
 */
class UploadButton extends Tag {

    /** @var File  */
    private $fileInput;

    private $dropText;

    private $button;

    /**
     * @param string       $name
     * @param array|string $value
     * @param array        $classOrAttributes
     */
    public function __construct($name, $value, $classOrAttributes = array()) {

        parent::__construct('div', '', $classOrAttributes);
        $this->addClass('fileinput-dropzone');

        $this->button = new Tag('span', '', 'btn fileinput-button');
        $this->button->append($value);

        $this->dropText = new Tag('p');
        $this->dropText->append('Drop Files...');


        $this->fileInput = new File("files[]");
        $this->fileInput->removeAttribute('id');
        $this->fileInput->multiple(true);
    }

    /**
     * @return File
     */
    public function getFileInput()
    {
        return $this->fileInput;
    }

    /**
     * @return Tag
     */
    public function getButton()
    {
        return $this->button;
    }

    /**
     * @return Tag
     */
    public function getDropText()
    {
        return $this->dropText;
    }

    public function toString()
    {
        $this->append($this->getFileInput());
        $this->append($this->getDropText());
        $this->append($this->getButton());

        return parent::toString();
    }
}