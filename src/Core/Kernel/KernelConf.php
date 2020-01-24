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


use Potara\Core\Crud\AbstractEntity;

class KernelConf extends AbstractEntity
{

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

    public $modules;

    /**
     * @var type=string
     */
    public $cache;

    /**
     * @var type=bolean
     */
    public $cache_module;


    public function __construct($conf = [])
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $storage      = "{$documentRoot}/../storage/";

        $confFinal = array_replace([
            'root'         => $documentRoot,
            'conf'         => $documentRoot . "/../conf/",
            'storage'      => $storage,
            'log'          => $storage . "log/",
            'cache'        => $storage . "cache/",
            'modules'      => [],
            'cache_module' => true,
        ], $conf);
        parent::__construct($confFinal);
    }

    /**
     * @param array $module
     * @return self
     */
    public function addModule($module = [])
    {
        array_push($this->modules, $module);
        return $this;
    }
}