<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
require_once __DIR__ . './../vendor/autoload.php';

use Potara\Core\Kernel\Kernel;

$kernelConf = [
    'cache_module' => false,
    'ignore_cache_module'=>false
];

$app = (new Kernel($kernelConf))->app;

$app->run();