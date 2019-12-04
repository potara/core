<?php

namespace Potara\Core\Crud;

abstract class AbstractEntity
{

    public function __construct($data = [])
    {
        $this->hydrator($data)
            ->convertToPHPValue();
    }

    /**
     * @param array $data
     * @return AbstractEntity
     */
    protected function hydrator($data = []): self
    {
        HelperEntity::hydrator($this, $data);
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function convertToPhpValue(): self
    {
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function convertToDbValue(): self
    {
        HelperEntity::convertToDbValue($this);
        return $this;
    }

    /**
     * @return array
     */
    protected function noToArray(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_reduce(array_keys(get_object_vars($this)), function ($result, $item) {
            in_array($item, $this->noToArray()) ?: $result[$item] = $this->$item;
            return $result;
        }, []);
    }


    /**
     * @return array
     */
    public function beforeToSave(): array
    {
        $toArray = $this->toArray();
        unset($toArray['id']);
        return $toArray;
    }

    public function toSave()
    {

    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }
}
