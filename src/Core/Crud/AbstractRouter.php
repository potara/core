<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2019 Bruno Lima
 * @author    Bruno Lima <eu@brunolima.me>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud;


abstract class AbstractRouter
{
    private $module;
    private $version;


    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @param $module
     * @return AbstractRouter
     */
    public function setModule($module): self
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return AbstractRouter
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @param $endName
     * @return string
     */
    public function factoryNameRouter($endName): string
    {
        $nameRouter = [];

        if (!empty($this->getVersion())) {
            $nameRouter[] = $this->getVersion();
        }

        if (!empty($this->getModule())) {
            $nameRouter[] = $this->getModule();
        }

        $nameRouter[] = $endName;
        return implode("_", $nameRouter);

    }

}