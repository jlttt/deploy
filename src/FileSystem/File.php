<?php


namespace Pmp\Deploy\FileSystem;


class File implements FileInterface
{
    private $fileSystem;
    private $path;
    private $type;
    private $modified;
    private $size;

    public function __construct(FileSystemInterface $fileSystem, $path, $infos = [])
    {
        $this->fileSystem = $fileSystem;
        $this->path = $path;
        foreach($infos as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    public function copyTo(FileSystemInterface $fileSystem)
    {
        $file = new File($fileSystem, $this->path);
        $file->write($this->read());
    }

    public function read()
    {
        return $this->fileSystem->read($this->path);
    }

    public function write($content)
    {
        return $this->fileSystem->write($this->path, $content);
    }

    public function delete()
    {
        return $this->fileSystem->delete($this->path);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getModified()
    {
        return $this->modified;
    }
}