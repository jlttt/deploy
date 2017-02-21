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
        $key = bin2hex(openssl_random_pseudo_bytes(15));
        $fileName = bin2hex(openssl_random_pseudo_bytes(15)) . '.php';
        $url = $this->baseUrl . '/' . $fileName;
        $path = $this->webPath . '/' . $fileName;

        $streamContent = file_get_contents(__DIR__ . '/../resources/webspy.php');
        $streamContent = str_replace('{{key}}', $key, $streamContent);
        $streamContent = str_replace('{{relativePath}}', $this->webPath, $streamContent);
        $stream = fopen('data://text/plain,' . $streamContent,'r');


        $this->fileSystem->write($path, $stream);

        $content = file_get_contents($url);
        $content = Cryptor::Decrypt($content, $key);
        $content = gzuncompress($content);

        return array_map([$this, 'getFile'], json_decode($content,true));
    }

    private function getFile($fileData)
    {
        $path = $fileData['path'];
        unset($fileData['path']);
        return new File($this->getFileSystem(), $path, $fileData);
    }

    public function getFileSystem()
    {
        return $this->fileSystem;
    }
}
