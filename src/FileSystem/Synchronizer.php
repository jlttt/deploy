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
<<<<<<< HEAD
        foreach($this->getComparator()->getUpdatedFiles() as $file) {
=======
        foreach ($this->getComparator()->getUpdatedFiles() as $file) {
>>>>>>> 8a7a6eb0a9d46bdd0c94c409f66e20333c70a1bf
            $file->copyTo($this->getComparator()->getDestination());
        }
    }

    private function deleteFiles(FileSystemInterface $backupFileSystem = null)
    {
<<<<<<< HEAD
        foreach($this->getComparator()->getDeletedFiles() as $file) {
=======
        foreach ($this->getComparator()->getDeletedFiles() as $file) {
>>>>>>> 8a7a6eb0a9d46bdd0c94c409f66e20333c70a1bf
            $file->copyTo($backupFileSystem);
            $file->delete();
        }
    }
}
