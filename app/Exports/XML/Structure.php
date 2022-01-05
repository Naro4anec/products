<?php


namespace App\Exports\XML;


class Structure
{
    protected $baseElement = null;

    /**
     * @param MultipleElement $element
     */
    public function setBaseElement(MultipleElement $element) : void
    {
        $this->baseElement = $element;
    }

    /**
     * @return MultipleElement|null
     */
    public function getBaseElement() : ?MultipleElement
    {
        return $this->baseElement;
    }
}
