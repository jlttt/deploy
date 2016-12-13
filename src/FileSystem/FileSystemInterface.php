<?php
namespace Pmp\Deploy\FileSystem;

interface FileSystemInterface
{
    public function getFiles();
    public function read($path);
    public function write($path, $content);
    public function delete($path);
}
