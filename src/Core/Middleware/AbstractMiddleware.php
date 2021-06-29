<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Middleware;


use Slim\App;

abstract class AbstractMiddleware
{
    public $_app;
    public $_args;

    public function __construct()
    {
        $args = func_get_args();
        if ($args[0] instanceof App) {
            $this->_app = $args[0];
        }
        else {
            throw new \InvalidArgumentException("Slim/App is required at __construct");
        }
        $this->_args = $args[1];
    }
}