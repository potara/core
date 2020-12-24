<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Middleware;

use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use Psr\Http\Server\RequestHandlerInterface;


class TrailingSlash extends AbstractMiddleware
{
    public function __invoke(ServerRequest $request, RequestHandlerInterface $handler)
    {
        $uri  = $request->getUri();
        $path = $uri->getPath();

        if ($path != '/' && substr($path, -1) == '/') {
            // permanently redirect paths with a trailing slash
            // to their non-trailing counterpart
            $uri = $uri->withPath(substr($path, 0, -1));

            if ($request->getMethod() == 'GET') {

                return (new Response())->withStatus(301)
                                       ->withHeader('Location', (string)$uri);

            } else {
                $request = $request->withUri($uri);
            }
        }

        return $handler->handle($request);
    }
}