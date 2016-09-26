<?php
namespace Pmp\Deploy;

use Pmp\Deploy\FileSystem\FileSystemInterface;

class Deployer
{
    protected $sourceFileSystem = null;
    protected $destinationFileSystem = null;
    protected $sourceFiles = null;
    protected $destinationFiles = null;

    public function __construct(FileSystemInterface $source, FileSystemInterface $destination)
    {
        $this->setSourceFileSystem($source);
        $this->setDestinationFileSystem($destination);
    }

    public function setSourceFileSystem(FileSystemInterface $fileSystem)
    {
        $this->sourceFileSystem = $fileSystem;
    }

    public function setDestinationFileSystem(FileSystemInterface $fileSystem)
    {
        $this->destinationFileSystem = $fileSystem;
    }

    public function getSourceFiles()
    {
        if (is_null($this->sourceFiles)) {
            $this->sourceFiles = $this->sourceFileSystem->getFiles();
        }
        return $this->sourceFiles;
    }

    public function getDestinationFiles()
    {
        if (is_null($this->destinationFiles)) {
            $this->destinationFiles = $this->destinationFileSystem->getFiles();
        }
        return $this->destinationFiles;
    }
    
    public function getCreatedFiles()
    {
        return array_udiff($this->getSourceFiles(), $this->getDestinationFiles(), function($sourceFile, $destinationFile) {
            return strcmp($sourceFile['path'], $destinationFile['path']);
        });
    }

    public function getDeletedFiles()
    {
        return array_udiff($this->getDestinationFiles(), $this->getSourceFiles(), function($destinationFile, $sourceFile) {
            return strcmp($destinationFile['path'], $sourceFile['path']);
        });
    }

    public function getUpdatedFiles()
    {
        return array_uintersect($this->getSourceFiles(), $this->getDestinationFiles(), function($sourceFile, $destinationFile) {
            if (strcmp($sourceFile['path'], $destinationFile['path']) == 0) {
                if ($sourceFile['timestamp'] > $destinationFile['timestamp']) {
                    return 0;
                }
            }
            return 1;
        });
    }
}