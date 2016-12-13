<?php
namespace Pmp\Deploy\FileSystem;

class FileSystemSynchronizer implements FileSystemSynchronizerInterface
{
    protected $source;
    protected $destination;

    public function __construct(FileSystemInterface $source, FileSystemInterface $destination)
    {
        $this->setSource($source);
        $this->setDestination($destination);
    }
    public function setSource(FileSystemInterface $source)
    {
        $this->source = $source;
    }

    public function setDestination(FileSystemInterface $destination)
    {
        $this->destination = $destination;
    }

    public function synchronize()
    {

    }

}
