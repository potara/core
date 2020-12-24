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


class KernelEntity
{

    public bool   $debug;
    public string $root;
    public string $conf;
    public string $conf_file;
    public string $storage;
    public string $log;
    public bool   $cache;
    public string $modules             = 'app';
    public string $modules_path;
    public bool   $cache_module        = true;
    public bool   $cache_twig          = false;
    public bool   $ignore_cache_module = false;
    public string $cache_module_file   = 'modules.yml';

    public function __construct()
    {
        $this->root  = $_SERVER['DOCUMENT_ROOT'];
        $defaultPath = $this->root . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '%s';

        $this->conf         = sprintf($defaultPath, 'conf' . DIRECTORY_SEPARATOR);
        $this->modules_path = sprintf($defaultPath, $this->modules);
        $this->storage      = sprintf($defaultPath, 'storage' . DIRECTORY_SEPARATOR);
        $this->log          = $this->storage . "log" . DIRECTORY_SEPARATOR;
        $this->cache        = $this->storage . "cache" . DIRECTORY_SEPARATOR;

        $this->setConfFile(null)
             ->setCacheTwig(false);
    }

    public function setConfFile(string $file = null): self
    {
        $this->conf_file = !empty($file) ? $file : $this->conf . "app.yml";
        return $this;
    }

    public function setCacheModule(bool $status = true): self
    {
        $this->cache_module = is_bool($status) ? $status : $this->cache_module;
        return $this;
    }

    public function setIgnoreCacheModule(bool $status = true): self
    {
        $this->ignore_cache_module = is_bool($status) ? $status : $this->ignore_cache_module;
        return $this;
    }

    public function setCacheTwig(bool $status = true)
    {
        $this->cache_twig = (is_bool($status) && $status === false) ? false : $this->cache . DIRECTORY_SEPARATOR . 'twig';
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_reduce(array_keys(get_object_vars($this)), function ($result, $item) {
            $result[$item] = $this->$item;
            return $result;
        }, []);
    }

}