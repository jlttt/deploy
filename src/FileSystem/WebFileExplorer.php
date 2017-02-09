<?php

namespace Jlttt\Deploy\FileSystem;

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
        $fileName = sha1(microtime());
        $content = "";
        $url = $baseUrl . '/' . $fileName;
        $path = $webPath . '/' . $fileName;
        $fileSystem->write($path, $content);
        file_get_contents($url);
    }
}
