<?php
namespace Pmp\Deploy\FileSystem;

class NullFileSystem implements FileSystemInterface
{
    public function getFiles()
    {
        return null;
    }
}
