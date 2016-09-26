<?php
namespace Pmp\Deploy\FileSystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListFiles;

class LocalFlySystemAdapter implements FileSystemInterface
{
    protected $fileSystem = null;

    public function __construct($path = null)
    {
        if (!is_null($path)) {
            $this->setPath($path);
        }
    }

    public function getFiles()
    {
        if (is_null($this->fileSystem)) {
            throw new Exception("File system not properly configured.");
        }
        return $this->fileSystem->listFiles('', true);
    }

    public function setPath($path)
    {
        $this->fileSystem = new Filesystem(new Local($path));
        $this->fileSystem->addPlugin(new ListFiles());
    }
}