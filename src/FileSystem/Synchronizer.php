<?php
namespace Jlttt\Deploy\FileSystem;

class Synchronizer implements SynchronizerInterface
{
    protected $comparator;

    public function __construct(Comparator $comparator)
    {
        $this->comparator = $comparator;
    }

    public function getComparator()
    {
        return $this->comparator;
    }

    public function synchronize(FileSystemInterface $backupFileSystem = null)
    {
        $this->createFiles();
        $this->updateFiles($backupFileSystem);
        $this->deleteFiles($backupFileSystem);
    }

    private function createFiles()
    {
        foreach ($this->getComparator()->getCreatedFiles() as $file) {
            $file->copyTo($this->getComparator()->getDestination());
        }
    }

    private function updateFiles(FileSystemInterface $backupFileSystem = null)
    {
        if (!empty($backupFileSystem)) {
            foreach ($this->getComparator()->getUpdatedFiles(ComparatorInterface::DESTINATION_FILE) as $file) {
                $file->copyTo($backupFileSystem);
            }
        }
        foreach($this->getComparator()->getUpdatedFiles() as $file) {
            $file->copyTo($this->getComparator()->getDestination());
        }
    }

    private function deleteFiles(FileSystemInterface $backupFileSystem = null)
    {
        foreach($this->getComparator()->getDeletedFiles() as $file) {
            $file->copyTo($backupFileSystem);
            $file->delete();
        }
    }
}
