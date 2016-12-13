<?php
namespace Pmp\Deploy\FileSystem;

interface FileSystemSynchronizerInterface
{
    public function setSource(FileSystemInterface $source);
    public function setDestination(FileSystemInterface $destination);

    public function synchronize();
}
