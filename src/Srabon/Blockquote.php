<?php
namespace Templates\Srabon;

use Templates\Html\Tag;

/**
 * Class Blockquote
 *
 * @category Thomann
 * @package  Templates\Srabon
 * @author   Reinhard Hampl <reini@dreiwerken.de>
 */
class Blockquote extends Tag
{
    const COLOR_BLUE = 1;
    const COLOR_ORANGE = 2;
    const COLOR_PINK = 3;

    /**
     * @var string
     */
    protected $text = null;

    /**
     * @var int
     */
    protected $colorType = self::COLOR_BLUE;


    /**
     * @param string $tag               Default = i-Tag
     * @param string $inner             default = ''
     * @param array  $classOrAttributes array of attributes or string as class or string start with # as ID
     */
    public function __construct($text = '', $classOrAttributes = array())
    {
        $this->setText($text);
        parent::__construct('blockquote', '', $classOrAttributes);
    }

    /**
     * @param string $text
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    /**
     * Setzt die gewünschte Farbe
     *
     * @param $colorType
     */
    public function setColor($colorType)
    {
        $this->colorType = $colorType;
    }

    /**
     * @return string
     */
    private function getColorClass()
    {
        switch ($this->colorType)
        {
            case self::COLOR_BLUE:
                return 'quote_blue';
            case self::COLOR_ORANGE:
                return 'quote_orange';
            case self::COLOR_PINK:
                return 'quote_pink';
        }
    }

    /**
     * @return string
     */
    public function toString()
    {
        $textContainer = new Tag('p');
        $textContainer->append($this->getText());

        $className = $this->getColorClass();
        $this->addClass($className);
        $this->append($textContainer);
        return parent::toString();
    }


}
