<?php

namespace Jlttt\Deploy\FileSystem;

class Comparator implements ComparatorInterface
{
    protected $source;
    protected $destination;
    protected $ignoreFilePatterns;

    public function __construct(FileSystemInterface $source, FileSystemInterface $destination, $ignoreFilePatterns = [])
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->setIgnoreFilePatterns($ignoreFilePatterns);
    }

    public function setSource(FileSystemInterface $source)
    {
        $this->source = $source;
    }

    public function setDestination(FileSystemInterface $source)
    {
        $this->destination = $destination;
    }

    public function setIgnoreFilePatterns($patterns)
    {
        $this->ignoreFilePatterns = $patterns;
    }

    public function getIgnoreFilePatterns()
    {
        return $this->ignoreFilePatterns;
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
        $differences = array_values(array_udiff(
            $first->getFiles(),
            $second->getFiles(),
            function ($fileFromFirst, $fileFromSecond) {
                return strcmp($fileFromFirst->getPath(), $fileFromSecond->getPath());
            }
        ));
        return array_filter($differences, function ($item) {
            return !$item->match($this->getIgnoreFilePatterns());
        });
    }

    public function getCreatedFiles()
    {
        return $this->getDifference($this->getSource(), $this->getDestination());
    }

    public function getDeletedFiles()
    {
        return $this->getDifference($this->getDestination(), $this->getSource());
    }

    public function getUpdatedFiles($fileType = self::SOURCE_FILE)
    {
        if (self::SOURCE_FILE == $fileType) {
            return array_uintersect(
                $this->getSource()->getFiles(),
                $this->getDestination()->getFiles(),
                function ($sourceFile, $destinationFile) {
                    $pathCmp = strcmp($sourceFile->getPath(), $destinationFile->getPath());
                    if ($pathCmp != 0) {
                        return $pathCmp;
                    }
                    $modifiedCmp = $sourceFile->getModified() > $destinationFile->getModified();
                    if (!$modifiedCmp || $sourceFile->match($this->getIgnoreFilePatterns())) {
                        return 1;
                    }
                    return 0;
                }
            );
        }
        return array_uintersect(
            $this->getDestination()->getFiles(),
            $this->getSource()->getFiles(),
            function ($destinationFile, $sourceFile) {
                $pathCmp = strcmp($sourceFile->getPath(), $destinationFile->getPath());
                if ($pathCmp != 0) {
                    return $pathCmp;
                }
                $modifiedCmp = $sourceFile->getModified() > $destinationFile->getModified();
                if (!$modifiedCmp || $sourceFile->match($this->getIgnoreFilePatterns())) {
                    return 1;
                }
                return 0;
            }
        );
    }

    public function getUnchangedFiles($fileType = self::SOURCE_FILE)
    {
        if (self::SOURCE_FILE == $fileType) {
            return array_uintersect(
                $this->getSource()->getFiles(),
                $this->getDestination()->getFiles(),
                function ($sourceFile, $destinationFile) {
                    $pathCmp = strcmp($sourceFile->getPath(), $destinationFile->getPath());
                    if ($pathCmp != 0) {
                        return $pathCmp;
                    }
                    $modifiedCmp = $sourceFile->getModified() <= $destinationFile->getModified();
                    if (!$modifiedCmp || $sourceFile->match($this->getIgnoreFilePatterns())) {
                        return 1;
                    }
                    return 0;
                }
            );
        }
        return array_uintersect(
            $this->getDestination()->getFiles(),
            $this->getSource()->getFiles(),
            function ($destinationFile, $sourceFile) {
                $pathCmp = strcmp($sourceFile->getPath(), $destinationFile->getPath());
                if ($pathCmp != 0) {
                    return $pathCmp;
                }
                $modifiedCmp = $sourceFile->getModified() <= $destinationFile->getModified();
                if (!$modifiedCmp || $sourceFile->match($this->getIgnoreFilePatterns())) {
                    return 1;
                }
                return 0;
            }
        );
    }
}
