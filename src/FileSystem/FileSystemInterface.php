<?php
<<<<<<< HEAD
namespace Jlttt\Deploy\FileSystem;

interface FileSystemInterface
{
    public function getFiles();
=======

namespace Jlttt\Deploy\FileSystem;

interface FileSystemInterface extends FileExplorerInterface
{
>>>>>>> 8a7a6eb0a9d46bdd0c94c409f66e20333c70a1bf
    public function read($path);
    public function write($path, $content);
    public function delete($path);
}
