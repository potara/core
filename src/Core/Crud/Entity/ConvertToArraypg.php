<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud\Entity;

final class ConvertToArraypg extends AbstractConvertTo implements ConvertToInterface
{

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $value = $this->convertPostgresToArray($value);
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = (empty($value) || !is_array($value)) ? $value : $this->convertArrayToPostgres($value);
    }

    /**
     * @param $arraystring
     * @param bool $reset
     * @return array|bool|string|null
     */
    private function convertPostgresToArray($arraystring, $reset = true)
    {
        static $i = 0;
        if ($reset) {
            $i = 0;
        }
        $matches = [];
        $indexer = 1;   // by default sql arrays start at 1
        // handle [0,2]= cases
        if (preg_match('/^\[(?P<index_start>\d+):(?P<index_end>\d+)]=/', substr($arraystring, $i), $matches)) {
            $indexer = (int)$matches['index_start'];
            $i       = strpos($arraystring, '{');
        }
        if ($arraystring[$i] != '{') {
            return null;
        }
        if (is_array($arraystring)) {
            return $arraystring;
        }
        // handles btyea and blob binary streams
        if (is_resource($arraystring)) {
            return fread($arraystring, 4096);
        }
        $i++;
        $work   = [];
        $curr   = '';
        $length = strlen($arraystring);
        $count  = 0;
        $quoted = false;
        while ($i < $length) {
            switch ($arraystring[$i]) {
                case '{':
                    $sub = $this->convertPostgresToArray($arraystring, false);
                    if (!empty($sub)) {
                        $work[$indexer++] = $sub;
                    }
                    break;
                case '}':
                    $i++;
                    if (strlen($curr) > 0) {
                        $work[$indexer++] = $curr;
                    }
                    return $work;
                    break;
                case '\\':
                    $i++;
                    $curr .= $arraystring[$i];
                    $i++;
                    break;
                case '"':
                    $quoted = true;
                    $openq  = $i;
                    do {
                        $closeq  = strpos($arraystring, '"', $i + 1);
                        $escaped = $closeq > $openq &&
                            preg_match('/(\\\\+)$/', substr($arraystring, $openq + 1, $closeq - ($openq + 1)), $matches) &&
                            (strlen($matches[1]) % 2);
                        if ($escaped) {
                            $i = $closeq;
                        } else {
                            break;
                        }
                    } while (true);
                    if ($closeq <= $openq) {
                        return null;
                    }
                    $curr .= substr($arraystring, $openq + 1, $closeq - ($openq + 1));
                    $i    = $closeq + 1;
                    break;
                case ',':
                    if (strlen($curr) > 0) {
                        if (!$quoted && (strtoupper($curr) == 'NULL')) {
                            $curr = null;
                        }
                        $work[$indexer++] = $curr;
                    }
                    $curr   = '';
                    $quoted = false;
                    $i++;
                    break;
                default:
                    $curr .= $arraystring[$i];
                    $i++;
            }
        }
        return null;
    }

    /**
     * @param array $data
     * @return string
     */
    private function convertArrayToPostgres($data = [])
    {
        $reduce = array_reduce($data, function ($result, $item) {
            if (is_array($item)) {
                $result[] = convertArrayToPostgres($item);
            } else {
                $itemReplace = str_replace('"', '\\"', $item); // escape double quote
                if (!is_numeric($itemReplace)) {
                    $itemReplace = '"' . $itemReplace . '"';
                }
                $result[] = $itemReplace;
            }
            return $result;
        }, []);

        return '{' . implode(",", $reduce) . '}'; // format
    }
}
