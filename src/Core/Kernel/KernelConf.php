<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Kernel;


use phpDocumentor\Reflection\Type;
use Potara\Core\Crud\AbstractEntity;
use Symfony\Component\Yaml\Yaml;

class KernelConf extends AbstractEntity
{

    /**
     * @var type=bolean
     */
    public $debug;

    /**
     * @var type=string
     */
    public $root;

    /**
     * @var type=string
     */
    public $conf;

    /**
     * @var type=string
     */
    public $storage;

    /**
     * @var type=string
     */
    public $log;

    /**
     * @var type=string
     */
    public $modules;

    /**
     * @var type=string
     */
    public $modules_path;

    /**
     * @var type=string
     */
    public $cache;

    /**
     * @var type=bolean
     */
    public $cache_module;

    /**
     * @var type=bolean
     */
    public $ignore_cache_module;

    /**
     * @var type=string
     */
    public $cache_module_file;

    /**
     * @var type=bolean
     */
    public $cache_twig;

    /**
     * @var type=string
     */
    public $conf_file;

    public $conf_data;

    public function __construct($conf = [])
    {
        parent::__construct($conf);
        $this->loadConfFile();

    }

    protected function loadConfFile()
    {
        if (file_exists($this->conf_file)) {
            $readConfFile = Yaml::parseFile($this->conf_file);

            if (!empty($readConfFile) && is_array($readConfFile)) {
                array_walk($readConfFile, function ($data, $item) {
                    $entity                 = !empty($data['entity']) ? $data['entity'] : null;
                    $this->conf_data[$item] = class_exists($entity) ? new $entity($data) : $data;
                });
            }
        }
    }

    /**
     * @param null $key
     *
     * @return mixed
     */
    public function getConf($key = null)
    {
        return is_null($key) ? $this->conf_data : $this->conf_data[$key];
    }
}