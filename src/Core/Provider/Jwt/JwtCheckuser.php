<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Provider\Jwt;


use Slim\App;

class JwtCheckuser implements JwtCheckuserInterface
{
    public $app;

    public function __construct(App &$app)
    {
        $this->app = $app;
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    static public function isValidArgs($args = []) : bool
    {
        return empty($args['user']) || empty($args['password']);

    }


    static public function check($args = []) : bool
    {
        return $args['user'] == 'root' && $args['password'] == 'toor';
    }
}