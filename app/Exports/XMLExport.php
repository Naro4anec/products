<?php

namespace App\Exports;

use App\Exports\XML\BaseElement;
use App\Exports\XML\Element;
use App\Exports\XML\MultipleElement;
use App\Exports\XML\SimpleElement;
use App\Exports\XML\Structure;
use App\Models\Shop;

class XMLExport extends BaseExport
{
    public const FILE_TYPE = 'xml';

    protected $struct = [];
    protected $document = null;
    protected $version = '1.0';
    protected $encoding = 'utf-8';

    /**
     * @param Element $struct
     * @param $item
     * @return \DOMElement
     */
    protected function createElement(Element $struct, &$item) : \DOMElement
    {
        $result = null;
        $result = $this->document->createElement($struct->getName());
        $this->addAttributes($result, $struct->getAttributes(), $item);

        if($struct instanceof SimpleElement){
            $valueKey = $struct->getValue();
            if(isset($item[$valueKey])){
                $result->nodeValue = (string)$item[$valueKey];
            }
        }

        if($struct instanceof MultipleElement){
            if($struct->getType() === MultipleElement::TYPE_MULTIPLE){
                $valuesKey = $struct->getMultiKey();
                if(isset($item[$valuesKey])){
                    foreach ($item[$valuesKey] as &$multiItem) {
                        $this->addMultupleElements($result, $struct, $multiItem);
                    }
                }
            }else{
                $this->addMultupleElements($result, $struct, $item);
            }
        }
        return $result;
    }

    /**
     * @param \DOMElement $baseElement
     * @param Element $struct
     * @param $item
     */
    protected function addMultupleElements(\DOMElement &$baseElement, Element $struct, &$item) : void
    {
        foreach ($struct->getData() as $childElement) {
            $baseElement->appendChild(
                $this->createElement($childElement, $item)
            );
        }
    }

    /**
     * @param $xmlItem
     * @param array $list
     * @param $item
     */
    protected function addAttributes(&$xmlItem, array $list, &$item) : void
    {
        foreach ($list as $attrKey => $attrValueKey){
            if(isset($item[$attrValueKey])){
                $xmlItem->setAttribute($attrKey, $item[$attrValueKey]);
            }else{
                $xmlItem->setAttribute($attrKey, '');
            }
        }
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding(string $encoding): void
    {
        $this->encoding = $encoding;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * @param Structure $struct
     */
    public function setStructure(Structure $struct) : void
    {
        $this->struct = $struct;
    }

    /**
     * @return bool
     */
    public function checkRequire() : bool
    {
        if(empty($this->struct)){
            $this->lastError = 'Empty structure';
            return false;
        }
        if(empty($this->exportData)){
            $this->lastError = 'Empty data';
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function makeFile() : bool
    {
        if(!$this->checkRequire()){
            return false;
        }

        $this->document = new \DOMDocument($this->version, $this->encoding);

        $baseStructElement = $this->struct->getBaseElement();
        foreach ($this->exportData as &$item){
            $this->document->appendChild(
                $this->createElement($baseStructElement, $item)
            );
        }

        $this->document->save(static::BASE_PATH . $this->filePath . '/' . $this->fileName . '.xml');
        return true;
    }

}
