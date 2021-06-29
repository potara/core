<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Lib;


use Cocur\Slugify\Slugify;
use Nyholm\Psr7\UploadedFile;


class ParseFile
{

    /**
     * @var UploadedFile
     */
    private $file;
    private $filename;
    private $newName;
    private $extension;

    /**
     * ParseFile constructor.
     *
     * @param UploadedFile $file
     *
     * @throws \Exception
     */
    public function __construct(UploadedFile $file)
    {
        $this->setFile($file);
        $this->parse();
    }

    /**
     * @return ParseFile
     * @throws \Exception
     */
    public function parse()
    {
        $isError = $this->checkError($this->getFile()->getError());
        if (!is_null($isError)) {
            throw new \Exception($isError, 401);
        }

        $pathParts = pathinfo($this->getFile()->getClientFilename());
        $this
            ->setFilename($pathParts['filename'])
            ->setExtension($pathParts['extension'])
            ->setNewName();
        return $this;
    }

    /**
     * Move o arquivo para pasta de destino, com o novo nome por padrão,
     * caso queria usar o nome original, defina $useNewName como false
     *
     * Moves the file to destination folder, with the new name by default,
     * If you wanted to use the original name, set $useNewName to false
     *
     * @param      $path
     * @param bool $useNewName
     *
     * @return $this
     * @throws \Exception
     */
    public function moveTo($path, $useNewName = true)
    {
        if (empty($path)) {
            throw new \Exception('"Missing a send folder', 401);
        }
        try {
            $nameFile = $this->getNewName();
            if (!$useNewName) {
                $nameFile = "{$this->getFilename()}.{$this->getExtension()}";
            }
            $this->getFile()->moveTo($path . $nameFile);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this;
    }

    /**
     * Verifica o status do erro
     * Checks the status of the error
     *
     * @param $code
     *
     * @return null|string
     */
    public function checkError($code)
    {
        $message = null;
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

        }
        return $message;
    }

    /**
     *
     * @return string
     */
    public function getFileTemp(): string
    {
        return $this->getFile();
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     *
     * @return ParseFile
     */
    public function setFile(UploadedFile $file): ParseFile
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     *
     * @return ParseFile
     */
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewName(): string
    {
        return $this->newName;
    }

    /**
     * Gera um novo nome
     * Generates a new name
     *
     * @return ParseFile
     * @throws \Exception
     */
    public function setNewName(): ParseFile
    {
        $slugName      = $this->slug($this->getFilename());
        $hashName      = bin2hex(random_bytes(8));
        $this->newName = "{$slugName}_{$hashName}.{$this->getExtension()}";
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     *
     * @return $this
     */
    public function setExtension(string $extension): ParseFile
    {
        $this->extension = $this->slug($extension);
        return $this;
    }

    /**
     * @param string $str
     *
     * @return string
     */
    private function slug(string $str)
    {
        $slugify = new Slugify();
        $slugify->activateRuleset('esperanto');
        return $slugify->slugify($str);
    }

    /**
     * @param int  $size
     * @param null $scale
     *
     * @return bool
     */
    public function checkLimitSize(int $size, $scale = null): bool
    {
        if ($this->getSize($scale) <= $size) {
            return true;
        }
        false;
    }

    /**
     * Retorna o tamanho do arquivo de acordo sua escala
     *
     * Returns the size of the file according to its scale
     *
     * @param string|null $scale
     *
     * @return float|int|null
     */
    public function getSize(string $scale = null)
    {
        $size = $this->getFile()->getSize();
        switch ($scale) {
            case 't':
                return $size / (1024 * 1024 * 1024 * 1024);
                break;
            case 'g':
                return $size / (1024 * 1024 * 1024);
                break;
            case 'm':
                return $size / (1024 * 1024);
                break;
            case 'k':
                return $size / 1024;
                break;
            default:
                return $size;
                break;
        }
    }
}
