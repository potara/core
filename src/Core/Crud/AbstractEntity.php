<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud;

use Potara\Core\Crud\Entity\ConvertToInterface;

abstract class AbstractEntity
{
    const REMOVE_TO_DB = "_remove_to_db";
    public $_table;

    public function __construct($data = [])
    {
        $this->hydrator($data)
             ->convertToPHPValue();
    }


    /**
     * @param array $data
     *
     * @return AbstractEntity
     */
    protected function hydrator($data = []): self
    {
        array_walk($data, function ($valeu, $key) {
            !property_exists($this, $key) ?: $this->$key = $valeu;
        });

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
        $checkIsValidVar = function ($name, $value) {
            return in_array($name, $this->noToArray()) || $value == self::REMOVE_TO_DB;
        };

        return array_reduce(array_keys(get_object_vars($this)), function ($result, $item) use ($checkIsValidVar) {
            $checkIsValidVar($item, $this->$item) ?: $result[$item] = $this->$item;
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
     * @param mixed  $value
     */
    public function __set(string $name, mixed $value)
    {
        // TODO: Implement __set() method.
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    protected function readerDoc(): array
    {
        $reflector  = new \ReflectionClass($this);
        $selfEntity = $this;
        return array_reduce(array_keys(get_object_vars($this)), function ($result, $propety) use ($reflector, $selfEntity) {
            $readPropety = $reflector->getProperty($propety)
                                     ->getDocComment();
            $pattern     = "#(@[a-zA-Z]+\s*[a-zA-Z0-9\=\&, ()_].*)#";
            preg_match_all($pattern, $readPropety, $matches, PREG_PATTERN_ORDER);

            $patternDoc = "#@([a-zA-Z]+)\s([a-zA-Z0-9\=\&, ()_].*)#";
            preg_match_all($patternDoc, current($matches[1]), $docMatches, PREG_PATTERN_ORDER);
            $typePropety = current($docMatches[1]);

            $loadClass = function ($nameClass, $options = null) use ($selfEntity) {
                unset($options['type']);
                unset($options['name_class']);
                if (class_exists($nameClass)) {
                    return count($options) > 0 ? new $nameClass($selfEntity, $options) : new $nameClass($selfEntity);
                }
                return null;
            };

            parse_str(trim(current($docMatches[2])), $parseVar);
            if ($typePropety == 'var') {
                $nameClassConvert = trim("Potara\\Core\\Crud\\Entity\\ConvertTo" . ucfirst($parseVar['type']));
                if ($parseVar['type'] == 'slug') {
                    $namePropety      = $parseVar['var'];
                    $parseVar['text'] = $this->$namePropety;
                }
                $result[$propety] = $loadClass($nameClassConvert, $parseVar);
            } else {
                if ($typePropety == 'class') {
                    $result[$propety] = $loadClass($parseVar['name_class'], $parseVar);
                }
            }
            return $result;
        }, []);
    }

    protected function convertToDoc(string $method = 'toPHP'): self
    {
        if (in_array($method, ['toPHP', 'toDB'])) {
            $loadDoc  = $this->readerDoc();
            $propetys = array_keys(get_object_vars($this));

            array_walk($propetys, function ($propety) use ($loadDoc, $method) {
                if (key_exists($propety, $loadDoc)) {
                    if ($loadDoc[$propety] instanceof ConvertToInterface) {
                        $loadDoc[$propety]->$method($this->$propety);
                    }
                }
            });
        }
        return $this;
    }
}
