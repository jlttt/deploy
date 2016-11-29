<?php
namespace Pmp\Deploy\FileSystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListFiles;

class LocalFlySystemAdapter implements FileSystemInterface
{
    protected $fileSystem = null;

    public function __construct($path)
    {
        $this->fileSystem = new Filesystem(new Local($path));
        $this->fileSystem->addPlugin(new ListFiles());
    }

    public function getFiles()
    {
        return $this->fileSystem->listFiles('', true);
    }
}