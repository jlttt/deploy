<?php

namespace Jlttt\Deploy\FileSystem;

interface FileSystemInterface extends FileExplorerInterface
{
    public function read($path);
    public function write($path, $content);
    public function delete($path);
}
