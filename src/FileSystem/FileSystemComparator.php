<?php
namespace Pmp\Deploy\FileSystem;

class FileSystemComparator implements FileSystemComparatorInterface
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

    public function getSource()
    {
        return $this->source;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    private function getDifference(FileSystemInterface $first, FileSystemInterface $second)
    {
        return array_values(array_udiff(
            $first->getFiles(),
            $second->getFiles(),
            function($fileFromFirst, $fileFromSecond) {
                return strcmp($fileFromFirst->getPath(), $fileFromSecond->getPath());
            }
        ));
    }

    public function getCreatedFiles()
    {
        return $this->getDifference($this->source, $this->destination);
    }

    public function getDeletedFiles()
    {
        return $this->getDifference($this->destination, $this->source);
    }

    public function getUpdatedFiles()
    {
        return array_uintersect(
            $this->source->getFiles(),
            $this->destination->getFiles(),
            function($sourceFile, $destinationFile) {
                if (strcmp($sourceFile->getPath(), $destinationFile->getPath()) == 0) {
                    if ($sourceFile->getModified() > $destinationFile->getModified()) {
                        return 0;
                    }
                }
                return 1;
            }
        );
    }

    public function getUnchangedFiles()
    {
        return array_uintersect(
            $this->source->getFiles(),
            $this->destination->getFiles(),
            function($sourceFile, $destinationFile) {
                if (strcmp($sourceFile->getPath(), $destinationFile->getPath()) == 0) {
                    if ($sourceFile->getModified() <= $destinationFile->getModified()) {
                        return 0;
                    }
                }
                return 1;
            }
        );
    }
}
