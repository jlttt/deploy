<?php


namespace Jlttt\Deploy\FileSystem;


use League\Flysystem\FileExistsException;

class File implements FileInterface
{
    private $fileSystem;
    private $path;
    private $modified;

    public function __construct(FileSystemInterface $fileSystem, $path, $infos = [])
    {
        $this->fileSystem = $fileSystem;
        $this->path = $path;
        foreach ($infos as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    private function getFileSystem()
    {
        return $this->fileSystem;
    }

    public function copyTo(FileSystemInterface $fileSystem)
    {
        $file = new File($fileSystem, $this->getPath());
        $file->write($this->read());
    }

    private function read()
    {
        return $this->fileSystem->read($this->getPath());
    }

    private function write($content)
    {
        return $this->getFileSystem()->write($this->getPath(), $content);
    }

    public function delete()
    {
        return $this->getFileSystem()->delete($this->getPath());
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getModified()
    {
        return $this->modified;
    }

    public function match($patterns)
    {
        foreach ($patterns as $pattern) {
            if (preg_match('/' . preg_quote($pattern, '/') . '/', $this->getPath()) == 1) {
                return true;
            }
        }
        return false;
    }
}