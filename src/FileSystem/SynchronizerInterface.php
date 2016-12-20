<?php
namespace Jlttt\Deploy\FileSystem;

interface SynchronizerInterface
{
    public function synchronize(FileSystemInterface $backupFileSystem);
}
