<?php


namespace App\Exports\XML;



class MultipleElement extends BaseElement
{
    public const TYPE_SIMPLE = 1;
    public const TYPE_MULTIPLE = 2;

    protected $multiValueKey = '';
    protected $type = self::TYPE_SIMPLE;
    protected $data = [];

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param string $valueKey
     */
    public function setMulti(string $valueKey) : void
    {
        $valueKey = trim($valueKey);
        if(empty($valueKey)){
            return;
        }
        $this->type = self::TYPE_MULTIPLE;
        $this->multiValueKey = $valueKey;
    }

    /**
     * @return string
     */
    public function getMultiKey() : string
    {
        return $this->multiValueKey;
    }

    /**
     * @param BaseElement $element
     */
    public function addData(BaseElement $element) : void
    {
        $this->data[] = $element;
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * @param int $index
     */
    public function deleteData(int $index) : void
    {
        if(isset($this->data[$index])){
            array_splice($this->data, $index,1);
        }
    }


}
