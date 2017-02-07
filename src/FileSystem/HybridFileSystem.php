<?php

namespace Jlttt\Deploy\FileSystem;

class HybridFileSystem implements FileSystemInterface
{
    protected $fileSystem;
    protected $fileExplorer;

    public function __construct(FileSystemInterface $fileSystem, FileExplorerInterface $fileExplorer)
    {
        $this->fileSystem = $fileSystem;
        $this->fileExplorer = $fileExplorer;
    }

    public function getFiles()
    {
        return $this->fileExplorer->getFiles();
    }

    public function read($path)
    {
        return $this->fileSystem->read($path);
    }

    public function write($path, $stream)
    {
        return $this->fileSystem->write($path, $stream);
    }

    public function delete($path)
    {
        return $this->fileSystem->delete($path);
    }
}
