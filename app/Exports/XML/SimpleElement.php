<?php


namespace App\Exports\XML;


class SimpleElement extends BaseElement
{
    protected $value = '';

    /**
     * SimpleElement constructor.
     * @param string $name
     * @param string $value
     * @throws \Exception
     */
    public function __construct(string $name, string $value = '')
    {
        parent::__construct($name);
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        $result = $this->value;
        if(empty($result)){
            $result = $this->name;
        }
        return $result;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function setValue(string $value = '')
    {
        $value = trim($value);
        if(empty($value)){
            return false;
        }
        $this->value = $value;
        return true;
    }

}
