<?php
namespace Jlttt\Deploy\FileSystem;

interface ComparatorInterface
{
    const SOURCE_FILE = 1;
    const DESTINATION_FILE = 2;

    public function setSource(FileSystemInterface $source);
    public function setDestination(FileSystemInterface $destination);
    public function setIgnoreFilePatterns($patterns);

    public function getSource();
    public function getDestination();

    public function getCreatedFiles($fileType = self::SOURCE_FILE);
    public function getDeletedFiles();
    public function getUpdatedFiles($fileType = self::SOURCE_FILE);
    public function getUnchangedFiles($fileType = self::SOURCE_FILE);
}
