<?php
namespace Pmp\Deploy\FileSystem;

interface ComparatorInterface
{
    public function setSource(FileSystemInterface $source);
    public function setDestination(FileSystemInterface $destination);

    public function getSource();
    public function getDestination();

    public function getCreatedFiles();
    public function getDeletedFiles();
    public function getUpdatedFiles();
    public function getUnchangedFiles();
}
