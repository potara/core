<?php


namespace Potara\Core\Crud;


final class HelperEntity
{

    static public function hydrator(&$entity, $data = []): void
    {
        foreach ($data as $key => $valeu) {
            !property_exists($entity, $key) ?: $entity->$key = $valeu;
        }
    }

    /**
     * @param $entity
     * @param string $delimiter
     */
    static public function convertToDbValue(&$entity, $delimiter = ','): void
    {
        if (is_array($entity)) {
            array_walk(array_keys($entity), function ($item) use (&$entity, $delimiter) {
                if ($entity[$item] instanceof \DateTime) {
                    self::convertDateTimeToString($entity[$item]);
                } elseif (is_array($entity[$item])) {
                    self::convertArrayToString($entity[$item], $delimiter);
                } elseif (is_bool($entity[$item])) {
                    $entity[$item] = (int)$entity[$item];
                }
            });
        } else {
            array_walk(array_keys(get_object_vars($entity)), function ($item) use (&$entity, $delimiter) {
                if ($entity->$item instanceof \DateTime) {
                    self::convertDateTimeToString($entity->$item);
                } elseif (is_array($entity->$item)) {
                    self::convertArrayToString($entity->$item, $delimiter);
                } elseif (is_bool($entity->$item)) {
                    $entity->$item = (int)$entity->$item;
                }
            });
        }
    }

    /**
     * @param $string
     * @param string $delimiter
     */
    static public function convertStringToArray(&$string, $delimiter = ","): void
    {
        if (is_null($string)) {
            $string = [];
        }

        $newArray = explode($delimiter, $string);
        $string   = is_string($newArray) ? [$newArray] : $newArray;
    }

    /**
     * @param array $array
     * @param string $delimitador
     */
    static public function convertArrayToString(&$array = [], $delimitador = ","): void
    {
        if (empty($array) || !is_array($array)) {
            $array = null;
        }
        $array = implode($delimitador, $array);
    }


    /**
     * @param $datetime
     * @param string $format
     */
    static public function convertDateTimeToString(&$datetime, $format = "Y-m-d H:i:s"): void
    {
        $datetime = $datetime instanceof \DateTime ? $datetime->format($format) : $datetime;
    }

    /**
     * @param $string
     * @param string $format
     */
    static public function convertStringToDateTime(&$string, $format = 'Y-m-d H:i:s'): void
    {
        $newDateTime = \DateTime::createFromFormat($format, $string);
        if ($newDateTime) {
            $string = $newDateTime;
        }
    }

    /**
     * @param $datetime
     */
    static public function convertDateToString(&$datetime): void
    {
        $datetime = self::convertDateTimeToString($datetime, 'Y-m-d');
    }
}
