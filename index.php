<?php
require_once(__DIR__ . '/vendor/autoload.php');
use Pmp\Deploy\FileSystem\LocalFlySystemAdapter;
use Pmp\Deploy\Deployer;

$sourcePath = __DIR__ . '/source';
$destinationPath = __DIR__ . '/destination';

$deployer = new Deployer(new LocalFlySystemAdapter($sourcePath), new LocalFlySystemAdapter($destinationPath));
var_dump(count($deployer->getCreatedFiles()));
var_dump(count($deployer->getDeletedFiles()));
var_dump(count($deployer->getUpdatedFiles()));
/*$sourceAdapter = new Local($sourcePath);
$sourceFileSystem = new Filesystem($sourceAdapter);
$sourceFileSystem->addPlugin(new \League\Flysystem\Plugin\ListFiles());
$sourceFiles = $sourceFileSystem->listFiles('', true);

var_dump($sourceFiles);
$destinationAdapter = new Local($destinationPath);
$destinationFileSystem = new Filesystem($destinationAdapter);
$destinationFileSystem->addPlugin(new \League\Flysystem\Plugin\ListFiles());
$destinationFiles = $destinationFileSystem->listFiles('', true);

var_dump($destinationFiles);

/*$sftpAdapter = new SftpAdapter([
    'host' => 'sftp.dc0.gpaas.net',
    'port' => 22,
    'username' => '6496984',
    'password' => 'PMPsites7#',
    'root' => '/vhosts/www2.ctd-pulverisation.com/',
    'timeout' => 30,
]);
$distantFileSystem = new Filesystem($sftpAdapter);
$distantFileSystem->addPlugin(new \League\Flysystem\Plugin\ListFiles());
var_dump($distantFileSystem->listFiles('', true));*/
