<?php


namespace Potara\Core\Crud;


use Core\Entity\Entity;

abstract class AbstractEntity
{

    public function __construct($data = [])
    {
        $this->hydrator($data);
    }

    /**
     * @param array $data
     * @return AbstractEntity
     */
    protected function hydrator($data = []): self
    {
        foreach ($data as $key => $valeu) {
            !property_exists($this, $key) ?: $this->$key = $valeu;
        }
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function convertToPHPValue(): self
    {
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function convertToDatabaseValue(): self
    {
        $this->factoryConvertToDatabaseValue();
        return $this;
    }

    protected function factoryConvertToDatabaseValue($data = [], $delimiter = ',')
    {
        if (empty($data)) {
            array_walk(array_keys(get_object_vars($this)), function ($item) use ($delimiter) {
                if ($this->$item instanceof \DateTime) {
                    $this->convertDateTimeToString($this->$item);
                } elseif (is_array($this->$item)) {
                    $this->convertArrayToString($this->$item, $delimiter);
                } elseif (is_bool($this->$item)) {
                    $this->$item = (int)$this->$item;
                }
            });
        } else {
            array_walk(array_keys($data), function ($item) use (&$data, $delimiter) {
                if ($data[$item] instanceof \DateTime) {
                    $this->convertDateTimeToString($data[$item]);
                } elseif (is_array($data[$item])) {
                    $this->convertArrayToString($data[$item], $delimiter);
                } elseif (is_bool($data[$item])) {
                    $data[$item] = (int)$data[$item];
                }
            });
        }
    }

    /**
     * @param $datetime
     * @param string $format
     */
    protected function convertDateTimeToString(&$datetime, $format = "Y-m-d H:i:s"): void
    {
        $datetime = $datetime instanceof \DateTime ? $datetime->format($format) : $datetime;
    }

    /**
     * @param $datetime
     */
    protected function convertDateToString(&$datetime): void
    {
        $this->convertDateTimeToString($datetime, 'Y-m-d');
    }

    /**
     * @param $string
     * @param string $delimiter
     */
    protected function convertStringToArray(&$string, $delimiter = ","): void
    {
        if (is_null($string)) {
            $string = [];
        }

        $newArray = explode($delimiter, $string);
        $string   = is_string($newArray) ? [$newArray] : $newArray;
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

    public function toSave()
    {

    }
}