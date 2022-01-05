<?php


namespace App\Exports\XML;


abstract class BaseElement implements Element
{
    protected $name = '';
    protected $attributes = [];

    /**
     * BaseElement constructor.
     * @param string $name
     * @throws \Exception
     */
    public function __construct(string $name)
    {
        if(!$this->setName($name)){
            throw new \Exception('name is require');
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setName(string $name) : bool
    {
        $name = trim($name);
        if(empty($name)){
            return false;
        }
        $this->name = $name;
        return true;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setAttribute(string $name, string $value = '') : void
    {
        $name = trim($name);
        $value = trim($value);
        if(empty($name)){
            return;
        }
        if(empty($value)){
            $value = $name;
        }
        $this->attributes[$name] = $value;
    }

    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     */
    public function deleteAttribute(string $name) : void
    {
        $name = trim($name);
        if(isset($this->attributes[$name])){
            unset($this->attributes[$name]);
        }
    }

}
