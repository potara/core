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


use Potara\Core\Crud\AbstractEntity;

class JwtEntity extends AbstractEntity
{
    public $auth_user;
    /**
     * @var type=bolean
     */
    public $secure;

    /**
     * @var type=string
     */
    public $attribute;

    /**
     * @var type=string
     */
    public $header;

    /**
     * @var type=string
     */
    public $regexp;

    /**
     * @var type=string
     */
    public $cookie;

    public $path;

    public $ignore;

    /**
     * @var type=integer
     */
    public $life;

    /**
     * @var type=integer
     */
    public $life_refresh;

    /**
     * @var type=integer
     */
    public $life_public;

    /**
     * @var type=string
     */
    public $secret;

    /**
     * @var type=string
     */
    public $algorithm;

    public $after;
    public $before;
    public $error;

    public function __construct($data = [])
    {
        $data['secure']       = !empty($data['secure']) ? $data['secure'] : false;
        $data['ignore']       = is_array($data['ignore']) ? $data['ignore'] : [];
        $data['life']         = !empty($data['life']) ? $data['life'] : 3600;
        $data['life_refresh'] = !empty($data['life_refresh']) ? $data['life_refresh'] : 86400;
        $data['life_public']  = !empty($data['life_public']) ? $data['life_public'] : 36000;
        $data['algorithm']    = !empty($data['algorithm']) ? $data['algorithm'] : 'HS384';

        parent::__construct($data);
    }

}