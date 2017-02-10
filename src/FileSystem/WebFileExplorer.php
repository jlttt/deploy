<?php

namespace Jlttt\Deploy\FileSystem;

use Cryptor\Cryptor;

class WebFileExplorer implements FileExplorerInterface
{
    private $fileSystem;
    private $baseUrl;
    private $webPath;

    function __construct(FileSystemInterface $fileSystem, $webPath, $baseUrl)
    {
        $this->fileSystem = $fileSystem;
        $this->baseUrl = $baseUrl;
        $this->webPath = $webPath;
    }

    function getFiles()
    {
        $data = 'Good things come in small packages.';
        $key = '9901:io=[<>602vV03&Whb>9J&M~Oq';

        $content = Cryptor::Encrypt($data, $key);

        $stream = fopen('data://text/plain,' . $content,'r');
        $fileName = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'),0,10) . '.php';
        var_dump($fileName);
        $url = $this->baseUrl . '/' . $fileName;
        $path = $this->webPath . '/' . $fileName;
        var_dump($this->fileSystem->write($path, $stream));
        var_dump(file_get_contents($url));
    }
}
