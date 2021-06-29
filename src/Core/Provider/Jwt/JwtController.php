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

use DI\Container;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JwtController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param Container              $container
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function authPublic(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        $jwtConf = $this->getJwtConf($container);

        try {
            $issued = time();

            $payload = [
                'type' => 'public',
                'iat'  => $issued,
                'exp'  => $issued + $jwtConf->life_public
            ];

            $token = JWT::encode($payload, $jwtConf->secret, $jwtConf->algorithm);

            $newPayload = [
                'token' => $token,
                'life'  => $jwtConf->life_public
            ];

            return $this->jsonResponse($response, $newPayload);

        } catch (\Exception $e) {
            throw new \Exception("Error validating token", 500);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param Container              $container
     *
     * @return ResponseInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function authLogin(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        $jwtConf = $this->getJwtConf($container);

        /** @var JwtCheckuserInterface $jwtAuthUser */
        $jwtAuthUser = $container->get('jwt_user_auth');

        $dataReq = $request->getParsedBody();

        if ($jwtAuthUser::isValidArgs($dataReq)) {
            throw new \InvalidArgumentException('Invalid parameters', 401);
        }

        $CheckUserLogin = $jwtAuthUser::check($dataReq);

        if (!$CheckUserLogin) {
            throw new \InvalidArgumentException('User or password not informed or invalid', 401);
        }

        try {

            $issued = time();

            $payload = [
                'type' => 'private',
                'iat'  => $issued,
                'exp'  => $issued + $jwtConf->life,
                'uid'  => $CheckUserLogin,
            ];


            $newToken = JWT::encode($payload, $jwtConf->secret, $jwtConf->algorithm);

            $payloadRefresh = [
                'type' => 'refresh',
                'iat'  => $issued,
                'exp'  => $issued + $jwtConf->life_refresh,
                'uid'  => [
                    'type' => 'private',
                    'uid'  => $CheckUserLogin
                ]
            ];

            $refreshToken = JWT::encode($payloadRefresh, $jwtConf->secret, $jwtConf->algorithm);

            $resultJson = [
                'token'        => $newToken,
                'life'         => $jwtConf->life,
                'refresh'      => $refreshToken,
                'life_refresh' => $jwtConf->life_refresh
            ];

            return $this->jsonResponse($response, $resultJson);


        } catch (\Exception $e) {
            throw new \Exception("Error generating token", 500);
        }

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param Container              $container
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function authRefresh(ServerRequestInterface $request, ResponseInterface $response, Container $container)
    {
        $jwtConf = $this->getJwtConf($container);

        $refreshToken = current($request->getHeader($jwtConf->header));

        if (empty($refreshToken)) {
            throw new \InvalidArgumentException("Token not informed", 401);
        }

        try {
            $decoded = (array) JWT::decode($refreshToken, $jwtConf->secret, [$jwtConf->algorithm]);

            if ($decoded['type'] != 'refresh') {
                throw new \InvalidArgumentException("Invalid token", 401);
            };


            $issued     = time();
            $decodedUid = (array) $decoded['uid'];
            $payload    = [
                'type' => $decodedUid['type'],
                'iat'  => $issued,
                'exp'  => $issued + $jwtConf->life,
                'uid'  => $decodedUid['uid']
            ];


            $newToken = JWT::encode($payload, $jwtConf->secret, $jwtConf->algorithm);

            $resultJson = [
                'token'        => $newToken,
                'life'         => $jwtConf->life,
                'refresh'      => $refreshToken,
                'life_refresh' => $jwtConf->life_refresh
            ];

            return $this->jsonResponse($response, $resultJson);

        } catch (\Exception $e) {
            throw new \Exception("Token revalidation error.", 500);
        }
    }

    protected function getJwtConf(Container &$container) : JwtEntity
    {
        return $container->get('kernel-conf')->getConf()['jwt'];
    }

    /**
     * @param ResponseInterface $response
     * @param array             $data
     *
     * @return ResponseInterface
     */
    protected function jsonResponse(ResponseInterface &$response, $data = [])
    {
        $payload = json_encode($data, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');

    }
}
