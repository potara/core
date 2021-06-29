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


use Potara\Core\Kernel\KernelConf;
use Potara\Core\Provider\ProviderInerface;
use Slim\App;
use Tuupola\Middleware\JwtAuthentication;
use Nyholm\Psr7\Response;

class JwtProvider implements ProviderInerface
{

    public function load(App &$app, $args = [])
    {
        $container = $app->getContainer();
        /** @var KernelConf $kernelConf */
        $kernelConf = $container->get('kernel-conf');

        /** @var JwtEntity $jwtEntity */
        $jwtEntity = $kernelConf->getConf()['jwt'];


        if (!class_exists($jwtEntity->auth_user)) {
            throw new \Exception("Login authenticator not set.", 500);
        }

        $container->set('jwt_user_auth', new $jwtEntity->auth_user($app));

        $jwtEntity->after  = function () {
        };
        $jwtEntity->before = function () {
        };

        $jwtEntity->error = function (Response $response, $args) {
            $payload = [
                'statusCode' => $response->getStatusCode(),
                'error'      => [
                    'type'        => 'ERROR',
                    'description' => $args['message'],
                ]
            ];
            $payload = json_encode($payload, JSON_PRETTY_PRINT);

            $response->getBody()->write($payload);

        };

        $app->add(new JwtAuthentication($jwtEntity->toArray()));
    }
}