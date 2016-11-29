<?php
/**
 * Created by PhpStorm.
 * User: famille
 * Date: 29/11/2016
 * Time: 09:21
 */

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

    private function getDifference(FileSystemInterface $first, FileSystemInterface $second)
    {
        return array_values(array_udiff(
            $first->getFiles(),
            $second->getFiles(),
            function($fileFromFirst, $fileFromSecond) {
                return strcmp($fileFromFirst['path'], $fileFromSecond['path']);
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
                if (strcmp($sourceFile['path'], $destinationFile['path']) == 0) {
                    if ($sourceFile['timestamp'] > $destinationFile['timestamp']) {
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
                if (strcmp($sourceFile['path'], $destinationFile['path']) == 0) {
                    if ($sourceFile['timestamp'] <= $destinationFile['timestamp']) {
                        return 0;
                    }
                }
                return 1;
            }
        );
    }
}