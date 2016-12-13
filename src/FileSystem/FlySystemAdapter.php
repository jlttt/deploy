<?php
namespace Jlttt\Deploy\FileSystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\FileExistsException;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\ListFiles;

class FlySystemAdapter implements FileSystemInterface
{
    protected $fileSystem = null;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
        $this->fileSystem->addPlugin(new ListFiles());
    }

    private function getFile($data)
    {
        $path =  $data['path'];
        $data['modified'] = $data['timestamp'];
        unset($data['path']);
        return new File($this, $path, $data);
    }

    public function getFiles()
    {
        return array_map([$this, 'getFile'], $this->fileSystem->listFiles('', true));
    }

    public function read($path)
    {
        return $this->fileSystem->readStream($path);
    }

    public function write($path, $stream)
    {
        try {
            return $this->fileSystem->writeStream($path, $stream);
        } catch (FileExistsException $e) {
            return $this->fileSystem->updateStream($path, $stream);
        }
    }

    public function delete($path)
    {
        return $this->fileSystem->delete($path);
    }
}
