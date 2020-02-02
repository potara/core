<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Lib;

class ParseFileLocal extends ParseFile
{

    /** @var string */
    private $file;

    /**
     * ParseFile constructor.
     *
     * @param string $file
     *
     * @throws \Exception
     */
    public function __construct(string $file)
    {
        $this->setFile($file);
        $this->parse();
    }

    /**
     * @return ParseFileLocal
     * @throws \Exception
     */
    public function parse(): ParseFileLocal
    {
        if (empty($this->getFile())) {
            throw new \Exception('Invalid file', 401);
        }

        $pathParts = pathinfo($this->getFile());
        $this
            ->setFilename($pathParts['filename'])
            ->setExtension($pathParts['extension'])
            ->setNewName();
        return $this;
    }

    public function moveTo($path, $useNewName = true)
    {
        throw new \RuntimeException('Invalid method');
    }

    /**
     *
     * @return string
     */
    public function getFileTemp(): string
    {
        return $this->file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     *
     * @return ParseFileLocal
     */
    public function setFile($file): ParseFileLocal
    {
        $this->file = $file;
        return $this;
    }
}
