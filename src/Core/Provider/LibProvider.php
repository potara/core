<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider;


use Potara\Core\Lib\ParseFile;
use Psr\Http\Message\UploadedFileInterface;
use Slim\App;

class LibProvider implements ProviderInerface
{

    public function load(App &$app, $args = [])
    {
        $container = $app->getContainer();

        /**
         * Faz o parse do arquivo, retornando o ParseFile
         *
         * Parse the file, returning ParseFile
         */
        $container->set('p_parse_file', function ()
        {
            return function (UploadedFileInterface $uploadedFile) : ParseFile
            {
                if (empty($uploadedFile)) {
                    throw new \RuntimeException("Invalid file");
                };
                return new ParseFile($uploadedFile);
            };
        });
    }
}