<?php
require_once(__DIR__ . '/vendor/autoload.php');

$sftp =  new \Jlttt\Deploy\FileSystem\FlySystemAdapter(
    new \League\Flysystem\Filesystem(
        new \League\Flysystem\Sftp\SftpAdapter([
            'host' => "sftp.dc0.gpaas.net",
            'port' => 22,
            'username' =>  "6496984",
            'password' => "PMPsites7#",
            'root' =>  "/lamp0/web/vhosts/23be3e6e5e.url-de-test.ws/",
            'timeout' => 10,
        ])
    )
);
$webExplorer = new \Jlttt\Deploy\FileSystem\WebFileExplorer($sftp, '/htdocs', 'http://23be3e6e5e.url-de-test.ws');
$webExplorer->getFiles();