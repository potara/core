<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud;

use Psr\Http\Message\ResponseInterface as Response;

abstract class AbstractResponse
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param array $data
     * @param null  $code
     * @param array $header
     *
     * @return Response
     */
    public function toJson(array $data = [], $code = null, array $header = []): Response
    {
        $statusCode = empty($code) ? 200 : (int)$code;
        $response   = $this->response->withStatus($statusCode)
                                     ->withHeader('Content-Type', 'application/json');

        //ADICIONAR DADOS AO HEADER
        $this->addHeader($header);

        $data['statusCode'] = $statusCode;
        $payload            = json_encode($data, JSON_PRETTY_PRINT);
        $response->getBody()
                 ->write($payload);
        return $response;
    }

    /**
     * @param array $header
     *
     * @return AbstractResponse
     */
    protected function addHeader(array $header = []): self
    {
        if (!empty($header) and is_array($header)) {
            foreach ($header as $name => $value) {
                $this->response->withHeader($name, $value);
            }
        }
        return $this;
    }
}
