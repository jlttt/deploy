<?php
namespace Pmp\Deploy\FileSystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListFiles;

class LocalFlySystemAdapter implements FileSystemInterface
{
//    protected $fileSystem = null;
//
    public function __construct($path)
    {
        if (!is_string($path)) {
            throw new \Exception("The constructor of " . get_class() . " expects a string argument.");
        }
        if (!file_exists($path)) {
            throw new \Exception("The path given to the constructor of " . get_class() . " is not valid.");
        }
//        $this->setPath($path);
    }

    public function getFiles()
    {
//        if (is_null($this->fileSystem)) {
//            throw new Exception("File system not properly configured.");
//        }
//        return $this->fileSystem->listFiles('', true);
    }

//    private function setPath($path)
//    {
//        $this->fileSystem = new Filesystem(new Local($path));
//        $this->fileSystem->addPlugin(new ListFiles());
//    }
}