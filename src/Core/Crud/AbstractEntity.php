<?php

namespace Potara\Core\Crud;

use Potara\Core\Crud\Entity\ConvertToInterface;

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
        foreach ($data as $key => $valeu) {
            !property_exists($this, $key) ?: $this->$key = $valeu;
        }
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function convertToPhpValue(): self
    {
        $this->convertToDoc('toPHP');
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function convertToDbValue(): self
    {
        $this->convertToDoc('toDB');
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

    /**
     * @return $this
     */
    public function toSave(): self
    {
        $this->convertToDbValue();
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    protected function readerDoc(): array
    {
        $reflector = new \ReflectionClass($this);
        return array_reduce(
            array_keys(get_object_vars($this)),
            function ($result, $propety) use ($reflector) {
                $readPropety = $reflector->getProperty($propety)->getDocComment();
                $pattern     = "#(@[a-zA-Z]+\s*[a-zA-Z0-9\=\&, ()_].*)#";
                preg_match_all($pattern, $readPropety, $matches, PREG_PATTERN_ORDER);

                $patternDoc = "#@([a-zA-Z]+)\s([a-zA-Z0-9\=\&, ()_].*)#";
                preg_match_all($patternDoc, current($matches[1]), $docMatches, PREG_PATTERN_ORDER);

                if (current($docMatches[1]) == 'var') {
                    parse_str(trim(current($docMatches[2])), $parseVar);

                    $nameClassConvert = trim("Potara\\Core\\Crud\\Entity\\ConvertTo" . ucfirst($parseVar['type']));
                    unset($parseVar['type']);
                    if (class_exists($nameClassConvert)) {
                        $result[$propety] = count($parseVar) > 0 ? new $nameClassConvert($parseVar) : new $nameClassConvert();
                    }
                }
                return $result;
            }, []
        );
    }

    protected function convertToDoc($method = 'toPHP'): AbstractEntity
    {
        $loadDoc  = $this->readerDoc();
        $propetys = array_keys(get_object_vars($this));
        array_walk($propetys, function ($propety) use ($loadDoc, $method) {
            if (@$loadDoc[$propety] instanceof ConvertToInterface) {
                $loadDoc[$propety]->$method($this->$propety);
            }
        });
        return $this;
    }
}
