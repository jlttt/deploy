<?php


namespace Jlttt\Deploy\FileSystem;


interface FileInterface
{
    public function delete();
    public function copyTo(FileSystemInterface $fileSystem);

    public function getPath();
    public function getModified();
}